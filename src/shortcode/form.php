<?php
/**
 * Create a search form
 */

class WPNS_Form {
	/**
	 * @var string $name This is the name of shortcode
	 */
	protected $name = 'wpns_search_form';

	/**
	 * Initilize
	 */
	function __construct() {
		add_shortcode($this->name, array(&$this, 'wpns_form_render'));
	}

	/**
	 * Function render html of form
	 */
	public function wpns_form_render( $atts ) {
		ob_start();
		$options = shortcode_atts( array(
			'only_search' => '',
		), $atts );
		$settings = get_option( 'wpns_options' );
		$settings['wpns_only_search'] = $options['only_search'];
		update_option( 'wpns_options' , $settings);
		include WPNS_DIR . '/src/templates/form.php';
		return ob_get_clean();
	}

}// end class

new WPNS_Form;