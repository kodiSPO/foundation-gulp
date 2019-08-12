/*
** fixed header
*/
function fixedHeader() {
	var scroll = $(window).scrollTop();
	var wpbarH = $('#wpadminbar').outerHeight() || 0;
	if (scroll > (0 + wpbarH)) {
		$('.header').addClass('fixed');
	} else {
		$('.header').removeClass('fixed');
	}
}
fixedHeader(); $('.header').show(); $(window).scroll(function() {fixedHeader();});
