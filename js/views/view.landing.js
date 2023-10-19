/*
Name: 			View - Landing
Written by: 	Okler Themes - (http://www.e-Prescriber)
Theme Version:	9.9.3
*/

(function( $ ) {
	
	'use strict';

	var timeout = false;

	$('#demoFilter').keyup(function() {

		if(!timeout) {

			timeout = true;

			$('html, body').animate({
				scrollTop: $('#demos').offset().top - 90
			}, 600, 'easeOutQuad', function() {
				$('body').removeClass('scrolling');
				timeout = false;
			});

		}

	});

}).apply( this, [ jQuery ]);
