<?php
/**
 * The Default Page Template -- With Sidebar page template
 *
 */
 ?>
<?php
    $pageID  = get_the_ID();
    
    $headerStyle    = tnm_single::bk_get_post_option($pageID, 'bk_page_header_style');    
    $sidebar        = tnm_single::bk_get_post_option($pageID, 'bk_page_sidebar_select');
    $sidebarPos     = tnm_single::bk_get_post_option($pageID, 'bk_page_sidebar_position');
    $sidebarSticky  = tnm_single::bk_get_post_option($pageID, 'bk_page_sidebar_sticky'); 
    $featuredImage  = tnm_single::bk_get_post_option($pageID, 'bk_page_feat_img');       
?>
<?php echo tnm_archive::render_page_heading($pageID, $headerStyle);?>
<div class="mnmd-block mnmd-block--fullwidth">
	<div class="container">
		<div class="row">
			<div class="mnmd-main-col <?php if($sidebarPos == 'left') echo('has-left-sidebar');?>" role="main">
                <article <?php post_class('post--single');?>>
                    <div class="single-content">
                        <?php
                            if ( ($featuredImage != 0) && tnm_core::bk_check_has_post_thumbnail($pageID)) {
                                echo '<div class="entry-thumb single-entry-thumb">';
                                echo get_the_post_thumbnail($pageID, 'tnm-m-2_1');
                				echo '</div>';
                            }
                        ?>
						<div class="entry-content typography-copy">
                            <?php the_content();?>
                        </div>
                        <?php echo tnm_single::bk_post_pagination();?>
                    </div>
                </article>
                <?php if(comments_open()) {?>
                    <div class="comments-section single-entry-section">
                        <?php comments_template(); ?>
                    </div> <!-- End Comment Box -->
                <?php }?>
            </div><!-- .mnmd-main-col -->
            <div class="mnmd-sub-col sidebar <?php if($sidebarSticky != 0) echo 'js-sticky-sidebar';?>" role="complementary">
				<?php 
                    dynamic_sidebar( $sidebar );
                ?>
			</div><!-- .mnmd-sub-col -->
        </div>
    </div> <!-- .container -->
</div><!-- .mnmd-block -->