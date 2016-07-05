<?php
/**
 * Plugin Name: WP Nice Search
 * Description: Live search for wordpress
 * Version: 1.1.0
 * Author: Duy Nguyen
 * Author URI: http://duywp.com
 * License: MIT
 */

define('WPNS_DIR', dirname(__FILE__));
define('WPNS_URL', plugin_dir_url(__FILE__));
define('WPNS_PLUGIN_VER', '1.1.0');
define('WPNS_REQUIRE_VER', '4.0');
define('WPNS_FILE', __FILE__);

require_once __DIR__ . '/vendor/autoload.php';

require_once WPNS_DIR . '/src/init.php';