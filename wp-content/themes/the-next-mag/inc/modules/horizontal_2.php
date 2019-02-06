<?php
// Display Numbers instead of Thumbnails
if (!class_exists('tnm_horizontal_2')) {
    class tnm_horizontal_2 {
        
        function render($postAttr) {
            ob_start();
            $postID = $postAttr['postID'];
            if(isset($postAttr['catClass']) && ($postAttr['catClass'] != '')) {
                $catClass = $postAttr['catClass']; 
            }else {
                $catClass = '';
            }
            ?>
            <article class="post post--horizontal <?php if(isset($postAttr['additionalClass']) && ($postAttr['additionalClass'] != null)) echo esc_attr($postAttr['additionalClass']);?>">
                <div class="media">
                    
                    <div class="media-left"><span class="index"><?php if(isset($postAttr['postCount']) && ($postAttr['postCount'] != null)) echo esc_attr($postAttr['postCount']);?>.</span></div>
                    <div class="post__text media-body">
						<?php if(isset($postAttr['cat']) && ($postAttr['cat'] != 0)) echo tnm_core::bk_get_post_cat_link($postID, $catClass);?>
						<h3 class="post__title <?php echo esc_attr($postAttr['typescale']);?>"><?php echo tnm_core::bk_get_post_title_link($postAttr['postID']);?></h3>
						<?php
                        if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) :
                            echo '<div class="post__meta">';
                            echo tnm_core::bk_get_post_meta($postAttr['meta']);
                            echo '</div>';
                        endif;
                        ?>
					</div>
                </div>
            </article>			
            <?php return ob_get_clean();
        }
        
    }
}