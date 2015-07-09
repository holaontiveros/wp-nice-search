<div class="wrap">
	<h3>WP NICE SEARCH SETTINGS <span class="dashicons dashicons-admin-settings"></span></h3>
	<form method="POST" action="options.php">
		<?php 
			settings_fields( 'wpns_options' );
			do_settings_sections( $this->menu_slug );
		?>
		<p class="submit">
			<input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit">
		</p>
	</form>
</div>