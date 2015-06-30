jQuery(document).ready(function($){
	var $ = jQuery;

	/* event occurs when people type */
	$('#wpns_search_input').keyup(function(){

		$('#wpns_results_box').hide();
		$('.wpns_results_list').remove();

		var keyword = $(this).val();

		/* Show/Hide loading and search icon */
		$('#wpns_loading_search').show();
		$('#wpns_search_icon').hide();

		/* */

	    delay(function(){
			var data = {
				action : 'wpns_search_ajax',
				keyword : keyword,
			};
			$.post(wpns_ajax_url.ajaxurl, data, function(response){
				$('#wpns_loading_search').hide();
				$('#wpns_search_icon').show();

				$('#wpns_results_box').append(response).slideDown(300);
				//alert(response);

			});
	    }, 1000 );	

		return false;
	});
	

	/* Hide results box when click around the box */
	$(':not(#wpns_results_box)').click(function(){
		$('#wpns_results_box').hide();
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