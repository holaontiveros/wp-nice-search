<?php
namespace core;

use core\Results\ResultCase\DefaultResult as DefaultResult;
use core\Results\ResultCase\ImageResult as ImageResult;
use core\Results\ResultCase\MetaResult as MetaResult;
use core\Results\ResultCase\FullResult as FullResult;

/**
 * Register script for ajax script and handle request search ajax
 * @package wpns
 * @author Duy Nguyen
 * @since 1.0.0
 */
class WpnsRegisterScript {
	/**
	 * Initiliaze
	 * @since 1.0.1
	 */
	function __construct()
	{
		add_action(
			'template_redirect',
			array($this, 'wpns_register_script')
		);

		// enable ajax for logged-in user
		add_action(
			'wp_ajax_get_results',
			array($this, 'getDataAjax')
		);
		// enabled ajax for visitors user
		add_action(
			'wp_ajax_nopriv_get_results',
			array($this, 'getDataAjax')
		);
	}

	/**
	 * callback method to get data from client request
	 * @return void
	 * @since 1.0.7
	 */
	public function getDataAjax()
	{
		$s = $_POST['s'];
		$_SESSION['s'] = $s;
		$only = $_POST['only'];
		$settings = get_option( 'wpns_options' );
		$settings['wpns_only_search'] = $only;
		update_option( 'wpns_options' , $settings);
		if ($settings['wpns_items_featured'] == 'on' && $settings['chk_items_meta'] == 'on') {
			$obj = new FullResult($s);
		} elseif ($settings['chk_items_meta'] == 'on') {
			$obj = new MetaResult($s);
		} elseif ($settings['wpns_items_featured'] == 'on') {
			$obj = new ImageResult($s);
		} else {
			$obj = new DefaultResult($s);
		}
		$data = $obj->createList();
		echo $data;
		wp_die();
	}

	/**
	 * Add script for ajax request
	 * @since 1.0.1
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
