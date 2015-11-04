<?php
/**
 * Plugin Name: WP Nice Search
 * Description: Live search for wordpress
 * Version: 1.0.6
 * Author: Duy Nguyen
 * Author URI: duywp.com
 * License: GPL v2
 */

define('WPNS_DIR', dirname(__FILE__));

define('WPNS_URL', plugin_dir_url( __FILE__ ));

define('WPNS_PLUGIN_VER', '1.0.7');

define('WPNS_REQUIRE_VER', '3.9');

require_once WPNS_DIR . '/src/init.php';

register_activation_hook(__DIR__, 'wpnsCheckActivate');

/**
 * Activate action
 */
function wpnsCheckActivate()
{
	$default_settings = array(
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
		//special options
		'wpns_only_search' => '',
	);

	if (version_compare(get_bloginfo('version'), WPNS_REQUIRE_VER, '<')) {
		deactivate_plugins(basename(WPNS_DIR . '/wp-nice-search.php'));
		wp_die(
			'Current version of wordpress is lower require version (' . WPNS_REQUIRE_VER . ')'
		);
	} else {
		// Save default settings and configution
		update_option('wpns_options' , $default_settings);
	}
}