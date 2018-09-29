<!DOCTYPE html>
<html lang="zh-Hans">
<head>
    <title>
        <?php
            if ( is_home() ) {
                bloginfo('name'); echo " - "; bloginfo('description');
            } elseif ( is_category() ) {
                single_cat_title(); echo " - "; bloginfo('name');
            } elseif (is_single() || is_page() ) {
                single_post_title();
            } elseif (is_search() ) {
                echo "搜索结果"; echo " - "; bloginfo('name');
            } elseif (is_404() ) {
                echo '404 - Not Found';
            } else {
                wp_title('',true);
            }
        ?>
    </title>
    <?php
        $description = '';
        $keywords = '';
        if (is_home() || is_page()) {
        $description = "Just 4 write.";
        $keywords = "WordPress,主题,极简,写作,纯粹,pure";
        }
        elseif (is_single()) {
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
        $description = trim(strip_tags($description));
        $keywords = trim(strip_tags($keywords));
    ?>
    <meta name="description" content="<?php echo $description; ?>" />
    <meta name="keywords" content="<?php echo $keywords; ?>" />
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet" type="text/css">
    <link href="<?php bloginfo('template_url'); ?>/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="<?php bloginfo('template_url'); ?>/favicon.ico">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有文章" href="<?php echo get_bloginfo('rss2_url'); ?>" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有评论" href="<?php bloginfo('comments_rss2_url'); ?>" />
    <?php wp_head(); ?>
</head>
<?php flush(); ?>
<body>
    <nav>
        <div class="spread">></div>
        <?php  wp_nav_menu(array('depth'=>1,'container'=>'div','container_class'=>'menu')); ?>
    </nav>
    <header>
        <h1 class="title"><a href="<?php echo get_option('home'); ?>"><?php bloginfo('name'); ?></a></h1>
        <p class="subtitle"><?php bloginfo('description'); ?></p>
    </header>