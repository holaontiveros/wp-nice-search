<?php
/**
 * Create filter shortcode
 * 
 * @package wpnt
 * @since   1.1.0
 * @author  Duy Nguyen <duyngha@gmail.com>
 */

namespace WPNS\Shortcodes;

use Shortcode\Classes\Shortcode as Shortcode;
use Corcel\Options as Options;

class Filter extends Shortcode
{
	public function __construct()
	{
		$this->shortcodeName = 'wpns_filter_form';

		$this->setPlatesPath(WPNS_DIR . '/templates');

		$this->setTemplate('filter_form');

		$this->setPlates();

		//$this->registerScript();

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

	public function registerScript()
	{
		add_action('wp_enqueue_scripts', [$this, 'scripts']);
	}

	public function scripts()
	{
		wp_enqueue_script('wpns_ajax_search', WPNS_URL . '/assist/js/ajax.js', ['jquery'], WPNS_PLUGIN_VER, true);
	}
}