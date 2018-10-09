<?php
/* Menu */
register_nav_menus(array(
    'nav_menu' => '菜单',
));

/* Thumbnails */
add_theme_support('post-thumbnails');

/* Title */
function show_title() {
    if ( is_home() ) {
        bloginfo('name'); echo " - "; bloginfo('description');
    } elseif ( is_category() ) {
        single_cat_title(); echo " - "; bloginfo('name');
    } elseif (is_single() || is_page() ) {
        single_post_title(); echo " - "; bloginfo('name');
    } elseif (is_search() ) {
        echo "搜索结果"; echo " - "; bloginfo('name');
    } elseif (is_404() ) {
        echo '404 - Not Found';
    } else {
        wp_title('',true);
    }
}

/* Meta */
function show_meta($meta) {
    $description = '';
    $keywords = '';
    if (is_home() || is_page()) {
        $description = get_bloginfo('description');
        $keywords = "WordPress,主题,极简,写作,纯粹,pure";
    }
    elseif (is_single()) {
        global $post;
        $description1 = get_post_meta($post->ID, "description", true);
        $description2 = str_replace("\n","",mb_strimwidth(strip_tags($post->post_content), 0, 200, "…", 'utf-8'));
        $description = $description1 ? $description1 : $description2;
        $keywords = get_post_meta($post->ID, "keywords", true);
        if($keywords == '') {
            $tags = wp_get_post_tags($post->ID);    
            foreach ($tags as $tag ) {        
                $keywords = $keywords . $tag->name . ", ";    
            }
            $keywords = rtrim($keywords, ', ');
        }
    }
    elseif (is_category()) {
        $description = category_description();
        $keywords = single_cat_title('', false);
    }
    elseif (is_tag()){
        $description = tag_description();
        $keywords = single_tag_title('', false);
    }
    if ($description == '') {
        $description = get_bloginfo('description');
    }
    if ($keywords == '') {
        $keywords = "WordPress,主题,极简,写作,纯粹,pure";
    }
    if ($meta == 'description') {
        echo trim(strip_tags($description));
    }
    if ($meta == 'keywords') {
        echo trim(strip_tags($keywords));
    }
}

/* Posts Paginate */
function posts_paginate() {
    echo paginate_links(array(
        'prev_next'    => 1,
        'prev_text'    => '<',
        'next_text'    => '>',
    ));
}

/* Tiny MCE Extend*/
function enable_more_buttons($buttons) {    // system function extension
    $buttons[] = 'fontselect';
    $buttons[] = 'fontsizeselect';
    $buttons[] = 'styleselect';
    $buttons[] = 'forecolor';
    $buttons[] = 'backcolor';
    return $buttons;
}
add_filter("mce_buttons", "enable_more_buttons");

if (!function_exists('wpex_mce_text_sizes')) {    // font number extension
    function wpex_mce_text_sizes( $initArray ){
        $initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 18px 21px 24px 28px 32px 36px 72px";
        return $initArray;
    }
}
add_filter( 'tiny_mce_before_init', 'wpex_mce_text_sizes' );

function appthemes_add_quicktags() {    // short code
    ?> 
    <script type="text/javascript"> 
        QTags.addButton('代码高亮', '代码高亮', '<pre><code>\n', '\n</pre></code>\n');  // code highlight
        QTags.addButton('v-notice', '绿框', '<div id="sc-notice">绿色提示框</div>\n');  // article info box
        QTags.addButton('v-error', '红框', '<div id="sc-error">红色提示框</div>\n');
        QTags.addButton('v-warn', '黄框', '<div id="sc-warn">黄色提示框</div>\n');
        QTags.addButton('v-tips', '灰框', '<div id="sc-tips">灰色提示框</div>\n');
        QTags.addButton('v-blue', '蓝框', '<div id="sc-blue">蓝色提示框</div>\n');
        QTags.addButton('v-black', '黑框', '<div id="sc-black">黑色提示框</div>\n');
        QTags.addButton('普通按钮','普通按钮','[btn]普通按钮[/btn]\n');
        QTags.addButton('下载按钮','下载按钮','[btn-download]下载按钮[/btn-download]\n');
    </script>
    <?php
}
add_action('admin_print_footer_scripts', 'appthemes_add_quicktags' );

function button($atts, $content = null) {    // button
    extract(shortcode_atts(array("title" => ''), $atts));
    $output = '<button class="btn btn-default">'.$content.'</button>';
    return $output;
}
add_shortcode('btn', 'button');

function button_download($atts, $content = null) {    // button
    extract(shortcode_atts(array("title" => ''), $atts));
    $output = '<button class="btn btn-default"><i class="iconfont icon-download"></i> '.$content.'</button>';
    return $output;
}
add_shortcode('btn-download', 'button_download');

/* Header Clear */
remove_action('wp_head', 'rsd_link' );     // offline-editor
remove_action('wp_head', 'wlwmanifest_link' ); 
remove_action('wp_head', 'wp_generator' );    // wp-version
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );    //wp-json
remove_action('wp_head', 'print_emoji_detection_script', 7 );    // emoji
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'feed_links', 2 );    // feed
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'index_rel_link' );    // article-meta
remove_action('wp_head', 'parent_post_rel_link', 10, 0 );
remove_action('wp_head', 'start_post_rel_link', 10, 0 );
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
function remove_dns_prefetch( $hints, $relation_type ) {    // dns-prefetch
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
function post_views() {
    global $post;
    $post_ID = $post->ID;
    $views = (int)get_post_meta($post_ID, 'views', true);
    echo $views;
}

?>