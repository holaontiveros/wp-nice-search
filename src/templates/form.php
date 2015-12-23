<div class="wpns-search-box">
	<form id="wpns_search_form" method="POST">
		<div class="wpns-input-box">
			<input type="text" id="wpns_input_search" class="wpns-input" data-only="<?php echo $options['only_search']; ?>" placeholder="<?php echo $settings['wpns_placeholder']; ?>">
			<i id="wpns_search_icon" class="fa fa-search"></i>
			<img style="display: none;" id="wpns_loading_search" src="<?php echo WPNS_URL . 'assist/images/loading_2.gif'; ?>">
		</div>
		<div class="results" style="display:none;"></div>
	</form>
</div>