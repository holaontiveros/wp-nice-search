/**
 * Get keyword from search form and send it to backend.
 * Once quite it'll display a list of results search.
 * 
 */

jQuery(document).ready(function($){
	var $ = jQuery;
	// version 2 demo
    $("#test_input").keyup(function(){
    	var onlyPlace = $(this).attr('data-only');
    	var searchIcon = $('#wpns_search_icon');
    	var loading = $('#wpns_loading_search');
    	var resultsList = $('.results');
    	var minLength = 3;
        var filter = $(this).val();
        if (filter.length >= minLength) {
    		searchIcon.hide();
        	loading.show();
        	//console.log(filter);
		   	var data = {
				action : 'get_results',
				s: filter,
				only: onlyPlace
			};
			$.post(wpns_ajax_url.ajaxurl, data, function(response){
				//console.log(response);
				searchIcon.show();
				loading.hide();
				resultsList.empty();
				resultsList.append(response).fadeIn(300);
			});
        } else {
        	resultsList.fadeOut(200);
        }
    });

	/* Disabled submit event of the form */
	$('#test_form').submit(function(e){
		e.preventDefault();
	});
});