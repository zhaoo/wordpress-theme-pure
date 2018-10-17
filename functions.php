<?php
// Options
include('inc/options.php');

// Init
add_action( 'after_setup_theme', 'setup' );
function setup(){
    // Menu
    register_nav_menus(array(
        'nav_menu' => '菜单',
    ));
    // Thumbnails
    add_theme_support('post-thumbnails');
    // Header Clear
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
    // Remove Google Font
    function remove_open_sans() {    
        wp_deregister_style( 'open-sans' );    
        wp_register_style( 'open-sans', false );    
        wp_enqueue_style('open-sans','');    
    }    
}

function init() {
    // Options
    include('inc/options-default.php');
    update_option('p_options', $default_options);
}
add_action( 'load-themes.php', 'init' );

// Title
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

// Meta
function show_meta($meta) {
    $description = '';
    $keywords = '';
    $options = get_option('p_options');
    if (is_home() || is_page()) {
        $description = $options['description'];
        $keywords = $options['keywords'];
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
        $keywords = $options['keywords'];
    }
    if ($meta == 'description') {
        echo trim(strip_tags($description));
    }
    if ($meta == 'keywords') {
        echo trim(strip_tags($keywords));
    }
}

// Posts Paginate
function posts_paginate() {
    echo paginate_links(array(
        'prev_next'    => 1,
        'prev_text'    => '<',
        'next_text'    => '>',
    ));
}

// Tiny MCE Extend
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
function appthemes_add_quicktags() {if (wp_script_is('quicktags')){    // short code
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
}}
add_action('admin_print_footer_scripts', 'appthemes_add_quicktags' );
function button($atts, $content = null) {    // button
    extract(shortcode_atts(array("title" => ''), $atts));
    $output = '<button class="btn btn-default">'.$content.'</button>';
    return $output;
}
add_shortcode('btn', 'button');
function button_download($atts, $content = null) {    // download-button
    extract(shortcode_atts(array("title" => ''), $atts));
    $output = '<button class="btn btn-default"><i class="iconfont icon-download"></i> '.$content.'</button>';
    return $output;
}
add_shortcode('btn-download', 'button_download');

// View Statistics
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

// Like
add_action('wp_ajax_nopriv_bigfa_like', 'bigfa_like');
add_action('wp_ajax_bigfa_like', 'bigfa_like');
function bigfa_like(){
    global $wpdb,$post;
    $id = $_POST["um_id"];
    $action = $_POST["um_action"];
    if ( $action == 'ding'){
		$bigfa_raters = get_post_meta($id,'bigfa_ding',true);
		$expire = time() + 99999999;
		$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
		setcookie('bigfa_ding_'.$id,$id,$expire,'/',$domain,false);
		if (!$bigfa_raters || !is_numeric($bigfa_raters)) {
			update_post_meta($id, 'bigfa_ding', 1);
		}else {
			update_post_meta($id, 'bigfa_ding', ($bigfa_raters + 1));
		}   
		echo get_post_meta($id,'bigfa_ding',true);    
    }     
    die;
}
function show_like() {
    global $post;
    $post_ID = $post->ID;
    echo (int)get_post_meta($post_ID, 'bigfa_ding', true);
}

// Comments
function aurelius_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <div class="comment" id="div-comment-<?php comment_ID(); ?>">
        <div class="gravatar"> <?php if (function_exists('get_avatar') && get_option('show_avatars')) { echo get_avatar($comment, 36); } ?></div>
        <div class="comment-content" id="comment-<?php comment_ID(); ?>">
            <div class="comment-info">
                <span class="name"><?php printf(__('%s'), get_comment_author_link()) ?></span>
                <span class="time"><?php echo timeago( $comment->comment_date_gmt ); ?></span>
                <span class="reply"><?php comment_reply_link(array_merge($args,array('reply_text' =>'回复','depth' =>$depth,'max_depth'=>$args['max_depth']))) ?></span>
            </div>
            <div class="comment-text">
                <?php if ($comment->comment_approved == '0') : ?>
                    <p>您的评论正在审核中。</p>
                <?php endif; ?>
                <?php comment_text(); ?>
            </div>
        </div>
    </div>
<?php }

// Comments Repair @ Author 
function ludou_comment_add_at( $comment_text, $comment = '') {
  if( $comment->comment_parent > 0) {
    $comment_text = '@<a href="#comment-' . $comment->comment_parent . '">'.get_comment_author( $comment->comment_parent ) . '</a> ' . $comment_text;
  }
  return $comment_text;
}
add_filter( 'comment_text' , 'ludou_comment_add_at', 20, 2);

// Time Ago
function timeago($ptime) {
    $ptime = strtotime($ptime);
    $etime = time() - $ptime;
    if ($etime < 1) return '刚刚';
    $interval = array (
        12 * 30 * 24 * 60 * 60  =>  '年前 ('.date('Y-m-d', $ptime).')',
        30 * 24 * 60 * 60       =>  '个月前 ('.date('m-d', $ptime).')',
        7 * 24 * 60 * 60        =>  '周前 ('.date('m-d', $ptime).')',
        24 * 60 * 60            =>  '天前',
        60 * 60                 =>  '小时前',
        60                      =>  '分钟前',
        1                       =>  '秒前'
    );
    foreach ($interval as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . $str;
        }
    };
}

// FancyBox
function lightbox_gall_replace ($content) {
    global $post;
    $pattern = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?)>/i";
    $replacement = '<a$1href=$2$3$4$5$6 class="fancybox" data-fancybox-group="button">';
    $content = preg_replace($pattern, $replacement, $content);
    return $content;
}
add_filter('the_content', 'lightbox_gall_replace', 99);

// Comments Email Repaly
function comment_mail_notify ($comment_id) {     
    $admin_email = get_bloginfo ('admin_email');
    $comment = get_comment($comment_id);      
    $comment_author_email = trim($comment->comment_author_email);      
    $parent_id = $comment->comment_parent ? $comment->comment_parent : '';      
    $to = $parent_id ? trim(get_comment($parent_id)->comment_author_email) : '';      
    $spam_confirmed = $comment->comment_approved;      
    if (($parent_id != '') && ($spam_confirmed != 'spam') && ($to != $admin_email) && ($comment_author_email == $admin_email)) {   
    $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));   
    $subject = '您在 [' . get_option("blogname") . '] 的留言有了回应';   
    $message =  trim(get_comment($parent_id)->comment_author) . ', 您好!  
        您曾在《' . get_the_title($comment->comment_post_ID) . '》的留言:'  
        . trim(get_comment($parent_id)->comment_content) . '   ' . trim($comment->comment_author) . ' 给您的回应:'   . trim($comment->comment_content) . '   您可以点击 ' . htmlspecialchars(get_comment_link($parent_id)) . '查看回应完整內容  欢迎再度光临' . get_option('home') . '' . get_option('blogname') . '  (此邮件由系统自动发出, 请勿回复.) ';  
        $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";   
        $mail_headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";   
        wp_mail( $to, $subject, $message, $headers );   
    }      
}      
add_action('comment_post', 'comment_mail_notify');

// Options Append
$options = get_option('p_options');
eval($options['php']);
?>