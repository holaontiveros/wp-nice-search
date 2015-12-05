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
		$this->getSearchIn();

	}

	/**
	 * hooks
	 */
	public function hooks()
	{
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
		global $wpdb;
		$posts = [];
		$search_in = $this->getSearchIn();
		$where = "post_type IN ($search_in) AND post_status = 'publish'";
		$sql = "SELECT ID FROM $wpdb->posts WHERE $where";
		$results = $wpdb->get_results($sql);

		if (empty($results)) return $posts;

		foreach ($results as $obj) {
			$posts[] = $obj->ID;
		}

		return $posts;
	}

	/**
	 * create where we search in database
	 * @return string $search
	 */
	public function getSearchIn()
	{
		$search = [];
		if ($this->settings['wpns_only_search'] != '') {
			$specific = $this->settings['wpns_only_search'];
			$search[] = "'$specific'";
		} else {
			$cpts = $this->getListCpts();
			if ($this->settings['wpns_in_all'] == 'on') {
				$search[] = "'post'";
				$search[] = "'page'";
				foreach ($cpts as $value) {
					$search[] = "'$value'";
				}
			} elseif ($this->settings['wpns_in_post'] == 'on') {
				$search[] = "'post'";
			} elseif ($this->settings['wpns_in_page'] == 'on') {
				$search[] = "'page'";
			} else {
				foreach ($cpts as $value) {
					$search[] = "'$value'";
				}
			}
		}
		//var_dump($search);
		if (empty($search)) {
			$search[] = "'post'";
		}

		return implode(',', $search);
	}

	/**
	 * get custom post type name
	 */
	public function getListCpts()
	{
		global $wpdb;
		$cpts = [];
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

		$sql = "SELECT DISTINCT post_type FROM $wpdb->posts";
		$results = $wpdb->get_results($sql);

		foreach ($results as $type) {
			$types[] = $type->post_type;
		}

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
	 * get terms of post
	 * @TODO get_object_taxonomies() is not working
	 *
	 * @param int $post_id
	 */
	public function getTerms($post_id)
	{
		$taxonomies_except = [
			'post_tag',
			'post_format'
		];
		$terms = [];
		$post_id = (int)$post_id;
		$post_obj = get_post($post_id);
		$post_type = $post_obj->post_type;
		$taxonomies = get_object_taxonomies($post_type);
		//$taxonomies = array_diff($taxonomies, $taxonomies_except);

		foreach ($taxonomies as $taxonomy) {
			$terms[] = get_the_terms($post_id, $taxonomy);
		}

		var_dump($taxonomies);
	}

	/**
	 * abstract method. This method must be declared in sub class
	 */
	abstract public function createList();
}