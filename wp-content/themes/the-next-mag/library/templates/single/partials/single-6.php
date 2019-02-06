<?php
/*
Template Name: Single Template 2 -- No Sidebar
*/
?>
<?php
    global $post;
    $tnm_option = tnm_core::bk_get_global_var('tnm_option');
    $currentPost        = $post;
    $postID             = get_the_ID();      
    $catIDClass         = '';
    $bkEntryTeaser      = get_post_meta($postID,'bk_post_subtitle',true);
    
    $reviewBoxPosition  = get_post_meta($postID,'bk_review_box_position',true);
    
    //Switch
    $bkAuthorSW         = tnm_single::bk_get_post_option($postID, 'bk-authorbox-sw');
    $bkPostNavSW        = tnm_single::bk_get_post_option($postID, 'bk-postnav-sw');
    $bkRelatedSW        = tnm_single::bk_get_post_wide_option($postID, 'bk-related-sw');
    $bkSameCatSW        = tnm_single::bk_get_post_wide_option($postID, 'bk-same-cat-sw');
    
    $featuredImageSTS   = tnm_single::bk_get_post_option($postID, 'bk-feat-img-status');
?>
<?php
if(function_exists('has_post_format')){
    $postFormat = get_post_format($postID);
}else {
    $postFormat = 'standard';
}
?>
<div class="site-content single-entry single-entry--no-sidebar <?php if(($postFormat == 'video') || ($postFormat == 'gallery')) {echo 'single-entry--video';}else {echo 'single-entry--template-2--no-sidebar';}?>">
    <div class="mnmd-block mnmd-block--fullwidth mnmd-block--contiguous single-entry-wrap">
        
        <article <?php post_class('mnmd-block post--single');?>>
            <div class="single-content site-content">
                <?php 
                    if(($postFormat == 'video') || ($postFormat == 'gallery')) {
                        echo '<div class="mnmd-block mnmd-block--fullwidth mnmd-block--contiguous single-entry-featured-media-wrap">';
                        echo '<div class="container">';
                        echo '<div class="single-entry-featured-media">';
                        echo tnm_single::bk_entry_media($postID, 'tnm-xl-2_1');
                        echo '</div></div></div>';
                    }else {
                        if (($featuredImageSTS != 0) && (tnm_core::bk_check_has_post_thumbnail($postID))) {
                            $thumbAttrXXL = array (
                                'postID'        => $postID,
                                'thumbSize'     => 'tnm-xxl',                                
                            );
                            $thumbAttr = array (
                                'postID'        => $postID,
                                'thumbSize'     => 'tnm-l-4_3',                                
                            );            
                            $theBGLinkXXL   = tnm_core::bk_get_post_thumbnail_bg_link($thumbAttrXXL);
                            $theBGLink      = tnm_core::bk_get_post_thumbnail_bg_link($thumbAttr); 
                            ?>
                            <div class="mnmd-block mnmd-block--fullwidth mnmd-block--contiguous single-billboard single-billboard--sm">
                                <div class="background-img background-img--scrim-bottom hidden-xs hidden-sm" style="background-image: url('<?php echo esc_url($theBGLinkXXL);?>');"></div>
                                <div class="background-img hidden-md hidden-lg" style="background-image: url('<?php echo esc_url($theBGLink);?>');"></div>
                            </div>
                            <?php
                        }
                    }
                ?>
                <header class="single-header single-header--center">
						<div class="container container--narrow">
                        <?php 
                            $catClass = 'post__cat cat-theme';
                            echo tnm_core::bk_get_post_cat_link($postID, $catClass, true);
                        ?>
    					<h1 class="entry-title entry-title--lg"><?php echo get_the_title($postID);?></h1>
    					
                        <?php if($bkEntryTeaser):?>
                            <div class="entry-teaser entry-teaser--lg">
        						<?php echo esc_html($bkEntryTeaser);?>
        					</div>
                        <?php endif;?>
                        
    					<?php get_template_part( 'library/templates/single/single-entry-meta');?>
                    </div>
				</header>
                <div class="container container--narrow">
                    <?php get_template_part( 'library/templates/single/single-entry-interaction');?>
                    <div class="single-body single-body--wide entry-content typography-copy">
                        <?php 
                            if(($reviewBoxPosition == 'aside-left') || ($reviewBoxPosition == 'aside-right')) {
                                echo tnm_single::bk_post_review_box_aside($postID, $reviewBoxPosition);
                            }
                        ?>
                        <?php the_content();?>
    				</div>
                    <?php echo tnm_single::bk_post_pagination();?>
                    <?php 
                        if($reviewBoxPosition == 'default') {
                            echo tnm_single::bk_post_review_box_default($postID);
                        }
                    ?>
                    <?php get_template_part( 'library/templates/single/single-footer');?>
                    <?php 
                        if(($bkAuthorSW != '') && ($bkAuthorSW != 0)) {
                            echo tnm_single::bk_author_box($currentPost->post_author);
                        }
                    ?>
                    <?php 
                        if(($bkPostNavSW != '') && ($bkPostNavSW != 0)) {
                            echo tnm_single::bk_post_navigation('wide');
                        }
                    ?>
                </div><!-- .container -->
            </div><!-- .single-content -->
        </article><!-- .post-single -->
        <?php
            $sectionsSorter = $tnm_option['single-sections-sorter']['enabled'];

            if ($sectionsSorter): foreach ($sectionsSorter as $key=>$value) {
             
                switch($key) {
             
                    case 'related': 
                        if(($bkRelatedSW != '') && ($bkRelatedSW != 0)) {
                            echo tnm_single::bk_related_post_wide($currentPost);
                        }
                        break;
             
                    case 'comment': 
                        comments_template();
                    break;
             
                    case 'same-cat': 
                        if(($bkSameCatSW != '') && ($bkSameCatSW != 0)) {
                            echo tnm_single::bk_same_category_posts_wide($currentPost);
                        }
                    break;
                    
                    default:
                    break;
                }
             
            }
            endif;
        ?>
    </div>
</div>