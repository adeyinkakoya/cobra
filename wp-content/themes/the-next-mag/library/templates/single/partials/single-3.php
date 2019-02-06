<?php
/*
Template Name: Single Template 1 -- No Sidebar
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
<div class="site-content single-entry single-entry--no-sidebar">
    <div class="mnmd-block mnmd-block--fullwidth single-entry-wrap">
        
        <article <?php post_class('mnmd-block post--single');?>>
            <div class="single-content">
                <header class="single-header">
                    <div class="container">
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
                        <?php get_template_part( 'library/templates/single/single-entry-interaction');?>
                    </div>
				</header>
                <?php
                    if(function_exists('has_post_format')){
                        $postFormat = get_post_format($postID);
                    }else {
                        $postFormat = 'standard';
                    } 
                    if(($postFormat == 'video') || ($postFormat == 'gallery')) {
                        echo '<div class="container">';
                        echo tnm_single::bk_entry_media($postID, 'tnm-xl-2_1');
                        echo '</div>';
                    }else {
                        $featImgCaption = get_the_post_thumbnail_caption($postID);
                        if (($featuredImageSTS != 0) && (tnm_core::bk_check_has_post_thumbnail($postID))) {
                            echo '<div class="entry-thumb single-entry-thumb">';
                            echo get_the_post_thumbnail($postID, 'tnm-xl-2_1');
                            if($featImgCaption != '') :
                                echo '<div class="single-entry-thumb-caption"><span>'.$featImgCaption.'</span></div>';
                            endif;
            				echo '</div>';
                        }
                    }
                ?>
                <div class="container container--narrow">
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