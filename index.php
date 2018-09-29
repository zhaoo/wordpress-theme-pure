<?php get_header(); ?>
<div class="container">
    <div class="list">
        <?php if (have_posts()): while (have_posts()): the_post(); ?>
            <article class="item">
                <div class="article-title">
                    <span><?php if(is_sticky()){echo '>';}else{echo '~';} ?></span>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                </div>
                <p><?php echo wp_trim_words( get_the_content(), 200 ); ?></p>
            </article>
        <?php endwhile; ?>
        <?php else : ?>
	        <h3 class="article-title">找不到文章！</h3>
        <?php endif; ?>
    </div>
    <div class="posts-nav">
        <?php echo paginate_links(array(
            'prev_next'          => 0,
            'before_page_number' => '',
            'mid_size'           => 5,
        ));?>
    </div>
</div>
<?php get_footer(); ?>