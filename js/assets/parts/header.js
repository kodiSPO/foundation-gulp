/*
** fixed header
*/
function fixedHeader() {
	var scroll = $(window).scrollTop();
	var wpbarH = $('#wpadminbar').outerHeight() || 0;
	if (scroll > (0 + wpbarH)) {
		$('.mayv2-header').addClass('fixed');
	} else {
		$('.mayv2-header').removeClass('fixed');
	}
}
fixedHeader(); $('.mayv2-header').show(); $(window).scroll(function() {fixedHeader();});