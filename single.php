<?php get_header(); ?>
<div class="container">
    <article class="article">
        <h3 class="article-title"><?php the_title(); ?></h3>
        <div class="article-info">
            <span><i class="fa fa-clock-o"></i><?php the_time('Y-n-j'); ?></span>
            <span><i class="fa fa-eye"></i><?php post_views(); ?></span>
            <?php if (is_user_logged_in()){ echo '<span><i class="fa fa-file-text"></i>'; echo edit_post_link('编辑'); echo '</span>';} ?>
        </div>
        <div class="content">
            <?php while (have_posts()): the_post(); the_content(); endwhile; ?>
        </div>
    </article>
</div>
<?php get_footer(); ?>