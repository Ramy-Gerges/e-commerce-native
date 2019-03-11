$(function() {

	'use strict';

	// Switch Between Login and SignUp

	$('.login-page h1 span').click(function(){

		$(this).addClass('selected').siblings().removeClass('selected');


		$('.login-page form').hide();

		$('.' + $(this).data('class')).fadeIn(100);

	});

	// Hide Place Holder On Form Focus

	$('[placeholder]').focus(function() {

		$(this).attr('data-text', $(this).attr('placeholder'));

		$(this).attr('placeholder', '');
		
	}).blur(function() {

		$(this).attr('placeholder', $(this).attr('data-text'));

	});

	// Confirmation Message On Button

	$('.confirm').click(function() {

		return confirm('Are You Sure?');

	});


	// Live Name

	$('.live').keyup(function(){

		$($(this).data('class')).text($(this).val());

	});



});


















