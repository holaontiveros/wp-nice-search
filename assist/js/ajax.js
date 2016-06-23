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
	var search = $("#ajax_form input[type='text']");

	var debug = $('#debug');

	search.keyup(function(e){

        var filter = $(this).val();

        //console.log(filter);

        $.ajax({

	        type: "POST",

	        url:'http://thebest.dev/wp-content/plugins/wp-nice-search/function.php',

	        data: {

	        	s: filter

	        },

	        dataType: 'json',

	        success: function(d){

	            console.log('ok');

	            debug.empty();

	            debug.append(d);
	        },

	        error: function(xhr, status, error){

	        	console.log('error');

	        }
    	});		

	});
	
});