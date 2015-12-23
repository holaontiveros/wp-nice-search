<?php
namespace core;

/**
 * Create admin page and register script for plugin
 * @package wpns
 * @since 1.0.0
 */

class WpnsAdmin
{
	/**
	 * Holds text title of plugin which displayed in browser bar
	 * @var string $page_title
	 */
	protected $page_title = 'Nice Search';

	/**
	 * Holds text which name of menu
	 * @var string $menu_title
	 */
	protected $menu_title = 'Nice Search';

	/**
	 * The capability required for menu to be displayed to the user
	 * @var string $capability
	 */
	protected $capability = 'manage_options';

	/**
	 * An unique slug name to refer to plugin menu
	 * @var string $menu_slug
	 */
	protected $menu_slug = 'wpns-nice-search-menu';

	/**
	 * An array holds default values and updated values
	 * @var array $settings
	 */
	protected $settings = array(
		//where
		'wpns_in_all' => null,
		'wpns_in_post' => 'on',
		'wpns_in_page' => null,
		'wpns_in_custom_post_type' => null,
		//layout
		'wpns_items_featured' => null,
		'wpns_items_meta' => null,
		//orderby & order
		'wpns_orderby_title' => null,
		'wpns_title_pri' => '2',
		'wpns_title_order' => 'DESC',
		'wpns_orderby_date' => 'on',
		'wpns_date_pri' => '1',
		'wpns_date_order' => 'DESC',
		'wpns_orderby_author' => null,
		'wpns_author_pri' => '3',
		'wpns_author_order' => 'DESC',
		//options for form
		'wpns_placeholder' => 'Type your words here...',
	);

	/**
	 * Initiliaze
	 */
	public function __construct()
	{
		add_action('wp_enqueue_scripts', array($this, 'wpns_plugin_script'));
		add_action('admin_enqueue_scripts', array($this, 'wpns_admin_script'));
		add_action('admin_menu', array($this, 'wpns_add_plugin_page'));
		add_action('admin_init', array($this, 'wpns_admin_init'));
		$this->wpns_get_options('wpns_options');
	}

	/**
	 * function callback to enqueue scripts and style
	 */
	public function wpns_plugin_script()
	{
		wp_enqueue_style(
			'wpns-style',
			WPNS_URL . 'assist/css/style.min.css',
			array(),
			WPNS_PLUGIN_VER
		);
		wp_enqueue_style(
			'wpns-fontawesome',
			WPNS_URL . 'assist/css/font-awesome.min.css',
			array(),
			WPNS_PLUGIN_VER
		);
	}

	/**
	 * Add script to admin
	 */
	public function wpns_admin_script()
	{
		wp_enqueue_script(
			'wpns-admin-script',
			WPNS_URL . 'assist/js/admin.js',
			array('jquery'),
			WPNS_PLUGIN_VER
		);
		wp_enqueue_style(
			'wpns-admin-style',
			WPNS_URL . 'assist/css/admin.css',
			array(),
			WPNS_PLUGIN_VER
		);
	}

	/**
	 * function callback to add plugin page in plugins menu
	 */
	public function wpns_add_plugin_page()
	{
		add_options_page(
			$this->page_title,
			$this->menu_title,
			$this->capability,
			$this->menu_slug,
			array(&$this, 'wpns_html_plugin_page')
		);
	}

	/**
	 * function callback to render html for plugin page
	 */
	public function wpns_html_plugin_page()
	{
		include WPNS_DIR . '/src/templates/admin.php';
	}

	/**
	 * Register and define the settings
	 */
	public function wpns_admin_init() {
		register_setting(
			'wpns_options',
			'wpns_options'
		);
	
		// section where
		add_settings_section(
			'wpns_group_where',
			'',
			array(&$this, 'wpnsSectionWhere'),
			$this->menu_slug
		);
		add_settings_field(
			'wpns_where',
			'Search In',
			array($this, 'wpnsInputWhere'),
			$this->menu_slug,
			'wpns_group_where'
		);
		
		// section orderby
		add_settings_section(
			'wpns_group_orderby',
			'',
			array(&$this, 'wpnsSectionOrderBy'),
			$this->menu_slug
		);
		add_settings_field(
			'wpns_orderby',
			'Order By Field',
			array(&$this, 'wpnsInputOrderBy'),
			$this->menu_slug,
			'wpns_group_orderby'
		);

		// layout
		add_settings_section(
			'wpns_group_layout',
			'',
			array(&$this, 'wpnsSectionLayout'),
			$this->menu_slug
		);
		add_settings_field(
			'wpns_layout',
			'Layout',
			array(&$this, 'wpnsInputLayout'),
			$this->menu_slug,
			'wpns_group_layout'
		);

		// form design
		add_settings_section(
			'wpns_group_form',
			'',
			array($this, 'wpnsSectionFormDesign'),
			$this->menu_slug
		);
		add_settings_field(
			'wpns_form_placeholder',
			'Placeholder Text',
			array($this, 'wpnsInputFormDesign'),
			$this->menu_slug,
			'wpns_group_form'
		);
		
		// document section
		add_settings_section(
			'wpns_group_doc',
			'',
			array($this, 'wpnsSectionDoc'),
			$this->menu_slug
		);
	}

	/**
	 * Draw the where section
	 * @since 1.0.7
	 */
	public function wpnsSectionWhere()
	{
		echo '<h3>Where do you want to search?</h3>';
	}
	
	/**
	 * Draw the orderby section
	 * @since 1.0.7
	 */
	public function wpnsSectionOrderBy()
	{
		echo '<h3>Sort retrieved results base on</h3>';
	}
	
	/**
	 * Draw the layout section
	 * @since 1.0.7
	 */
	public function wpnsSectionLayout()
	{
		echo '<h3>Choose the layout for the list results</h3>';
	}
	
	/**
	 * Draw the form design section
	 * @since 1.0.7
	 */
	public function wpnsSectionFormDesign()
	{
		echo '<h3>Change Form Components</h3>';
	}

	/**
	 * render fields in orderby section
	 * @since 1.0.7
	 */
	public function wpnsInputOrderBy()
	{
		?>
		<fieldset class="has-group">
			<label>
				<input type="checkbox" name="wpns_options[wpns_orderby_title]" <?php checked($this->settings['wpns_orderby_title'], 'on'); ?> />
				<i>Title</i>
				<select name="wpns_options[wpns_title_pri]">
					<option value="1" <?php @selected($this->settings['wpns_title_pri'], '1'); ?>>1</option>
					<option value="2" <?php @selected($this->settings['wpns_title_pri'], '2'); ?>>2</option>
					<option value="3" <?php @selected($this->settings['wpns_title_pri'], '3'); ?>>3</option>
				</select>
				<i>Priority</i>
				<select name="wpns_options[wpns_title_order]">
					<option value="DESC" <?php @selected($this->settings['wpns_title_order'], 'DESC'); ?>>DESC</option>
					<option value="ASC" <?php @selected($this->settings['wpns_title_order'], 'ASC'); ?>>ASC</option>
				</select>
				<i>Order</i>
			</label>
			<br>
			<label>
				<input type="checkbox" name="wpns_options[wpns_orderby_date]" <?php checked($this->settings['wpns_orderby_date'], 'on'); ?> />
				<i>Date</i>
				<select name="wpns_options[wpns_date_pri]">
					<option value="1" <?php @selected($this->settings['wpns_date_pri'], '1'); ?>>1</option>
					<option value="2" <?php @selected($this->settings['wpns_date_pri'], '2'); ?>>2</option>
					<option value="3" <?php @selected($this->settings['wpns_date_pri'], '3'); ?>>3</option>
				</select>
				<i>Priority</i>
				<select name="wpns_options[wpns_date_order]">
					<option value="DESC" <?php @selected($this->settings['wpns_date_order'], 'DESC'); ?>>DESC</option>
					<option value="ASC" <?php @selected($this->settings['wpns_date_order'], 'ASC'); ?>>ASC</option>
				</select>
				<i>Order</i>
			</label>
			<br>
			<label>
				<input type="checkbox" name="wpns_options[wpns_orderby_author]" <?php checked($this->settings['wpns_orderby_author'], 'on'); ?> />
				<i>Author</i>
				<select name="wpns_options[wpns_author_pri]">
					<option value="1" <?php @selected($this->settings['wpns_author_pri'], '1'); ?>>1</option>
					<option value="2" <?php @selected($this->settings['wpns_author_pri'], '2'); ?>>2</option>
					<option value="3" <?php @selected($this->settings['wpns_author_pri'], '3'); ?>>3</option>
				</select>
				<i>Priority</i>
				<select name="wpns_options[wpns_author_order]">
					<option value="DESC" <?php @selected($this->settings['wpns_author_order'], 'DESC'); ?>>DESC</option>
					<option value="ASC" <?php @selected($this->settings['wpns_author_order'], 'ASC'); ?>>ASC</option>
				</select>
				<i>Order</i>
			</label>
		</fieldset>
		<?php		
	}

	/**
	 * render fields in where section
	 * @since 1.0.7
	 */
	public function wpnsInputWhere()
	{
		?>
		<fieldset>
			<label>
				<input type="checkbox" id="chk_all" name="wpns_options[wpns_in_all]" <?php @checked($this->settings['wpns_in_all'], 'on'); ?> />
				<i>All</i>
			</label>
			<br>
			<label>
				<input type="checkbox" class="chk_items" name="wpns_options[wpns_in_post]" <?php @checked($this->settings['wpns_in_post'], 'on'); ?> />
				<i>Post</i>
			</label>
			<br>
			<label>
				<input type="checkbox" class="chk_items" name="wpns_options[wpns_in_page]" <?php @checked($this->settings['wpns_in_page'], 'on'); ?> />
				<i>Page</i>
			</label>
			<br>
			<label>
				<input type="checkbox" class="chk_items" name="wpns_options[wpns_in_cpt]" <?php @checked($this->settings['wpns_in_cpt'], 'on'); ?> />
				<i>Custom post type</i>
			</label>
			<br>
		</fieldset>
		<?php
	}

	/**
	 * render fields in form design section
	 * @since 1.0.5
	 */
	public function wpnsInputFormDesign()
	{
		// get option value from database
		$text_string = $this->settings['wpns_placeholder'];
		echo '<input type="text" id="wpns_placeholder" name="wpns_options[wpns_placeholder]" value="' . $text_string . '"/>';
	}

	/**
	 * render fields in Layout section
	 * @since 1.0.1
	 */
	public function wpnsInputLayout()
	{
		?>
		<fieldset>
			<label>
				<input type="checkbox" id="chk_items_featured" name="wpns_options[wpns_items_featured]" <?php @checked($this->settings['wpns_items_featured'], 'on'); ?> />
				<i>Display featured</i>
			</label>
			<br>
			<label>
				<input type="checkbox" class="wpns_items_meta" name="wpns_options[wpns_items_meta]" <?php @checked($this->settings['wpns_items_meta'], 'on'); ?>/>
				<i>Display meta section (Author, Date, Taxonomy)</i>
			</label>
			<br>
		</fieldset>
		<?php
	}

	/**
	 * Draw the document section
	 * @since 1.0.6
	 */
	public function wpnsSectionDoc()
	{
		echo '<p class="separater"></p>';
		echo '<p>* Use this shortcode in content of the page or post or custom post type: <code>[wpns_search_form]</code></p>';
		echo '<p>* To use this shortcode in template file: <code>&lt;?php echo do_shortcode("[wpns_search_form]"); ?&gt;</code></p>';
		echo '<p>* Shortcode Options: </p>';
		echo '<ul style="margin-left:20px;">';
		echo '<li><label><b>only_search </b>(optional): This option determine place searching. ';
		echo '( Example: <code>[wpns_search_form only_search="my_custom_post_type"]</code> ';
		echo 'This shortcode only search in the custom post type named my_custom_post_type)</label></li>';
		echo '</ul>';
	}

	/**
	 * Validation options callback function
	 * @param array $input Holds values of option fields
	 * @return array $valid
	 */
	public function wpns_validate_options($input){}

	/**
	 * Get option values from database
	 * @param string $name Holds option name
	 * @since 1.0.5
	 * @return array $options
	 */
	public function wpns_get_options($name = '')
	{
		$options = get_option($name);
		$this->settings = $options;
	}

} // end class WpnsAdmin