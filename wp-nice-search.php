<?php
/**
 * Plugin Name: WP Nice Search
 * Description: Live search for wordpress
 * Version: 1.0.9
 * Author: Duy Nguyen
 * Author URI: duywp.com
 * License: GPL v2
 */

/**
 * @todo create new response from server
 * @todo update panel in admin
 */

define('WPNS_DIR', dirname(__FILE__));
define('WPNS_URL', plugin_dir_url(__FILE__));
define('WPNS_PLUGIN_VER', '1.0.9');
define('WPNS_REQUIRE_VER', '4.0');
define('WPNS_FILE', __FILE__);

require_once __DIR__ . '/vendor/autoload.php';

require_once WPNS_DIR . '/src/init.php';