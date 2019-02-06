<?php
if (!class_exists('tnm_thumb_overlap')) {
    class tnm_thumb_overlap {
        
        function render($postAttr) {
            ob_start();
            $postID = $postAttr['postID'];
            $bk_permalink = get_permalink($postID);
            $bk_post_title = get_the_title($postID);
            
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
            $thumbAttr = array (
                'postID'        => $postID,
                'thumbSize'     => $postAttr['thumbSize'],                                
            );
            $theBGLink = tnm_core::bk_get_post_thumbnail_bg_link($thumbAttr);
            $thumbMobileAttr = array (
                'postID'        => $postID,
                'thumbSize'     => $postAttr['thumbSizeMobile'],                                
            );
            $theBGMobileLink = tnm_core::bk_get_post_thumbnail_bg_link($thumbMobileAttr);
            ?>
            <article class="post--thumb-overlap">
				<div class="post__wrap">
					<div class="background-svg-pattern-inverse"></div>
					<div class="post__thumb">
						<a href="<?php echo esc_url($bk_permalink);?>">
							<img class="visible-xs" src="<?php echo esc_url($theBGMobileLink);?>" alt="<?php esc_attr_e('image', 'the-next-mag');?>">
							<div class="background-img hidden-xs" style="background-image: url('<?php echo esc_url($theBGLink);?>');"></div>
						</a>
                        <?php 
                        if($postIcon != '') :
                            echo tnm_core::bk_get_post_icon($postID, $postIcon);
                        endif;
                        ?>
                        <?php if(isset($postAttr['cat']) && ($postAttr['cat'] == '1')) echo tnm_core::bk_get_post_cat_link($postID, $catClass);?>
					</div>
					<div class="post__text">
						<div class="post__meta">
							<?php if(isset($postAttr['cat']) && ($postAttr['cat'] != '') && ($postAttr['cat'] != 1)) echo tnm_core::bk_get_post_cat_link($postID, $catClass);?>
						</div>
						<h3 class="post__title <?php if(isset($postAttr['typescale'])) echo esc_attr($postAttr['typescale']);?>"><a href="<?php echo esc_url($bk_permalink);?>"><?php echo esc_attr($bk_post_title);?></a></h3>
						<?php if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) :?>
                        <div class="post__meta">
							<?php echo tnm_core::bk_meta_cases($postAttr['meta'][0]);?>
						</div>
                        <?php endif;?>
                        <?php if(isset($postAttr['except_length']) && ($postAttr['except_length'] != null)) :?>
						<div class="post__excerpt <?php if(isset($postAttr['additionalExcerptClass']) && ($postAttr['additionalExcerptClass'] != null)) echo esc_attr($postAttr['additionalExcerptClass']);?>">
							<?php echo tnm_core::bk_get_post_excerpt($postAttr['except_length']);?>
						</div>
                        <?php endif;?>
						<?php if (isset($postAttr['meta']) && ($postAttr['meta'] != '')) :?>
                        <div class="post__meta">
							<?php echo tnm_core::bk_meta_cases($postAttr['meta'][1]);?>
							<?php echo tnm_core::bk_meta_cases($postAttr['meta'][2]);?>
						</div>
                        <?php endif;?>
					</div>
				</div>
			</article>
            <?php return ob_get_clean();
        }
        
    }
}