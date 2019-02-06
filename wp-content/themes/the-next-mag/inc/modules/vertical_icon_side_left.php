<?php
if (!class_exists('tnm_vertical_icon_side_left')) {
    class tnm_vertical_icon_side_left {
        
        function render($postAttr) {
            ob_start();
            $postID = $postAttr['postID'];
            $bk_permalink = get_permalink($postID);
            $bk_post_title = get_the_title($postID);
            if(isset($postAttr['catClass']) && ($postAttr['catClass'] != '')) {
                $catClass = $postAttr['catClass']; 
            }else {
                $catClass = '';
            }
            ?>
            <article class="post post--vertical <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
                 <?php if(isset($postAttr['thumbSize']) && ($postAttr['thumbSize'] != '')) :?>
				    <div class="post__thumb">
                        <?php echo tnm_core::get_feature_image($postID, $postAttr['thumbSize'], true);?>
                        <?php if(isset($postAttr['cat']) && ($postAttr['cat'] == 2)) echo tnm_core::bk_get_post_cat_link($postID, $catClass);?>
                    </div>
                <?php endif;?>
				<div class="post__text <?php if(isset($postAttr['additionalTextClass']) && ($postAttr['additionalTextClass'] != null)) echo esc_attr($postAttr['additionalTextClass']);?>">
					<div class="media">
                        <div class="media-left media-middle">
							<?php 
                                if(isset($postAttr['postIcon']) && ($postAttr['postIcon'] != '')) :
                                    echo tnm_core::bk_get_post_icon($postID, $postAttr['postIcon']);               
                                endif;
                            ?>
						</div>
                        <div class="media-body media-middle">
                            <?php if(isset($postAttr['cat']) && ($postAttr['cat'] != 0) && ($postAttr['cat'] != 1) && ($postAttr['cat'] != 2)) echo tnm_core::bk_get_post_cat_link($postID, $catClass);?>
							<h3 class="post__title <?php echo esc_attr($postAttr['typescale']);?>"><a href="<?php echo esc_url($bk_permalink);?>"><?php echo esc_attr($bk_post_title);?></a></h3>
                            <?php
                                if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) :
                                    echo '<div class="post__meta">';
                                    echo tnm_core::bk_get_post_meta($postAttr['meta']);
                                    echo '</div>';
                                endif;
                            ?> 
                        </div>    
                    </div>
				</div>
                <?php if(isset($postAttr['cat']) && ($postAttr['cat'] == 1)) echo tnm_core::bk_get_post_cat_link($postID, $catClass);?>
			</article>
            <?php return ob_get_clean();
        }
        
    }
}