<?php
	if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
        die ('Please do not load this page directly. Thanks!');
    }
?>
<section id="comments" class="comments">
    <?php if (comments_open()): ?>
        <?php if (get_option('comment_registration') && !$user_ID ) : ?>
            <p><?php printf(__('您需要先<a href="%s">登录</a>才能发表评论。'), get_option('siteurl')."/wp-login.php?redirect_to=".urlencode(get_permalink()));?></p>
        <?php else : ?>
            <?php
                $fields =  array(
                    'author'  => '<p class="comment-fields comment-form-author"><label for="author">' . __( '昵称' ).( $req ? '<span class="required">*</span>' : '' ).'</label> '.'<input id="author" name="author" type="text" value="' . esc_attr(  $commenter['comment_author'] ) . '" size="20" maxlength="245" required="required"' . ' />',
                    'email'  => '<p class="comment-fields comment-form-email"><label for="email">' . __( '邮箱' ).( $req ? '<span class="required">*</span>' : '' ).'</label> '.'<input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="20" maxlength="100" aria-describedby="email-notes" required="required"' . ' />',
                    'url'  => '<p class="comment-fields comment-form-url"><label for="url">' . __( '网址' ) . '</label> '.'<input id="url" name="url" type="url" value="' . esc_attr(  $commenter['comment_author_url'] ) . '" size="20" maxlength="200"' . ' />',
                );
                $pure_style = array(
                    'label_submit' => __('发表评论'),
                    'title_reply' => __('评论'),
                    'fields' =>  $fields,
                    'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="6" maxlength="65525" required="required"></textarea></p>',
                    'comment_notes_before' => '',
                    'comment_notes_after' => '',
                    'logged_in_as' => '<p class="logged-in-as">'.sprintf(__( '<a href="%1$s">%2$s</a> <a href="%3$s">[注销]</a>' ),admin_url( 'profile.php' ),$user_identity,wp_logout_url(apply_filters('the_permalink', get_permalink()))).'</p>',
                );
                comment_form($pure_style);
            ?>
        <?php endif; ?>
        <?php if (!empty($post->post_password) && $_COOKIE['wp-postpass_'.COOKIEHASH] != $post->post_password){ ?>
            <li class="decmt-box">
                <p><a href="#addcomment">评论内容已加密，请输入密码查看。</a></p>
            </li>
        <?php } else if (!comments_open()){ ?>
            <li class="decmt-box">
                <p><a href="#addcomment">评论功能已经关闭。</a></p>
            </li>
        <?php } else if (!have_comments()){ ?>
            <li class="decmt-box">
                <p><a href="#addcomment">还没有任何评论，来说两句吧。</a></p>
            </li>
        <?php } else { ?>
            <div class="comment-container">
                <?php wp_list_comments('type=comment&callback=aurelius_comment'); ?>
            </div>
        <?php } ?>
    <?php else : ?>   
        <p><?php _e('评论功能已经关闭。'); ?></p>
    <?php endif; ?>
</section>