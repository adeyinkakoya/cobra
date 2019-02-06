<?php
/*
Template Name: Blog
*/
 ?> 
<?php
    get_header();
    
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    query_posts('post_type=post&post_status=publish&paged=' . $paged);
    
    $sticky = get_option('sticky_posts') ;
    rsort( $sticky );
    
    $pageID         = get_the_ID();
    $headerStyle    = tnm_single::bk_get_post_option($pageID, 'bk_blog_header_style');
    $blogLayout     = tnm_core::bk_get_theme_option('bk_blog_content_layout');
    $pagination     = tnm_core::bk_get_theme_option('bk_blog_pagination');
    $sidebar        = tnm_core::bk_get_theme_option('bk_blog_sidebar_select');
    $sidebarPos     = tnm_core::bk_get_theme_option('bk_blog_sidebar_position');
    $sidebarSticky  = tnm_core::bk_get_theme_option('bk_blog_sidebar_sticky'); 
    
    $moduleID = uniqid('tnm_posts_'.$blogLayout.'-');
    $posts_per_page = intval(get_query_var('posts_per_page'));
    $customArgs = array(
        'post__not_in'      => $sticky,
    	'post_type'         => array( 'post' ),
    	'posts_per_page'    => $posts_per_page,
        'post_status'       => 'publish',
        'offset'            => 0,
        'orderby'           => 'date',
    );
    tnm_core::bk_add_buff('query', $moduleID, 'args', $customArgs);
?>
<div class="site-content">
    <?php echo tnm_archive::render_page_heading($pageID, $headerStyle);?>
<?php if( ($blogLayout == 'listing_list')       || 
          ($blogLayout == 'listing_list_alt_a') || 
          ($blogLayout == 'listing_list_alt_b') ||
          ($blogLayout == 'listing_list_alt_c') || 
          ($blogLayout == 'listing_grid')       ||
          ($blogLayout == 'listing_grid_alt_a') ||
          ($blogLayout == 'listing_grid_alt_b') ||
          ($blogLayout == 'listing_grid_small')
        ) {?>
    <div class="mnmd-block mnmd-block--fullwidth">
        <div class="container">
            <div class="row">
                <div class="mnmd-main-col <?php if($sidebarPos == 'left') echo('has-left-sidebar');?>" role="main">
                    <div id="<?php echo esc_attr($moduleID);?>" class="mnmd-block tnm_latest_blog_posts">                        
                        <?php 
                        if($pagination == 'ajax-loadmore') {
                            echo '<div class="js-ajax-load-post">';
                        }
                        ?>
                        <?php echo tnm_archive::archive_main_col($blogLayout, $moduleID, $pagination);?>
                        <?php echo tnm_archive::bk_pagination_render($pagination);?>
                        <?php 
                        if($pagination == 'ajax-loadmore') {
                            echo '</div>';
                        }
                        ?>
                    </div><!-- .mnmd-block -->
                </div><!-- .mnmd-main-col -->

                <div class="mnmd-sub-col mnmd-sub-col--right sidebar <?php if($sidebarSticky != 0) echo 'js-sticky-sidebar';?>" role="complementary">
                    <div class="theiaStickySidebar">
                        <?php 
                            dynamic_sidebar( $sidebar );
                        ?>
                    </div>
                </div> <!-- .mnmd-sub-col -->
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .mnmd-block -->
<?php } elseif( 
          ($blogLayout == 'listing_grid_no_sidebar')         ||
          ($blogLayout == 'listing_grid_small_no_sidebar')   ||
          ($blogLayout == 'listing_list_no_sidebar')         ||
          ($blogLayout == 'listing_list_alt_a_no_sidebar')   ||
          ($blogLayout == 'listing_list_alt_b_no_sidebar')   ||
          ($blogLayout == 'listing_list_alt_c_no_sidebar')
        ) { ?>
    <div id="<?php echo esc_attr($moduleID);?>" class="mnmd-block mnmd-block--fullwidth tnm_latest_blog_posts">
        <?php
        if( ($blogLayout == 'listing_grid_no_sidebar') || ($blogLayout == 'listing_grid_small_no_sidebar') ) {
            echo '<div class="container">';
        }else {
            echo '<div class="container container--narrow">';
        }
                
        if($pagination == 'ajax-loadmore') {
            echo '<div class="js-ajax-load-post">';
        }
        
        echo tnm_archive::archive_fullwidth($blogLayout, $moduleID, $pagination);
        echo tnm_archive::bk_pagination_render($pagination);
        
        if($pagination == 'ajax-loadmore') {
            echo '</div>';
        }
        echo '</div><!-- .container -->';
        ?>
    </div><!-- .mnmd-block -->
<?php }?>
</div>
<?php get_footer(); ?>