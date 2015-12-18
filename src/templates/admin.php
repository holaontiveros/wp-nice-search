<div class="wrap">
	<h2>WP NICE SEARCH SETTINGS <span class="dashicons dashicons-admin-settings"></span></h2>
	<form method="POST" action="options.php" style="width: 60%;float:left;margin-right: 15px;">
		<?php 
			settings_fields('wpns_options');
			do_settings_sections($this->menu_slug);
		?>
		<p class="submit">
			<input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit">
		</p>
	</form>
	<div class="sidebar">
		<h3>Documentation</h3>
		<ul>
			<li>
				<a target="_blank" href="https://github.com/duyngha/wp-nice-search/wiki/Filters">Filters References</a>
			</li>
		</ul>
	</div>
</div>