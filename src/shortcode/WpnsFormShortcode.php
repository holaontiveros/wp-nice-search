<?php
namespace shortcode;

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
		$settings = get_option('wpns_options');
		include WPNS_DIR . '/src/templates/form.php';
		return ob_get_clean();
	}

}// end class WpnsShortcodeForm