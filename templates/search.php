<div class="search-holder">
	<!-- DEBUG SECTION -->
	<div id="debug"></div>

	<!-- FORM SECTION -->
	<form id="ajax_form" method="POST" action="<?php echo WPNS_URL . 'function.php'; ?>">
		<div class="form-group">
			<input type="text" class="form-control" name="testname" placeholder="What are you looking for?"/>
		</div>
		<input type="hidden" name="only_search" value="<?php echo $settings['wpns_only_search']; ?>">
		<input type="hidden" name="current_page" value="1">
	</form>

	<!-- LIST RESULTS -->
	<div id="results_list" class="row">
		<ul class="list-results"></ul>
		<div id="loadmore">
			<button class="btn btn-default">
				<span>
					<?php 
						echo __('Load more', 'wpns'); ?>
				</span>
				<img id="moreloading" src="<?php echo WPNS_URL . 'assist/images/loading_2.gif'; ?>" />
			</button>
		</div>
	</div>
</div>
<!-- END SEARCH -->