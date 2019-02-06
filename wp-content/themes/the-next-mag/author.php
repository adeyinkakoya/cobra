<?php
/**
 * The template for displaying Author archive pages
 *
 */
 ?> 
<?php
    get_header();
    
    if (function_exists('get_queried_object_id')) :
        $authorID = get_queried_object_id();
    else:
        $authorID = $wp_query->get_queried_object_id();
    endif;
    
    $authorLayout   = tnm_core::bk_get_theme_option('bk_author_content_layout');
    $pagination     = tnm_core::bk_get_theme_option('bk_author_pagination');
    $sidebar        = tnm_core::bk_get_theme_option('bk_author_sidebar_select');
    $sidebarPos     = tnm_core::bk_get_theme_option('bk_author_sidebar_position');
    $sidebarSticky  = tnm_core::bk_get_theme_option('bk_author_sidebar_sticky'); 
    
    $moduleID = uniqid('tnm_posts_'.$authorLayout.'-');
    $posts_per_page = intval(get_query_var('posts_per_page'));
    $customArgs = array(
        'author'            => $authorID,
    	'post_type'         => array( 'post' ),
    	'posts_per_page'    => $posts_per_page,
        'post_status'       => 'publish',
        'offset'            => 0,
        'orderby'           => 'date',
    );
    tnm_core::bk_add_buff('query', $moduleID, 'args', $customArgs);
?>
<div class="site-content">
<?php if( ($authorLayout == 'listing_list')       || 
          ($authorLayout == 'listing_list_alt_a') || 
          ($authorLayout == 'listing_list_alt_b') ||
          ($authorLayout == 'listing_list_alt_c') || 
          ($authorLayout == 'listing_grid')       ||
          ($authorLayout == 'listing_grid_alt_a') ||
          ($authorLayout == 'listing_grid_alt_b') ||
          ($authorLayout == 'listing_grid_small')
        ) {?>
    <div class="mnmd-block mnmd-block--fullwidth">
        <div class="container">
            <div class="row">
                <div class="mnmd-main-col <?php if($sidebarPos == 'left') echo('has-left-sidebar');?>" role="main">
                    <div id="<?php echo esc_attr($moduleID);?>" class="mnmd-block">
                        <?php echo tnm_archive::author_box($authorID);?>
                        
                        <div class="spacer-lg"></div>
                        
                        <?php 
                        if($pagination == 'ajax-loadmore') {
                            echo '<div class="js-ajax-load-post">';
                        }
                        ?>
                        <?php echo tnm_archive::archive_main_col($authorLayout, $moduleID, $pagination);?>
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
          ($authorLayout == 'listing_grid_no_sidebar')         ||
          ($authorLayout == 'listing_grid_small_no_sidebar')   ||
          ($authorLayout == 'listing_list_no_sidebar')         ||
          ($authorLayout == 'listing_list_alt_a_no_sidebar')   ||
          ($authorLayout == 'listing_list_alt_b_no_sidebar')   ||
          ($authorLayout == 'listing_list_alt_c_no_sidebar')
        ) { ?>
    <div id="<?php echo esc_attr($moduleID);?>" class="mnmd-block mnmd-block--fullwidth">
        <?php
        if( ($authorLayout == 'listing_grid_no_sidebar') || ($authorLayout == 'listing_grid_small_no_sidebar') ) {
            echo '<div class="container">';
        }else {
            echo '<div class="container container--narrow">';
        }
        
        echo tnm_archive::author_box($authorID);
        echo '<div class="spacer-lg"></div>';
        
        if($pagination == 'ajax-loadmore') {
            echo '<div class="js-ajax-load-post">';
        }
        
        echo tnm_archive::archive_fullwidth($authorLayout, $moduleID, $pagination);
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