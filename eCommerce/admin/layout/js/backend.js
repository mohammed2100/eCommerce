$(function () {

	'use strict';

	//Hide Placeholder On Form Focus 

	$("[Placeholder]").focus(function () {

		$(this).attr('data-text', $(this).attr("Placeholder"));

		$(this).attr("Placeholder", "");

	    }).blur(function () {

			$(this).attr("Placeholder", $(this).attr('data-text'));
	    });

	    //Add Asterisk On Required Field
	    $('input').each(function () {

	    	if ($(this).attr('required') === 'required') {

	    		$(this).after('<span class="asterisk">*</span>');
	    	}
	    });

	   // Conver Password Field To Text Field On Haver
	   var passField = $('.password');
	   $('.show-pass').hover(function () {

	   		passField.attr('type','text');

	   }, function () {

	   		passField.attr('type','password');

	   });

	   //Confirmation Message On Buttom 'Emin Misin'
	   $('.confirm').click(function() {

	   	return confirm('Are You Sure ? ');
	   });

	   //Category View Option

	   $('.cat h3').click(function() {

	   		$(this).next('.full-view').fadeToggle(200);
	   });

	   $('.option span').click(function () {

	   		$(this).addClass('active').siblings('span').removeClass('active');

	   		if ($(this).data('view') === 'full') {

	   			$('.cat .full-view').fadeIn(100);
	   		} else {

	   			$('.cat .full-view').fadeOut(100);
	   		}


	   });

});


