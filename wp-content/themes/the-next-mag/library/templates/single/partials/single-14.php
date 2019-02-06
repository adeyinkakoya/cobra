<?php
/*
Template Name: Single Template 6
*/
?>
<?php
    global $post;
    $tnm_option = tnm_core::bk_get_global_var('tnm_option');
    $currentPost        = $post;
    $postID             = get_the_ID();      
    $catIDClass         = '';
    $bkEntryTeaser      = get_post_meta($postID,'bk_post_subtitle',true);
    
    $sidebar            =  tnm_single::bk_get_post_option($postID, 'bk_post_sb_select');   
    $sidebarPos         =  tnm_single::bk_get_post_option($postID, 'bk_post_sb_position');    
    $sidebarSticky      =  tnm_single::bk_get_post_option($postID, 'bk_post_sb_sticky');
    
    $reviewBoxPosition  = get_post_meta($postID,'bk_review_box_position',true);
    
    //Switch
    $bkAuthorSW         = tnm_single::bk_get_post_option($postID, 'bk-authorbox-sw');
    $bkPostNavSW        = tnm_single::bk_get_post_option($postID, 'bk-postnav-sw');
    $bkRelatedSW        = tnm_single::bk_get_post_option($postID, 'bk-related-sw');
    $bkSameCatSW        = tnm_single::bk_get_post_option($postID, 'bk-same-cat-sw');
?>
<div class="site-content single-entry single-entry--billboard-blur">
    <?php
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
    <div class="mnmd-block mnmd-block--fullwidth mnmd-block--contiguous single-billboard js-overlay-bg">     
        <div class="background-img hidden-xs hidden-sm" style="background-image: url('<?php echo esc_url($theBGLinkXXL);?>');"></div>
		<div class="background-img background-img--darkened hidden-md hidden-lg" style="background-image: url('<?php echo esc_url($theBGLink);?>');"></div>
        <div class="single-billboard__inner">
            <header class="single-header">
                <div class="container">
                    <div class="single-header__inner inverse-text js-overlay-bg-sub-area">
                        <div class="background-img background-img--dimmed blurred-more hidden-xs hidden-sm js-overlay-bg-sub" style="background-image: url('<?php echo esc_url($theBGLinkXXL);?>');"></div>
                        <div class="single-header__content">
                            <?php 
                                $catClass = 'post__cat post__cat--bg cat-theme-bg';
                                echo tnm_core::bk_get_post_cat_link($postID, $catClass, true);
                            ?>
        					<h1 class="entry-title entry-title--lg"><?php echo get_the_title($postID);?></h1>
                            
                            <?php if($bkEntryTeaser):?>
                                <div class="entry-teaser hidden-xs">
        							<?php echo esc_html($bkEntryTeaser);?>
        						</div>
                            <?php endif;?>
                            
        					<?php get_template_part( 'library/templates/single/single-entry-meta');?>
                        </div>
                    </div>
                </div>
			</header>
        </div>
	</div>
    <div class="mnmd-block mnmd-block--fullwidth single-entry-wrap">
        <div class="container">
            <div class="row">
                <div class="mnmd-main-col <?php if($sidebarPos == 'left') echo('has-left-sidebar');?>" role="main">
                    <article <?php post_class('mnmd-block post--single');?>>
                        <div class="single-content">
                            <?php
                                if(function_exists('has_post_format')){
                                    $postFormat = get_post_format($postID);
                                }else {
                                    $postFormat = 'standard';
                                } 
                                if(($postFormat == 'video') || ($postFormat == 'gallery')) {
                                    echo tnm_single::bk_entry_media($postID);
                                }
                            ?>
                            <?php get_template_part( 'library/templates/single/single-entry-interaction');?>
                            
                            <?php if($bkEntryTeaser):?>
                                <div class="entry-teaser visible-xs">
        							<?php echo esc_html($bkEntryTeaser);?>
        						</div>
                            <?php endif;?>
                        
                            <div class="single-body entry-content typography-copy">
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
                        </div><!-- .single-content -->
                    </article><!-- .post-single -->
                    <?php 
                        if(($bkAuthorSW != '') && ($bkAuthorSW != 0)) {
                            echo tnm_single::bk_author_box($currentPost->post_author);
                        }
                    ?>
                    <?php 
                        if(($bkPostNavSW != '') && ($bkPostNavSW != 0)) {
                            echo tnm_single::bk_post_navigation();
                        }
                    ?>
                    <?php
                        $sectionsSorter = $tnm_option['single-sections-sorter']['enabled'];
 
                        if ($sectionsSorter): foreach ($sectionsSorter as $key=>$value) {
                         
                            switch($key) {
                         
                                case 'related': 
                                    if(($bkRelatedSW != '') && ($bkRelatedSW != 0)) {
                                        echo tnm_single::bk_related_post($currentPost);
                                    }
                                    break;
                         
                                case 'comment': 
                                    comments_template();
                                break;
                         
                                case 'same-cat': 
                                    if(($bkSameCatSW != '') && ($bkSameCatSW != 0)) {
                                        echo tnm_single::bk_same_category_posts($currentPost);
                                    }
                                break;
                                
                                default:
                                break;
                            }
                         
                        }
                        endif;
                    ?>
                </div><!-- .mnmd-main-col -->
                
                <div class="mnmd-sub-col sidebar <?php if($sidebarSticky != 0) echo 'js-sticky-sidebar';?>" role="complementary">
					<div class="theiaStickySidebar">
                        <?php 
                            dynamic_sidebar( $sidebar );
                        ?>
                    </div>
				</div><!-- .mnmd-sub-col -->
            </div>
        </div>
    </div>
</div>