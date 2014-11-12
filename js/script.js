jQuery(document).ready(function(){
	

	jQuery('.mz_accordion li div').hide();

	jQuery('.mz_accordion li h3').on('click' , function(){

        //Do a text reset
        jQuery('.mz_accordion li h3 small').html('Click to expand');

        var textObj = jQuery(this).find('small');
        var text = textObj.html();

		jQuery('div.mz_accordion_item').slideUp( 100 );

		var item = jQuery(this).parent().attr('class');

		item = item + '_inner';

		jQuery('div.' + item ).slideToggle( 300 );

        //Tidy up the sexy text
        if (text == 'Click to expand'){
            text = 'Click to close';
        } else {
            text = 'Click to expand';
        }

        textObj.html(text);

	});




    jQuery('.mz_accord').hide();

    jQuery('a.mz_accordion_button').on('click' , function(){

        //Do a text reset
        jQuery('a.mz_accordion_button').html('INFO');

        var text = jQuery(this).html();

        jQuery('.mz_accord').slideUp( 100 );

        var item = jQuery(this).attr('rel');

        item = item + '_inner';

        if ( jQuery('.' + item ).is(":visible") ){
            jQuery('.' + item ).slideUp( 300 );
            jQuery(this).html('INFO');
        } else {
            jQuery('.' + item ).slideDown( 300 );
            jQuery(this).html('LESS INFO');
        }

    });

});
