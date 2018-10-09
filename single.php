<?php get_header(); ?>
<div class="container">
    <article class="article">
        <hgroup>
            <h3 class="article-title"><?php the_title(); ?></h3>
            <div class="article-info">
                <span><i class="iconfont icon-time"></i><?php the_time('Y-n-j'); ?></span>
                <span><i class="iconfont icon-browse"></i><?php post_views(); ?></span>
                <?php if (is_user_logged_in()){ echo '<span><i class="iconfont icon-brush"></i>'; edit_post_link('编辑'); echo '</span>';} ?>
            </div>
        </hgroup>
        <div class="content">
            <?php while (have_posts()): the_post(); the_content(); endwhile; ?>
        </div>
    </article>
</div>
<?php get_footer(); ?>