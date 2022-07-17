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

function get_child_pages( $number = -1, $specified_id = null ) {
    if ( isset( $specified_id ) ):
        $parent_id = $specified_id;
    else:
        $parent_id = get_the_ID();
    endif;
    $args = array(
      'posts_per_page' => $number,
      'post_type' => 'page',
      'orderby' => 'menu_order',
      'order' => 'ASC',
      'post_parent' => $parent_id,
    );
    $child_pages = new WP_Query( $args );
    return $child_pages;
}

add_theme_support( 'post-thumbnails' );

add_image_size( 'top', 1077, 622, true );
add_image_size( 'contribution', 557, 280, true );
add_image_size( 'front-contribution', 255, 189, true );
add_image_size( 'common', 465, 252, true );
add_image_size( 'detail', 1100, 330, true );
add_image_size( 'search', 168, 168, true );

function get_main_image() {
    if ( is_page() ):
        return get_the_post_thumbnail( $post->ID, 'detail' );
    elseif ( is_category( 'news' ) || is_singular( 'post' ) ):
        return '<img src="'. get_template_directory_uri(). '/assets/images/bg-page-news.jpg" />';
    else:
        return '<img src="'. get_template_directory_uri(). '/assets/images/bg-page-dummy.png" />';
    endif;
}

function get_specific_posts( $post_type, $taxonomy = null, $term = null, $number = -1 ) {
    $args = array(
        'post_type' => $post_type,
        'tax_query' => array(
            array(
                'taxonomy' => $taxonomy,
                'field' => 'slug',
                'terms' => $term,
            ),
        ),
        'posts_per_page' => $number,
    );
    $specific_posts = new WP_Query( $args );
    return $specific_posts;
}
