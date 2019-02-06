<?php
if (!class_exists('tnm_horizontal_1')) {
    class tnm_horizontal_1 {
        
        function render($postAttr) {
            ob_start();
            $postID = $postAttr['postID'];
            if(isset($postAttr['postIcon']) && ($postAttr['postIcon'] != '')) {
                $postIcon = $postAttr['postIcon']; 
            }else {
                $postIcon = '';
            }
            if(isset($postAttr['catClass']) && ($postAttr['catClass'] != '')) {
                $catClass = $postAttr['catClass']; 
            }else {
                $catClass = '';
            }
            ?>
            <article class="post post--horizontal <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
                 <?php if(tnm_core::bk_check_has_post_thumbnail($postID) && isset($postAttr['thumbSize']) && ($postAttr['thumbSize'] != '')) :?>
				    <div class="post__thumb <?php if(isset($postAttr['additionalThumbClass']) && ($postAttr['additionalThumbClass'] != null)) echo esc_attr($postAttr['additionalThumbClass']);?>">
                        <?php echo tnm_core::get_feature_image($postID, $postAttr['thumbSize'], true, $postIcon);?>
                    </div>
                <?php endif;?>
				<div class="post__text <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
                    <?php if(isset($postAttr['cat']) && ($postAttr['cat'] != 0) && ($postAttr['cat'] != 1)) echo tnm_core::bk_get_post_cat_link($postID, $catClass);?>
					<h3 class="post__title <?php echo esc_attr($postAttr['typescale']);?>"><?php echo tnm_core::bk_get_post_title_link($postAttr['postID']);?></h3>
				    <?php if(isset($postAttr['except_length']) && ($postAttr['except_length'] != null)) {?>
                    <div class="post__excerpt <?php if(isset($postAttr['additionalExcerptClass']) && ($postAttr['additionalExcerptClass'] != null)) echo esc_attr($postAttr['additionalExcerptClass']);?>">
						<?php echo tnm_core::bk_get_post_excerpt($postAttr['except_length']);?>
					</div>
                    <?php }?>
                    <?php
                    if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) :
                        echo '<div class="post__meta">';
                        echo tnm_core::bk_get_post_meta($postAttr['meta']);
                        echo '</div>';
                    endif;
                    ?> 
                    <?php
                    if (isset($postAttr['scoreStar']) && ($postAttr['scoreStar'] != '')) :
                        echo '<div class="post-score-star">';
    					echo tnm_core::bk_get_post_score_star($postAttr['scoreStar']);
    					echo '</div>';
                    endif;
                    ?>
                </div>
                <?php if(tnm_core::bk_check_has_post_thumbnail($postID) && isset($postAttr['cat']) && ($postAttr['cat'] == 1)) echo tnm_core::bk_get_post_cat_link($postID, $catClass);?>
			</article>
            <?php return ob_get_clean();
        }
        
    }
}