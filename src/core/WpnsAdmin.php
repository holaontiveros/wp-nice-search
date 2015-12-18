<?php
namespace core;

/**
 * Create admin page and register script for plugin
 * @package wpns
 * @author Duy Nguyen
 */

class WpnsAdmin
{
	/**
	 * @var string $page_title Holds text title of plugin which displayed in browser bar
	 */
	protected $page_title = 'Nice Search';

	/**
	 * @var string $menu_title Holds text which name of menu
	 */
	protected $menu_title = 'Nice Search';

	/**
	 * @var string $capability The capability required for menu to be displayed to the user
	 */
	protected $capability = 'manage_options';

	/**
	 * @var string $menu_slug A unique slug name to refer to plugin menu
	 */
	protected $menu_slug = 'wpns-nice-search-menu';

	/**
	 * @var array $settings A array holds default values and updated values
	 */
	protected $settings = array(
		// global options
		'wpns_in_all' => null,
		'wpns_in_post' => 'on',
		'wpns_in_page' => null,
		//'wpns_in_category' => null,
		'wpns_in_custom_post_type' => null,
		'wpns_items_featured' => null,
		'chk_items_meta' => null,

		// options for form
		'wpns_placeholder' => 'Type your words here...',
	);

	/**
	 * Initiliaze
	 */
	public function __construct()
	{
		add_action('wp_enqueue_scripts', array(&$this, 'wpns_plugin_script'));
		add_action('admin_enqueue_scripts', array(&$this, 'wpns_admin_script'));
		add_action('admin_menu', array(&$this, 'wpns_add_plugin_page'));
		add_action('admin_init', array(&$this, 'wpns_admin_init'));
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
		add_settings_field(
			'wpns_order',
			'Order',
			array(&$this, 'wpnsInputOrder'),
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
	 * Draw the section header group 1
	 */
	public function wpnsSectionWhere()
	{
		echo '<h3>Where do you want to search?</h3>';
	}

	public function wpnsSectionOrderBy()
	{
		echo '<h3>Sort retrieved results base on</h3>';
	}
	
	public function wpnsSectionLayout()
	{
		echo '<h3>Choose the layout for the list results</h3>';
	}
	
	public function wpnsSectionFormDesign()
	{
		echo '<h3>Change Form Components</h3>';
	}

	/**
	 * 
	 */
	public function wpnsInputOrderBy()
	{
		?>
		<fieldset>
			<label>
				<input type="checkbox" name="wpns_options[wpns_orderby_title]" <?php echo ($this->settings['wpns_orderby_title'] == 'on') ? 'checked' : ''; ?> />
				<i>Title</i>
			</label>
			<br>
			<label>
				<input type="checkbox" name="wpns_options[wpns_orderby_date]" <?php echo ($this->settings['wpns_orderby_date'] == 'on') ? 'checked' : ''; ?> />
				<i>Date</i>
			</label>
			<br>
			<label>
				<input type="checkbox" name="wpns_options[wpns_orderby_author]" <?php echo ($this->settings['wpns_orderby_author'] == 'on') ? 'checked' : ''; ?> />
				<i>Author</i>
			</label>
		</fieldset>
		<?php		
	}

	/**
	 * 
	 */
	public function wpnsInputOrder()
	{
		?>
		<select name="wpns_options[wpns_order]">
			<option value="DESC" <?php selected($this->settings['wpns_order'], 'DESC'); ?>>DESC</option>
			<option value="ASC" <?php selected($this->settings['wpns_order'], 'ASC'); ?>>ASC</option>
		</select>
		<?php
	}

	/**
	 * Display and fill the field group 1
	 */
	public function wpnsInputWhere()
	{
		?>
		<fieldset>
			<label>
				<input type="checkbox" id="chk_all" name="wpns_options[wpns_in_all]" <?php checked($this->settings['wpns_in_all'], 'on'); ?> />
				<i>All</i>
			</label>
			<br>
			<label>
				<input type="checkbox" class="chk_items" name="wpns_options[wpns_in_post]" <?php checked($this->settings['wpns_in_post'], 'on'); ?> />
				<i>Post</i>
			</label>
			<br>
			<label>
				<input type="checkbox" class="chk_items" name="wpns_options[wpns_in_page]" <?php checked($this->settings['wpns_in_page'], 'on'); ?> />
				<i>Page</i>
			</label>
			<br>
			<label>
				<input type="checkbox" class="chk_items" name="wpns_options[wpns_in_cpt]" <?php checked($this->settings['wpns_in_cpt'], 'on'); ?> />
				<i>Custom post type</i>
			</label>
			<br>
		</fieldset>
		<?php
	}

	/**
	 * Draw the section header group 2
	 */
	public function wpns_section_2()
	{
		echo '<h3>Form Design</h3>';
	}

	/**
	 * Display and fill the field group 2
	 */
	public function wpnsInputFormDesign()
	{
		// get option value from database
		$text_string = $this->settings['wpns_placeholder'];
		// echo the field
		echo '<input type="text" id="wpns_placeholder" name="wpns_options[wpns_placeholder]" value="' . $text_string . '"/>';
	}

	/**
	 * Display and fill the field group 3
	 */
	public function wpnsInputLayout()
	{
		?>
		<fieldset>
			<label>
				<input type="checkbox" id="chk_items_featured" name="wpns_options[wpns_items_featured]" <?php echo ($this->settings['wpns_items_featured'] == 'on') ? 'checked' : ''; ?> />
				<i>Display featured</i>
			</label>
			<br>
			<label>
				<input type="checkbox" class="chk_items_meta" name="wpns_options[chk_items_meta]" <?php echo ($this->settings['chk_items_meta'] == 'on') ? 'checked' : ''; ?> />
				<i>Display meta section (Author, Date, Taxonomy)</i>
			</label>
			<br>
		</fieldset>
		<?php
	}

	/**
	 * Draw the section header group 2
	 */
	public function wpnsSectionDoc()
	{
		echo '<p class="separater"></p>';
		echo '<p>* Use this shortcode in content of the page or post or custom post type: <code>[wpns_search_form]</code></p>';
		echo '<p>* To use this shortcode in template file: <code>&lt;?php echo do_shortcode("[wpns_search_form]"); ?&gt;</code></p>';
		echo '<p>* Shortcode Options: </p>';
		echo '<ul style="margin-left:20px;">';
		echo '<li><label><b>only_search </b>(optional): This option determine place searching. ( Ex: <code>[wpns_search_form only_search="page"]</code> This shortcode only search in the pages)</label></li>';
		echo '</ul>';
	}

	/**
	 * Validation options callback function
	 * @param mix $input Holds values of option fields
	 *
	 * @return mix $valid
	 */
	public function wpns_validate_options($input)
	{

		$valid = array();
		//$valid['wpns_placeholder'] = preg_replace( '/[^a-zA-Z. ]/', '', $input['wpns_placeholder'] );
		$valid['wpns_placeholder'] = $input['wpns_placeholder'];

		// checkbox value
		$valid['wpns_in_all'] = $input['wpns_in_all'];
		$valid['wpns_in_post'] = $input['wpns_in_post'];
		$valid['wpns_in_page'] = $input['wpns_in_page'];
		//$valid['wpns_in_category'] = $input['wpns_in_category'];
		$valid['wpns_in_custom_post_type'] = $input['wpns_in_custom_post_type'];
		$valid['wpns_items_featured'] = $input['wpns_items_featured'];
		$valid['chk_items_meta'] = $input['chk_items_meta'];

		return $valid;
	}

	/**
	 * Get option values from database
	 * @var string $name Holds option name
	 *
	 * @return array $options
	 */
	public function wpns_get_options($name = '')
	{
		$options = get_option($name);
		$this->settings = $options;
	}

} // end class WpnsAdmin