/**
 * Get keyword from search form and send it to backend.
 * Once quite it'll display a list of results search.
 * 
 */

jQuery(document).ready(function($){
	var $ = jQuery;

	result_box = $('#wpns_results_box');
	loading = $('#wpns_loading_search');
	search_icon = $('#wpns_search_icon');

	// test code
	$('#test_input').click(function(){
		var data = {
			action : 'get_results',
		};
		$.post(wpns_ajax_url.ajaxurl, data, function(response){
			console.log(response);
			$('.results').empty();
			$('.results').append(response);
		});
	});

    $("#test_input").keyup(function(){
    	loading.show();
        // Retrieve the input field text and reset the count to zero
        var filter = $(this).val();
 
        // Loop through the comment list
        $(".results li").each(function(){
 
            // If the list item does not contain the text phrase fade it out
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).fadeOut();
 
            // Show the list item if the phrase matches and increase the count by 1
            } else {
		        if (filter == '') {
		        	$('.results').hide();
		        } else {
		        	$('.results').show();
		        }
                $(this).show();
            }
        });
    });

	compare_key = '';
	/* event occurs when people type */
	$('#wpns_search_input').keyup(function(){

		result_box.hide();

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
						$('.wpns_results_list').remove();
						loading.hide();
						search_icon.show();
						result_box.append(response).slideDown(300);
					});
					compare_key = keyword;

		    });
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