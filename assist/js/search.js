/**
 * Get keyword from search form and send it to backend.
 * Once quite it'll display a list of results search.
 * 
 */

jQuery(document).ready(function($){
	var $ = jQuery;

	//result_box = $('#wpns_results_box');
	//loading = $('#wpns_loading_search');
	//search_icon = $('#wpns_search_icon');

	// test code
/*	$('#test_input').(function(){

	});*/

	var data = {
		action : 'get_results',
	};
	$.post(wpns_ajax_url.ajaxurl, data, function(response){
		//console.log(response);
		$('.results').empty();
		$('.results').append(response);
	});
	
    $("#test_input").keyup(function(){
    	var count = 0;
    	//loading.show();
        // Retrieve the input field text and reset the count to zero
        var filter = $(this).val();
        count = 0;
        // Loop through the comment list
        $(".post-title").each(function(){
            // If the list item does not contain the text phrase fade it out
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).parentsUntil($('.list-results')).fadeOut();
            // Show the list item if the phrase matches and increase the count by 1
            } else {
		        if (filter == '') {
		        	$('.results').hide();
		        } else {
		        	$('.results').show();
		        }
		        $(this).parentsUntil($('.list-results')).fadeIn();
		        count++;
            }
        });
    });
    
	/* Disabled submit event of the form */
	$('#test_form').submit(function(e){
		e.preventDefault();
	});
});