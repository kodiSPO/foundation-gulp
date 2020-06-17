/* all scripts are in ./parts/ folder */


// <div class="row vacancy-list"></div>
// <div id="load-more" paged="0" posts_per_page="6" status="ready"></div>


/*
** vacancies - load vacancies via ajax
*/
// function loadVacanciesViaAjax() {
// 	var that           = $('#load-more');
// 	var paged          = that.attr('paged');
// 	var posts_per_page = that.attr('posts_per_page');
// 	var status         = that.attr('status');

// 	if (that.attr('status') !== 'ready') return false;

// 	that.attr('status', 'loading');

// 	$.ajax({
// 		type : 'POST',
// 		url  : document.location.origin + "/wp-admin/admin-ajax.php",
// 		data : {
// 			'action'        : 'load_more_vacancies',
// 			'paged'         : paged,
// 			'posts_per_page': posts_per_page,
// 		},
// 		dataType : 'JSON',
// 		success: function(response) {
// 			that.attr('paged', response.paged);

// 			$('.vacancy-list').append(response.content);
// 			initLazyLoad();

// 			if (response.no_more) {
// 				that.attr('status', 'nomore');
// 			} else {
// 				that.attr('status', 'ready');
// 			}

// 			// repeat
// 			loadVacanciesOnScroll();
// 		}
// 	});
// }


/*
** vacancies - bind ajax load to scroll
*/
// function loadVacanciesOnScroll() {
// 	var scrollTop    = $(window).scrollTop();
// 	var windowHeight = $(window).height();
// 	if ($('#load-more').length && (scrollTop + windowHeight) > $('#load-more').offset().top) {
// 		loadVacanciesViaAjax();
// 	}
// }
// loadVacanciesOnScroll(); $(window).scroll(function() { loadVacanciesOnScroll(); });

