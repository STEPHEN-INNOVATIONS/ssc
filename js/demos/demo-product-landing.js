/*
Name: 			Product Landing
Written by: 	Okler Themes - (http://www.e-Prescriber)
Theme Version:	9.9.3
*/

(function( $ ) {

	'use strict';

	/*
	Quantity
	*/
    $('.quantity .plus').on('click',function(){
        var $qty=$(this).parents('.quantity').find('.qty');
        var currentVal = parseInt($qty.val());
        if (!isNaN(currentVal)) {
            $qty.val(currentVal + 1);
        }
    });

    $('.quantity .minus').on('click',function(){
        var $qty=$(this).parents('.quantity').find('.qty');
        var currentVal = parseInt($qty.val());
        if (!isNaN(currentVal) && currentVal > 0) {
            $qty.val(currentVal - 1);
        }
    });

}).apply( this, [ jQuery ]);