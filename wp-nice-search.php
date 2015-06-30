<?php
/**
 * Plugin Name: WP Nice Search
 * Description: Live search post in wordpress
 * Version: 1.0.0
 * Author: Duy Nguyen
 * License: GPLv2
 */

define( 'WPNS_DIR', dirname(__FILE__) );

define( 'WPNS_URL', plugin_dir_url( __FILE__ ) );

require WPNS_DIR . '/src/loader.php';
