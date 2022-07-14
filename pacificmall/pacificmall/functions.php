<?php
function my_enqueue_scripts() {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'bundle_js', get_template_directory_uri(). '/assets/js/bundle.js', array() );
    wp_enqueue_style( 'my_styles', get_template_directory_uri(). '/assets/css/styles.css', array() );
}
add_action( 'wp_enqueue_scripts', 'my_enqueue_scripts' );

register_nav_menus(
    array(
        'place_global' => 'グローバル',
        'place_footer' => 'フッターナビ',
    )
);

function get_main_title() {
    if ( is_singular( 'post' ) ):
        $category_obj = get_the_category();
        return $category_obj[0]->name;
    elseif ( is_page() ):
        return get_the_title();
    elseif ( is_category() ):
        return single_cat_title();
    endif;
}
