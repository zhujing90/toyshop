/**
 * Cherry WooCommerce package scripts
 */

jQuery(document).ready(function($) {

	//Dropdown account in header
	$('.cherry-wc-account_title').click(function(event){
		event.preventDefault();
		event.stopPropagation();
		if( $(this).hasClass('cherry-dropdown-opened') ) {
			$(this).removeClass('cherry-dropdown-opened')
			$(this).parent().find('.cherry-wc-account_content').slideUp(300).removeClass('opened');
		} else {
			$(this).addClass('cherry-dropdown-opened')
			$(this).parent().find('.cherry-wc-account_content').slideDown(300).addClass('opened');
		}
	});

	$(document).on('click', 'body', function(event) {
		$(this).find('.cherry-wc-account_content.opened').slideUp(300).removeClass('opened');
		$(this).find('.cherry-dropdown-opened').removeClass('cherry-dropdown-opened');
	});

	$(document).on('click', '.cherry-wc-account_content', function(event) {
		event.stopPropagation();
	})

	$('.sf-menu > li > .cherry-badge').each(function(){
		$(this).append('<b class="cherry-badge-content">' + $(this).data('badge-text') + '</b>');
	}); 

});