<?php

use core\Results\Results as Results;
use core\Results\ResultCase\DefaultResult as DefaultResult;
use core\Results\ResultCase\ImageResult as ImageResult;
use core\Results\ResultCase\MetaResult as MetaResult;
use core\Results\ResultCase\FullResult as FullResult;
use core\WpnsAdmin as WpnsAdmin;
use core\WpnsRegisterScript as WpnsRegisterScript;
use shortcode\WpnsFormShortcode as WpnsFormShortcode;

require WPNS_DIR . '/src/loader.php';

$GLOBALS['wp_rewrite'] = new \WP_Rewrite();

new WpnsAdmin;
new WpnsFormShortcode;
new WpnsRegisterScript;