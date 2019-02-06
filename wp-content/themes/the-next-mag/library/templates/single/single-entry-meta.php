<!-- Entry meta -->
<?php
    global $post; //$post->post_author
    $tnm_option = tnm_core::bk_get_global_var('tnm_option');
    $postID = get_the_ID();
    $bk_author_name = get_the_author_meta('display_name', $post->post_author);
    $authorImgALT = $bk_author_name;
    $authorArgs = array(
        'class' => 'entry-author__avatar',
    );
    $tnm_article_date_unix = get_the_time('U', $postID);
    $tnm_meta_items = 8;
    if(isset($tnm_option['bk-single-meta-items'])):
        $tnm_meta_case = $tnm_option['bk-single-meta-items'];
        $tnm_meta_items = tnm_core::bk_get_meta_list($tnm_meta_case);
    endif;
?>
<div class="entry-meta">
	<span class="entry-author entry-author--with-ava">
        <?php 
            echo get_avatar($post->post_author, '34', '', $authorImgALT, $authorArgs);
            echo esc_html__('By', 'the-next-mag');
            echo ' <a class="entry-author__name" title="Posts by '.esc_attr($bk_author_name).'" rel="author" href="'.get_author_posts_url($post->post_author).'">'.esc_attr($bk_author_name).'</a>';
        ?>
    </span>
    <?php
        echo tnm_core::bk_get_post_meta($tnm_meta_items);
    ?>
</div>