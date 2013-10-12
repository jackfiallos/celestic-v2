jQuery(document).ready(function(){
	jQuery('.projectlnk').on('click', function(e) {
		e.preventDefault();
		if (!jQuery(this).hasClass('open')) {
			jQuery(this).next().css('margin-top', '250px');
			jQuery(this).css('overflow', 'visible').addClass('open');
		}
		else {
			jQuery(this).next().css('margin-top', '0');
			jQuery(this).css('overflow', 'hidden').removeClass('open');
		}
	});

	jQuery('.projectlnk .projectlist').on('click', function(e) {
		e.stopPropagation();
	});
});