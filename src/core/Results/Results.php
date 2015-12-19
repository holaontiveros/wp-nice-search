<?php
namespace core\Results;

/**
 * Get data from database and format it base setting values
 * @since 1.0.7
 */

abstract class Results
{
	/**
	 * @var array $settings
	 */
	protected $settings;

	/**
	 * constructor
	 */
	public function __construct()
	{
		$this->settings = get_option('wpns_options');
		$this->writeFile($this->createList());
	}

	/**
	 * put content into file template
	 * @param string $data
	 */
	public function writeFile($data)
	{
		$path = WPNS_DIR . '/src/templates/ListResults.php';
		file_put_contents($path, $data);
	}

	/**
	 * Get posts and return an array of post id
	 *
	 * @param string $where
	 * @return array $posts
	 */
	public function getPosts()
	{
		$where = $this->getPostTypes();
		$orderby = $this->getOrderBy();
		//$orderby = array('title' => 'DESC', 'author' => 'ASC');
		$order = $this->getOrder();

		$args = array(
			'post_type' => $where,
			'posts_per_page' => -1,
			'orderby' => $orderby,
			'order' => $order
		);

		$loop = new \WP_Query($args);
		
		if ($loop->have_posts()) {
			while ($loop->have_posts()) {
				$loop->the_post();
				$posts[] = get_the_ID();
			}
		}

		return $posts;
	}
	
	/**
	 * 
	 */
	public function getOrder()
	{
		$settings = $this->settings;
		return $settings['wpns_order'];
	}
	
	/**
	 * @param int $author_id
	 */
	public function getAuthor($author_id)
	{
		//$post_obj->post_author
		$author = array();
		$author_url = get_author_posts_url($author_id);
		$post_author = get_user_meta($author_id);
		$first_name = $post_author['first_name'][0];
		$last_name = $post_author['last_name'][0];
		if ($first_name == '' && $last_name == '') {
			$post_author_name = $post_author['nickname'][0];
		} else {
			$post_author_name = $first_name . ' ' . $last_name;
		}
		$author['author_url'] = $author_url;
		$author['author_nicename'] = $post_author_name;
		
		return $author;
	}
	
	/**
	 * get terms of post
	 * @param object $post_obj
	 * @param array $termarr
	 */
	public function getTerms($post_obj)
	{
		$taxonomies = get_object_taxonomies($post_obj);
		foreach ($taxonomies as $key => $value) {
			if ($value == 'post_format' || $value == 'post_tag') {
				unset($taxonomies[$key]);
			}
		}
		
		//$terms = array();
		foreach ($taxonomies as $key => $taxonomy) {
			$terms = get_terms($taxonomy);
			foreach ($terms as $term) {
				$term_id = $term->term_id;
				$term_name = $term->name;
				$term_url = get_term_link($term_id);
				$term_link = '<a href="' . $term_url . '">' . $term_name . '</a>';
				$termarr[] = $term_link;
			}
		}
		
		return $termarr;
	}
	
	/**
	 * @return string $orderby
	 */
	public function getOrderBy()
	{
		$orderby = array();
		$settings = $this->settings;
		
		$priority = array(
			'title' => $settings['wpns_title_pri'],
			'date' => $settings['wpns_date_pri'],
			'author' => $settings['wpns_author_pri']
		);
		asort($priority);
		foreach ($priority as $key => $value) {
			if ($settings['wpns_orderby_' . $key] == 'on') {
				$orderby[$key] = $settings['wpns_' . $key . '_order'];
			}
		}
		if (empty($orderby)) return '';
		return $orderby;
	}

	/**
	 * This method gets post types that selected in settings page
	 * @return array $post_types
	 */
	public function getPostTypes()
	{
		$post_types = array();
		$settings = $this->settings;
		if ($settings['wpns_only_search'] != '') {
			$post_types[] = $settings['wpns_only_search'];
		} else {
			$cpts = $this->getListCpts();
			if ($settings['wpns_in_all'] == 'on') {
				$post_types[] = 'post';
				$post_types[] = 'page';
				foreach ($cpts as $value) {
					$post_types[] = $value;
				}
			} elseif ($settings['wpns_in_post'] == 'on' && $settings['wpns_in_page'] == 'on') {
				$post_types[] = 'post';
				$post_types[] = 'page';
			} elseif ($settings['wpns_in_post'] == 'on' && $settings['wpns_in_cpt'] == 'on') {
				$post_types = 'post';
				foreach ($cpts as $value) {
					$post_types[] = $value;
				}
			} elseif ($settings['wpns_in_page'] == 'on' && $settings['wpns_in_cpt'] == 'on') {
				$post_types[] = 'page';
				foreach ($cpts as $value) {
					$post_types[] = $value;
				}
			} elseif ($settings['wpns_in_post'] == 'on') {
				$post_types[] = 'post';
			} elseif ($settings['wpns_in_page'] == 'on') {
				$post_types[] = 'page';
			} elseif ($settings['wpns_in_cpt'] == 'on') {
				foreach ($cpts as $value) {
					$post_types[] = $value;
				}
			}
		}

		return $post_types;
	}

	/**
	 * get custom post type name
	 * @retun array $cpts
	 */
	public function getListCpts()
	{
		$types = get_post_types(array('_builtin' => false));
		$cpts = array();
		$cpts_except = [
			'slider',
			'_pods_field',
			'_pods_pod',
			'acf',
			'attachment',
			'nav_menu_item',
			'post',
			'page',
			'product_variation',
			'revision',
		];
		$cpts = array_diff($types, $cpts_except);
		return $cpts;
	}

	/**
	 * Return setting options
	 */
	public function getOptions()
	{
		return $this->settings;
	}

	/**
	 * abstract method. This method must be declared in sub class
	 */
	abstract public function createList();
	
	/**
	 * markup wrap results list
	 * @return array $wrap_default
	 */
	public function resultsWrap()
	{
		$wrap_default = array(
			'heading_tag' => 'h3',
			'heading_text' => 'Search Results'
		);
		return apply_filters('results_title', $wrap_default);
	}
}