<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */
?>
<?php
    get_header();
    
    $archiveLayout  = tnm_core::bk_get_theme_option('bk_archive_content_layout');
    $headerStyle    = tnm_core::bk_get_theme_option('bk_archive_header_style');
    $sidebar        = tnm_core::bk_get_theme_option('bk_archive_sidebar_select');
    $sidebarPos     = tnm_core::bk_get_theme_option('bk_archive_sidebar_position');
    $sidebarSticky  = tnm_core::bk_get_theme_option('bk_archive_sidebar_sticky'); 
    
    if(($headerStyle == 'grey-bg-center') || ($headerStyle == 'image-bg-center')) :
        $archiveHeadingClass = 'page-heading--center';
    else :
        $archiveHeadingClass = '';
    endif;
?>
<div class="site-content">       
    <div class="mnmd-block mnmd-block--fullwidth mnmd-block--contiguous page-heading page-heading--has-background <?php echo esc_attr($archiveHeadingClass);?>">
		<div class="container">
			<h2 class="page-heading__title">
                <?php
                    if ( is_day() ) :
                		printf( esc_html__( 'Daily Archives: %s', 'the-next-mag' ), get_the_date() );
                	elseif ( is_month() ) :
                		printf( esc_html__( 'Monthly Archives: %s', 'the-next-mag' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'the-next-mag' ) ) );
                	elseif ( is_year() ) :
                		printf( esc_html__( 'Yearly Archives: %s', 'the-next-mag' ), get_the_date( _x( 'Y', 'yearly archives date format', 'the-next-mag' ) ) );
                    else :
                		esc_html_e( 'Archives', 'the-next-mag' );
                	endif;
                ?>                                
            </h2>
        </div>
	</div>
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
                <?php echo tnm_archive::archive_main_col($archiveLayout);?>
                <?php
                    if (function_exists('tnm_paginate')) {
                        echo tnm_core::tnm_get_pagination();
                    }
                ?>
                </div><!-- .mnmd-main-col -->

                <div class="mnmd-sub-col mnmd-sub-col--right sidebar <?php if($sidebarSticky != 0) echo 'js-sticky-sidebar';?>" role="complementary">
                    <div class="theiaStickySidebar">
                        <?php dynamic_sidebar( $sidebar );?>
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
        ) {?>
    <div class="mnmd-block mnmd-block--fullwidth">
        <?php
            if( ($archiveLayout == 'listing_grid_no_sidebar') || ($archiveLayout == 'listing_grid_small_no_sidebar') ) {
                echo '<div class="container">';
            }else {
                echo '<div class="container container--narrow">';
            }
            echo tnm_archive::archive_fullwidth($archiveLayout);
            if (function_exists('tnm_paginate')) {
                echo tnm_core::tnm_get_pagination();
            }
            echo '</div><!-- .container -->';
        ?>
    </div><!-- .mnmd-block -->
    <?php }?>
        
</div>

<?php get_footer(); ?>