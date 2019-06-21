/*
** matchHeights
*/
$('.mayv2-home-services p.h3').matchHeight();
$('.mayv2-project-preview-logo').matchHeight();
$('.mayv2-home-location-img').matchHeight();


/*
** load events from provectus.com and initialize slick slider
*/
$.ajax({
	type: 'POST',
	url : "/wp-admin/admin-ajax.php",
	data: {
		'action': 'load_provectus_events',
	},
	dataType : 'JSON',
})
	.done(function(response) {
		if (response.status == 'ok') {
			$('.mayv2-events-wrapper').show();
			$('.mayv2-events').append(response.content);

			/*
			** hide events images on mobile
			*/
			if ($(window).width() < 768) {
				$('.mayv2-event-img img').each(function() {
					console.log('test');
					$(this).removeAttr('data-lazy');
				});
			}

			$('.mayv2-events').on('init', function() {
				setTimeout(function() {
					$('.mayv2-events-wrapper').css('opacity', 1);
				}, 300);
			});
			$('.mayv2-events').slick({
				dots: true,
				arrows: false,
				autoplay: false,
			});
		} else {
			console.log('provectus.com events failed to load');
		}
	})
	.fail(function(response) {
		console.log('provectus.com events failed to load');
	});