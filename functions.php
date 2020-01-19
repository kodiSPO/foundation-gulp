<?php
/*
** Security improvements
*/
// Disable use XML-RPC
add_filter( 'xmlrpc_enabled', '__return_false' );

// remove WP version from meta tags and form the XML feeds
add_filter('the_generator', '__return_empty_string');

// Switching off REST API
add_filter('rest_enabled', '__return_false');

// Switching off REST API filters
remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
remove_action( 'wp_head', 'rest_output_link_wp_head', 10, 0 );
remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
remove_action( 'auth_cookie_malformed', 'rest_cookie_collect_status' );
remove_action( 'auth_cookie_expired', 'rest_cookie_collect_status' );
remove_action( 'auth_cookie_bad_username', 'rest_cookie_collect_status' );
remove_action( 'auth_cookie_bad_hash', 'rest_cookie_collect_status' );
remove_action( 'auth_cookie_valid', 'rest_cookie_collect_status' );
remove_filter( 'rest_authentication_errors', 'rest_cookie_check_errors', 100 );

// Switching off Embeds mixed up with REST API
remove_action( 'rest_api_init', 'wp_oembed_register_route');
remove_filter( 'rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4 );

remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );




// theme support
// add_theme_support('custom-logo');
add_theme_support('post-thumbnails');


/*
** custom image sizes
*/
// add_image_size('case-preview-865-450', 865, 450, true);
// add_image_size('post-preview-387-220', 387, 220, true);


// allow .svg through wp media uploader
function cc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


// enqueue scripts and styles
function theme_styles_scripts() {
	if (!is_admin()) {

		$theme_uri = get_template_directory_uri();
		$version   = '1.0.0';

		wp_deregister_script('wp-embed');
		remove_action('wp_head', 'print_emoji_detection_script', 7);
		remove_action('wp_print_styles', 'print_emoji_styles');
		wp_deregister_script('jquery');


		/*
		** load css
		*/
		// wp_enqueue_style('font-montserrat', 'https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700,900', array(), null);
		wp_enqueue_style('theme-css', $theme_uri .'/css/theme.min.css', array(), $version);

		/*
		** load js
		*/
		wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js', array(), null);
		wp_enqueue_script('theme-js', $theme_uri . '/js/theme.min.js', array('jquery'), $version, true);

	}
}
add_action('wp_enqueue_scripts', 'theme_styles_scripts');


// enqueue admin scripts and styles
function admin_theme_styles_scripts() {
	$theme_uri = get_template_directory_uri();
	$version   = '1.0.0';
	wp_enqueue_style('admin-css', $theme_uri .'/css/admin.css', array(), $version);
}
add_action( 'admin_enqueue_scripts', 'admin_theme_styles_scripts' );


// custom Walker
class Foundation_6_Walker extends Walker_Nav_Menu {
	/*
	 * Add vertical menu class and submenu data attribute to sub menus
	 */

	function start_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"vertical menu\" data-submenu>\n";
	}
}


// optional fallback
function f6_topbar_menu_fallback($args) {
	/*
	 * Instantiate new Page Walker class instead of applying a filter to the
	 * "wp_page_menu" function in the event there are multiple active menus in theme.
	 */

	$walker_page = new Walker_Page();
	$fallback = $walker_page->walk(get_pages(), 0);
	$fallback = str_replace("<ul class='children'>", '<ul class="menu">', $fallback);

	echo '<ul class="menu" data-responsive-menu="drilldown medium-dropdown">'.$fallback.'</ul>';
}


// register navigation menu
register_nav_menus(array(
	'main-nav'   => 'Main navigation',
));


// options page
if (function_exists('acf_add_options_page')) {
	acf_add_options_page();
}


// GF: add support to hide field labels
add_filter('gform_enable_field_label_visibility_settings', '__return_true');
// GF: Disable Automatic Scrolling On All Forms
add_filter( 'gform_confirmation_anchor', '__return_false' );


/*
** customize login screen
*/
function wordpress_login_styling() {
	?>
	<style type="text/css">
		.login {
			background-color: #fff;
		}

		.login #login h1 a {
			background-image: url('<?php //the_field('opt_colored_logo', 'option'); ?>');
			background-position: center;
			background-size: auto 100%;
			background-repeat: no-repeat;
			width: auto;
			height: 52px;
		}

		body.login #backtoblog a,
		body.login #nav a {
			color: #fff;
		}

		.login.login-password-protected {
			background-color: #f1f1f1;
		}

		.login.login-password-protected #login h1 a {
			background-image: url('<?php echo get_stylesheet_directory_uri() . '/images/rt-logo.png'; ?>');
			background-position: center;
			background-size: auto 100%;
			background-repeat: no-repeat;
			width: auto;
			height: 30px;
		}
	</style>
<?php }
// add_action( 'login_enqueue_scripts', 'wordpress_login_styling' );


// Removing menu pages
function remove_menus(){
	remove_menu_page( 'edit.php' );
	remove_menu_page( 'edit-comments.php' );
}
// add_action( 'admin_menu', 'remove_menus' );


/*
** dynamic submenu
*/
// if (isset($_GET['dev']) && $_GET['dev'] == 1) {

// 	if (!function_exists('projects_submenu')) {
// 		add_filter( 'wp_get_nav_menu_items', 'projects_submenu', 10, 3 );

// 		function projects_submenu( $items, $menu, $args ) {

// 			$child_items    = array();
// 			$menu_order     = count($items);
// 			$parent_item_id = 0;

// 			foreach ( $items as $item ) {
// 				if ( in_array('menu-item-projects', $item->classes) ){
// 					$parent_item_id = $item->ID;
// 				}
// 			}

// 			if($parent_item_id > 0){

// 				foreach ( get_posts( 'post_type=projects_post_type&numberposts=-1&order=DESC' ) as $post ) {
// 					$post->menu_item_parent = $parent_item_id;
// 					$post->post_type = 'nav_menu_item';
// 					$post->object = 'custom';
// 					$post->type = 'custom';
// 					$post->menu_order = ++$menu_order;
// 					$post->title = $post->post_title;
// 					$post->url = get_permalink( $post->ID );
// 					array_push($child_items, $post);
// 				}

// 			}

// 			return array_merge( $items, $child_items );

// 		}
// 	}

// }


/*
** ajax handler - load_more_vacancies
*/
// if ( !function_exists('load_more_vacancies') ):

// 	function load_more_vacancies() {
// 		$paged          = intval(sanitize_text_field($_POST["paged"])) + 1;
// 		$posts_per_page = intval(sanitize_text_field($_POST["posts_per_page"]));

// 		$arg = array(
// 			'post_type'        => 'vacancies',
// 			'order'            => 'DESC',
// 			'paged'            => $paged,
// 			'posts_per_page'   => $posts_per_page,
// 			'suppress_filters' => true,
// 			'meta_query' => array(
// 				array(
// 					'key'     => 'status',
// 					'value'   => 1,
// 					'compare' => '='
// 				)
// 			)
// 		);

// 		$response = array();

// 		$the_query = new WP_Query($arg);

// 		$no_more = ($paged == $the_query->max_num_pages) ? 1 : 0;
// 		$content = '';

// 		ob_start();

// 		if ($the_query->have_posts()) :
// 			while ( $the_query->have_posts() ) : $the_query->the_post();

// 				echo get_template_part('parts/vacancy_loop_item');

// 			endwhile;
// 		endif; wp_reset_query();

// 		$content = ob_get_contents();
// 		ob_end_clean();

// 		$response['content'] = $content;
// 		$response['paged']   = $paged;
// 		$response['no_more'] = $no_more;

// 		echo wp_json_encode($response);
// 		wp_die();
// 	}

// 	add_action('wp_ajax_load_more_vacancies',        'load_more_vacancies');
// 	add_action('wp_ajax_nopriv_load_more_vacancies', 'load_more_vacancies');

// endif;




/* add custom editor blocks category */
if (!function_exists('project_block_category')) {
	function project_block_category($categories, $post) {
		return array_merge(
			array(
				array(
					'slug'  => 'project_blocks',
					'title' => 'Project blocks',
				),
			),
			$categories
		);
	}
	add_filter( 'block_categories', 'project_block_category', 10, 2 );
}


/* register custom blocks */
if( function_exists('acf_register_block_type') ) {
	function register_acf_block_types() {

		acf_register_block_type(array(
			'name'            => 'home_hero',
			'title'           => __('Home Hero'),
			'render_template' => 'parts/home_hero.php',
			'category'        => 'project_blocks',
			'mode'            => 'edit',
			'icon'            => array(
				'src'        => 'admin-appearance',
				'foreground' => '#ffffff',
				'background' => '#880b57',
			),
		));

	}
	add_action('acf/init', 'register_acf_block_types');
}
















