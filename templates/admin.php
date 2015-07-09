<div class="wrap">
	<h3>WP NICE SEARCH SETTINGS <span class="dashicons dashicons-admin-settings"></span></h3>
	<form method="POST" action="">
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="wpns_placeholder">Search in: </label></th>
				<td>
					<fieldset>
						<label>
							<input type="checkbox" name="wpns_placeholder" checked />
							Post
						</label>
						<br>
						<label>
							<input type="checkbox" name="wpns_placeholder"/>
							Page
						</label>
						<br>
						<label>
							<input type="checkbox" name="wpns_placeholder"/>
							Taxonomy
						</label>
						<br>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="wpns_placeholder">Placeholder Text</label></th>
				<td><input type="text" class="regular-text" name="wpns_placeholder"/></td>
			</tr>
		</table>
		<p class="submit">
			<input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit">
			<input type="submit" value="Reset" class="button button-secondary" id="submit" name="submit">
		</p>
	</form>
</div>