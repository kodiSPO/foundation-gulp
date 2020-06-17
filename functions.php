<?php
// Disable use XML-RPC
add_filter( 'xmlrpc_enabled', '__return_false' );

// remove WP version from meta tags and form the XML feeds
add_filter('the_generator', '__return_empty_string');


// theme support
// add_theme_support('custom-logo');
add_theme_support('post-thumbnails');


/**
 * Disable fullscreen mode by default
 **/
add_action( 'enqueue_block_editor_assets', function() {
    $script = "window.onload = function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } }";
    wp_add_inline_script( 'wp-blocks', $script );
});


/**
 * Add custom image sizes
 **/
// add_image_size('case-preview-865-450', 865, 450, true);
// add_image_size('post-preview-387-220', 387, 220, true);


/**
 * Enqueue scripts and styles
 **/
add_action('wp_enqueue_scripts', function() {
    if (!is_admin()) {

        $theme_uri = get_template_directory_uri();
        $version   = '1.0.0';

        wp_deregister_script('wp-embed');
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        wp_deregister_script('jquery');


        /**
         * Load fonts & css
         **/
        // wp_enqueue_style('font-montserrat', 'https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700,900', array(), null);
        wp_enqueue_style('theme-css', $theme_uri .'/css/theme.min.css', array(), $version);

        /**
         * Load js
         **/
        wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js', array(), null);
        wp_enqueue_script('theme-js', $theme_uri . '/js/theme.min.js', array('jquery'), $version, true);

    }
});


/**
 * Enqueue admin scripts and styles
 **/
add_action( 'admin_enqueue_scripts', function() {
    $css_url = get_stylesheet_directory_uri() . '/css/admin.css';
    $css_path = get_stylesheet_directory() . '/css/admin.css';
    wp_enqueue_style('admin-css', $css_url, array(), filemtime($css_path));
});


/**
 * Custom Walker
 **/
class Foundation_6_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"vertical menu\" data-submenu>\n";
    }
}


/**
 * Register navigation menus
 **/
register_nav_menus(array(
    'main_nav'   => 'Main navigation',
//    'footer_nav'   => 'Footer navigation',
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
    </style>
<?php }
// add_action( 'login_enqueue_scripts', 'wordpress_login_styling' );


// Removing menu pages
//add_action('admin_menu', function() {
//    remove_menu_page( 'edit.php' );
//    remove_menu_page( 'edit-comments.php' );
//});


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



/**
 * Enqueue custom ACF blocks
 **/
require_once get_stylesheet_directory() . '/blocks/init.php';












