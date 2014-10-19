jQuery(document).ready(function(){
	

	jQuery('ul.mz_accordion li div').hide();

	jQuery('ul.mz_accordion li h3').on('click' , function(){

        //Do a text reset
        jQuery('ul.mz_accordion li h3 small').html('Click to expand');

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

});
