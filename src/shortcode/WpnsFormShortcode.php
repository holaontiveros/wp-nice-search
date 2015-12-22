<?php

namespace shortcode;

use core\Results\Results as Results;
use core\Results\ResultCase\DefaultResult as DefaultResult;
use core\Results\ResultCase\ImageResult as ImageResult;
use core\Results\ResultCase\MetaResult as MetaResult;
use core\Results\ResultCase\FullResult as FullResult;

/**
 * Create a search form
 */

class WpnsFormShortcode
{
	/**
	 * @var string $name This is the name of shortcode
	 */
	protected $name = 'wpns_search_form';

	/**
	 * Initilize
	 */
	public function __construct()
	{
		add_shortcode($this->name, array(&$this, 'wpns_form_render'));
	}

	/**
	 * Function render html of form
	 * @param array $atts
	 */
	public function wpns_form_render($atts)
	{
		ob_start();

		$options = shortcode_atts(
			array(
				'only_search' => '',
			),
			$atts
		);

		// $settings = get_option( 'wpns_options' );
		// $settings['wpns_only_search'] = $options['only_search'];
		// update_option( 'wpns_options' , $settings);

		// if ($settings['wpns_items_featured'] == 'on' && $settings['chk_items_meta'] == 'on') {
		// 	new FullResult;
		// } elseif ($settings['chk_items_meta'] == 'on') {
		// 	new MetaResult;
		// } elseif ($settings['wpns_items_featured'] == 'on') {
		// 	new ImageResult;
		// } else {
		// 	new DefaultResult;
		// }

		include WPNS_DIR . '/test/TestForm.php';

		return ob_get_clean();
	}

}// end class WpnsShortcodeForm