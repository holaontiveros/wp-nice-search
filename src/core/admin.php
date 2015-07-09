<?php
/**
 * Create admin page and register script for plugin
 * @package wpns
 * @author Duy Nguyen
 */

class WPNS_Admin {
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
	protected $capability = 'read';

	/**
	 * @var string $menu_slug A unique slug name to refer to plugin menu
	 */
	protected $menu_slug = 'wpns-nice-search-menu';

	/**
	 * Initiliaze
	 */
	function __construct() {
		add_action( 'wp_enqueue_scripts', array( &$this, 'wpns_plugin_script' ) );
		add_action( 'admin_menu', array( &$this, 'wpns_add_plugin_page' ) );
	}

	/**
	 * function callback to enqueue scripts and style
	 */
	public function wpns_plugin_script() {
		wp_enqueue_style( 'wpns-style', WPNS_URL . 'assist/css/style.min.css' );
		wp_enqueue_style( 'wpns-fontawesome', WPNS_URL . 'assist/css/font-awesome.min.css' );
	}

	/**
	 * function callback to add plugin page in plugins menu
	 */
	public function wpns_add_plugin_page() {
		add_plugins_page( $this->page_title, $this->menu_title, $this->capability, $this->menu_slug, array( &$this, 'wpns_html_plugin_page' ) );
	}

	/**
	 * function callback to render html for plugin page
	 */
	public function wpns_html_plugin_page() {
		include WPNS_DIR . '/templates/admin.php';
	}

} // end class WPNS_Admin

new WPNS_Admin;