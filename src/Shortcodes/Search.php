<?php
/**
 * Create search shortcode
 * 
 * @package wpnt
 * @since   1.1.0
 * @author  Duy Nguyen <duyngha@gmail.com>
 */

namespace WPNS\Shortcodes;

use Shortcode\Classes\Shortcode as Shortcode;
use Corcel\Options as Options;

class Search extends Shortcode
{
	public function __construct()
	{
		$this->shortcodeName = 'wpns_search_form_test';

		$this->setPlatesPath(WPNS_DIR . '/templates');

		$this->setTemplate('search');

		$this->setPlates();

	}

	public function callback($atts, $cont)
	{
		$options = shortcode_atts(
			array(
				'only_search' => '',
			),
			$atts
		);

		$settings = Options::get('wpns_options');

		$settings['wpns_only_search'] = $options['only_search'];

		echo $this->plates->render($this->templateName, ['options' => $options, 'settings' => $settings]);
	}
}