<?php
/**
 * The template for displaying Search Results pages.
 *
 */
 ?> 
<?php
    get_header();    
    $searchLayout   = tnm_core::bk_get_theme_option('bk_search_content_layout');
    $pagination     = tnm_core::bk_get_theme_option('bk_search_pagination');
    $sidebar        = tnm_core::bk_get_theme_option('bk_search_sidebar_select');
    $sidebarPos     = tnm_core::bk_get_theme_option('bk_search_sidebar_position');
    $sidebarSticky  = tnm_core::bk_get_theme_option('bk_search_sidebar_sticky');
    $authorResults  = tnm_core::bk_get_theme_option('bk_author_results_active'); 
    
    $moduleID = uniqid('tnm_posts_'.$searchLayout.'-');
    
    /* Search Count */ 
    $allsearch = new WP_Query("s=$s&showposts=0");
    $searchCount = $allsearch->found_posts;     
    
    if($authorResults != 0) :
        $authorEntries  = tnm_core::bk_get_theme_option('bk_author_results_entries'); 
        $authorPagination     = tnm_core::bk_get_theme_option('bk_author_results_pagination');
        $authorResultID = uniqid('tnm_author_results-');
        
        $userArgs = array(
            'search'         => '*'.esc_attr( $s ).'*',
            'search_columns' => array(
                'user_login',
                'user_nicename',
                'user_email',
                'user_url',
            ),
            'number'         => $authorEntries,
            'offset'         => 0,
        );
        $users = new WP_User_Query( $userArgs );
        
        tnm_core::bk_add_buff('query', $authorResultID, 'args', $userArgs);
        
        $users_found = $users->get_results();
        $user_count = count($users_found);
        $totalUsers = $users->get_total();
        $userMaxPages = 0;
        
        if ($user_count != 0):
            $userMaxPages = intval($totalUsers/$user_count);
            if($totalUsers%$user_count > 0) {
                $userMaxPages = $userMaxPages + 1;
            }
        endif;
        
        $searchCount = $searchCount + $totalUsers;
        
        wp_reset_postdata(); 
    endif;
    
    $posts_per_page = intval(get_query_var('posts_per_page'));
    
    $customArgs = array(
        's'                 => esc_attr($s),
		'post_type'         => array( 'post', 'page' ),
		'posts_per_page'    => $posts_per_page,
        'post_status'       => 'publish',
        'offset'            => 0,
        'orderby'           => 'date',
	);
    tnm_core::bk_add_buff('query', $moduleID, 'args', $customArgs);
?>
<div class="site-content">
    <div class="mnmd-block mnmd-block--fullwidth mnmd-block--contiguous page-heading page-heading--has-background">
		<div class="container">
			<h2 class="page-heading__title"><?php printf( esc_html__( 'Search for: %s', 'the-next-mag' ), get_search_query() ); ?></h2>
			<div class="page-heading__subtitle"><?php echo (esc_html__('There are', 'the-next-mag') . ' ' . esc_attr($searchCount) . ' ' . esc_html__('results', 'the-next-mag'));?></div>
		</div>
	</div>
    <?php 
        if( ($searchLayout == 'listing_list')       || 
          ($searchLayout == 'listing_list_alt_a') || 
          ($searchLayout == 'listing_list_alt_b') ||
          ($searchLayout == 'listing_list_alt_c') || 
          ($searchLayout == 'listing_grid')       ||
          ($searchLayout == 'listing_grid_alt_a') ||
          ($searchLayout == 'listing_grid_alt_b') ||
          ($searchLayout == 'listing_grid_small')
        ) {
    ?>  
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
                        <?php echo tnm_archive::archive_main_col($searchLayout, $moduleID, $pagination);?>
                        <?php echo tnm_archive::bk_pagination_render($pagination);?>
                        <?php 
                        if($pagination == 'ajax-loadmore') {
                            echo '</div><!-- .js-ajax-load-post -->';
                        }
                        ?>
                    </div><!-- .mnmd-block -->
                    <?php if($authorResults != 0) :?>
                        <!-- Author Results -->
                        <div id="<?php echo esc_attr($authorResultID);?>" class="mnmd-block">
                        <?php 
                            if(($userMaxPages != 0) && ($authorPagination == 'ajax-loadmore')) {
                            echo '<div class="js-ajax-load-post">';
                        }
                        ?>
                        <?php 
                        if($userMaxPages != 0) :
                            echo '<div class="block-heading">';
                        	echo '<h4 class="block-heading__title">'.esc_html__('Author Results', 'the-next-mag').'</h4>';
                        	echo '</div>';
                            echo tnm_archive::bk_render_authors($users_found);
                            echo tnm_archive::bk_author_pagination_render($authorPagination, $userMaxPages);
                            if($authorPagination == 'ajax-loadmore') {
                                echo '</div>';
                            }
                        endif;
                        ?>      
                        </div><!-- End Author Results -->
                <?php endif;?>            
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
              ($searchLayout == 'listing_grid_no_sidebar')         ||
              ($searchLayout == 'listing_grid_small_no_sidebar')   ||
              ($searchLayout == 'listing_list_no_sidebar')         ||
              ($searchLayout == 'listing_list_alt_a_no_sidebar')   ||
              ($searchLayout == 'listing_list_alt_b_no_sidebar')   ||
              ($searchLayout == 'listing_list_alt_c_no_sidebar')
            ) { ?>
    <div id="<?php echo esc_attr($moduleID);?>" class="mnmd-block mnmd-block--fullwidth">
        <?php
        if( ($searchLayout == 'listing_grid_no_sidebar') || ($searchLayout == 'listing_grid_small_no_sidebar') ) {
            echo '<div class="container">';
        }else {
            echo '<div class="container container--narrow">';
        }
        if($pagination == 'ajax-loadmore') {
            echo '<div class="js-ajax-load-post">';
        }
        
        echo tnm_archive::archive_fullwidth($searchLayout, $moduleID, $pagination);
        echo tnm_archive::bk_pagination_render($pagination);
        
        if($pagination == 'ajax-loadmore') {
            echo '</div>';
        }
        echo '</div><!-- .container -->';
        ?>
    </div><!-- .mnmd-block -->
    <div id="<?php echo esc_attr($authorResultID);?>" class="mnmd-block mnmd-block--fullwidth">    
        <div class="container container--narrow">
        <!-- Author Results -->
        <?php 
        if($authorPagination == 'ajax-loadmore') {
            echo '<div class="js-ajax-load-post">';
        }
        ?>
        <?php 
        if($userMaxPages != 0) :
            echo '<div class="block-heading">';
        	echo '<h4 class="block-heading__title">'.esc_html__('Author Results', 'the-next-mag').'</h4>';
        	echo '</div>';
            echo tnm_archive::bk_render_authors($users_found);
            echo tnm_archive::bk_author_pagination_render($authorPagination, $userMaxPages);
            if($authorPagination == 'ajax-loadmore') {
                echo '</div>';
            }
        endif;
        ?> 
        </div>
    </div>
    <?php }?>
</div>
<?php get_footer(); ?>