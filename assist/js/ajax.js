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

	var form = $('#ajax_form');

	//var list = $('#results_list');

	var list = $('.list-results');

	var loadmoreBox = $('#loadmore');

	var loadmore = '#loadmore button';

	var moreloading = $('#moreloading');

	var keyword;

	var currentPage = $('input[name="current_page"]').val();

	var onlySearch = $('input[name="only_search"]').val();

	var url = form.attr('action');

	var method = form.attr('method');

	loadmoreBox.hide();

	moreloading.hide();

	form.submit(function(e){

		e.preventDefault();

	});

	// searching
	search.keyup(function(e){

        keyword = $(this).val();

        if (keyword == '') return;

        $.ajax({

	        type: method,

	        url: url,

	        data: {

	        	s: keyword,

	        	page: currentPage,

	        	onlySearch: onlySearch

	        },

	        dataType: 'json',

	        success: function(d){

	            //console.log('ok');

	            list.empty();

	            list.append(d);

	            loadmoreBox.show();

	        },

	        error: function(xhr, status, error){

	        	console.log('error');

	        }
    	});		

	});

	// load more results
	$(document).on('click', loadmore, function(){

		currentPage = parseInt(currentPage);

		currentPage++;

		moreloading.show();

        $.ajax({

	        type: method,

	        url: url,

	        data: {

	        	s: keyword,

	        	page: currentPage,

	        	onlySearch: onlySearch

	        },

	        dataType: 'json',

	        success: function(d){

	        	if (d.length == 0) {

	        		loadmoreBox.hide();

	        	} else {

	        		list.append(d);

	        	}

	        	moreloading.hide();

	        },

	        error: function(xhr, status, error){

	        	console.log('error');

	        }
    	});		

	});

	function ajax(form, keyword, offset)
	{


	}
	
});