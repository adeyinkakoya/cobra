<?php
/**
 * The template for displaying Category archive pages
 *
 */
 ?>
<?php
    get_header();
    $tnm_option = tnm_core::bk_get_global_var('tnm_option');
    
    $paged = intval(get_query_var('paged'));
    if(empty($paged) || $paged == 0) {
        $paged = 1;
    }
    
    if (function_exists('get_queried_object_id')) :
        $catID          = get_queried_object_id();
    else:
        $catID          = $wp_query->get_queried_object_id();
    endif;
    
    $archiveLayout  = tnm_archive::bk_get_archive_option($catID, 'bk_category_content_layout');
    $pagination     = tnm_archive::bk_get_archive_option($catID, 'bk_category_pagination');
    $featLayout     = tnm_archive::bk_get_archive_option($catID, 'bk_category_feature_area');
    $featAreaShowHide  = tnm_archive::bk_get_archive_option($catID, 'bk_feature_area__show_hide');
    $sidebar        = tnm_archive::bk_get_archive_option($catID, 'bk_category_sidebar_select');
    $sidebarPos     = tnm_archive::bk_get_archive_option($catID, 'bk_category_sidebar_position');
    $sidebarSticky  = tnm_archive::bk_get_archive_option($catID, 'bk_category_sidebar_sticky');
    $featAreaOption = tnm_archive::bk_get_archive_option($catID, 'bk_category_feature_area__post_option');
    
    $moduleID = uniqid('tnm_posts_'.$archiveLayout.'-');
    $posts_per_page = intval(get_query_var('posts_per_page'));
    
    if(function_exists('rwmb_meta')) {
        $is_exclude = rwmb_meta( 'bk_category_exclude_posts', array( 'object_type' => 'term' ), $catID );
    }else {
        $is_exclude = '';
    }
    if (isset($is_exclude) && ($is_exclude == 'global_settings')): 
        $is_exclude = $tnm_option['bk_category_exclude_posts'];
    endif;
    if(($is_exclude == 1) || ($featAreaOption == 'latest')) {
        $excludeID = tnm_archive::get_sticky_ids__category_feature_area($catID, $featLayout);
    }else {
        $excludeID = '';
    }
    
    $customArgs = array(
        'cat'               => $catID,
        'post__not_in'      => $excludeID,
		'post_type'         => array( 'post' ),
		'posts_per_page'    => $posts_per_page,
        'post_status'       => 'publish',
        'offset'            => 0,
        'orderby'           => 'date',
	);
    tnm_core::bk_add_buff('query', $moduleID, 'args', $customArgs);
?>
<div class="site-content">
    <?php 
        if(($featLayout == 'disable') || ($featLayout == '')) {
            echo tnm_archive::tnm_archive_header($catID);
        }else {
            if($featAreaShowHide != 1) {
                echo tnm_archive::archive_feature_area($catID, $featLayout);
            }else {
                if($paged == 1) {
                    echo tnm_archive::archive_feature_area($catID, $featLayout);
                }else {
                    echo tnm_archive::tnm_archive_header($catID);
                }
            }
        }
    ?>          
    
    <?php if( ($archiveLayout == 'listing_list')       || 
              ($archiveLayout == 'listing_list_alt_a') || 
              ($archiveLayout == 'listing_list_alt_b') ||
              ($archiveLayout == 'listing_list_alt_c') || 
              ($archiveLayout == 'listing_grid')       ||
              ($archiveLayout == 'listing_grid_alt_a') ||
              ($archiveLayout == 'listing_grid_alt_b') ||
              ($archiveLayout == 'listing_grid_small')
            ) {?>
    <div class="mnmd-block mnmd-block--fullwidth">
        <div class="container">
            <div class="row">
                <div class="mnmd-main-col <?php if($sidebarPos == 'left') echo('has-left-sidebar');?>" role="main">
                    <div id="<?php echo esc_attr($moduleID);?>" class="mnmd-block">
                        <?php 
                        if($pagination == 'ajax-loadmore') {
                            echo '<div class="js-ajax-load-post">';
                        }
                        ?>
                        <?php echo tnm_archive::archive_main_col($archiveLayout, $moduleID, $pagination);?>
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
              ($archiveLayout == 'listing_grid_no_sidebar')         ||
              ($archiveLayout == 'listing_grid_small_no_sidebar')   ||
              ($archiveLayout == 'listing_list_no_sidebar')         ||
              ($archiveLayout == 'listing_list_alt_a_no_sidebar')   ||
              ($archiveLayout == 'listing_list_alt_b_no_sidebar')   ||
              ($archiveLayout == 'listing_list_alt_c_no_sidebar')
            ) { ?>
    <div id="<?php echo esc_attr($moduleID);?>" class="mnmd-block mnmd-block--fullwidth">
        <?php
        if( ($archiveLayout == 'listing_grid_no_sidebar') || ($archiveLayout == 'listing_grid_small_no_sidebar') ) {
            echo '<div class="container">';
        }else {
            echo '<div class="container container--narrow">';
        }
        if($pagination == 'ajax-loadmore') {
            echo '<div class="js-ajax-load-post">';
        }
        
        echo tnm_archive::archive_fullwidth($archiveLayout, $moduleID, $pagination);
        echo tnm_archive::bk_pagination_render($pagination);
        
        if($pagination == 'ajax-loadmore') {
            echo '</div>';
        }
        echo '</div><!-- .container -->';
        ?>
    </div><!-- .mnmd-block -->
    <?php }else {?>
    <div class="mnmd-block mnmd-block--fullwidth">
        <div class="container">
            <div class="row">
                <div class="mnmd-main-col" role="main">
                    <div id="<?php echo esc_attr($moduleID);?>" class="mnmd-block">
                        <?php echo tnm_archive::archive_main_col('listing_list', $moduleID, 'default');?>
                        <?php echo tnm_archive::bk_pagination_render('default');?>
                    </div><!-- .mnmd-block -->
                </div><!-- .mnmd-main-col -->

                <div class="mnmd-sub-col mnmd-sub-col--right sidebar js-sticky-sidebar" role="complementary">
                    <div class="theiaStickySidebar">
                    <?php dynamic_sidebar( $sidebar ); ?>
                    </div>
                </div> <!-- .mnmd-sub-col -->
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .mnmd-block -->
    <?php }?>
</div>

<?php get_footer(); ?>