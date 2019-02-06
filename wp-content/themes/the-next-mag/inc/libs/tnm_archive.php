<?php
if (!class_exists('tnm_archive')) {
    class tnm_archive {
        static function the_query__sticky($catID, $posts_per_page){
            $feat_tag = '';                            
            $feat_area_option  = tnm_archive::bk_get_archive_option($catID, 'bk_category_feature_area__post_option');

            $args = array(
                'cat' => $catID,
				'post_status' => 'publish',
				'ignore_sticky_posts' => 1,
				'posts_per_page' => $posts_per_page,
            );
                                    
            if($feat_area_option !== 'latest') {
                $args['post__in'] = get_option( 'sticky_posts' );
            }
                        
            $the_query = new WP_Query( $args );
            wp_reset_postdata();
            return $the_query;
        }
    /**
     * ************* Get Option *****************
     *---------------------------------------------------
     */
        static function bk_get_archive_option($termID, $theoption = '') {
            $tnm_option = tnm_core::bk_get_global_var('tnm_option');
            $output = '';
            
            if($theoption != '') :
                $output  = tnm_core::tnm_rwmb_meta( $theoption, array( 'object_type' => 'term' ), $termID );  
                if (isset($output) && (($output == 'global_settings') || ($output == ''))): 
                    $output = $tnm_option[$theoption];
                endif;
            endif;
            
            return $output;
        }
        static function bk_pagination_render($pagination){
            global $wp_query;
            $max_page = $wp_query->max_num_pages;
            $render = '';
            if($max_page <= 1) {
                return '';
            }
            if($pagination == 'default') {
                $render = tnm_core::tnm_get_pagination();
            }else if($pagination == 'ajax-pagination') {
                $render = tnm_ajax_function::ajax_load_buttons('pagination', $max_page);
            }else if($pagination == 'ajax-loadmore') {
                $render = tnm_ajax_function::ajax_load_buttons('loadmore', $max_page);
            }
            return $render;
        }
        static function bk_author_pagination_render($pagination, $userMaxPages){
            $render = '';
            if($pagination == 'ajax-pagination') {
                $render = tnm_ajax_function::ajax_load_buttons('pagination', $userMaxPages);
            }else if($pagination == 'ajax-loadmore') {
                $render .= '<nav class="mnmd-pagination text-center">';
                $render .= '<button class="btn btn-default js-ajax-load-post-trigger">'.esc_html__('Load more authors', 'the-next-mag').'<i class="mdicon mdicon-cached mdicon--last"></i></button>';
    			$render .= '</nav>';
            }
            return $render;
        }
        static function bk_archive_pages_post_icon(){
            global $post;
            $tnm_option = tnm_core::bk_get_global_var('tnm_option');
            $postIcon = '';
            
            if(is_category()) {
                $postIcon = isset($tnm_option['bk_category_post_icon']) ? $tnm_option['bk_category_post_icon'] : 'disable';
            }elseif(is_author()) {
                $postIcon = isset($tnm_option['bk_author_post_icon']) ? $tnm_option['bk_author_post_icon'] : 'disable';
            }elseif(is_search()) {
                $postIcon = isset($tnm_option['bk_search_post_icon']) ? $tnm_option['bk_search_post_icon'] : 'disable';
            }elseif(is_archive()){
                $postIcon = isset($tnm_option['bk_archive_post_icon']) ? $tnm_option['bk_archive_post_icon'] : 'disable';
            }else {
                $pageTemplate =  get_post_meta($post->ID,'_wp_page_template',true);
                if($pageTemplate == 'blog.php') {
                    $postIcon = isset($tnm_option['bk_blog_post_icon']) ? $tnm_option['bk_blog_post_icon'] : 'disable';
                }
            }
            return $postIcon;
        }
        static function bk_render_authors($users_found) {
            $render = '';
            if(count($users_found) > 0):
                $render .= '<ul class="authors-list list-unstyled list-space-lg">';
                foreach($users_found as $user) :
                    $render .= '<li>';
                    $render .= tnm_archive::author_box($user->data->ID);
                    $render .= '</li>';
                endforeach;
                $render .= '</ul> <!-- End Author Results -->';
            endif;            
            return $render;
        }
        static function get_sticky_ids__category_feature_area($catID, $featLayout){
            $featAreaOption  = self::bk_get_archive_option($catID, 'bk_category_feature_area__post_option');
            $excludeIDs = array();
            $posts_per_page = 0;
            $sticky = get_option('sticky_posts') ;
            rsort( $sticky );
            
            $args = array (
                'post_type'     => 'post',
                'cat'           => $catID, // Get current category only
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
                return '';
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
            return $excludeIDs;
        }
        static function archive_feature_area($term_id, $featLayout){  
            $featArea = '';
            switch( $featLayout ) {
                default:
                    break;
                case 'mosaic_a':
                    $featArea .= self::mosaic_a__render($term_id);
                    break;
                case 'mosaic_a_bg':
                    $featArea .= self::mosaic_a_bg__render($term_id);
                    break;
                case 'mosaic_b':
                    $featArea .= self::mosaic_b__render($term_id);
                    break;
                case 'mosaic_b_bg':
                    $featArea .= self::mosaic_b_bg__render($term_id);
                    break;
                case 'mosaic_c':
                    $featArea .= self::mosaic_c__render($term_id);
                    break;
                case 'mosaic_c_bg':
                    $featArea .= self::mosaic_c_bg__render($term_id);
                    break;
                case 'featured_block_e':
                    $featArea .= self::featured_block_e__render($term_id);
                    break;
                case 'featured_block_f':
                    $featArea .= self::featured_block_f__render($term_id);
                    break;
                case 'posts_block_b':
                    $featArea .= self::posts_block_b__render($term_id);
                    break;
                case 'posts_block_c':
                    $featArea .= self::posts_block_c__render($term_id);
                    break;
                case 'posts_block_e':
                    $featArea .= self::posts_block_e__render($term_id);
                    break;
                case 'posts_block_e_bg':
                    $featArea .= self::posts_block_e_bg__render($term_id);
                    break;
                case 'posts_block_i':
                    $featArea .= self::posts_block_i__render($term_id);
                    break;
            }
            return $featArea;
        }
        static function tnm_archive_header($term_id){
            $archiveHeader = '';
            if(is_category()) :
                $imageID = get_term_meta( $term_id, 'bk_category_feat_img', false );
            else:
                $imageID = get_term_meta( $term_id, 'bk_archive_feat_img', false );
            endif;
            
            if((tnm_core::bk_check_array($imageID)) && ($imageID[0] != '')) {
                $bgURL = wp_get_attachment_image_src( $imageID[0], 'tnm-m-4_3' );
            }else {
                $bgURL = '';
            }
            
            if(is_category()) :
                $headerStyle = tnm_archive::bk_get_archive_option($term_id, 'bk_category_header_style');  
            else :
                $headerStyle = tnm_archive::bk_get_archive_option($term_id, 'bk_archive_header_style');
            endif;
            
            //In case the feature image is NULL and header background is a image => Force grey-bg style
            if(($bgURL == '') && (($headerStyle == 'image-bg') || ($headerStyle == 'image-bg-center'))) :
                $headerStyle = 'grey-bg';
            endif;
            
            if($headerStyle == 'grey-bg') :
                $archiveHeader .= '<div class="mnmd-block mnmd-block--fullwidth mnmd-block--contiguous page-heading page-heading--has-background">';
                $archiveHeader .= '<div class="container">';
                
                if(is_category()) :
                    $archiveHeader .= '<h2 class="page-heading__title">'.get_cat_name($term_id).'</h2>';
                    if ( category_description($term_id) ) :
                        $archiveHeader .= '<div class="page-heading__subtitle">'.category_description($term_id).'</div>';
                    endif;
                elseif(is_tag()) :
                    $tag = get_tag($term_id);
                    $archiveHeader .= '<h2 class="page-heading__title">'. esc_html__('Tag: ', 'the-next-mag'). $tag->name.'</h2>';
                    if ( $tag->description ) :
                        $archiveHeader .= '<div class="page-heading__subtitle">'.$tag->description.'</div>';
                    endif;
                endif;
                
    			$archiveHeader .= '</div><!-- .container -->';
                $archiveHeader .= '</div>';
            elseif($headerStyle == 'grey-bg-center') :
                $archiveHeader .= '<div class="mnmd-block mnmd-block--fullwidth mnmd-block--contiguous page-heading page-heading--has-background page-heading--center">';
                $archiveHeader .= '<div class="container">';
    			
                if(is_category()) :
                    $archiveHeader .= '<h2 class="page-heading__title">'.get_cat_name($term_id).'</h2>';
                    if ( category_description($term_id) ) :
                        $archiveHeader .= '<div class="page-heading__subtitle">'.category_description($term_id).'</div>';
                    endif;
                elseif(is_tag()) :
                    $tag = get_tag($term_id);
                    $archiveHeader .= '<h2 class="page-heading__title">'. esc_html__('Tag: ', 'the-next-mag'). $tag->name.'</h2>';
                    if ( $tag->description ) :
                        $archiveHeader .= '<div class="page-heading__subtitle">'.$tag->description.'</div>';
                    endif;
                endif;
                
    			$archiveHeader .= '</div><!-- .container -->';
                $archiveHeader .= '</div>';
                
            elseif($headerStyle == 'image-bg') :
         
                if($bgURL != '') :
                    $bgURLInline = "background-image: url('".esc_url($bgURL[0])."');";
                    $archiveHeader .= '<div class="mnmd-block mnmd-block--fullwidth mnmd-block--contiguous page-heading page-heading--has-background page-heading--inverse">';
                    $archiveHeader .= '<div class="background-img background-img--darkened">';
        			$archiveHeader .= '<div class="background-img blurred-more" style="'.$bgURLInline.'"></div>';
        			$archiveHeader .= '</div>';
                    $archiveHeader .= '<div class="container">';
        			if(is_category()) :
                        $archiveHeader .= '<h2 class="page-heading__title">'.get_cat_name($term_id).'</h2>';
                        if ( category_description($term_id) ) :
                            $archiveHeader .= '<div class="page-heading__subtitle">'.category_description($term_id).'</div>';
                        endif;
                    elseif(is_tag()) :
                        $tag = get_tag($term_id);
                        $archiveHeader .= '<h2 class="page-heading__title">'. esc_html__('Tag: ', 'the-next-mag'). $tag->name.'</h2>';
                        if ( $tag->description ) :
                            $archiveHeader .= '<div class="page-heading__subtitle">'.$tag->description.'</div>';
                        endif;
                    endif;
        			$archiveHeader .= '</div><!-- .container -->';
                    $archiveHeader .= '</div>';
                endif;
           
            elseif($headerStyle == 'image-bg-center') :
         
                if($bgURL != '') :
                    $bgURLInline = "background-image: url('".esc_url($bgURL[0])."');";
                    $archiveHeader .= '<div class="mnmd-block mnmd-block--fullwidth mnmd-block--contiguous page-heading page-heading--has-background page-heading--inverse page-heading--center">';
                    $archiveHeader .= '<div class="background-img background-img--darkened">';
        			$archiveHeader .= '<div class="background-img blurred-more" style="'.$bgURLInline.'"></div>';
        			$archiveHeader .= '</div>';
                    $archiveHeader .= '<div class="container">';
        			if(is_category()) :
                        $archiveHeader .= '<h2 class="page-heading__title">'.get_cat_name($term_id).'</h2>';
                        if ( category_description($term_id) ) :
                            $archiveHeader .= '<div class="page-heading__subtitle">'.category_description($term_id).'</div>';
                        endif;
                    elseif(is_tag()) :
                        $tag = get_tag($term_id);
                        $archiveHeader .= '<h2 class="page-heading__title">'. esc_html__('Tag: ', 'the-next-mag'). $tag->name.'</h2>';
                        if ( $tag->description ) :
                            $archiveHeader .= '<div class="page-heading__subtitle">'.$tag->description.'</div>';
                        endif;
                    endif;
        			$archiveHeader .= '</div><!-- .container -->';
                    $archiveHeader .= '</div>';
                endif;
                                                
            else :
                $archiveHeader .= '';
            endif;
                
            return $archiveHeader;
        }
        
        static function render_page_heading($pageID, $headerStyle) {
            $page_description  = get_post_meta($pageID,'bk_page_description',true);
            
            $imageID = get_post_thumbnail_id( $pageID );
            if($imageID != '') {
                $bgURL = wp_get_attachment_image_src( $imageID, 'tnm-m-4_3' );
            }else {
                $bgURL = '';
            }
            //In case the feature image is NULL and header background is a image => Force grey-bg style
            if(($bgURL == '') && (($headerStyle == 'image-bg') || ($headerStyle == 'image-bg-center'))) :
                $headerStyle = 'grey-bg';
            endif;
            
            $archiveHeader = '';            
            if($headerStyle == 'grey-bg') :
                $archiveHeader .= '<div class="mnmd-block mnmd-block--fullwidth mnmd-block--contiguous page-heading page-heading--has-background">';
                $archiveHeader .= '<div class="container">';
                
                $archiveHeader .= '<h1 class="page-heading__title">'. get_the_title($pageID) .'</h1>';
                if ( $page_description != '' ) :
                    $archiveHeader .= '<div class="page-heading__subtitle">'.esc_attr($page_description).'</div>';
                endif;
                
    			$archiveHeader .= '</div><!-- .container -->';
                $archiveHeader .= '</div>';
            elseif($headerStyle == 'grey-bg-center') :
                $archiveHeader .= '<div class="mnmd-block mnmd-block--fullwidth mnmd-block--contiguous page-heading page-heading--has-background page-heading--center">';
                $archiveHeader .= '<div class="container">';
    			
                $archiveHeader .= '<h1 class="page-heading__title">'. get_the_title($pageID) .'</h1>';
                if ( $page_description != '' ) :
                    $archiveHeader .= '<div class="page-heading__subtitle">'.esc_attr($page_description).'</div>';
                endif;
                
    			$archiveHeader .= '</div><!-- .container -->';
                $archiveHeader .= '</div>';
                
            elseif($headerStyle == 'image-bg') :
                if($bgURL != '') :
                    $bgURLInline = "background-image: url('".esc_url($bgURL[0])."');";
                    $archiveHeader .= '<div class="mnmd-block mnmd-block--fullwidth mnmd-block--contiguous page-heading page-heading--has-background page-heading--inverse">';
                    $archiveHeader .= '<div class="background-img background-img--darkened">';
        			$archiveHeader .= '<div class="background-img blurred-more" style="'.$bgURLInline.'"></div>';
        			$archiveHeader .= '</div>';
                    $archiveHeader .= '<div class="container">';
        			
                    $archiveHeader .= '<h1 class="page-heading__title">'. get_the_title($pageID) .'</h1>';
                    if ( $page_description != '' ) :
                        $archiveHeader .= '<div class="page-heading__subtitle">'.esc_attr($page_description).'</div>';
                    endif;
                    
        			$archiveHeader .= '</div><!-- .container -->';
                    $archiveHeader .= '</div>';
                endif;
            elseif($headerStyle == 'image-bg-center') :
                if($bgURL != '') :
                    $bgURLInline = "background-image: url('".esc_url($bgURL[0])."');";
                    $archiveHeader .= '<div class="mnmd-block mnmd-block--fullwidth mnmd-block--contiguous page-heading page-heading--has-background page-heading--inverse page-heading--center">';
                    $archiveHeader .= '<div class="background-img background-img--darkened">';
        			$archiveHeader .= '<div class="background-img blurred-more" style="'.$bgURLInline.'"></div>';
        			$archiveHeader .= '</div>';
                    $archiveHeader .= '<div class="container">';
        			$archiveHeader .= '<h1 class="page-heading__title">'. get_the_title($pageID) .'</h1>';
                    if ( $page_description != '' ) :
                        $archiveHeader .= '<div class="page-heading__subtitle">'.esc_attr($page_description).'</div>';
                    endif;
        			$archiveHeader .= '</div><!-- .container -->';
                    $archiveHeader .= '</div>';
                endif;               
            else :
                $archiveHeader .= '';
            endif;
            
            return $archiveHeader;                        
                    
        }      
        
        static function mosaic_a__render($term_id){  
            $dataOutput = '';
            $mosaicHTML = new tnm_mosaic_a;
            $postIcon = self::bk_archive_pages_post_icon();
            $moduleInfo_Array = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'meta_L'          => 2, // Author + Date
                'meta_S'          => 8, // Date
                'cat_L'           => '', 
                'cat_S'           => '',
                'excerpt_L'       => '',
                'textAlign'     => '',
                'footerStyle'   => '1-col',
            );
            
            $posts_per_page = 5;
            $the_query = self::the_query__sticky($term_id, $posts_per_page);
            
            $dataOutput .= self::tnm_archive_header($term_id);
            
            $dataOutput .= '<div class="mnmd-block mnmd-block--fullwidth mnmd-mosaic mnmd-mosaic--gutter-10">';
            $dataOutput .= '<div class="container">';
            $dataOutput .= $mosaicHTML->render_modules($the_query, $moduleInfo_Array);            //render modules
            $dataOutput .= '</div><!-- .container -->';
            $dataOutput .= '</div>';
            
            return $dataOutput;
        }
        static function mosaic_a_bg__render($term_id){  
            $dataOutput = '';
            $postIcon = self::bk_archive_pages_post_icon();
            $mosaicHTML = new tnm_mosaic_a_bg;
            $moduleInfo_Array = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'meta_L'          => 2, // Author + Date
                'meta_S'          => 8, // Date
                'cat_L'           => '', 
                'cat_S'           => '',
                'excerpt_L'       => '',
                'textAlign'     => '',
                'footerStyle'   => '1-col',
            );
            
            $posts_per_page = 5;
            $the_query = self::the_query__sticky($term_id, $posts_per_page);
                     
            $dataOutput .= '<div class="mnmd-block mnmd-block--fullwidth mnmd-block--contiguous mnmd-mosaic mnmd-mosaic--has-shadow mnmd-mosaic--gutter-10 has-overlap-background">';
            
            $dataOutput .= '<div class="overlap-background background-svg-pattern background-svg-pattern--solid-color">';
    		$dataOutput .= '<div class="background-overlay cat-theme-bg cat-'.$term_id.'"></div>';
    		$dataOutput .= '</div>';
            
            $dataOutput .= '<div class="container container--wide">';
            
            $dataOutput .= '<div class="page-heading page-heading--center page-heading--inverse">';
			$dataOutput .= '<h2 class="page-heading__title">'.get_cat_name($term_id).'</h2>';
            if ( category_description() ) :
			 $dataOutput .= '<div class="page-heading__subtitle">'.category_description().'</div>';
            endif;
			$dataOutput .= '</div>';
            
            $dataOutput .= '<div class="row row--space-between">';
            $dataOutput .= $mosaicHTML->render_modules($the_query, $moduleInfo_Array);            //render modules
            $dataOutput .= '</div>';
            $dataOutput .= '</div><!-- .container -->';
            $dataOutput .= '</div>';
            
            return $dataOutput;
        }
        static function mosaic_b__render($term_id){  
            $dataOutput = '';
            $postIcon = self::bk_archive_pages_post_icon();
            $mosaicHTML = new tnm_mosaic_b;
            $moduleInfo_Array = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition_L'  => 'top-right',
                'iconPosition_S'  => 'top-right',
                'meta_L'          => 2, // Author + Date
                'meta_S'          => 8, // Date
                'cat_L'           => '', 
                'cat_S'           => '',
                'excerpt_L'       => '',
                'textAlign'     => '',
                'footerStyle'   => '1-col',
            );
            
            $posts_per_page = 4;
            $the_query = self::the_query__sticky($term_id, $posts_per_page);
            
            $dataOutput .= '<div class="mnmd-block mnmd-block--fullwidth mnmd-mosaic mnmd-mosaic--gutter-10">';
            $dataOutput .= '<div class="container container--wide">';
            
            $dataOutput .= '<div class="page-heading page-heading--center">';
			$dataOutput .= '<h2 class="page-heading__title">'.get_cat_name($term_id).'</h2>';
            if ( category_description() ) :
			 $dataOutput .= '<div class="page-heading__subtitle">'.category_description().'</div>';
            endif;
			$dataOutput .= '</div>';
            
            $dataOutput .= $mosaicHTML->render_modules($the_query, $moduleInfo_Array);            //render modules
            $dataOutput .= '</div><!-- .container -->';
            $dataOutput .= '</div>';
            
            return $dataOutput;
        }
        static function mosaic_b_bg__render($term_id){  
            $dataOutput = '';
            $postIcon = self::bk_archive_pages_post_icon();
            $mosaicHTML = new tnm_mosaic_b_bg;
            $moduleInfo_Array = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition_L'  => 'top-right',
                'iconPosition_S'  => 'top-right',
                'meta_L'          => 2, // Author + Date
                'meta_S'          => 8, // Date
                'cat_L'           => '', 
                'cat_S'           => '',
                'excerpt_L'       => '',
                'textAlign'     => '',
                'footerStyle'   => '1-col',
            );
            
            $posts_per_page = 4;
            $the_query = self::the_query__sticky($term_id, $posts_per_page);
                     
            $dataOutput .= '<div class="mnmd-block mnmd-block--fullwidth mnmd-block--contiguous mnmd-mosaic mnmd-mosaic--has-shadow mnmd-mosaic--gutter-10 has-overlap-background">';
            
            $dataOutput .= '<div class="overlap-background background-svg-pattern background-svg-pattern--solid-color">';
    		$dataOutput .= '<div class="background-overlay cat-theme-bg cat-'.$term_id.'"></div>';
    		$dataOutput .= '</div>';
            
            $dataOutput .= '<div class="container container--wide">';
            
            $dataOutput .= '<div class="page-heading page-heading--center page-heading--inverse">';
			$dataOutput .= '<h2 class="page-heading__title">'.get_cat_name($term_id).'</h2>';
            if ( category_description() ) :
			 $dataOutput .= '<div class="page-heading__subtitle">'.category_description().'</div>';
            endif;
			$dataOutput .= '</div>';
            
            $dataOutput .= '<div class="row row--space-between">';
            $dataOutput .= $mosaicHTML->render_modules($the_query, $moduleInfo_Array);            //render modules
            $dataOutput .= '</div>';
            $dataOutput .= '</div><!-- .container -->';
            $dataOutput .= '</div>';
            
            return $dataOutput;
        }
        static function mosaic_c__render($term_id){  
            $dataOutput = '';
            $postIcon = self::bk_archive_pages_post_icon();
            $mosaicHTML = new tnm_mosaic_c;
            $moduleInfo_Array = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition_L'  => 'top-right',
                'iconPosition_S'  => 'top-right',
                'meta_L'          => 1, // Author
                'meta_S'          => 1, // Date
                'cat_L'           => '', 
                'cat_S'           => '',
                'excerpt_L'       => '',
                'textAlign'     => '',
                'footerStyle'   => '1-col',
            );
            
            $posts_per_page = 3;
            $the_query = self::the_query__sticky($term_id, $posts_per_page);
            
            $dataOutput .= self::tnm_archive_header($term_id);
            
            $dataOutput .= '<div class="mnmd-block mnmd-block--fullwidth mnmd-mosaic mnmd-mosaic--gutter-10">';
            $dataOutput .= '<div class="container">';
            $dataOutput .= $mosaicHTML->render_modules($the_query, $moduleInfo_Array);            //render modules
            $dataOutput .= '</div><!-- .container -->';
            $dataOutput .= '</div>';
            
            return $dataOutput;
        }
        static function mosaic_c_bg__render($term_id){  
            $dataOutput = '';
            $postIcon = self::bk_archive_pages_post_icon();
            $mosaicHTML = new tnm_mosaic_c_bg;
            $moduleInfo_Array = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition_L'  => 'top-right',
                'iconPosition_S'  => 'top-right',
                'meta_L'          => 1, // Author
                'meta_S'          => 1, // Date
                'cat_L'           => '', 
                'cat_S'           => '',
                'excerpt_L'       => '',
                'textAlign'     => '',
                'footerStyle'   => '1-col',
            );
            
            $posts_per_page = 3;
            $the_query = self::the_query__sticky($term_id, $posts_per_page);
                     
            $dataOutput .= '<div class="mnmd-block mnmd-block--fullwidth mnmd-block--contiguous mnmd-mosaic mnmd-mosaic--has-shadow mnmd-mosaic--gutter-10 has-overlap-background">';
            
            $dataOutput .= '<div class="overlap-background background-svg-pattern background-svg-pattern--solid-color">';
    		$dataOutput .= '<div class="background-overlay cat-theme-bg cat-'.$term_id.'"></div>';
    		$dataOutput .= '</div>';
            
            $dataOutput .= '<div class="container container--wide">';
            
            $dataOutput .= '<div class="page-heading page-heading--center page-heading--inverse">';
			$dataOutput .= '<h2 class="page-heading__title">'.get_cat_name($term_id).'</h2>';
            if ( category_description() ) :
			 $dataOutput .= '<div class="page-heading__subtitle">'.category_description().'</div>';
            endif;
			$dataOutput .= '</div>';
            
            $dataOutput .= '<div class="row row--space-between">';
            $dataOutput .= $mosaicHTML->render_modules($the_query, $moduleInfo_Array);            //render modules
            $dataOutput .= '</div>';
            $dataOutput .= '</div><!-- .container -->';
            $dataOutput .= '</div>';
            
            return $dataOutput;
        }
        static function featured_block_e__render($term_id){  
            $dataOutput = '';
            $postIcon = self::bk_archive_pages_post_icon();
            $moduleHTML = new tnm_featured_block_e;
            $moduleInfo_Array = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition_L'  => 'center',
                'iconPosition_S'  => 'center',
                'meta_L'          => 2, // Author + Date
                'meta_S'          => 8, // Date
                'cat_L'           => '', 
                'cat_S'           => '',
                'excerpt_L'       => 1,
                'textAlign'     => '',
            );
            
            $posts_per_page = 5;
            $the_query = self::the_query__sticky($term_id, $posts_per_page);
                     
            $dataOutput .= '<div class="mnmd-block mnmd-block--fullwidth mnmd-featured-block-e has-background inverse-text mnmd-block--contiguous">';
            
            $dataOutput .= '<div class="background-svg-pattern background-svg-pattern--solid-color">';
    		$dataOutput .= '<div class="background-overlay cat-theme-bg cat-'.$term_id.'"></div>';
    		$dataOutput .= '</div>';
            
            $dataOutput .= '<div class="container">';
            
            $dataOutput .= '<div class="page-heading page-heading--center page-heading--inverse">';
			$dataOutput .= '<h2 class="page-heading__title">'.get_cat_name($term_id).'</h2>';
            if ( category_description() ) :
			 $dataOutput .= '<div class="page-heading__subtitle">'.category_description().'</div>';
            endif;
			$dataOutput .= '</div>';
            
            $dataOutput .= $moduleHTML->render_modules($the_query, $moduleInfo_Array);            //render modules

            $dataOutput .= '</div><!-- .container -->';
            $dataOutput .= '</div>';
            
            return $dataOutput;
        }
        static function featured_block_f__render($term_id){  
            $dataOutput = '';
            $postIcon = self::bk_archive_pages_post_icon();
            $moduleHTML = new tnm_featured_block_f;
            $moduleInfo_Array = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition_L'  => 'top-right',
                'iconPosition_S'  => 'top-right',
                'meta_L'          => 2, // Author + Date
                'meta_S'          => 8, // Date
                'cat_L'           => '', 
                'cat_S'           => '',
                'excerpt_L'       => 0,
                'textAlign'     => '',
            );
            
            $posts_per_page = 5;
            $the_query = self::the_query__sticky($term_id, $posts_per_page);
            
            $dataOutput .= self::tnm_archive_header($term_id);
            
            $dataOutput .= '<div class="mnmd-block mnmd-block--fullwidth mnmd-featured-block-f">';
            
            $dataOutput .= '<div class="container">';
            
            $dataOutput .= $moduleHTML->render_modules($the_query, $moduleInfo_Array);            //render modules

            $dataOutput .= '</div><!-- .container -->';
            $dataOutput .= '</div>';
            
            return $dataOutput;
        }
        static function posts_block_b__render($term_id){  
            $dataOutput = '';
            $postIcon = self::bk_archive_pages_post_icon();
            $moduleHTML = new tnm_posts_block_b;
            $moduleInfo_Array = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition_L'  => 'top-right',
                'iconPosition_S'  => 'top-right',
                'meta_L'          => 1, // Author 
                'meta_S'          => 8, // Date
                'cat_L'           => '', 
                'cat_S'           => '',
                'excerpt_L'       => 1,
                'textAlign'       => '',
                'footerStyle'     => '1-col',
            );
            
            $posts_per_page = 6;
            $the_query = self::the_query__sticky($term_id, $posts_per_page);
            
            $dataOutput .= self::tnm_archive_header($term_id);
            
            $dataOutput .= '<div class="mnmd-block mnmd-block--fullwidth">';
            
            $dataOutput .= '<div class="container">';
            
            $dataOutput .= $moduleHTML->render_modules($the_query, $moduleInfo_Array);            //render modules

            $dataOutput .= '</div><!-- .container -->';
            $dataOutput .= '</div>';
            
            return $dataOutput;
        }
        static function posts_block_c__render($term_id){  
            $dataOutput = '';
            $postIcon = self::bk_archive_pages_post_icon();
            $moduleHTML = new tnm_posts_block_c;
            $moduleInfo_Array = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'center',
                'meta'          => 7, // Author 
                'cat'           => '', 
                'footerStyle'   => '2-cols',
            );
            
            $posts_per_page = 4;
            $the_query = self::the_query__sticky($term_id, $posts_per_page);
            
            $dataOutput .= self::tnm_archive_header($term_id);
            
            $dataOutput .= '<div class="mnmd-block mnmd-block--fullwidth">';
            
            $dataOutput .= '<div class="container">';
            
            $dataOutput .= $moduleHTML->render_modules($the_query, $moduleInfo_Array);            //render modules

            $dataOutput .= '</div><!-- .container -->';
            $dataOutput .= '</div>';
            
            return $dataOutput;
        }
        static function posts_block_e__render($term_id){  
            $dataOutput = '';
            $postIcon = self::bk_archive_pages_post_icon();
            $moduleHTML = new tnm_posts_block_e;
            $moduleInfo_Array = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition_L'  => 'top-right',
                'iconPosition_S'  => 'top-right',
                'meta_L'          => 2, // Author 
                'meta_S'          => 8, // Date
                'cat_L'           => '', 
                'cat_S'           => '',
                'excerpt_L'       => '',
                'textAlign'       => '',
                'footerStyle'     => '1-col',
            );
            
            $posts_per_page = 3;
            $the_query = self::the_query__sticky($term_id, $posts_per_page);
            
            $dataOutput .= self::tnm_archive_header($term_id);
            
            $dataOutput .= '<div class="mnmd-block mnmd-block--fullwidth">';
            
            $dataOutput .= '<div class="container">';
            
            $dataOutput .= $moduleHTML->render_modules($the_query, $moduleInfo_Array);            //render modules

            $dataOutput .= '</div><!-- .container -->';
            $dataOutput .= '</div>';
            
            return $dataOutput;
        }
        static function posts_block_e_bg__render($term_id){  
            $dataOutput = '';
            $postIcon = self::bk_archive_pages_post_icon();
            $moduleHTML = new tnm_posts_block_e_wide_bg;
            $moduleInfo_Array = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition_L'  => 'top-right',
                'iconPosition_S'  => 'top-right',
                'meta_L'          => 2, // Author 
                'meta_S'          => 8, // Date
                'cat_L'           => '', 
                'cat_S'           => '',
                'excerpt_L'       => '',
                'textAlign'       => '',
                'footerStyle'     => '1-col',
            );
            
            $posts_per_page = 3;
            $the_query = self::the_query__sticky($term_id, $posts_per_page);
            
            $dataOutput .= '<div class="mnmd-block mnmd-block--fullwidth mnmd-mosaic mnmd-mosaic--has-shadow mnmd-mosaic--gutter-10 has-overlap-background mnmd-block--contiguous">';
            
            $dataOutput .= '<div class="overlap-background background-svg-pattern background-svg-pattern--solid-color">';
    		$dataOutput .= '<div class="background-overlay cat-theme-bg cat-'.$term_id.'"></div>';
    		$dataOutput .= '</div>';
            
            $dataOutput .= '<div class="container container--wide">';
            
            $dataOutput .= '<div class="page-heading page-heading--center page-heading--inverse">';
			$dataOutput .= '<h2 class="page-heading__title">'.get_cat_name($term_id).'</h2>';
            if ( category_description() ) :
			 $dataOutput .= '<div class="page-heading__subtitle">'.category_description().'</div>';
            endif;
			$dataOutput .= '</div>';
            
            $dataOutput .= $moduleHTML->render_modules($the_query, $moduleInfo_Array);            //render modules

            $dataOutput .= '</div><!-- .container -->';
            $dataOutput .= '</div>';
            
            return $dataOutput;
        }
        static function posts_block_i__render($term_id){  
            $dataOutput = '';
            $postIcon = self::bk_archive_pages_post_icon();
            $moduleHTML = new tnm_posts_block_i;
            $moduleInfo_Array = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition_L'  => 'top-right',
                'iconPosition_S'  => 'center',
                'meta_L'          => 1, // Author 
                'meta_S'          => '', // Date
                'cat_L'           => '', 
                'cat_S'           => '',
                'excerpt_L'       => '',
                'textAlign'       => '',
                'footerStyle'     => '1-col',
            );
            
            $posts_per_page = 5;
            $the_query = self::the_query__sticky($term_id, $posts_per_page);
            
            $dataOutput .= self::tnm_archive_header($term_id);
            
            $dataOutput .= '<div class="mnmd-block mnmd-block--fullwidth">';
            
            $dataOutput .= '<div class="container">';
            
            $dataOutput .= $moduleHTML->render_modules($the_query, $moduleInfo_Array);            //render modules

            $dataOutput .= '</div><!-- .container -->';
            $dataOutput .= '</div>';
            
            return $dataOutput;
        }
        static function archive_fullwidth($archiveLayout, $moduleID = '', $pagination = ''){ 

            $dataOutput = '';
			
            switch($archiveLayout) {
                case 'listing_grid_no_sidebar':
                    $dataOutput .= self::listing_grid_no_sidebar__render($moduleID);
                    break;
                case 'listing_grid_small_no_sidebar':
                    $dataOutput .= self::listing_grid_small_no_sidebar__render($moduleID, $pagination);
                    break;
                case 'listing_list_no_sidebar':
                    $dataOutput .= self::listing_list_no_sidebar__render($moduleID);
                    break;
                case 'listing_list_alt_a_no_sidebar':
                    $dataOutput .= self::listing_list_alt_a_no_sidebar__render($moduleID);
                    break;
                case 'listing_list_alt_b_no_sidebar':
                    $dataOutput .= self::listing_list_alt_b_no_sidebar__render($moduleID);
                    break;
                case 'listing_list_alt_c_no_sidebar':
                    $dataOutput .= self::listing_list_alt_c_no_sidebar__render($moduleID);
                    break;
                default: 
                    $dataOutput .= self::listing_grid_no_sidebar__render($moduleID);
                    break;                                                        
            } 
            return $dataOutput;
        }
        static function archive_main_col($archiveLayout, $moduleID = '', $pagination = ''){ 

            $dataOutput = '';
			
            switch($archiveLayout) {
                case 'listing_list':
                    $dataOutput .= self::listing_list__render($moduleID);
                    break;
                case 'listing_list_alt_a':
                    $dataOutput .= self::listing_list_alt_a__render($moduleID);
                    break;
                case 'listing_list_alt_b':
                    $dataOutput .= self::listing_list_alt_b__render($moduleID);
                    break;
                case 'listing_list_alt_c':
                    $dataOutput .= self::listing_list_alt_c__render($moduleID);
                    break;
                case 'listing_grid':
                    $dataOutput .= self::listing_grid__render($moduleID, $pagination);
                    break;
                case 'listing_grid_alt_a':
                    $dataOutput .= self::listing_grid_alt_a__render($moduleID, $pagination);
                    break;
                case 'listing_grid_alt_b':
                    $dataOutput .= self::listing_grid_alt_b__render($moduleID, $pagination);
                    break;
                case 'listing_grid_small':
                    $dataOutput .= self::listing_grid_small__render($moduleID, $pagination);
                    break;
                default:
                    $dataOutput .= self::listing_list__render($moduleID);
                    break;                                    
            } 
            return $dataOutput;
        }
/** Full Width Modules ( No sidebar)**/
        static function listing_grid_no_sidebar__render($moduleID) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postVerticalHTML = new tnm_vertical_1;

            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'meta'          => 2,
                'cat'           => 1,
                'excerpt'       => 1,
            );
            tnm_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);    
                    
            $cat = 1; //Top - Left
            $cat_Class = tnm_core::bk_get_cat_class($cat);
            
            $postVerticalAttr = array (
                'additionalClass'   => '',
                'cat'               => $cat,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'tnm-xs-2_1',
                'typescale'         => 'typescale-2',
                'except_length'     => 17,
                'meta'              => array('author', 'date'),
                'postIcon'          => $postIconAttr,  
            );
            
			$render_modules .= '<div class="posts-listing">';
            
            $render_modules .= '<div class="row row--space-between posts-list">';
            
            while (have_posts()): the_post();  
                $currentPost = $wp_query->current_post;
                $currentPostINBLK = $currentPost % 6; //1 BLK has 6 Post
                if(($currentPostINBLK == 2) || ($currentPostINBLK == 4)) {
                    $render_modules .= '<div class="clearfix visible-sm"></div>';
                }elseif($currentPostINBLK == 3) {
                    $render_modules .= '<div class="clearfix visible-md visible-lg"></div>';
                }elseif(($currentPostINBLK == 0) && ($currentPost != 0)){
                    $render_modules .= '<div class="clearfix hidden-xs"></div>';
                }
                
                $postVerticalAttr['postID'] = get_the_ID();
                
                if($postIcon != 'disable') {
                    $postIconAttr['iconType'] = tnm_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition']);
                    $postVerticalAttr['postIcon'] = $postIconAttr;
                }
                
                $render_modules .= '<div class="col-xs-12 col-sm-6 col-md-4">';
                $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                $render_modules .= '</div>';
            endwhile;
            $render_modules .= '</div><!--Close Row -->';
            $render_modules .= '</div><!-- .Post Listing -->';
            
            return $render_modules;
        }
        static function listing_grid_small_no_sidebar__render($moduleID, $pagination) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postVerticalHTML = new tnm_vertical_1;
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'meta'          => 2,
                'cat'           => 1,
                'excerpt'       => 1,
            );
            tnm_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);    
            
            $cat = 1; //Top - Left
            $cat_Class = tnm_core::bk_get_cat_class($cat);
            
            $postVerticalAttr = array (
                'additionalClass'   => '',
                'cat'               => $cat,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'tnm-xs-2_1',
                'typescale'         => 'typescale-1',
                'meta'              => array('author', 'date'),
                'postIcon'          => $postIconAttr,  
            );
            
			$render_modules .= '<div class="posts-listing posts-list">';
            
            $openRow = '<div class="row row--space-between">';
            $closeRow = '</div><!-- Close Row -->';
            
            if($pagination == 'ajax-loadmore') :
                while (have_posts()): the_post();  
                    $currentPost = $wp_query->current_post;
                    if($currentPost % 4 == 0) {
                        $render_modules_tmp = '';
                        $render_modules_tmp .= $openRow;
                    }
                    if($currentPost % 4 == 2) {
                        $render_modules_tmp .= '<div class="clearfix visible-sm"></div>';
                    }
                    $postVerticalAttr['postID'] = get_the_ID();
                    
                    if($postIcon != 'disable') {
                        $addClass = 'overlay-item--sm-p';
                        $postIconAttr['iconType'] = tnm_core::bk_post_format_detect(get_the_ID());
                        $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], 'small', $moduleInfo['iconPosition'], $addClass);
                        $postVerticalAttr['postIcon'] = $postIconAttr;
                    }
                    
                    $render_modules_tmp .= '<div class="col-xs-12 col-sm-6 col-md-3">';
                    $render_modules_tmp .= $postVerticalHTML->render($postVerticalAttr);
                    $render_modules_tmp .= '</div>';
                    
                    if($currentPost % 4 == 3) {
                        $render_modules_tmp .= $closeRow;
                        $render_modules .= $render_modules_tmp;
                    }
                endwhile;
                    
                if(($currentPost%4 < 3) && ($wp_query->post_count < 3)) :
                    $render_modules_tmp .= $closeRow;
                    $render_modules .= $render_modules_tmp;
                endif;
            else :
                while (have_posts()): the_post();  
                    $currentPost = $wp_query->current_post;
                    if($currentPost % 4 == 0) {
                        $render_modules .= $openRow;
                    }
                    if($currentPost % 4 == 2) {
                        $render_modules .= '<div class="clearfix visible-sm"></div>';
                    }
                    $postVerticalAttr['postID'] = get_the_ID();
                    
                    if($postIcon != 'disable') {
                        $addClass = 'overlay-item--sm-p';
                        $postIconAttr['iconType'] = tnm_core::bk_post_format_detect(get_the_ID());
                        $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition'], $addClass);
                        $postVerticalAttr['postIcon'] = $postIconAttr;
                    }
                                                    
                    $render_modules .= '<div class="col-xs-12 col-sm-6 col-md-3">';
                    $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                    $render_modules .= '</div>';
                    
                    if($currentPost % 4 == 3) {
                        $render_modules .= $closeRow;
                    }
                endwhile;
                if($currentPost % 4 != 3) {
                    $render_modules .= $closeRow;
                }
            endif;
            
            $render_modules .= '</div><!-- .Post Listing -->';
            
            return $render_modules;
        }
        static function listing_list_no_sidebar__render($moduleID) {
            $render_modules = '';
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postHorizontalHTML = new tnm_horizontal_1;

            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'meta'          => 3,
                'cat'           => 3,
                'excerpt'       => 1,
            );
            tnm_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);       
                     
            $cat = 3; //Above the Title - No BG
            $cat_Class = tnm_core::bk_get_cat_class($cat);
            
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-sm',
                'cat'               => $cat,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'tnm-xs-4_3',
                'typescale'         => 'typescale-3',
                'except_length'     => 23,
                'meta'              => array('author', 'date', 'comment'),
                'postIcon'          => $postIconAttr,  
            );
            
            $render_modules .= '<div class="posts-list list-unstyled list-space-xl">';
            
            while (have_posts()): the_post();                 
                $postHorizontalAttr['postID'] = get_the_ID();
                
                if($postIcon != 'disable') {
                    $postIconAttr['iconType'] = tnm_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition']);
                    $postHorizontalAttr['postIcon'] = $postIconAttr;
                }
                
                $render_modules .= '<div class="list-item">';
                $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                $render_modules .= '</div>';
            endwhile;
            
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        static function listing_list_alt_a_no_sidebar__render($moduleID) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postHorizontalHTML = new tnm_horizontal_1;
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'meta'          => 3,
                'cat'           => 3,
                'excerpt'       => 1,
            );
            tnm_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);       
                        
            $cat = 3; //Above the Title - No BG
            $cat_Class = tnm_core::bk_get_cat_class($cat);
            
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-sm',
                'cat'               => $cat,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'tnm-xs-4_3',
                'typescale'         => 'typescale-3',
                'except_length'     => 23,
                'meta'              => array('author', 'date', 'comment'),
                'postIcon'          => $postIconAttr,  
            );
            
			$render_modules .= '<div class="posts-list list-space-md list-seperated">';
            
            while (have_posts()): the_post();                 
                $currentPost = $wp_query->current_post;
                $postHorizontalAttr['postID'] = get_the_ID();
                
                if($postIcon != 'disable') {
                    $postIconAttr['iconType'] = tnm_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition']);
                    $postHorizontalAttr['postIcon'] = $postIconAttr;
                }
                
                if($currentPost % 5) : //Normal Posts 
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</div>';
                else: //Large Posts
                    $postHorizontalAttr_L = $postHorizontalAttr;
                    $postHorizontalAttr_L['additionalClass'] = '';
                    $postHorizontalAttr_L['postIcon']['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $moduleInfo['iconPosition']);
                    
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr_L);
                    $render_modules .= '</div>';
                endif;
            endwhile;
            
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        static function listing_list_alt_b_no_sidebar__render($moduleID) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postHorizontalHTML = new tnm_horizontal_1;
            $postOverlayHTML = new tnm_overlay_1;
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition_l'  => 'top-right',
                'iconPosition_s'  => 'top-right',
                'meta_l'          => 3,
                'cat_l'           => 1,
                'excerpt_l'       => 1,
                'meta_s'          => 3,
                'cat_s'           => 3,
                'excerpt_s'       => 1,
                'footer_style'    => '1-col',
            );
            tnm_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
                        
            $cat_L = 1; //Above the Title - No BG
            $cat_L_Class = tnm_core::bk_get_cat_class($cat_L);
            
            $cat_S = 3; //Above the Title - No BG
            $cat_S_Class = tnm_core::bk_get_cat_class($cat_S);
            
            $postOverlayAttr = array (
                'additionalClass'   => 'post--overlay-floorfade post--overlay-bottom post--overlay-sm post--overlay-padding-lg',
                'cat'               => $cat_L,
                'catClass'          => $cat_L_Class,
                'thumbSize'         => 'tnm-m-16_9',
                'typescale'         => 'typescale-4',
                'footerType'            => '1-col',
                'additionalMetaClass'   => '',
                'except_length'     => 23,
                'meta'              => array('author', 'date', 'comment'),
                'postIcon'          => $postIconAttr,  
            );
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-sm',
                'cat'               => $cat_S,
                'catClass'          => $cat_S_Class,
                'thumbSize'         => 'tnm-xs-4_3',
                'typescale'         => 'typescale-3',
                'except_length'     => 23,
                'meta'              => array('author', 'date', 'comment'),
                'postIcon'          => $postIconAttr,  
            );
			$render_modules .= '<div class="posts-list list-unstyled list-space-xl">';
            
            while (have_posts()): the_post();                 
                $currentPost = $wp_query->current_post;                
                
                if($currentPost % 5) : //Small Posts
                    $postHorizontalAttr['postID'] = get_the_ID();
                    
                    if($postIcon != 'disable') {
                        $postIconAttr['iconType'] = tnm_core::bk_post_format_detect(get_the_ID());
                        $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition_s']);
                        $postHorizontalAttr['postIcon'] = $postIconAttr;
                    }
                    
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</div>';
                else: //Large Posts
                    $postOverlayAttr['postID'] = get_the_ID();
                    
                    if($postIcon != 'disable') {
                        $postIconAttr['iconType'] = tnm_core::bk_post_format_detect(get_the_ID());
                        if($postIconAttr['iconType'] == 'gallery') {
                            $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                        }else {
                            $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $moduleInfo['iconPosition_l']);
                        }
                        
                        $postOverlayAttr['postIcon']    = $postIconAttr;
                    }
                    
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                    $render_modules .= '</div>';
                endif;
                
            endwhile;
            
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        static function listing_list_alt_c_no_sidebar__render($moduleID) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postHorizontalHTML = new tnm_horizontal_1;
            $postVerticalHTML = new tnm_vertical_1;
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition_l'  => 'top-right',
                'iconPosition_s'  => 'top-right',
                'meta_l'          => 3,
                'cat_l'           => 1,
                'excerpt_l'       => 1,
                'meta_s'          => 3,
                'cat_s'           => 3,
                'excerpt_s'       => 1,
                'footer_style'    => '1-col',
            );
            tnm_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
            $cat_L = 1; //Above the Title - No BG
            $cat_L_Class = tnm_core::bk_get_cat_class($cat_L);
            
            $cat_S = 3; //Above the Title - No BG
            $cat_S_Class = tnm_core::bk_get_cat_class($cat_S);

            $postVerticalAttr = array (
                'cat'               => $cat_L,
                'catClass'          => $cat_L_Class,
                'thumbSize'         => 'tnm-m-2_1',
                'typescale'         => 'typescale-4',
                'additionalExcerptClass' => 'post__excerpt--xxl ',
                'except_length'     => 23,
                'meta'              => array('author', 'date', 'comment'),
                'postIcon'          => $postIconAttr,
            );
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-sm',
                'cat'               => $cat_S,
                'catClass'          => $cat_S_Class,
                'thumbSize'         => 'tnm-xs-4_3',
                'typescale'         => 'typescale-3',
                'except_length'     => 23,
                'meta'              => array('author', 'date', 'comment'),
                'postIcon'          => $postIconAttr,     
            );
			$render_modules .= '<div class="posts-list list-unstyled list-space-xl">';
            
            while (have_posts()): the_post();                 
                $currentPost = $wp_query->current_post;                
                
                if($currentPost % 5) : //Small Posts
                    $postHorizontalAttr['postID'] = get_the_ID();
                    
                    if($postIcon != 'disable') {
                        $postIconAttr['iconType'] = tnm_core::bk_post_format_detect(get_the_ID());
                        $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition_s']);
                        $postHorizontalAttr['postIcon'] = $postIconAttr;
                    }
                    
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</div>';
                else: //Large Posts
                    $postVerticalAttr['postID'] = get_the_ID();
                    
                    if($postIcon != 'disable') {
                        $postIconAttr['iconType'] = tnm_core::bk_post_format_detect(get_the_ID());
                        $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $moduleInfo['iconPosition_l']);
                        $postVerticalAttr['postIcon']    = $postIconAttr;
                    }
                    
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                    $render_modules .= '</div>';
                endif;
                
            endwhile;
            
            $render_modules .= '</div>';
            
            return $render_modules;
        }
/** Main Col Modules **/
        static function listing_list__render($moduleID) {
            $render_modules = '';
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postHorizontalHTML = new tnm_horizontal_1;
            $postIcon = self::bk_archive_pages_post_icon();
                        
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'meta'          => 3,
                'cat'           => 3,
                'excerpt'       => 1,
            );
            tnm_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
                        
            $cat = 3; //Above the Title - No BG
            $cat_Class = tnm_core::bk_get_cat_class($cat);
            
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-sm',
                'cat'               => $cat,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'tnm-xs-4_3',
                'typescale'         => 'typescale-2',
                'except_length'     => 23,
                'meta'              => array('author', 'date', 'comment'),
                'postIcon'          => $postIconAttr,  
            );
            
			$render_modules .= '<div class="posts-list list-unstyled list-space-xl">';
            
            while (have_posts()): the_post();                 
                $postHorizontalAttr['postID'] = get_the_ID();
                if($postIcon !== 'disable') {
                    $addClass = 'overlay-item--sm-p';
                    $postIconAttr['iconType'] = tnm_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition'], $addClass);
                    $postHorizontalAttr['postIcon'] = $postIconAttr;
                }
                $render_modules .= '<div class="list-item">';
                $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                $render_modules .= '</div>';
            endwhile;
            
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        static function listing_list_alt_a__render($moduleID) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postHorizontalHTML = new tnm_horizontal_1;
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'meta'          => 3,
                'cat'           => 3,
                'excerpt'       => 1,
            );
            tnm_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
            $cat = 3; //Above the Title - No BG
            $cat_Class = tnm_core::bk_get_cat_class($cat);
            
            $postHorizontalAttr = array (
                'additionalClass'   => '',
                'cat'               => $cat,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'tnm-xs-4_3',
                'typescale'         => 'typescale-2',
                'except_length'     => 23,
                'meta'              => array('author', 'date', 'comment'),
                'postIcon'          => $postIconAttr,  
            );
            
			$render_modules .= '<div class="posts-list list-unstyled list-space-xl">';
            
            while (have_posts()): the_post();                 
                $currentPost = $wp_query->current_post;
                $postHorizontalAttr['postID'] = get_the_ID();
                $postHorizontalAttr['additionalClass'] = 'post--horizontal-sm';
                
                if($postIcon !== 'disable') {
                    $addClass = 'overlay-item--sm-p';
                    $postIconAttr['iconType'] = tnm_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition'], $addClass);
                    $postHorizontalAttr['postIcon'] = $postIconAttr;
                }
                if($currentPost % 5) : //Normal Posts 
                    $postHorizontalAttr['additionalClass'] = 'post--horizontal-sm';
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</div>';
                else: //Large Posts
                    $postHorizontalAttr_L = $postHorizontalAttr;
                    $postHorizontalAttr_L['typescale'] = 'typescale-3';
                    $postHorizontalAttr_L['additionalClass'] = '';
                    $postHorizontalAttr_L['postIcon']['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $moduleInfo['iconPosition']);
                    
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr_L);
                    $render_modules .= '</div>';
                endif;
            endwhile;
            
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        static function listing_list_alt_b__render($moduleID) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postHorizontalHTML = new tnm_horizontal_1;
            $postOverlayHTML = new tnm_overlay_1;
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition_l'  => 'top-right',
                'iconPosition_s'  => 'top-right',
                'meta_l'          => 3,
                'cat_l'           => 1,
                'excerpt_l'       => 1,
                'meta_s'          => 3,
                'cat_s'           => 3,
                'excerpt_s'       => 1,
                'footer_style'    => '1-col',
            );
            tnm_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
            $cat_L = 1; //Above the Title - No BG
            $cat_L_Class = tnm_core::bk_get_cat_class($cat_L);
            
            $cat_S = 3; //Above the Title - No BG
            $cat_S_Class = tnm_core::bk_get_cat_class($cat_S);
            
            $postOverlayAttr = array (
                'additionalClass'   => 'post--overlay-floorfade post--overlay-bottom post--overlay-sm post--overlay-padding-lg',
                'cat'               => $cat_L,
                'catClass'          => $cat_L_Class,
                'thumbSize'         => 'tnm-m-16_9',
                'typescale'         => 'typescale-4',
                'footerType'            => '1-col',
                'additionalMetaClass'   => '',
                'except_length'     => 23,
                'meta'              => array('author', 'date', 'comment'),
                'postIcon'          => $postIconAttr,  
            );
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-sm',
                'cat'               => $cat_S,
                'catClass'          => $cat_S_Class,
                'thumbSize'         => 'tnm-xs-4_3',
                'typescale'         => 'typescale-2',
                'except_length'     => 23,
                'meta'              => array('author', 'date', 'comment'),
                'postIcon'          => $postIconAttr,  
            );
            
			$render_modules .= '<div class="posts-list list-unstyled list-space-xl">';
            
            while (have_posts()): the_post();                 
                $currentPost = $wp_query->current_post;                
                
                if($currentPost % 5) : //Small Posts
                    $postHorizontalAttr['postID'] = get_the_ID();
                    $postHorizontalAttr['additionalClass'] = 'post--horizontal-sm';
                    
                    if($postIcon !== 'disable') {
                        $addClass = 'overlay-item--sm-p';
                        $postIconAttr['iconType'] = tnm_core::bk_post_format_detect(get_the_ID());
                        $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition_s'], $addClass);
                        $postHorizontalAttr['postIcon'] = $postIconAttr;
                    }
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</div>';
                else: //Large Posts
                    $postOverlayAttr['postID'] = get_the_ID();
                    
                    if($postIcon !== 'disable') {
                        $postIconAttr['iconType'] = tnm_core::bk_post_format_detect(get_the_ID());
                        if($postIconAttr['iconType'] == 'gallery') {
                            $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                        }else {
                            $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $moduleInfo['iconPosition_l']);
                        }
                        
                        $postOverlayAttr['postIcon']    = $postIconAttr;
                    }
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                    $render_modules .= '</div>';
                endif;
                
            endwhile;
            
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        static function listing_list_alt_c__render($moduleID) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postHorizontalHTML = new tnm_horizontal_1;
            $postVerticalHTML = new tnm_vertical_1;

            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition_l'  => 'top-right',
                'iconPosition_s'  => 'top-right',
                'meta_l'          => 3,
                'cat_l'           => 1,
                'excerpt_l'       => 1,
                'meta_s'          => 3,
                'cat_s'           => 3,
                'excerpt_s'       => 1,
                'footer_style'    => '1-col',
            );
            tnm_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
            $cat_L = 1; //Above the Title - No BG
            $cat_L_Class = tnm_core::bk_get_cat_class($cat_L);
            
            $cat_S = 3; //Above the Title - No BG
            $cat_S_Class = tnm_core::bk_get_cat_class($cat_S);

            $postVerticalAttr = array (
                'cat'           => $cat_L,
                'catClass'      => $cat_L_Class,
                'thumbSize'     => 'tnm-m-2_1',
                'typescale'     => 'typescale-4',
                'additionalExcerptClass' => 'post__excerpt--lg',
                'except_length' => 23,
                'meta'          => array('author', 'date', 'comment'),
                'postIcon'      => $postIconAttr,    
                'additionalTextClass'   => '',
            );
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-sm',
                'cat'               => $cat_S,
                'catClass'          => $cat_S_Class,
                'thumbSize'         => 'tnm-xs-4_3',
                'typescale'         => 'typescale-2',
                'except_length'     => 23,
                'meta'              => array('author', 'date', 'comment'),
                'postIcon'          => $postIconAttr,  
            );
            
			$render_modules .= '<div class="posts-list list-unstyled list-space-xl">';
            
            while (have_posts()): the_post();                 
                $currentPost = $wp_query->current_post;                
                
                if($currentPost % 5) : //Small Posts
                    $postHorizontalAttr['postID'] = get_the_ID();
                    $postHorizontalAttr['additionalClass'] = 'post--horizontal-sm';
                    
                    if($postIcon !== 'disable') {
                        $addClass = 'overlay-item--sm-p';
                        $postIconAttr['iconType'] = tnm_core::bk_post_format_detect(get_the_ID());
                        $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition_s'], $addClass);
                        $postHorizontalAttr['postIcon'] = $postIconAttr;
                    }
                    
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</div>';
                else: //Large Posts
                    $postVerticalAttr['postID'] = get_the_ID();
                    
                    if($postIcon !== 'disable') {
                        $postIconAttr['iconType'] = tnm_core::bk_post_format_detect(get_the_ID());
                        $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $moduleInfo['iconPosition_l']);
                        $postVerticalAttr['postIcon']    = $postIconAttr;
                    }
                    
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                    $render_modules .= '</div>';
                endif;
                
            endwhile;
            
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        static function listing_grid__render($moduleID, $pagination) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            $postVerticalHTML = new tnm_vertical_1;
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'meta'          => 2,
                'cat'           => 1,
                'excerpt'       => 1,
            );
            tnm_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
            $cat = 1; //Top - Left
            $cat_Class = tnm_core::bk_get_cat_class($cat);
            
            $postVerticalAttr = array (
                'additionalClass'   => '',
                'cat'               => $cat,
                'catClass'          => $cat_Class,
                'thumbSize'         => 'tnm-xs-2_1',
                'typescale'         => 'typescale-2',
                'except_length'     => 17,
                'meta'              => array('author', 'date'),
                'postIcon'          => $postIconAttr,  
            );
            
			$render_modules .= '<div class="posts-list">';
            
            $openRow = '<div class="row row--space-between">';
            $closeRow = '</div><!--Close Row -->';
            
            if($pagination == 'ajax-loadmore') :
                while (have_posts()): the_post();                 
                    $currentPost = $wp_query->current_post;
                    if($currentPost%2 == 0) {
                        $render_modules_tmp = '';
                        $render_modules_tmp .= $openRow;
                    }          
                    $postVerticalAttr['postID'] = get_the_ID();
                    
                    if($postIcon !== 'disable') {
                        $postIconAttr['iconType'] = tnm_core::bk_post_format_detect(get_the_ID());
                        $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition']);
                        $postVerticalAttr['postIcon'] = $postIconAttr;
                    }
                    
                    $render_modules_tmp .= '<div class="col-xs-12 col-sm-6">';
                    $render_modules_tmp .= $postVerticalHTML->render($postVerticalAttr);
                    $render_modules_tmp .= '</div>';
                    if($currentPost%2 == 1) {
                        $render_modules_tmp .= $closeRow;
                        $render_modules .=$render_modules_tmp;
                    } 
                    if(($currentPost%2 == 0) && ($wp_query->post_count == 1)) {
                        $render_modules_tmp .= $closeRow;
                        $render_modules .= $render_modules_tmp;
                    }
                endwhile;
            else:
                while (have_posts()): the_post();                 
                    $currentPost = $wp_query->current_post;
                    
                    if($postIcon !== 'disable') {
                        $postIconAttr['iconType'] = tnm_core::bk_post_format_detect(get_the_ID());
                        $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition']);
                        $postVerticalAttr['postIcon'] = $postIconAttr;
                    }
                    
                    if($currentPost%2 == 0) {
                        $render_modules .= $openRow;
                    } 
                    
                    $postVerticalAttr['postID'] = get_the_ID();
                    $render_modules .= '<div class="col-xs-12 col-sm-6">';
                    $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                    $render_modules .= '</div>';
                    if($currentPost%2 == 1) {
                        $render_modules .= $closeRow;
                    } 
                endwhile;
                if($currentPost%2 != 1) {
                    $render_modules .= $closeRow;
                } 
            endif;
            
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        static function listing_grid_alt_a__render($moduleID, $pagination) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition_l'  => 'top-right',
                'iconPosition_s'  => 'top-right',
                'meta_l'          => 3,
                'cat_l'           => 1,
                'excerpt_l'       => 1,
                'meta_s'          => 2,
                'cat_s'           => 1,
                'excerpt_s'       => 1,
                'footer_style'    => '1-col',
            );
            tnm_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
            $cat_L = 1; //Top - Left
            $cat_L_Class = tnm_core::bk_get_cat_class($cat_L);
            
            $cat_S = 1; //Top - Left
            $cat_S_Class = tnm_core::bk_get_cat_class($cat_S);
            
            $postVerticalHTML = new tnm_vertical_1;
            $postOverlayHTML = new tnm_overlay_1;
            $postOverlayAttr = array (
                'additionalClass'   => 'post--overlay-floorfade post--overlay-bottom post--overlay-md post--overlay-padding-lg',
                'additionalExcerptClass' => 'hidden-xs',
                'cat'               => $cat_L,
                'catClass'          => $cat_L_Class,
                'thumbSize'         => 'tnm-m-16_9',
                'typescale'         => 'typescale-4',
                'footerType'            => '1-col',
                'additionalMetaClass'   => '',
                'except_length'     => 23,
                'meta'              => array('author', 'date', 'comment'),
                'postIcon'          => $postIconAttr,  
            );
            $postVerticalAttr = array (
                'cat'               => $cat_S,
                'catClass'          => $cat_S_Class,
                'thumbSize'         => 'tnm-xs-2_1',
                'typescale'         => 'typescale-2',
                'except_length'     => 17,
                'meta'              => array('author', 'date'),
                'postIcon'          => $postIconAttr,      
            );
            
			$render_modules .= '<div class="posts-list">';
            
            $openRow = '<div class="row row--space-between">';
            $closeRow = '</div><!--Close Row -->';
            
            if($pagination == 'ajax-loadmore') :
                while (have_posts()): the_post();
                    $currentPost = $wp_query->current_post;
                    $currentPostINBLK = $currentPost % 5; //1 BLK has 5 Posts (Include: 1 Large Post and 4 Small Posts))
                    if(($currentPostINBLK == 1) || ($currentPostINBLK == 3)) {
                        $render_modules_tmp = '';
                        $render_modules_tmp .= $openRow;
                    }
                    if($currentPostINBLK % 5) : //Small Posts
                        $postVerticalAttr['postID'] = get_the_ID();
                        
                        if($postIcon !== 'disable') {
                            $postIconAttr['iconType']       = tnm_core::bk_post_format_detect(get_the_ID());
                            $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition_s']);
                            $postVerticalAttr['postIcon']   = $postIconAttr;
                        }
                        
                        $render_modules_tmp .= '<div class="col-xs-12 col-sm-6">';
                        $render_modules_tmp .= $postVerticalHTML->render($postVerticalAttr);
                        $render_modules_tmp .= '</div>';
                    else: //Large Posts
                        $postOverlayAttr['postID'] = get_the_ID();
                        
                        if($postIcon !== 'disable') {
                            $postIconAttr['iconType']   = tnm_core::bk_post_format_detect(get_the_ID());
                            if($postIconAttr['iconType'] == 'gallery') {
                                $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                            }else {
                                $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $moduleInfo['iconPosition_l']);
                            }
                            $postOverlayAttr['postIcon']    = $postIconAttr;
                        }
                        
                        $render_modules .= $openRow;
                        $render_modules .= '<div class="col-xs-12">';
                        $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                        $render_modules .= '</div>';
                        $render_modules .= $closeRow;
                    endif;
                                        
                    if(($currentPostINBLK == 2) || ($currentPostINBLK == 4)) {
                        $render_modules_tmp .= $closeRow;
                        $render_modules .= $render_modules_tmp;
                    } 
                    if((($currentPostINBLK == 1) || ($currentPostINBLK == 3)) && ($wp_query->post_count == 1)) {
                        $render_modules_tmp .= $closeRow;
                        $render_modules .= $render_modules_tmp;
                    }
                endwhile;
            else :
                while (have_posts()): the_post();
                    $currentPost = $wp_query->current_post;
                    $currentPostINBLK = $currentPost % 5; //1 BLK has 5 Post (Include: 1 Large Post and 4 Small Post))
                    if(($currentPostINBLK == 1) || ($currentPostINBLK == 3)) {
                        $render_modules .= $openRow;
                    }
                    if($currentPostINBLK % 5) : // Normal Posts
                        $postVerticalAttr['postID'] = get_the_ID();
                        
                        if($postIcon !== 'disable') {
                            $postIconAttr['iconType']       = tnm_core::bk_post_format_detect(get_the_ID());
                            $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition_s']);
                            $postVerticalAttr['postIcon']   = $postIconAttr;
                        }
                        $render_modules .= '<div class="col-xs-12 col-sm-6">';
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                        $render_modules .= '</div>';
                    else: // Large Posts
                        $postOverlayAttr['postID'] = get_the_ID();
                        
                        if($postIcon !== 'disable') {
                            $postIconAttr['iconType']   = tnm_core::bk_post_format_detect(get_the_ID());
                            if($postIconAttr['iconType'] == 'gallery') {
                                $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                            }else {
                                $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $moduleInfo['iconPosition_l']);
                            }
                            $postOverlayAttr['postIcon']    = $postIconAttr;
                        }
                        $render_modules .= $openRow;
                        $render_modules .= '<div class="col-xs-12">';
                        $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                        $render_modules .= '</div>';
                        $render_modules .= $closeRow;
                    endif;
                                        
                    if(($currentPostINBLK == 2) || ($currentPostINBLK == 4)) {
                        $render_modules .= $closeRow;
                    } 
                endwhile;
    
                if(($currentPostINBLK == 1) || ($currentPostINBLK == 3)) {
                    $render_modules .= $closeRow;
                } 
            endif;
            
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        static function listing_grid_alt_b__render($moduleID, $pagination) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition_l'  => 'top-right',
                'iconPosition_s'  => 'top-right',
                'meta_l'          => 3,
                'cat_l'           => 1,
                'excerpt_l'       => 1,
                'meta_s'          => 2,
                'cat_s'           => 1,
                'excerpt_s'       => 1,
                'footer_style'    => '1-col',
            );
            tnm_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
            $cat_L = 1; //Top - Left
            $cat_L_Class = tnm_core::bk_get_cat_class($cat_L);
            
            $cat_S = 1; //Top - Left
            $cat_S_Class = tnm_core::bk_get_cat_class($cat_S);
            
            $postVerticalHTML = new tnm_vertical_1;
            $postVerticalAttr_L = array (
                'cat'           => $cat_L,
                'catClass'      => $cat_L_Class,
                'thumbSize'     => 'tnm-m-2_1',
                'typescale'     => 'typescale-4',
                'additionalExcerptClass' => 'post__excerpt--lg',
                'except_length' => 23,
                'meta'          => array('author', 'date', 'comment'),
                'postIcon'      => $postIconAttr,    
                'additionalTextClass'   => '',
            );
            $postVerticalAttr = array (
                'cat'               => $cat_S,
                'catClass'          => $cat_S_Class,
                'thumbSize'         => 'tnm-xs-2_1',
                'typescale'         => 'typescale-2',
                'except_length'     => 17,
                'meta'              => array('author', 'date'),
                'postIcon'          => $postIconAttr,      
            );
            
			$render_modules .= '<div class="posts-list">';
            
            $openRow = '<div class="row row--space-between">';
            $closeRow = '</div><!--Close Row -->';
            
            if($pagination == 'ajax-loadmore') :
                while (have_posts()): the_post();
                    $currentPost = $wp_query->current_post;
                    $currentPostINBLK = $currentPost % 5; //1 BLK has 5 Posts (Include: 1 Large Post and 4 Small Posts))
                    if(($currentPostINBLK == 1) || ($currentPostINBLK == 3)) {
                        $render_modules_tmp = '';
                        $render_modules_tmp .= $openRow;
                    }
                    if($currentPostINBLK % 5) : //Small Posts
                        $postVerticalAttr['postID'] = get_the_ID();
                        
                        if($postIcon !== 'disable') {
                            $postIconAttr['iconType']       = tnm_core::bk_post_format_detect(get_the_ID());
                            $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition_s']);
                            $postVerticalAttr['postIcon']   = $postIconAttr;
                        }
                        
                        $render_modules_tmp .= '<div class="col-xs-12 col-sm-6">';
                        $render_modules_tmp .= $postVerticalHTML->render($postVerticalAttr);
                        $render_modules_tmp .= '</div>';
                    else: //Large Posts
                        $postVerticalAttr_L['postID'] = get_the_ID();
                        
                        if($postIcon !== 'disable') {
                            $postIconAttr['iconType']       = tnm_core::bk_post_format_detect(get_the_ID());
                            $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $moduleInfo['iconPosition_l']);
                            $postVerticalAttr_L['postIcon'] = $postIconAttr;
                        }
                        $render_modules .= $openRow;
                        $render_modules .= '<div class="col-xs-12">';
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr_L);
                        $render_modules .= '</div>';
                        $render_modules .= $closeRow;
                    endif;
                                        
                    if(($currentPostINBLK == 2) || ($currentPostINBLK == 4)) {
                        $render_modules_tmp .= $closeRow;
                        $render_modules .= $render_modules_tmp;
                    } 
                    if((($currentPostINBLK == 1) || ($currentPostINBLK == 3)) && ($wp_query->post_count == 1)) {
                        $render_modules_tmp .= $closeRow;
                        $render_modules .= $render_modules_tmp;
                    }
                endwhile;
            else:
                while (have_posts()): the_post();
                    $currentPost = $wp_query->current_post;
                    $currentPostINBLK = $currentPost % 5; //1 BLK has 5 Post (Include: 1 Large Post and 4 Small Post))
                    if(($currentPostINBLK == 1) || ($currentPostINBLK == 3)) {
                        $render_modules .= $openRow;
                    }
                    if($currentPostINBLK % 5) : // Normal Posts
                        $postVerticalAttr['postID'] = get_the_ID();
                        
                        if($postIcon !== 'disable') {
                            $postIconAttr['iconType']       = tnm_core::bk_post_format_detect(get_the_ID());
                            $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], '', $moduleInfo['iconPosition_s']);
                            $postVerticalAttr['postIcon']   = $postIconAttr;
                        }
                        
                        $render_modules .= '<div class="col-xs-12 col-sm-6">';
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                        $render_modules .= '</div>';
                    else: // Large Posts
                        $postVerticalAttr_L['postID']   = get_the_ID();
                        
                        if($postIcon !== 'disable') {
                            $postIconAttr['iconType']       = tnm_core::bk_post_format_detect(get_the_ID());
                            $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $moduleInfo['iconPosition_l']);
                            $postVerticalAttr_L['postIcon'] = $postIconAttr;
                        }
                        $render_modules .= $openRow;
                        $render_modules .= '<div class="col-xs-12">';
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr_L);
                        $render_modules .= '</div>';
                        $render_modules .= $closeRow;
                    endif;
                                        
                    if(($currentPostINBLK == 2) || ($currentPostINBLK == 4)) {
                        $render_modules .= $closeRow;
                    } 
                endwhile;
    
                if(($currentPostINBLK == 1) || ($currentPostINBLK == 3)) {
                    $render_modules .= $closeRow;
                } 
                
            endif;
            
            $render_modules .= '</div>';
            
            return $render_modules;
        }
        static function listing_grid_small__render($moduleID) {
            global $wp_query;
            $render_modules = '';
            $currentPost = 0;
            
            $postIcon = self::bk_archive_pages_post_icon();
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';

            $moduleInfo = array(
                'post_source'   => 'all',
                'post_icon'     => $postIcon,
                'iconPosition'  => 'top-right',
                'meta'          => 2,
                'cat'           => 1,
            );
            tnm_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            $cat = 1; //Top - Left
            $cat_Class = tnm_core::bk_get_cat_class($cat);
            
            $postVerticalHTML = new tnm_vertical_1;
            $postVerticalAttr = array (
                'cat'           => $cat,
                'catClass'      => $cat_Class,
                'thumbSize'     => 'tnm-xs-2_1',
                'typescale'     => 'typescale-1',
                'meta'          => array('author', 'date'),
                'postIcon'      => $postIconAttr,     
            );
            
			$render_modules .= '<div class="posts-listing">';
            
            $render_modules .= '<div class="row row--space-between posts-list">';
            
            while (have_posts()): the_post();
                $currentPost = $wp_query->current_post;
                $currentPostINBLK = $currentPost % 6; //1 BLK has 6 Post
                if(($currentPostINBLK == 2) || ($currentPostINBLK == 4)) {
                    $render_modules .= '<div class="clearfix visible-sm"></div>';
                }elseif($currentPostINBLK == 3) {
                    $render_modules .= '<div class="clearfix visible-md visible-lg"></div>';
                }elseif(($currentPostINBLK == 0) && ($currentPost != 0)){
                    $render_modules .= '<div class="clearfix hidden-xs"></div>';
                }
                $postVerticalAttr['postID'] = get_the_ID();
                
                if($postIcon !== 'disable') {
                    $addClass = 'overlay-item--sm-p';
                    $postIconAttr['iconType']       = tnm_core::bk_post_format_detect(get_the_ID());
                    $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], 'small', $moduleInfo['iconPosition'], $addClass);
                    $postVerticalAttr['postIcon']   = $postIconAttr;
                }
                $render_modules .= '<div class="col-xs-12 col-sm-6 col-md-4">';
                $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                $render_modules .= '</div>';
            endwhile;
            
            $render_modules .= '</div><!-- .row - posts-list -->';
            $render_modules .= '</div><!-- .posts-listing -->';
            
            return $render_modules;
        }
        static function author_box($authorID){  
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
            
            $render = '';
            $render .= '<div class="author-box">';
            $render .= '<div class="author-box__image">';
            $render .= '<div class="author-avatar">';
            $render .= get_avatar($authorID, '180', '', esc_attr($authorImgALT), $authorArgs);
            $render .= '</div>';
            $render .= '</div>';
            $render .= '<div class="author-box__text">';
            $render .= '<div class="author-name meta-font">';
            $render .= '<a href="'.get_author_posts_url($authorID).'" title="Posts by '.esc_attr($bk_author_name).'" rel="author">'.esc_attr($bk_author_name).'</a>';
            $render .= '</div>';
            $render .= '<div class="author-bio">';
            $render .= $bk_author_desc;
            $render .= '</div>';
            $render .= '<div class="author-info">';
            $render .= '<div class="row row--space-between row--flex row--vertical-center grid-gutter-20">';
            $render .= '<div class="author-socials col-xs-12 col-sm-6">';
            $render .= '<ul class="list-unstyled list-horizontal list-space-sm">';

            if (($bk_author_email != NULL) || ($bk_author_www != NULL) || ($bk_author_go != NULL) || ($bk_author_tw != NULL) || ($bk_author_fb != NULL) ||($bk_author_yo != NULL)) {
                if ($bk_author_email != NULL) { $render .= '<li><a href="mailto:'. esc_attr($bk_author_email) .'"><i class="mdicon mdicon-mail_outline"></i><span class="sr-only">e-mail</span></a></li>'; } 
                if ($bk_author_www != NULL) { $render .= ' <li><a href="'. esc_url($bk_author_www) .'" target="_blank"><i class="mdicon mdicon-public"></i><span class="sr-only">Website</span></a></li>'; } 
                if ($bk_author_tw != NULL) { $render .= ' <li><a href="'. esc_url($bk_author_tw).'" target="_blank" ><i class="mdicon mdicon-twitter"></i><span class="sr-only">Twitter</span></a></li>'; } 
                if ($bk_author_go != NULL) { $render .= ' <li><a href="'. esc_url($bk_author_go) .'" rel="publisher" target="_blank"><i class="mdicon mdicon-google-plus"></i><span class="sr-only">Google+</span></a></li>'; }
                if ($bk_author_fb != NULL) { $render .= ' <li><a href="'. esc_url($bk_author_fb) . '" target="_blank" ><i class="mdicon mdicon-facebook"></i><span class="sr-only">Facebook</span></a></li>'; }
                if ($bk_author_yo != NULL) { $render .= ' <li><a href="http://www.youtube.com/user/'. esc_attr($bk_author_yo) . '" target="_blank" ><span class="sr-only">Youtube</span></a></li>'; }
            }       
                               
            $render .= '</ul>';
            $render .= '</div>';
            $render .= '</div>';
            $render .= '</div>';
            
            $render .= '</div>';
            $render .= '</div>';
            
            return $render;
        }
    } // Close tnm_archive class
    
}
