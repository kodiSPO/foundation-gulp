<?php
/**
 * Register custom blocks
 **/
add_action('acf/init', function() {
//    theme_acf_register_block_type('example', 'Example');
});

/**
 * Register custom block function
 **/
function theme_acf_register_block_type($name, $title) {
    acf_register_block_type(array(
        'name'            => 'custom_acf_block_' . $name,
        'title'           => $title,
        'render_template' => get_stylesheet_directory() . '/blocks/' . $name . '/view.php',
        'category'        => 'custom_acf_blocks',
        'mode'            => 'edit',
        'icon'            => array(
            'src'        => 'admin-appearance',
            'foreground' => '#ffffff',
            'background' => '#880b57',
        ),
    ));
}

/**
 * Register block category
 **/
add_filter('block_categories', function($categories, $post) {
    return array_merge(
        array(
            array(
                'slug'  => 'custom_acf_blocks',
                'title' => 'Project blocks',
            ),
        ),
        $categories
    );
}, 10, 2);
