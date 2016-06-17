/**
 * This script was built for laravel ajax request
 * 
 * @author  Duy Nguyen <duyngha@gmail.com>
 * @since   1.1.0
 * @license MIT
 */

jQuery(document).ready(function($){
	var $ = jQuery;
	// version 2 demo
	var search_button = $("#ajax_form input[type='text']");
	search_button.on('keyup', function(event){
        var filter = $(this).val();
        //console.log(filter);
        $.ajax({

	        type: "POST",
	        url:'http://thebest.dev/wp-content/plugins/wp-nice-search/function.php',
	        data: {
	        	s: filter
	        },
	        dataType: 'json',
	        success: function(data){
	            //console.log(data);
	            $('#debug').append(data);
	        },
	        error: function(data){

	        }
    	});

	});
	
});