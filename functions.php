<?php

/* Menu */

register_nav_menus(array(
    'nav_menu' => '菜单',
));

/* Header Clear */

remove_action( 'wp_head','feed_links_extra', 3 ); 
remove_action( 'wp_head','rsd_link' ); 
remove_action( 'wp_head','wlwmanifest_link' ); 
remove_action( 'wp_head','index_rel_link' ); 
remove_action( 'wp_head','start_post_rel_link', 10, 0 ); 
remove_action( 'wp_head','wp_generator' );
remove_action('wp_head','print_emoji_detection_script', 7 );
remove_action('admin_print_scripts','print_emoji_detection_script');
remove_action('wp_print_styles','print_emoji_styles');
remove_action('admin_print_styles','print_emoji_styles');
function remove_dns_prefetch( $hints, $relation_type ) {
    if ( 'dns-prefetch' === $relation_type ) {
		return array_diff( wp_dependencies_unique_hosts(), $hints );
    }
    return $hints;
}
add_filter( 'wp_resource_hints', 'remove_dns_prefetch', 10, 2 );

/* Remove Google Font */

function remove_open_sans() {    
    wp_deregister_style( 'open-sans' );    
    wp_register_style( 'open-sans', false );    
    wp_enqueue_style('open-sans','');    
}    
add_action( 'init', 'remove_open_sans' );

/* View Statistics */ 

function record_visitors() {
    if (is_singular()) {
        global $post;
        $post_ID = $post->ID;
        if($post_ID) {
            $post_views = (int)get_post_meta($post_ID, 'views', true);
            if(!update_post_meta($post_ID, 'views', ($post_views+1))) {
                add_post_meta($post_ID, 'views', 1, true);
            }
        }
    }
}
add_action('wp_head', 'record_visitors');
function post_views($echo = 1) {
    global $post;
    $post_ID = $post->ID;
    $views = (int)get_post_meta($post_ID, 'views', true);
    if ($echo) echo $before, number_format($views), $after;
    else return $views;
}

?>