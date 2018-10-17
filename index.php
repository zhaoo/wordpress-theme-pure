<?php get_header(); ?>
<div class="container">
    <section class="list">
        <?php if (have_posts()): while (have_posts()): the_post(); ?>
            <div class="item">
                <div class="article-title">
                    <span><?php if(is_sticky()){echo '<i class="iconfont icon-fire" style="color: #ff3b00;"></i>';}else{echo '~';} ?></span>
                    <h3><a class="underline" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                </div>
                <p><?php echo wp_trim_words( get_the_content(), 200 ); ?></p>
            </div>
        <?php endwhile; ?>
        <?php else : ?>
	        <h3 class="article-title">找不到文章！</h3>
        <?php endif; ?>
    </section>
    <?php $options = get_option('p_options'); ?>
    <?php if ($options['ajax']): ?>
    <div id="pagination">
        <?php next_posts_link(__('加载更多')); ?>
        <div class="loading">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
    </div>
    <?php else: ?>
    <div id="pagaination-default">
        <?php posts_paginate(); ?>
    </div>
    <?php endif; ?>
</div>
<?php get_footer(); ?>