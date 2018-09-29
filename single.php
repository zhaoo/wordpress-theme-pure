<?php get_header(); ?>
<div class="container">
    <article class="article">
        <h3 class="article-title"><?php the_title(); ?></h3>
        <div class="content">
            <?php while (have_posts()): the_post(); the_content(); endwhile; ?>
        </div>
    </article>
</div>
<?php get_footer(); ?>