<?php
function tnm_modify_main_query( $query ) {
    global $tnm_option;
    if($tnm_option == '') {
        return;
    }    
    if($query->is_main_query() AND !is_admin() ) {
        if ( is_category() ){
            $excludeIDs = array();
            $posts_per_page = 0;
            
            $term_id = get_queried_object_id();
            
            $featAreaOption  = tnm_archive::bk_get_archive_option($term_id, 'bk_category_feature_area__post_option');
            
            if(function_exists('rwmb_meta')) {
                $is_exclude = rwmb_meta( 'bk_category_exclude_posts', array( 'object_type' => 'term' ), $term_id );
            }else {
                $is_exclude = '';
            }
            if (isset($is_exclude) && (($is_exclude == 'global_settings') || ($is_exclude == ''))): 
                $is_exclude = $tnm_option['bk_category_exclude_posts'];
            endif;
            
            if(($is_exclude == 1) || ($featAreaOption == 'latest')) {                     

                $sticky = get_option('sticky_posts') ;
                rsort( $sticky );
                
                if(function_exists('rwmb_meta')) {
                    $featLayout = rwmb_meta( 'bk_category_feature_area', array( 'object_type' => 'term' ), $term_id );
                }else {
                    $featLayout = 'global_settings';
                }
                if (isset($is_exclude) && (($featLayout == 'global_settings') || ($featLayout == ''))): 
                    $featLayout = $tnm_option['bk_category_feature_area'];
                endif;
                            
                $args = array (
                    'post_type'     => 'post',
                    'cat'           => $term_id, // Get current category only
                    'order'         => 'DESC',
                );
                
                switch($featLayout){
                    case 'posts_block_b' :
                        $posts_per_page = 6;
                        break;
                    case 'mosaic_a' :
                    case 'mosaic_a_bg' :
                    case 'featured_block_e' :
                    case 'featured_block_f' :
                    case 'posts_block_i' :
                        $posts_per_page = 5;
                        break;
                    case 'mosaic_b' :
                    case 'mosaic_b_bg' :
                    case 'posts_block_c' :
                        $posts_per_page = 4;
                        break;
                    case 'mosaic_c' :
                    case 'mosaic_c_bg' :
                    case 'posts_block_e' :
                    case 'posts_block_e_bg' :
                        $posts_per_page = 3;
                        break;
                    default:
                        $posts_per_page = 0;
                        break;
                }
                if($posts_per_page == 0) :
                    wp_reset_postdata();
                    return;
                endif;
                $args['posts_per_page'] = $posts_per_page;
                if($featAreaOption == 'featured') {
                    $args['post__in'] = $sticky; // Get stickied posts
                }
                
                $sticky_query = new WP_Query( $args );
                while ( $sticky_query->have_posts() ): $sticky_query->the_post();
                    $excludeIDs[] = get_the_ID();
                endwhile;
                wp_reset_postdata();
                            
                $query->set( 'post__not_in', $excludeIDs );
            }else {
                return;
            }
        }
    }
}
add_action( 'pre_get_posts', 'tnm_modify_main_query' );

require_once (get_template_directory() . '/library/meta_box_config.php');

add_theme_support('title-tag');

/**
 * http://codex.wordpress.org/Content_Width
 */
if ( ! isset($content_width)) {
	$content_width = 1200;
}
/**
 * Add support for the featured images (also known as post thumbnails).
 */
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' );
}

/**
 * Remove Comment Default Style
 */
add_filter( 'show_recent_comments_widget_style', '__return_false' );
  
add_action( 'after_setup_theme', 'tnm_thumbnail_setup' );
if ( ! function_exists( 'tnm_thumbnail_setup' ) ){

    function tnm_thumbnail_setup() {
        add_image_size( 'tnm-xxs-4_3', 180, 135, true );
        add_image_size( 'tnm-xxs-1_1', 180, 180, true );
        add_image_size( 'tnm-xs-16_9 400x225', 400, 225, true );
        add_image_size( 'tnm-xs-4_3', 400, 300, true );
        add_image_size( 'tnm-xs-2_1', 400, 200, true );
        add_image_size( 'tnm-xs-1_1', 400, 400, true );        
        add_image_size( 'tnm-xs-16_9', 600, 338, true ); 
        add_image_size( 'tnm-s-4_3', 600, 450, true );
        add_image_size( 'tnm-s-2_1', 600, 300, true );
        add_image_size( 'tnm-s-1_1', 600, 600, true );
        add_image_size( 'tnm-m-16_9', 800, 450, true );
        add_image_size( 'tnm-m-4_3', 800, 600, true );
        add_image_size( 'tnm-m-2_1', 800, 400, true );
        add_image_size( 'tnm-l-16_9', 1200, 675, true );
        add_image_size( 'tnm-l-4_3', 1200, 900, true );
        add_image_size( 'tnm-l-2_1', 1200, 600, true );
        add_image_size( 'tnm-xl-16_9', 1600, 900, true );
        add_image_size( 'tnm-xl-4_3', 1600, 1200, true );        
        add_image_size( 'tnm-xl-2_1', 1600, 800, true ); 
        add_image_size( 'tnm-xxl', 2000, 1125, true );
    }

}
/**
 * Post Format 
 */
 add_action('after_setup_theme', 'tnm_add_theme_format', 11);
function tnm_add_theme_format() {
    add_theme_support( 'post-formats', array( 'gallery', 'video' ) );
}
/**
 * Add support for the featured images (also known as post thumbnails).
 */
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
}
/**
 * Add Image Column To Posts Page
 */
function tnm_featured_image_column_image( $image ) {
    if ( !tnm_core::bk_check_has_post_thumbnail(get_the_ID()) )
        return trailingslashit( get_stylesheet_directory_uri() ) . 'images/no-featured-image';
}
add_filter( 'featured_image_column_default_image', 'tnm_featured_image_column_image' );

/**
 * Title
 */
add_filter( 'wp_title', 'tnm_wp_title', 10, 2 );
if ( ! function_exists( 'tnm_wp_title' ) ) {
    function tnm_wp_title( $title, $sep ) {
    	global $paged, $page;
    
    	if ( is_feed() ) {
    		return $title;
    	}
    
    	// Add the site name.
    	$title .= get_bloginfo( 'name' );
    
    	// Add the site description for the home/front page.
    	$site_description = get_bloginfo( 'description', 'display' );
    	if ( $site_description && ( is_home() || is_front_page() ) ) {
    		$title = "$title $sep $site_description";
    	}
    
    	// Add a page number if necessary.
    	if ( $paged >= 2 || $page >= 2 ) {
    		$title = "$title $sep " . sprintf( esc_html__( 'Page %s', 'the-next-mag' ), max( $paged, $page ) );
    	}
    
    	return $title;
    }
}
/**
 * Register menu locations
 *---------------------------------------------------
 */
if ( ! function_exists( 'tnm_register_menu' ) ) {
    function tnm_register_menu() {
        register_nav_menu('top-menu', esc_html__( 'Top Menu', 'the-next-mag' ));
        register_nav_menu('main-menu', esc_html__( 'Main Menu', 'the-next-mag' ));
        register_nav_menu('footer-menu', esc_html__( 'Footer Menu', 'the-next-mag' )); 
        register_nav_menu('offcanvas-menu', esc_html__( 'Offcanvas Menu', 'the-next-mag' )); 
    }
}
add_action( 'init', 'tnm_register_menu' );

function tnm_category_nav_class( $classes, $item ){
    /*
    if(isset($item->bkmegamenu[0])) :
        if ($item->bkmegamenu[0]) {
            $classes[] = 'menu-category-megamenu';
        }
        if( 'category' == $item->object ){
            $classes[] = 'menu-item-cat-' . $item->object_id;
        }
    endif;
    */
    if( 'category' == $item->object ){
        $classes[] = 'menu-item-cat-' . $item->object_id;
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'tnm_category_nav_class', 10, 4 );

function tnm_custom_excerpt_length( $length ) {
	return 100;
}
add_filter( 'excerpt_length', 'tnm_custom_excerpt_length', 999 );

/**
 * ReduxFramework
 */
/**-------------------------------------------------------------------------------------------------------------------------
 * remove redux admin page
 */
if ( ! function_exists( 'tnm_remove_redux_page' ) ) {
	function tnm_remove_redux_page() {
		remove_submenu_page( 'tools.php', 'redux-about' );
	}
	add_action( 'admin_menu', 'tnm_remove_redux_page', 12 );
}
/**-------------------------------------------------------------------------------------------------------------------------
 * Init
 */
if ( !isset( $tnm_option ) && file_exists( THENEXTMAG_LIBS.'theme-option.php' ) ) {
    require_once( THENEXTMAG_LIBS.'theme-option.php' );
}
/**
 * Register sidebars and widgetized areas.
 *---------------------------------------------------
 */
 if ( ! function_exists( 'tnm_widgets_init' ) ) {
    function tnm_widgets_init() {
        $tnm_option = tnm_core::bk_get_global_var('tnm_option');
        $headingStyle = isset($tnm_option['bk-default-widget-heading']) ? $tnm_option['bk-default-widget-heading'] : '';
        if($headingStyle) {
            $headingClass = tnm_core::bk_get_widget_heading_class($headingStyle);
        }else {
            $headingClass = 'block-heading--line';
        }
        register_sidebar( array(
    		'name' => esc_html__('Sidebar', 'the-next-mag'),
    		'id' => 'home_sidebar',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget' => '</div>',
    		'before_title' => '<div class="widget__title block-heading '.$headingClass.'"><h4 class="widget__title-text">',
    		'after_title' => '</h4></div>',
    	) );
        
        register_sidebar( array(
    		'name' => esc_html__('Desktop OffCanvas Area', 'the-next-mag'),
    		'id' => 'offcanvas-widget-area',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget' => '</div>',
    		'before_title' => '<div class="widget__title block-heading no-line"><h4 class="widget__title-text">',
    		'after_title' => '</h4></div>',
    	) );
        
        register_sidebar( array(
    		'name' => esc_html__('Mobile OffCanvas Area', 'the-next-mag'),
    		'id' => 'mobile-offcanvas-widget-area',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget' => '</div>',
    		'before_title' => '<div class="widget__title block-heading no-line"><h4 class="widget__title-text">',
    		'after_title' => '</h4></div>',
    	) );
        
        register_sidebar( array(
    		'name' => esc_html__('Footer Sidebar 1', 'the-next-mag'),
    		'id' => 'footer_sidebar_1',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget' => '</div>',
    		'before_title' => '<div class="widget__title block-heading block-heading--center"><h4 class="widget__title-text">',
    		'after_title' => '</h4></div>',
    	) );
        
        register_sidebar( array(
    		'name' => esc_html__('Footer Sidebar 2', 'the-next-mag'),
    		'id' => 'footer_sidebar_2',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget' => '</div>',
    		'before_title' => '<div class="widget__title block-heading block-heading--center"><h4 class="widget__title-text">',
    		'after_title' => '</h4></div>',
    	) );
        
        register_sidebar( array(
    		'name' => esc_html__('Footer Sidebar 3', 'the-next-mag'),
    		'id' => 'footer_sidebar_3',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget' => '</div>',
    		'before_title' => '<div class="widget__title block-heading block-heading--center"><h4 class="widget__title-text">',
    		'after_title' => '</h4></div>',
    	) );
    }
}
add_action( 'widgets_init', 'tnm_widgets_init' );

/**
 * Save Post Content Word Count
 *---------------------------------------------------
 */
function bk_post_content__word_count($postID){
    $content = get_post_field( 'post_content', $postID );
    $word_count = str_word_count( strip_tags( $content ) );
    $lastLength = get_post_meta($postID, 'bk_post_content__word_count');
    if(!empty($lastLength)) :
        if(($lastLength[0] != '') && ($lastLength[0] != $word_count)) :
            update_post_meta($postID, 'bk_post_content__word_count', $word_count);
        elseif($lastLength[0] == '') :
            add_post_meta($postID, 'bk_post_content__word_count', $word_count, true);
        endif;
    endif;
}

add_action( 'post_updated', 'bk_post_content__word_count', 10, 1 ); //don't forget the last argument to allow all three arguments of the function

/**
 * Add responsive container to embeds video
 */
if ( !function_exists('bk_embed_html') ){
	function bk_embed_html( $embed, $url = '', $attr = '' ) {
		$accepted_providers = array(
			'youtube',
			'vimeo',
			'slideshare',
			'dailymotion',
			'viddler.com',
			'hulu.com',
			'blip.tv',
			'revision3.com',
			'funnyordie.com',
			'wordpress.tv',
		);
		$resize = false;

		// Check each provider
		foreach ( $accepted_providers as $provider ) {
			if ( strstr( $url, $provider ) ) {
				$resize = true;
				break;
			}
		}
		if ( $resize ) {
	    	return '<div class="mnmd-responsive-video">' . $embed . '</div>';
	    } else {
	    	return $embed;
	    }
	}
}
add_filter( 'embed_oembed_html', 'bk_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'bk_embed_html' ); // Jetpack

/**
 * Limit number of tags in widget tag cloud
 */
if ( !function_exists('tnm_tag_widget_limit') ) {
  function tnm_tag_widget_limit($args){

    //Check if taxonomy option inside widget is set to tags
    if(isset($args['taxonomy']) && $args['taxonomy'] == 'post_tag'){
      $args['number'] = 16; //Limit number of tags
      $args['smallest'] = 12; //Size of lowest count tags
      $args['largest'] = 12; //Size of largest count tags
      $args['unit'] = 'px'; //Unit of font size
      $args['orderby'] = 'count'; //Order by counts
      $args['order'] = 'DESC';
    }

    return $args;
  }
}
add_filter('widget_tag_cloud_args', 'tnm_tag_widget_limit');
?>