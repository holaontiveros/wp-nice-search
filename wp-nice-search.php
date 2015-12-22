<?php
/**
 * Plugin Name: WP Nice Search
 * Description: Live search for wordpress
 * Version: 1.0.7
 * Author: Duy Nguyen
 * Author URI: duywp.com
 * License: GPL v2
 */

define('WPNS_DIR', dirname(__FILE__));
define('WPNS_URL', plugin_dir_url( __FILE__ ));
define('WPNS_PLUGIN_VER', '1.0.7');
define('WPNS_REQUIRE_VER', '4.0');
require_once WPNS_DIR . '/src/init.php';

register_activation_hook(__DIR__, 'wpnsCheckActivate');

/**
 * Activate action
 */
function wpnsCheckActivate()
{
	$default_settings = array(
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