<?php
if (!class_exists('tnm_single')) {
    class tnm_single {
        
        static $related_query = '';
        static $samecat_query = '';
        
        static function bk_entry_media($postID){
            if(function_exists('has_post_format')){
                $postFormat = get_post_format($postID);
            }else {
                $postFormat = 'standard';
            }
            $htmlOutput = '';
            if($postFormat == 'video'){
                $bkURL = get_post_meta($postID, 'bk_video_media_link', true);
                $htmlOutput .= tnm_core::bk_get_video_media($bkURL);                
            }else if($postFormat == 'gallery'){
                $galleryType = get_post_meta($postID, 'bk_gallery_type', true);
                if($galleryType == 'gallery-1') {
                    $htmlOutput .= tnm_core::bk_get_gallery_1($postID);
                }else if($galleryType == 'gallery-2') {
                    $htmlOutput .= tnm_core::bk_get_gallery_2($postID);
                }else if($galleryType == 'gallery-3') {
                    $htmlOutput .= tnm_core::bk_get_gallery_3($postID);
                }else if($galleryType == 'gallery-4') {
                    $htmlOutput .= tnm_core::bk_get_gallery_4($postID);
                }else {
                    $htmlOutput .= tnm_core::bk_get_gallery_1($postID);
                }
            }else {
                $htmlOutput = '';
            }
            return $htmlOutput;
        }
        static function bk_author_box($authorID){
            $bk_author_email = get_the_author_meta('publicemail', $authorID);
            $bk_author_name = get_the_author_meta('display_name', $authorID);
            $bk_author_tw = get_the_author_meta('twitter', $authorID);
            $bk_author_go = get_the_author_meta('googleplus', $authorID);
            $bk_author_fb = get_the_author_meta('facebook', $authorID);
            $bk_author_yo = get_the_author_meta('youtube', $authorID);
            $bk_author_www = get_the_author_meta('url', $authorID);
            $bk_author_desc = get_the_author_meta('description', $authorID);
            $bk_author_posts = count_user_posts( $authorID ); 
    
            $authorImgALT = $bk_author_name;
            $authorArgs = array(
                'class' => 'avatar photo',
            );
            
            $htmlOutput = '';
            if (($bk_author_desc != NULL) || ($bk_author_email != NULL) || ($bk_author_www != NULL) || ($bk_author_tw != NULL) || ($bk_author_go != NULL) || ($bk_author_fb != NULL) ||($bk_author_yo != NULL)) :
                $htmlOutput .= '<div class="author-box single-entry-section">';
                $htmlOutput .= '<div class="author-box__image">';
                $htmlOutput .= '<div class="author-avatar">';
                $htmlOutput .= get_avatar($authorID, '180', '', esc_attr($authorImgALT), $authorArgs);
                $htmlOutput .= '</div>';
                $htmlOutput .= '</div>';
                $htmlOutput .= '<div class="author-box__text">';
                $htmlOutput .= '<div class="author-name meta-font">';
                $htmlOutput .= '<a href="'.get_author_posts_url($authorID).'" title="Posts by '.esc_attr($bk_author_name).'" rel="author">'.esc_attr($bk_author_name).'</a>';
                $htmlOutput .= '</div>';
                $htmlOutput .= '<div class="author-bio">';
                $htmlOutput .= $bk_author_desc;
                $htmlOutput .= '</div>';
                $htmlOutput .= '<div class="author-info">';
                $htmlOutput .= '<div class="row row--space-between row--flex row--vertical-center grid-gutter-20">';
                $htmlOutput .= '<div class="author-socials col-xs-12 col-sm-6">';
                $htmlOutput .= '<ul class="list-unstyled list-horizontal list-space-sm">';
    
                if (($bk_author_email != NULL) || ($bk_author_www != NULL) || ($bk_author_go != NULL) || ($bk_author_tw != NULL) || ($bk_author_fb != NULL) ||($bk_author_yo != NULL)) {
                    if ($bk_author_email != NULL) { $htmlOutput .= '<li><a href="mailto:'. esc_attr($bk_author_email) .'"><i class="mdicon mdicon-mail_outline"></i><span class="sr-only">e-mail</span></a></li>'; } 
                    if ($bk_author_www != NULL) { $htmlOutput .= ' <li><a href="'. esc_url($bk_author_www) .'" target="_blank"><i class="mdicon mdicon-public"></i><span class="sr-only">Website</span></a></li>'; } 
                    if ($bk_author_tw != NULL) { $htmlOutput .= ' <li><a href="'. esc_url($bk_author_tw).'" target="_blank" ><i class="mdicon mdicon-twitter"></i><span class="sr-only">Twitter</span></a></li>'; } 
                    if ($bk_author_go != NULL) { $htmlOutput .= ' <li><a href="'. esc_url($bk_author_go) .'" rel="publisher" target="_blank"><i class="mdicon mdicon-google-plus"></i><span class="sr-only">Google+</span></a></li>'; }
                    if ($bk_author_fb != NULL) { $htmlOutput .= ' <li><a href="'. esc_url($bk_author_fb) . '" target="_blank" ><i class="mdicon mdicon-facebook"></i><span class="sr-only">Facebook</span></a></li>'; }
                    if ($bk_author_yo != NULL) { $htmlOutput .= ' <li><a href="http://www.youtube.com/user/'. esc_attr($bk_author_yo) . '" target="_blank" ><span class="sr-only">Youtube</span></a></li>'; }
                }       
                                   
                $htmlOutput .= '</ul>';
                $htmlOutput .= '</div>';
                $htmlOutput .= '</div>';
                $htmlOutput .= '</div>';
                $htmlOutput .= '</div>';
                $htmlOutput .= '</div>';
            endif;
            
            return $htmlOutput;
        }
        static function bk_post_navigation($navStyle = ''){
            $next_post = get_next_post();
            $prev_post = get_previous_post();
            
            $htmlOutput = '';
            if ((!empty($prev_post)) || (!empty($next_post))):
                $htmlOutput .= '<!-- Posts navigation -->';
                $htmlOutput .= '<div class="posts-navigation single-entry-section clearfix">';
                if (!empty($prev_post)):
                    $thumbAttr = array (
                        'postID'        => $prev_post->ID,
                        'thumbSize'     => 'tnm-xs-16_9 400x225',                                
                    );
                    if($navStyle == 'wide') {
                        $thumbAttr['thumbSize'] = 'tnm-xs-16_9';
                    }
                    $theBG__URL = "url('".tnm_core::bk_get_post_thumbnail_bg_link($thumbAttr)."')";
                    
                    $htmlOutput .= '<div class="posts-navigation__prev">';
                    $htmlOutput .= '<article class="post--overlay post--overlay-bottom post--overlay-floorfade">';
                    $htmlOutput .= '<div class="background-img" style="background-image: '.$theBG__URL.';"></div>';
                    $htmlOutput .= '<div class="post__text inverse-text">';
                    $htmlOutput .= '<div class="post__text-wrap">';
                    $htmlOutput .= '<div class="post__text-inner">';
                    $htmlOutput .= '<h3 class="post__title typescale-1">'.get_the_title($prev_post->ID).'</h3>';
                    $htmlOutput .= '</div>';
                    $htmlOutput .= '</div>';
                    $htmlOutput .= '</div>';
                    $htmlOutput .= '<a href="'.get_permalink( $prev_post->ID ).'" class="link-overlay"></a>';
                    $htmlOutput .= '</article>';
                    $htmlOutput .= '<a class="posts-navigation__label" href="'.get_permalink( $prev_post->ID ).'"><span><i class="mdicon mdicon-arrow_back"></i>'.esc_html__('Previous article', 'the-next-mag').'</span></a>';
                    $htmlOutput .= '</div>';
                endif;
                if (!empty($next_post)):
                    $thumbAttr = array (
                        'postID'        => $next_post->ID,
                        'thumbSize'     => 'tnm-xs-16_9 400x225',                                
                    );
                    if($navStyle == 'wide') {
                        $thumbAttr['thumbSize'] = 'tnm-xs-16_9';
                    }
                    $theBG__URL = "url('".tnm_core::bk_get_post_thumbnail_bg_link($thumbAttr)."')";
                    
                    $htmlOutput .= '<div class="posts-navigation__next">';
                    $htmlOutput .= '<article class="post--overlay post--overlay-bottom post--overlay-floorfade">';
                    $htmlOutput .= '<div class="background-img" style="background-image: '.$theBG__URL.';"></div>';
                    $htmlOutput .= '<div class="post__text inverse-text">';
                    $htmlOutput .= '<div class="post__text-wrap">';
                    $htmlOutput .= '<div class="post__text-inner">';
                    $htmlOutput .= '<h3 class="post__title typescale-1">'.get_the_title($next_post->ID).'</h3>';
                    $htmlOutput .= '</div>';
                    $htmlOutput .= '</div>';
                    $htmlOutput .= '</div>';
                    $htmlOutput .= '<a href="'.get_permalink( $next_post->ID ).'" class="link-overlay"></a>';
                    $htmlOutput .= '</article>';
                    $htmlOutput .= '<a class="posts-navigation__label" href="'.get_permalink( $next_post->ID ).'"><span>'.esc_html__('Next article', 'the-next-mag').'<i class="mdicon mdicon-arrow_forward"></i></span></a>';
                    $htmlOutput .= '</div>';
                endif;
                $htmlOutput .= '</div>';
                $htmlOutput .= '<!-- Posts navigation -->';
            endif;
            return $htmlOutput;
        }
    /**
     * ************* Get Post Option *****************
     *---------------------------------------------------
     */
        static function bk_get_post_option($postID, $theoption = '') {
            $tnm_option = tnm_core::bk_get_global_var('tnm_option');
            $output = '';
            
            if($theoption != '') :
                $output = get_post_meta($postID, $theoption, true);
                if(($output == 'global_settings') || ($output == '')):
                    if(isset($tnm_option[$theoption])) {
                        $output = $tnm_option[$theoption];
                    }else {
                        $output = '';
                    }
                endif;
            endif;
            
            return $output;
        }
     /**
     * ************* Get Post Option *****************
     *---------------------------------------------------
     */
        static function bk_get_post_wide_option($postID, $theoption = '') {
            $tnm_option = tnm_core::bk_get_global_var('tnm_option');
            $output = '';
            
            if($theoption != '') :
                $output = get_post_meta($postID, $theoption, true);
                if(($output == 'global_settings') || ($output == '')):
                    if(isset($tnm_option[$theoption.'-wide'])) {
                        $output = $tnm_option[$theoption.'-wide'];
                    }else {
                        $output = '';
                    }
                endif;
            endif;
            
            return $output;
        }        
    /**
     * ************* Related Post *****************
     *---------------------------------------------------
     */            
        static function bk_related_post($post) {
            $postID = $post->ID;
            $tnm_option = tnm_core::bk_get_global_var('tnm_option');
            
            $excludeid = array();
            $samecat_post_ids = array();
            
            if(self::$samecat_query != '') {
                $samecat_post_ids = wp_list_pluck( self::$samecat_query->posts, 'ID' );
            }
            
            array_push($excludeid, $postID);
            
            if(count($samecat_post_ids) > 0) {
                foreach($samecat_post_ids as $samecat_post_id):
                    array_push($excludeid, $samecat_post_id);
                endforeach;
            }
            
            $bkSingleLayout = get_post_meta($postID,'bk_post_layout_standard',true);
            
            if($bkSingleLayout != 'global_settings') :
                $bkRelatedSource    =  self::bk_get_post_option($postID, 'bk_related_source');
                $bk_number_related  =  self::bk_get_post_option($postID, 'bk_number_related');
                $headingStyle       =  self::bk_get_post_option($postID, 'bk_related_heading_style');
                $postLayout         =  self::bk_get_post_option($postID, 'bk_related_post_layout');
                $cat                =  self::bk_get_post_option($postID, 'bk_related_post_category');
                $excerpt            =  self::bk_get_post_option($postID, 'bk_related_post_excerpt');
                $metaList           =  self::bk_get_post_option($postID, 'bk_related_post_meta');
                $postIcon           =  self::bk_get_post_option($postID, 'bk_related_post_icon');
            else:
                $bkRelatedSource    =  $tnm_option['bk_related_source'];
                $bk_number_related  =  $tnm_option['bk_number_related'];
                $headingStyle       =  $tnm_option['bk_related_heading_style'];
                $postLayout         =  $tnm_option['bk_related_post_layout'];
                $cat                =  $tnm_option['bk_related_post_category'];
                $excerpt            =  $tnm_option['bk_related_post_excerpt'];
                $metaList           =  $tnm_option['bk_related_post_meta'];
                $postIcon           =  $tnm_option['bk_related_post_icon'];
            endif;
            
            if (is_attachment() && ($post->post_parent)) { $postID = $post->post_parent; };
            
            $bk_tags = wp_get_post_tags($postID);
            $tag_length = sizeof($bk_tags);                               
            $bk_tag_check = $bk_all_cats = array();
            foreach ( $bk_tags as $tag_key => $bk_tag ) { $bk_tag_check[$tag_key] = $bk_tag->term_id; }    
            
            $bk_categories = get_the_category($postID);  
            $category_length = sizeof($bk_categories);
            if ($category_length > 0){       
                foreach ( $bk_categories as $category_key => $bk_category ) { $bk_all_cats[$category_key] = $bk_category->term_id; }
            }
            
            if($bkRelatedSource == 'category_tag') {
                $args = array(  
                    'posts_per_page' => intval($bk_number_related),
                    'post__not_in' => $excludeid,
                    'post_status' => 'publish',
                    'post_type' => 'post',
        			'ignore_sticky_posts' => 1,
                    'tax_query' => array(
                        'relation' => 'OR',
                        array(
                            'taxonomy' => 'category',
                            'field' => 'term_id',
                            'terms' => $bk_all_cats,
                            'include_children' => false,
                        ),
                        array(
                            'taxonomy' => 'post_tag',
                            'field' => 'term_id',
                            'terms' => $bk_tag_check,
                        )
                    )
                );
            }elseif($bkRelatedSource == 'tag') {
                $args = array(  
                    'posts_per_page' => intval($bk_number_related),
                    'tag_in' => $bk_tag_check, 
                    'post__not_in' => $excludeid,
                    'post_status' => 'publish',
                    'orderby' => 'rand',
                    'ignore_sticky_posts' => 1,
                );
            }elseif($bkRelatedSource == 'category') {
                $args = array(  
                    'posts_per_page' => intval($bk_number_related),
                    'post__not_in'   => $excludeid,
                    'post_status'    => 'publish',
                    'post_type'      => 'post',
        			'ignore_sticky_posts' => 1,
                    'category__in'        => $bk_all_cats,
                );
            }elseif($bkRelatedSource == 'author') {
                $args = array(  
                    'posts_per_page'    => intval($bk_number_related),
                    'post__not_in'      => $excludeid,
                    'post_status'       => 'publish',
                    'post_type'         => 'post',
        			'ignore_sticky_posts' => 1,
                    'author'              => $post->post_author
                );
            }
            
            $moduleInfo = array(
                'align'         => '',
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'meta'          => $metaList,
                'cat'           => $cat,
                'excerpt'       => $excerpt,
            );
            
            if(isset($headingStyle)) {
                $headingClass = tnm_core::bk_get_block_heading_class($headingStyle);
            }
            
            $the_query = new WP_Query( $args );
            
            if (empty($the_query) || ($the_query->post_count == 0)) {
                return '';
            }
            
            self::$related_query = $the_query;
            
            $bk_related_output = '';
            
            $bk_related_output .= '<div class="related-posts single-entry-section">';
            $bk_related_output .= '<div class="block-heading '.$headingClass.'">';
        	$bk_related_output .= '<h4 class="block-heading__title">'.esc_html__('You may also like', 'the-next-mag').'</h4>';
        	$bk_related_output .= '</div>';
            
            if ( $the_query != NULL ) {
                $bk_related_output .= '<div class="posts-list">';
                $bk_related_output .= self::bk_get_blog_posts($the_query, $moduleInfo, $postLayout);
                $bk_related_output .= '</div>';
            }    
            $bk_related_output .= '</div>';
            
            wp_reset_postdata();    
            return $bk_related_output;
        }
    /**
     * ************* Related Post *****************
     *---------------------------------------------------
     */            
        static function bk_related_post_wide($post) {
            $postID = $post->ID;
            $tnm_option = tnm_core::bk_get_global_var('tnm_option');
            
            $excludeid = array();
            $samecat_post_ids = array();
            
            if(self::$samecat_query != '') {
                $samecat_post_ids = wp_list_pluck( self::$samecat_query->posts, 'ID' );
            }
            
            array_push($excludeid, $postID);
            
            if(count($samecat_post_ids) > 0) {
                foreach($samecat_post_ids as $samecat_post_id):
                    array_push($excludeid, $samecat_post_id);
                endforeach;
            }
            
            $bkSingleLayout = get_post_meta($postID,'bk_post_layout_standard',true);
            
            if($bkSingleLayout != 'global_settings') :
                $bkRelatedSource    =  self::bk_get_post_option($postID, 'bk_related_source_wide');
                $headingStyle       =  self::bk_get_post_option($postID, 'bk_related_heading_style_wide');
                $postLayout         =  self::bk_get_post_option($postID, 'bk_related_post_layout_wide');
                $postIcon           =  self::bk_get_post_option($postID, 'bk_related_post_icon_wide');
            else:
                $bkRelatedSource    =  $tnm_option['bk_related_source_wide'];
                $headingStyle       =  $tnm_option['bk_related_heading_style_wide'];
                $postLayout         =  $tnm_option['bk_related_post_layout_wide'];
                $postIcon           =  $tnm_option['bk_related_post_icon_wide'];
            endif;
            
            $postEntries        = 3;
            if (is_attachment() && ($post->post_parent)) { $postID = $post->post_parent; };
            
            $bk_tags = wp_get_post_tags($postID);
            $tag_length = sizeof($bk_tags);                               
            $bk_tag_check = $bk_all_cats = array();
            foreach ( $bk_tags as $tag_key => $bk_tag ) { $bk_tag_check[$tag_key] = $bk_tag->term_id; }    
            
            $bk_categories = get_the_category($postID);  
            $category_length = sizeof($bk_categories);
            if ($category_length > 0){       
                foreach ( $bk_categories as $category_key => $bk_category ) { $bk_all_cats[$category_key] = $bk_category->term_id; }
            }
            
            switch($postLayout){
                case 'listing_grid_no_sidebar':
                    $postEntries = 6;
                    break;
                case 'posts_block_j':
                    $postEntries = 6;
                    break;
                case 'posts_block_b':
                    $postEntries = 6;
                    break;
                case 'posts_block_c':
                    $postEntries = 4;
                    break;
                case 'posts_block_d':
                    $postEntries = 4;
                    break;
                case 'posts_block_e':
                    $postEntries = 3;
                    break;
                case 'posts_block_i':
                    $postEntries = 5;
                    break;
                case 'mosaic_a':
                    $postEntries = 5;
                    break;
                case 'mosaic_b':
                    $postEntries = 4;
                    break;
                case 'mosaic_c':
                    $postEntries = 3;
                    break;
                case 'featured_block_c':
                    $postEntries = 5;
                    break;
                case 'featured_block_e':
                    $postEntries = 5;
                    break;
                case 'featured_block_f':
                    $postEntries = 5;
                    break;
                default:
                    $postEntries = 3;
                    break;
            }
            if($bkRelatedSource == 'category_tag') {
                $args = array(  
                    'posts_per_page' => intval($postEntries),
                    'post__not_in' => $excludeid,
                    'post_status' => 'publish',
                    'post_type' => 'post',
        			'ignore_sticky_posts' => 1,
                    'tax_query' => array(
                        'relation' => 'OR',
                        array(
                            'taxonomy' => 'category',
                            'field' => 'term_id',
                            'terms' => $bk_all_cats,
                            'include_children' => false,
                        ),
                        array(
                            'taxonomy' => 'post_tag',
                            'field' => 'term_id',
                            'terms' => $bk_tag_check,
                        )
                    )
                );
            }elseif($bkRelatedSource == 'tag') {
                $args = array(  
                    'posts_per_page' => intval($postEntries),
                    'tag_in' => $bk_tag_check, 
                    'post__not_in' => $excludeid,
                    'post_status' => 'publish',
                    'orderby' => 'rand',
                    'ignore_sticky_posts' => 1,
                );
            }elseif($bkRelatedSource == 'category') {
                $args = array(  
                    'posts_per_page' => intval($postEntries),
                    'post__not_in'   => $excludeid,
                    'post_status'    => 'publish',
                    'post_type'      => 'post',
        			'ignore_sticky_posts' => 1,
                    'category__in'        => $bk_all_cats,
                );
            }elseif($bkRelatedSource == 'author') {
                $args = array(  
                    'posts_per_page'    => intval($postEntries),
                    'post__not_in'      => $excludeid,
                    'post_status'       => 'publish',
                    'post_type'         => 'post',
        			'ignore_sticky_posts' => 1,
                    'author'              => $post->post_author
                );
            }
            $moduleInfo = array(
                'align'         => '',
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => '',
                'meta'          => '',
                'cat'           => '',
                'excerpt'       => '',
            );
            
            if(isset($headingStyle)) {
                $headingClass = tnm_core::bk_get_block_heading_class($headingStyle);
            }
            
            $the_query = new WP_Query( $args );
            
            if (empty($the_query) || ($the_query->post_count == 0)) {
                return '';
            }
            
            self::$related_query = $the_query;
            
            $bk_related_output = '';
            
            $bk_related_output .= '<div class="mnmd-block mnmd-block--fullwidth related-posts has-background lightgray-bg">';
            $bk_related_output .= '<div class="container">';
            $bk_related_output .= '<div class="block-heading '.$headingClass.'">';
        	$bk_related_output .= '<h4 class="block-heading__title">'.esc_html__('You may also like', 'the-next-mag').'</h4>';
            $bk_related_output .= '</div>';
            
            if ( $the_query != NULL ) {
                $bk_related_output .= self::bk_get_blog_posts($the_query, $moduleInfo, $postLayout);
            }    
            $bk_related_output .= '</div><!--.container-->';
            $bk_related_output .= '</div>';
            
            wp_reset_postdata();    
            return $bk_related_output;
        }
        static function bk_same_category_posts($post) {
            $postID = $post->ID;
            $excludeid = array();
            $related_post_ids = array();
            
            if(self::$related_query != ''):
                $related_post_ids = wp_list_pluck( self::$related_query->posts, 'ID' );
            endif;
            
            array_push($excludeid, $postID);
            
            if(count($related_post_ids) > 0) {
                foreach($related_post_ids as $related_post_id):
                    array_push($excludeid, $related_post_id);
                endforeach;
            }
            
            $catID       = self::bk_get_post_option($postID, 'bk_same_cat_id');
            if($catID == '') {
                $catID = 'current_cat';
            }
            if($catID == 'disable') {
                return '';
            }
            if($catID == 'current_cat') {
                $category = get_the_category($postID); 
                if(isset($category[0]) && $category[0]){
                    $catID = $category[0]->term_id;  
                }
                else {
                    return '';
                }
            }      
            
            $tnm_option = tnm_core::bk_get_global_var('tnm_option');
            $bkSingleLayout = get_post_meta($postID,'bk_post_layout_standard',true);
            
            if($bkSingleLayout != 'global_settings') :
                $headingStyle       =  self::bk_get_post_option($postID, 'bk_same_cat_heading_style');    
                $postLayout         =  self::bk_get_post_option($postID, 'bk_same_cat_post_layout');
                $postEntries        =  self::bk_get_post_option($postID, 'bk_same_cat_number_posts');            
                $cat                =  self::bk_get_post_option($postID, 'bk_same_cat_post_category');
                $excerpt            =  self::bk_get_post_option($postID, 'bk_same_cat_post_excerpt');
                $metaList           =  self::bk_get_post_option($postID, 'bk_same_cat_post_meta');
                $postIcon           =  self::bk_get_post_option($postID, 'bk_same_cat_post_icon');
                $moreLink           =  self::bk_get_post_option($postID, 'bk_same_cat_more_link');
            else:
                $headingStyle       =  $tnm_option['bk_same_cat_heading_style'];    
                $postLayout         =  $tnm_option['bk_same_cat_post_layout'];
                $postEntries        =  $tnm_option['bk_same_cat_number_posts'];            
                $cat                =  $tnm_option['bk_same_cat_post_category'];
                $excerpt            =  $tnm_option['bk_same_cat_post_excerpt'];
                $metaList           =  $tnm_option['bk_same_cat_post_meta'];
                $postIcon           =  $tnm_option['bk_same_cat_post_icon'];
                $moreLink           =  $tnm_option['bk_same_cat_more_link'];
            endif;
            
            if(isset($headingStyle)) {
                $headingClass = tnm_core::bk_get_block_heading_class($headingStyle);
            }
            
            $bk_all_cats = array();
            $bk_categories = get_the_category($postID);  
            $category_length = sizeof($bk_categories);
            if ($category_length > 0){       
                foreach ( $bk_categories as $category_key => $bk_category ) { $bk_all_cats[$category_key] = $bk_category->term_id; }
            }
            
            $moduleInfo = array(
                'align'         => '',
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'meta'          => $metaList,
                'cat'           => $cat,
                'excerpt'       => $excerpt,
            );
                        
            $args = array(  
                'posts_per_page' => $postEntries,
                'post__not_in'   => $excludeid,
                'post_status'    => 'publish',
                'post_type'      => 'post',
    			'ignore_sticky_posts' => 1,
                'category__in'        => $catID,
            );
            
            $the_query = new WP_Query( $args );
            
            self::$samecat_query = $the_query;
            
            if (empty($the_query) || ($the_query->post_count == 0)) {
                return '';
            }
            
            $dataOutput = '';
            $dataOutput .= '<div class="same-category-posts single-entry-section">';
            $dataOutput .= '<div class="block-heading '.$headingClass.'">';
        	$dataOutput .= '<h4 class="block-heading__title">'.esc_html__('More in', 'the-next-mag').' <a href="'.get_category_link($catID).'" class="cat-'.$catID.' cat-theme">'. get_cat_name($catID).'</a></h4>';
        	$dataOutput .= '</div>';
            
            $dataOutput .= '<div class="posts-list">';
            $dataOutput .= self::bk_get_blog_posts($the_query, $moduleInfo, $postLayout);
            $dataOutput .= '</div>';
            
            if($moreLink == 1) {
                $dataOutput .= '<nav class="mnmd-pagination text-center">';
            	$dataOutput .= '<a href="'.get_category_link($catID).'" class="btn btn-default">'.esc_html__('View all ', 'the-next-mag'). get_cat_name($catID).'<i class="mdicon mdicon-arrow_forward mdicon--last"></i></a>';
            	$dataOutput .= '</nav>';
            }
            
            $dataOutput .= '</div>';
            
            wp_reset_postdata();    
            return $dataOutput;
        }
        static function bk_same_category_posts_wide($post) {
            $postID = $post->ID;
            $excludeid = array();
            
            $related_post_ids = array();
            
            if(self::$related_query != ''):
                $related_post_ids = wp_list_pluck( self::$related_query->posts, 'ID' );
            endif;
            
            array_push($excludeid, $postID);
            
            if(count($related_post_ids) > 0) {
                foreach($related_post_ids as $related_post_id):
                    array_push($excludeid, $related_post_id);
                endforeach;
            }
            
            $catID              = self::bk_get_post_option($postID, 'bk_same_cat_id_wide');
            
            if($catID == '') {
                $catID = 'current_cat';
            }
            if($catID == 'disable') {
                return '';
            }
            if($catID == 'current_cat') {
                $category = get_the_category($postID); 
                if(isset($category[0]) && $category[0]){
                    $catID = $category[0]->term_id;  
                }
                else {
                    return '';
                }
            }      
            
            $tnm_option = tnm_core::bk_get_global_var('tnm_option');
            $bkSingleLayout = get_post_meta($postID,'bk_post_layout_standard',true);
            
            if($bkSingleLayout != 'global_settings') :
                $headingStyle       =  self::bk_get_post_option($postID, 'bk_same_cat_heading_style_wide');    
                $postLayout         =  self::bk_get_post_option($postID, 'bk_same_cat_post_layout_wide');
                $postEntries        =  3;
                $postIcon           =  self::bk_get_post_option($postID, 'bk_same_cat_post_icon_wide');
                $moreLink           =  self::bk_get_post_option($postID, 'bk_same_cat_more_link_wide');
            else:
                $headingStyle       =  $tnm_option['bk_same_cat_heading_style_wide'];    
                $postLayout         =  $tnm_option['bk_same_cat_post_layout_wide'];
                $postEntries        =  3;
                $postIcon           =  $tnm_option['bk_same_cat_post_icon_wide'];
                $moreLink           =  $tnm_option['bk_same_cat_more_link_wide'];
            endif;
            
            if(isset($headingStyle)) {
                $headingClass = tnm_core::bk_get_block_heading_class($headingStyle);
            }
            
            $bk_all_cats = array();
            $bk_categories = get_the_category($postID);  
            $category_length = sizeof($bk_categories);
            if ($category_length > 0){       
                foreach ( $bk_categories as $category_key => $bk_category ) { $bk_all_cats[$category_key] = $bk_category->term_id; }
            }
            
            $moduleInfo = array(
                'align'         => '',
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => '',
                'meta'          => '',
                'cat'           => '',
                'excerpt'       => '',
            );
            
            switch($postLayout){
                case 'listing_grid_no_sidebar':
                    $postEntries = 6;
                    break;
                case 'posts_block_j':
                    $postEntries = 6;
                    break;
                case 'posts_block_b':
                    $postEntries = 6;
                    break;
                case 'posts_block_c':
                    $postEntries = 4;
                    break;
                case 'posts_block_d':
                    $postEntries = 4;
                    break;
                case 'posts_block_e':
                    $postEntries = 3;
                    break;
                case 'posts_block_i':
                    $postEntries = 5;
                    break;
                case 'mosaic_a':
                    $postEntries = 5;
                    break;
                case 'mosaic_b':
                    $postEntries = 4;
                    break;
                case 'mosaic_c':
                    $postEntries = 3;
                    break;
                case 'featured_block_c':
                    $postEntries = 5;
                    break;
                case 'featured_block_e':
                    $postEntries = 5;
                    break;
                case 'featured_block_f':
                    $postEntries = 5;
                    break;
                default:
                    $postEntries = 3;
                    break;
            }
                
            $args = array(  
                'posts_per_page' => $postEntries,
                'post__not_in'   => $excludeid,
                'post_status'    => 'publish',
                'post_type'      => 'post',
    			'ignore_sticky_posts' => 1,
                'category__in'        => $catID,
            );

            $the_query = new WP_Query( $args );
            
            self::$samecat_query = $the_query;
            
            if (empty($the_query) || ($the_query->post_count == 0)) {
                return '';
            }
            
            $dataOutput = '';
            $dataOutput .= '<div class="mnmd-block mnmd-block--fullwidth related-posts has-background lightgray-bg">';
            $dataOutput .= '<div class="container">';
            $dataOutput .= '<div class="block-heading '.$headingClass.'">';
        	$dataOutput .= '<h4 class="block-heading__title">'.esc_html__('More in', 'the-next-mag').' <a href="'.get_category_link($catID).'" class="cat-'.$catID.' cat-theme">'. get_cat_name($catID).'</a></h4>';
        	$dataOutput .= '</div>';
            
            $dataOutput .= self::bk_get_blog_posts($the_query, $moduleInfo, $postLayout);
            
            if($moreLink == 1) {
                $dataOutput .= '<nav class="mnmd-pagination text-center">';
            	$dataOutput .= '<a href="'.get_category_link($catID).'" class="btn btn-default">'.esc_html__('View all ', 'the-next-mag'). get_cat_name($catID).'<i class="mdicon mdicon-arrow_forward mdicon--last"></i></a>';
            	$dataOutput .= '</nav>';
            }
            
            $dataOutput .= '</div><!--.container-->';
            $dataOutput .= '</div>';
            
            wp_reset_postdata();    
            return $dataOutput;
        }
        /**
         * ************* Post Share *****************
         *---------------------------------------------------
         */   
        static function bk_entry_interaction_share($postID) {
            $tnm_option = tnm_core::bk_get_global_var('tnm_option');
            $htmlOutput = '';
            $titleget = get_the_title($postID);
            $bk_url = get_permalink($postID);
            $fb_oc = "window.open('http://www.facebook.com/sharer.php?u=".urlencode(get_permalink())."','Facebook','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;";
            $tw_oc = "window.open('http://twitter.com/share?url=".urlencode(get_permalink())."&amp;text=".str_replace(" ", "%20", $titleget)."','Twitter share','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;";
            $gp_oc = "window.open('https://plus.google.com/share?url=".urlencode(get_permalink())."','Google plus','width=585,height=666,left='+(screen.availWidth/2-292)+',top='+(screen.availHeight/2-333)+''); return false;";
            $li_oc = "window.open('http://www.linkedin.com/shareArticle?mini=true&amp;url=".urlencode(get_permalink())."','Linkedin','width=863,height=500,left='+(screen.availWidth/2-431)+',top='+(screen.availHeight/2-250)+''); return false;";
            
            $share_box = $tnm_option['bk-sharebox-sw'];
            if ($share_box){
                $social_share['fb'] = $tnm_option['bk-fb-sw'];
                $social_share['tw'] = $tnm_option['bk-tw-sw'];
                $social_share['gp'] = $tnm_option['bk-gp-sw'];
                $social_share['pi'] = $tnm_option['bk-pi-sw'];
                $social_share['li'] = $tnm_option['bk-li-sw'];
                
                $social_share['fb_text'] = $tnm_option['bk-fb-text'];
                $social_share['tw_text'] = $tnm_option['bk-tw-text'];
                $social_share['gp_text'] = $tnm_option['bk-gp-text'];
                $social_share['pi_text'] = $tnm_option['bk-pi-text'];
                $social_share['li_text'] = $tnm_option['bk-li-text'];
                
                $fbText = $twText = $gpText = $piText = $stuText = $liText = '';
                
                if($social_share['fb_text'] != '') {
                    $fbText = '<span class="sharing-btn__text">'.esc_attr($social_share['fb_text']).'</span>';
                }
                if($social_share['tw_text'] != '') {
                    $twText = '<span class="sharing-btn__text">'.esc_attr($social_share['tw_text']).'</span>';
                }
                if($social_share['gp_text'] != '') {
                    $gpText = '<span class="sharing-btn__text">'.esc_attr($social_share['gp_text']).'</span>';
                }
                if($social_share['pi_text'] != '') {
                    $piText = '<span class="sharing-btn__text">'.esc_attr($social_share['pi_text']).'</span>';
                }
                if($social_share['li_text'] != '') {
                    $liText = '<span class="sharing-btn__text">'.esc_attr($social_share['li_text']).'</span>';
                }
            }
    
            if ($social_share['fb']):
                $htmlOutput .= '<li><a class="sharing-btn sharing-btn-primary facebook-btn facebook-theme-bg" data-toggle="tooltip" data-placement="top" title="'.esc_attr__('Share on Facebook', 'the-next-mag').'" onClick="'.$fb_oc.'" href="http://www.facebook.com/sharer.php?u='.urlencode($bk_url).'"><i class="mdicon mdicon-facebook"></i>'.$fbText.'</a></li>';
            endif;
            if ($social_share['tw']):
                $htmlOutput .= '<li><a class="sharing-btn sharing-btn-primary twitter-btn twitter-theme-bg" data-toggle="tooltip" data-placement="top" title="'.esc_attr__('Share on Twitter', 'the-next-mag').'" onClick="'.$tw_oc.'" href="http://twitter.com/share?url='.urlencode(get_permalink()).'&amp;text='.str_replace(" ", "%20", $titleget).'"><i class="mdicon mdicon-twitter"></i>'.$twText.'</a></li>';
            endif;
            if ($social_share['gp']):
                $htmlOutput .= '<li><a class="sharing-btn googleplus-btn googleplus-theme-bg" data-toggle="tooltip" data-placement="top" title="'.esc_attr__('Share on Google+', 'the-next-mag').'" onClick="'.$gp_oc.'" href="https://plus.google.com/share?url='.urlencode($bk_url).'"><i class="mdicon mdicon-google-plus"></i>'.$gpText.'</a></li>';
            endif;
            if ($social_share['pi']):
                $htmlOutput .= '<li><a class="sharing-btn pinterest-btn pinterest-theme-bg" data-toggle="tooltip" data-placement="top" title="'.esc_attr__('Share on Pinterest', 'the-next-mag').'" href="javascript:void((function()%7Bvar%20e=document.createElement(&apos;script&apos;);e.setAttribute(&apos;type&apos;,&apos;text/javascript&apos;);e.setAttribute(&apos;charset&apos;,&apos;UTF-8&apos;);e.setAttribute(&apos;src&apos;,&apos;http://assets.pinterest.com/js/pinmarklet.js?r=&apos;+Math.random()*99999999);document.body.appendChild(e)%7D)());"><i class="mdicon mdicon-pinterest-p"></i>'.$piText.'</a></li>';
            endif;
            if ($social_share['li']):
                $htmlOutput .= '<li><a class="sharing-btn linkedin-btn linkedin-theme-bg" data-toggle="tooltip" data-placement="top" title="'.esc_attr__('Share on Linkedin', 'the-next-mag').'" onClick="'.$li_oc.'" href="http://www.linkedin.com/shareArticle?mini=true&amp;url='.urlencode($bk_url).'"><i class="mdicon mdicon-linkedin"></i>'.$liText.'</a></li>';
            endif;
            
            return $htmlOutput;
        }
        /**
         * ************* Post Share *****************
         *---------------------------------------------------
         */   
        static function bk_entry_interaction_comments($postID) {
            $htmlOutput = '<a href="#comments" class="comments-count entry-action-btn" data-toggle="tooltip" data-placement="top" title="'.get_comments_number($postID).' '.esc_attr__('Comments', 'the-next-mag').'"><i class="mdicon mdicon-chat_bubble"></i><span>'.get_comments_number($postID).'</span></a>';
            return $htmlOutput;
        }
        static function bk_get_blog_posts($the_query, $moduleInfo, $postLayout = 'listing_list') {
            $dataOutput = '';
            if ( $the_query->have_posts() ) :
                switch($postLayout){
                    case 'listing_list':
                        $sectionHTML = new tnm_posts_listing_list;
                        $dataOutput .= '<div class="posts-list list-space-xl">';
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo);            //render modules
                        $dataOutput .= '</div>';
                        break;
                    case 'listing_list_alt_a':
                        $sectionHTML = new tnm_posts_listing_list_alt_a;
                        $dataOutput .= '<div class="posts-list list-space-xl">';
                        $dataOutput .= $sectionHTML->render_modules($the_query, 0, $moduleInfo);            //render modules
                        $dataOutput .= '</div>';
                        break;
                    case 'listing_grid':
                        $sectionHTML = new tnm_posts_listing_grid;
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo);            //render modules
                        break;
                    case 'listing_grid_no_sidebar':
                        $sectionHTML = new tnm_posts_listing_grid_no_sidebar;
                        $moduleInfo_Array = array(
                            'post_source'   => 'all',
                            'post_icon'     => $moduleInfo['post_icon'],
                            'iconPosition'  => 'center',
                            'meta'          => 2, //array('author', 'date'),
                            'cat'           => 1,
                            'excerpt'       => '',
                            'align'         => '',
                        );
                        $dataOutput .= '<div class="row row--space-between posts-list">';
                        $dataOutput .= $sectionHTML->render_modules($the_query, 0, $moduleInfo_Array);            //render modules
                        $dataOutput .= '</div>';
                        break;
                    case 'listing_grid_small':
                        $sectionHTML = new tnm_posts_listing_grid_small;
                        $dataOutput .= '<div class="row row--space-between posts-list">';
                        $dataOutput .= $sectionHTML->render_modules($the_query, 0, $moduleInfo);            //render modules
                        $dataOutput .= '</div>';
                        break;
                    case 'posts_block_main_col_l':
                        $sectionHTML = new tnm_posts_block_main_col_l;
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo);            //render modules
                        break;
                    case 'posts_block_b':
                        $sectionHTML = new tnm_posts_block_b;
                        $moduleInfo_Array = array(
                            'post_source'   => 'all',
                            'post_icon'     => $moduleInfo['post_icon'],
                            'iconPosition_L'  => 'top-right',
                            'iconPosition_S'  => 'top-right',
                            'meta_L'          => 1, // Author
                            'meta_S'          => 8, // Date
                            'cat_L'           => 1, //Top-Left 
                            'cat_S'           => 1, //Top-Left 
                            'textAlign'     => '',
                            'footerStyle'   => '1-col',
                        );
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo_Array);            //render modules
                        break;
                    case 'posts_block_c':
                        $sectionHTML = new tnm_posts_block_c;
                        $moduleInfo_Array = array(
                            'post_source'   => 'all',
                            'post_icon'     => $moduleInfo['post_icon'],
                            'iconPosition'  => 'center',
                            'meta'          => 9, //array('date', 'comment'),
                            'cat'           => 2, //Overlap
                            'footerStyle'   => '1-col'
                        );   
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo_Array);            //render modules
                        break;
                    case 'posts_block_d':
                        $sectionHTML = new tnm_posts_block_d;
                        $moduleInfo_Array = array(
                            'post_source'   => 'all',
                            'post_icon'     => $moduleInfo['post_icon'],
                            'iconPosition'  => 'center',
                            'meta'          => 9, //array('date', 'comment'),
                            'cat'           => 2, //Overlap
                            'textAlign'     => 'text-center',
                            'footerStyle'   => '1-col'
                        );   
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo_Array);            //render modules
                        break;
                    case 'posts_block_e':
                        $sectionHTML = new tnm_posts_block_e;
                        $moduleInfo_Array = array(
                            'post_source'   => 'all',
                            'post_icon'     => $moduleInfo['post_icon'],
                            'iconPosition_L'  => 'top-right',
                            'iconPosition_S'  => 'top-right',
                            'meta_L'          => 2, //array('author', 'date'),
                            'meta_S'          => 8, //array('date'),
                            'cat_L'           => 1, //Top-Left 
                            'cat_S'           => '', //Top-Left 
                            'excerpt_L'       => '',
                            'textAlign'     => '',
                            'footerStyle'   => '1-col',
                        );
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo_Array);            //render modules
                        break;
                    case 'posts_block_i':
                        $sectionHTML = new tnm_posts_block_i;
                        $moduleInfo_Array = array(
                            'post_source'   => 'all',
                            'post_icon'     => $moduleInfo['post_icon'],
                            'iconPosition_L'  => 'top-right',
                            'iconPosition_S'  => 'top-right',
                            'meta_L'          => 2, //array('author', 'date'),
                            'meta_S'          => 8, //array('date'),
                            'cat_L'           => 1, //Top-Left 
                            'cat_S'           => 1, //Top-Left 
                            'excerpt_L'       => '',
                            'footerStyle'   => '1-col',
                        );
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo_Array);            //render modules
                        break;
                    case 'posts_block_j':
                        $sectionHTML = new tnm_posts_block_j;
                        $moduleInfo_Array = array(
                            'post_source'   => 'all',
                            'post_icon'     => $moduleInfo['post_icon'],
                            'iconPosition_L'  => 'top-right',
                            'iconPosition_S'  => 'top-right',
                            'meta_L'          => 1, // Author
                            'meta_S'          => 8, // Date
                            'cat_L'           => 1, //Top-Left 
                            'cat_S'           => '', //Top-Left 
                            'excerpt_L'       => '',
                            'textAlign'     => '',
                            'footerStyle'   => '1-col',
                        );
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo_Array);            //render modules
                        break;
                    case 'mosaic_a':
                        $sectionHTML = new tnm_mosaic_a;
                        $moduleInfo_Array = array(
                            'post_source'   => 'all',
                            'post_icon'     => $moduleInfo['post_icon'],
                            'iconPosition_L'  => 'top-right',
                            'iconPosition_S'  => 'top-right',
                            'meta_L'          => 2, // Author
                            'meta_S'          => 8, // Date
                            'cat_L'           => 1, //Top-Left 
                            'cat_S'           => '', //Top-Left 
                            'excerpt_L'       => '',
                            'textAlign'     => '',
                            'footerStyle'   => '1-col',
                        );
                        $dataOutput .= '<div class="mnmd-mosaic mnmd-mosaic--gutter-10">';
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo_Array);            //render modules
                        $dataOutput .= '</div>';
                        break;
                    case 'mosaic_b':
                        $sectionHTML = new tnm_mosaic_b;
                        $moduleInfo_Array = array(
                            'post_source'   => 'all',
                            'post_icon'     => $moduleInfo['post_icon'],
                            'iconPosition_L'  => 'top-right',
                            'iconPosition_S'  => 'top-right',
                            'meta_L'          => 2, // Author
                            'meta_S'          => 8, // Date
                            'cat_L'           => 1, //Top-Left 
                            'cat_S'           => '', //Top-Left 
                            'excerpt_L'       => '',
                            'textAlign'     => '',
                            'footerStyle'   => '1-col',
                        );
                        $dataOutput .= '<div class="mnmd-mosaic mnmd-mosaic--gutter-10">';
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo_Array);            //render modules
                        $dataOutput .= '</div>';
                        break;
                    case 'mosaic_c':
                        $sectionHTML = new tnm_mosaic_c;
                        $moduleInfo_Array = array(
                            'post_source'   => 'all',
                            'post_icon'     => $moduleInfo['post_icon'],
                            'iconPosition_L'  => 'top-right',
                            'iconPosition_S'  => 'top-right',
                            'meta_L'          => 2, // Author
                            'meta_S'          => 8, // Date
                            'cat_L'           => 1, //Top-Left 
                            'cat_S'           => '', //Top-Left 
                            'excerpt_L'       => '',
                            'textAlign'     => '',
                            'footerStyle'   => '1-col',
                        );
                        $dataOutput .= '<div class="mnmd-mosaic mnmd-mosaic--gutter-10">';
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo_Array);            //render modules
                        $dataOutput .= '</div>';
                        break;
                    case 'featured_block_c':
                        $sectionHTML = new tnm_featured_block_c;
                        $moduleInfo_Array = array(
                            'post_source'   => 'all',
                            'post_icon'     => $moduleInfo['post_icon'],
                            'iconPosition_L'  => 'top-right',
                            'iconPosition_S'  => 'top-right',
                            'meta'            => 3, // Author
                            'cat_L'           => 1, //Top-Left 
                            'cat_S'           => '', //Top-Left 
                            'excerpt_L'       => '',
                            'footerStyle'   => '2-cols-border',
                        );
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo_Array);            //render modules
                        break;
                    case 'featured_block_e':
                        $sectionHTML = new tnm_featured_block_e;
                        $moduleInfo_Array = array(
                            'post_source'   => 'all',
                            'post_icon'     => $moduleInfo['post_icon'],
                            'iconPosition_L'  => 'center',
                            'iconPosition_S'  => 'center',
                            'meta_L'          => 2, // Author
                            'meta_S'          => 8, // Date
                            'cat_L'           => 1, //Top-Left 
                            'cat_S'           => 1, //Top-Left 
                            'excerpt_L'       => '',
                            'textAlign'     => '',
                        );
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo_Array);            //render modules
                        break;
                    case 'featured_block_f':
                        $sectionHTML = new tnm_featured_block_f;
                        $moduleInfo_Array = array(
                            'post_source'   => 'all',
                            'post_icon'     => $moduleInfo['post_icon'],
                            'iconPosition_L'  => 'center',
                            'iconPosition_S'  => 'center',
                            'meta_L'          => 2, // Author
                            'meta_S'          => 8, // Date
                            'cat_L'           => 1, //Top-Left 
                            'cat_S'           => 1, //Top-Left 
                            'excerpt_L'       => '',
                            'textAlign'     => '',
                        );
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo_Array);            //render modules
                        break;
                    default:
                        $sectionHTML = new tnm_posts_listing_list;
                        $dataOutput .= $sectionHTML->render_modules($the_query, $moduleInfo);            //render modules
                        break;
                }
            endif;
            
            return $dataOutput;
        }
        static function bk_post_pagination(){
            global $page, $pages;
            if(count($pages) > 1):
            ?>
            <nav class="mnmd-pagination mnmd-pagination--next-n-prev">
				<div class="mnmd-pagination__inner">
					<div class="mnmd-pagination__label"><?php esc_html_e('Page ', 'the-next-mag'); echo( esc_html($page).' of '.count($pages) );?></div>
					<div class="mnmd-pagination__links <?php if($page == count($pages)){echo ('mnmd-pagination-last-page-link');}?>">
                        <?php
                            wp_link_pages( array( 
                                'before' => '', 
                                'after' => '', 
                                'previouspagelink' => esc_html__('Previous', 'the-next-mag'), 
                                'nextpagelink' => esc_html__('Next', 'the-next-mag'), 
                                'next_or_number' => 'next',   
                                'link_before' => '<span class="mnmd-pagination__item">',
	                            'link_after' => '</span>',                                                                                           
                            ) ); 
                        ?>                                                                                                                                                                                                       
					</div>
				</div>
			</nav>
            <?php
            endif;
        }
        
    /**
     * ************* Review Box *****************
     *---------------------------------------------------
     */   
        static function bk_post_review_box_default($postID){
            
            $reviewCheck = get_post_meta($postID,'bk_review_checkbox',true);
            if($reviewCheck != 1) :
                return '';
            endif;
            
            $dataOutput = '';
            $productMediaLeft = '';
            $productMediaBody = '';
            
            $reviewScore = get_post_meta($postID,'bk_review_score',true);
            $the_pros_cons = get_post_meta($postID,'bk_pros_cons',true);
            
            
            $dataOutput .= '<div class="mnmd-review">';
            $dataOutput .= '<div class="mnmd-review__inner">';
            
            $dataOutput .= '<div class="mnmd-review__top">';        
            $dataOutput .= self::bk_post_review_media($postID);            
            $dataOutput .= self::bk_post_review_overall_score($postID);
            $dataOutput .= '</div><!--mnmd-review__top-->';
            
            $dataOutput .= self::bk_post_review_summary($postID);
            
            if($the_pros_cons == 1) :
                $dataOutput .= self::bk_post_review_pros_cons($postID);
            endif;
            
            $dataOutput .= '</div><!--mnmd-review__inner-->';
            $dataOutput .= '</div>';
            
            return $dataOutput;
        }
        static function bk_post_review_box_aside($postID, $position){
            global $page, $pages;
            
            $reviewCheck = get_post_meta($postID,'bk_review_checkbox',true);
            if($reviewCheck != 1) :
                return '';
            endif;
            
            if($page > 1) {
                return '';
            }
            $dataOutput = '';
            $productMediaLeft = '';
            $productMediaBody = '';
            
            $the_pros_cons = get_post_meta($postID,'bk_pros_cons',true);
            
            if($position == 'aside-left') {
                $dataOutput .= '<div class="mnmd-review mnmd-review--aside alignleft">';
            }else {
                $dataOutput .= '<div class="mnmd-review mnmd-review--aside alignright">';
            }
            $dataOutput .= '<div class="mnmd-review__inner">';
            
            $dataOutput .= self::bk_post_review_overall_score($postID);
            $dataOutput .= self::bk_post_review_media($postID, $position);            
            
            $dataOutput .= self::bk_post_review_summary($postID);
            
            if($the_pros_cons == 1) :
                $dataOutput .= self::bk_post_review_pros_cons_aside($postID);
            endif;
            
            $dataOutput .= '</div><!--mnmd-review__inner-->';
            $dataOutput .= '</div>';
            
            return $dataOutput;
        }
        static function bk_post_review_summary($postID){
            $summaryText = get_post_meta($postID,'bk_review_summary',true);
            
            $reviewSummary = '';
            $reviewSummary .= '<div class="mnmd-review__summary">';
            $reviewSummary .= '<p>';
            $reviewSummary .= $summaryText;
            $reviewSummary .= '</p>';
            $reviewSummary .= '</div><!--mnmd-review__summary-->';
            
            return $reviewSummary;
        }
        static function bk_post_review_media($postID, $position = 'default'){
            $boxTitle = get_post_meta($postID,'bk_review_box_title',true);
            $boxSubTitle = get_post_meta($postID,'bk_review_box_sub_title',true);
            
            $productMedia = '';
            $productMedia .= '<div class="mnmd-review__product media">';
            $imageID = get_post_meta( $postID, 'bk_review_product_img', false );
            if((tnm_core::bk_check_array($imageID)) && ($imageID[0] != '')) {
                $productIMGURL = wp_get_attachment_image_src( $imageID[0], 'tnm-xxs-1_1' );
            }else {
                $productIMGURL = '';
            }
            if (!empty($productIMGURL) && ($productIMGURL[0] != NULL)) {
                $productMedia .= '<div class="media-left media-middle">';
                $productMedia .= '<div class="mnmd-review__product-image"><img src="'.$productIMGURL[0].'" alt="'.esc_attr__('product-image', 'the-next-mag').'"></div>';
                $productMedia .= '</div>';
            }
            
            if($position == 'default') {
                $titleTypeScale = 'typescale-2';
            }else {
                $titleTypeScale = 'typescale-1';
            }
            $productMedia .= '<div class="media-body media-middle">';
            $productMedia .= '<h3 class="mnmd-review__product-name '.$titleTypeScale.'">'.$boxTitle.'</h3>';
            $productMedia .= '<span class="mnmd-review__product-byline">'.$boxSubTitle.'</span>';
            $productMedia .= '</div>';
            $productMedia .= '</div><!--mnmd-review__product media-->';
            
            return $productMedia;
        }
        static function bk_post_review_overall_score($postID){
            $reviewScore = get_post_meta($postID,'bk_review_score',true);
            
            $scoreBox = '';
            $scoreBox .= '<div class="mnmd-review__overall-score">';
            $scoreBox .= '<div class="post-score-hexagon post-score-hexagon--xl">';
            $scoreBox .= '<svg class="hexagon-svg" version="1.1" xmlns="http://www.w3.org/2000/svg" viewbox="-5 -5 184 210">';
            $scoreBox .= '<g>';
            $scoreBox .= '<path fill="#FC3C2D" stroke="#fff" stroke-width="10px" d="M81.40638795573723 2.9999999999999996Q86.60254037844386 0 91.7986928011505 2.9999999999999996L168.0089283341811 47Q173.20508075688772 50 173.20508075688772 56L173.20508075688772 144Q173.20508075688772 150 168.0089283341811 153L91.7986928011505 197Q86.60254037844386 200 81.40638795573723 197L5.196152422706632 153Q0 150 0 144L0 56Q0 50 5.196152422706632 47Z"></path>';
            $scoreBox .= '</g>';
            $scoreBox .= '</svg>';
            $scoreBox .= '<span class="post-score-value">'.$reviewScore.'</span>';
            $scoreBox .= '</div>';
            $scoreBox .= '</div><!--mnmd-review__overall-score-->';
            
            return $scoreBox;
        }
        static function bk_post_review_pros_cons_aside($postID){

            $prosTitle   = get_post_meta($postID,'bk_review_pros_title',true);
            $consTitle   = get_post_meta($postID,'bk_review_cons_title',true);
            $the_pros    = get_post_meta($postID,'bk_review_pros',true);
            $the_cons    = get_post_meta($postID,'bk_review_cons',true);
            
            $pros_cons = '';
            
            $pros_cons .= '<div class="mnmd-review__pros-and-cons">';
            $pros_cons .= '<div class="row row--space-between grid-gutter-20">';
            
            $pros_cons .= '<div class="col-xs-12">';
            $pros_cons .= '<div class="mnmd-review__pros">';
            $pros_cons .= '<h5 class="mnmd-review__list-title">'.$prosTitle.'</h5>';
            $pros_cons .= '<ul>';
            if(count($the_pros) > 0) {
                foreach($the_pros as $val) :
                    $pros_cons .= '<li><i class="mdicon mdicon-add_circle"></i><span>'.$val.'</span></li>';
                endforeach;
            }
            $pros_cons .= '</ul>';
            $pros_cons .= '</div>';
            $pros_cons .= '</div>';
            
            $pros_cons .= '<div class="col-xs-12">';
            $pros_cons .= '<div class="mnmd-review__cons">';
            $pros_cons .= '<h5 class="mnmd-review__list-title">'.$consTitle.'</h5>';
            $pros_cons .= '<ul>';
            if(count($the_cons) > 0) {
                foreach($the_cons as $val) :
                    $pros_cons .= '<li><i class="mdicon mdicon-remove_circle"></i><span>'.$val.'</span></li>';
                endforeach;
            }
            $pros_cons .= '</ul>';
            $pros_cons .= '</div>';
            $pros_cons .= '</div>';
            
            $pros_cons .= '</div>';
            $pros_cons .= '</div><!--mnmd-review__pros-and-cons-->';
            
            return $pros_cons;
        }
        static function bk_post_review_pros_cons($postID){

            $prosTitle   = get_post_meta($postID,'bk_review_pros_title',true);
            $consTitle   = get_post_meta($postID,'bk_review_cons_title',true);
            $the_pros    = get_post_meta($postID,'bk_review_pros',true);
            $the_cons    = get_post_meta($postID,'bk_review_cons',true);
            
            $pros_cons = '';
            
            $pros_cons .= '<div class="mnmd-review__pros-and-cons">';
            $pros_cons .= '<div class="row row--space-between grid-gutter-20">';
            
            $pros_cons .= '<div class="col-xs-12 col-sm-6">';
            $pros_cons .= '<div class="mnmd-review__pros">';
            $pros_cons .= '<h5 class="mnmd-review__list-title">'.$prosTitle.'</h5>';
            $pros_cons .= '<ul>';
            if(count($the_pros) > 0) {
                foreach($the_pros as $val) :
                    $pros_cons .= '<li><i class="mdicon mdicon-add_circle"></i><span>'.$val.'</span></li>';
                endforeach;
            }
            $pros_cons .= '</ul>';
            $pros_cons .= '</div>';
            $pros_cons .= '</div>';
            
            $pros_cons .= '<div class="col-xs-12 col-sm-6">';
            $pros_cons .= '<div class="mnmd-review__cons">';
            $pros_cons .= '<h5 class="mnmd-review__list-title">'.$consTitle.'</h5>';
            $pros_cons .= '<ul>';
            if(count($the_cons) > 0) {
                foreach($the_cons as $val) :
                    $pros_cons .= '<li><i class="mdicon mdicon-remove_circle"></i><span>'.$val.'</span></li>';
                endforeach;
            }
            $pros_cons .= '</ul>';
            $pros_cons .= '</div>';
            $pros_cons .= '</div>';
            
            $pros_cons .= '</div>';
            $pros_cons .= '</div><!--mnmd-review__pros-and-cons-->';
            
            return $pros_cons;
        }
    } // Close tnm_single
    
}