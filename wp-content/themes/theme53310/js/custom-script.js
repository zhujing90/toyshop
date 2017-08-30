(function($) {
    $(function(){
    	//Dropdown cart in header
		$('.cart-holder > h3').click(function(){
			if($(this).hasClass('cart-opened')) {
				$(this).removeClass('cart-opened').next().slideUp(300);
			} else {
				$(this).addClass('cart-opened').next().slideDown(300);
			}
		});
		//Popup rating content
		// $('.star-rating').each(function(){
		// 	rate_cont = $(this).attr('title');
		// 	$(this).append('<b class="rate_content">' + rate_cont + '</b>');
		// });
		//Fix contact form not valid messages errors
		jQuery(window).load(function() {
			jQuery('.wpcf7-not-valid-tip').live('mouseover', function(){
				jQuery(this).fadeOut();
			});

			jQuery('.wpcf7-form input[type="reset"]').live('click', function(){
				jQuery('.wpcf7-not-valid-tip, .wpcf7-response-output').fadeOut();
			});
		});

		// compare trigger
		$(document).on('click', '.cherry-compare', function(event) {
			event.preventDefault();
			button = $(this);
			$('body').trigger( 'yith_woocompare_open_popup', { response: compare_data.table_url, button: button } )
		});

		jQuery(".owl-carousel .owl-item .item").addClass("maxheight");

		(function() {

			function addAnimation(selector, start, diff, classToAdd) {
				var elements = jQuery(selector);
				var duration = 1;
				elements.each(function() {
					jQuery(this).attr('data-wow-duration', duration + 's');
					jQuery(this).addClass('wow ' + classToAdd);
					jQuery(this).attr('data-wow-delay', (start += diff) + 's');
				});
			}

			if (jQuery('body').hasClass('home') && jQuery('html').hasClass('desktop')) {
				addAnimation('h2', 0.1, 0, 'fadeIn');
				addAnimation('.banners-wrapper1 .banner-wrap', 0, 0.1, 'fadeIn');
				addAnimation('.parallax-block1 .service-box', 0, 0.1, 'fadeIn');
				addAnimation('.featured-products_wrapper .product', 0, 0.1, 'fadeIn');
				addAnimation('.parallax-block2 .posts-grid li', 0, 0.1, 'fadeIn');
				addAnimation('.parallax-block2 .btn-default', 0, 0.1, 'fadeIn');
				addAnimation('.carousel-wrap .item', 0, 0.1, 'fadeIn');
				addAnimation('.newsletter_wrapper p', 0, 0.1, 'fadeIn');
				addAnimation('.newsletter_wrapper .nsu-form', 0, 0.2, 'fadeIn');
			}
		})();

        $('.triangle_block').fullwidth_stretcher();

    });
})(jQuery);