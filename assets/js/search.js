jQuery(document).ready(function($){
	var $ = jQuery;

	result_box = $('#wpns_results_box');
	loading = $('#wpns_loading_search');
	search_icon = $('#wpns_search_icon');
	compare_key = '';
	/* event occurs when people type */
	$('#wpns_search_input').keyup(function(){

		result_box.hide();
		$('.wpns_results_list').remove();

		var keyword = $(this).val();

		if (keyword != '' && keyword != compare_key) {
			/* Show/Hide loading and search icon */
			loading.show();
			search_icon.hide();

			/* delay keyup event */
		    delay(function(){
		    	
					var data = {
						action : 'wpns_search_ajax',
						keyword : keyword,
					};
					$.post(wpns_ajax_url.ajaxurl, data, function(response){
						loading.hide();
						search_icon.show();
						result_box.append(response).slideDown(300);
					});
					compare_key = keyword;

		    }, 1000 );
	    }
	    
		return false;
	});
	

	/* Hide results box when click around the box */
	$(':not(#wpns_results_box)').click(function(){
		result_box.hide();
	});
	
	/* Set delay time and clear settimeout */
	var delay = (function(){
		var timer = 0;
		return function(callback, ms){
			clearTimeout(timer);
			timer = setTimeout(callback, ms);
		};
	})();

	/* Disabled submit event of the form */
	$('#wpns_search_form').submit(function(e){
		e.preventDefault();
	});
});