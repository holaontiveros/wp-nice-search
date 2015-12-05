<?php

namespace core;

/**
 * Register script for ajax script and handle request search ajax
 * 
 * @since 1.0.0
 * @author Duy Nguyen
 */
class WpnsRegisterScript {
	/**
	 * Initiliaze
	 */
	function __construct()
	{
		add_action(
			'template_redirect',
			array(&$this, 'wpns_register_script')
		);

		// test code
		// enable ajax for logged-in user
		add_action(
			'wp_ajax_get_results',
			array(&$this, 'TestData')
		);
		// enabled ajax for visitors user
		add_action(
			'wp_ajax_nopriv_get_results',
			array(&$this, 'TestData')
		);
	}


	public function TestData()
	{
		$path = WPNS_DIR . '/src/templates/ListResults.php';
		$data = file_get_contents($path);
		echo $data;
		wp_die();
	}


	/**
	 * Add script for ajax request
	 */
	public function wpns_register_script()
	{
		wp_enqueue_script(
			'wpns_ajax_search',
			WPNS_URL . 'assist/js/search.js',
			array('jquery'),
			'',
			true
		);

		$protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
		$params = array(
			'ajaxurl' => admin_url('admin-ajax.php', $protocol)
		);
		wp_localize_script('wpns_ajax_search', 'wpns_ajax_url', $params);
	}
}// end class WpnsRegisterScript
