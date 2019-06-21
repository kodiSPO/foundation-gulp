/*
** lazy load
*/
// if ($(window).width() < 768) {
// 	$('.lazy.lazy-hide-on-mobile').each(function() {
// 		$(this).removeClass('lazy');
// 	});
// }


function initLazyLoad() {
	$('.lazy').Lazy({
		effect: "fadeIn",
		effectTime: 300,
		threshold: 300,
		afterLoad: function(element) {
			$(element[0]).addClass('lazy-loaded');
		}
	});
}
initLazyLoad();