jQuery(document).ready(function(){
	

	jQuery('ul.mz_accordion li div').hide();

	jQuery('ul.mz_accordion li h3').on('click' , function(){

		jQuery('div.mz_accordion_item').slideUp( 100 );

		var item = jQuery(this).parent().attr('class');

		item = item + '_inner';

		jQuery('div.' + item ).slideToggle( 300 );
		console.log(item);

	});

});
