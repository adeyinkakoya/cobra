<?php
if (!class_exists('tnm_carousel_overlay_post_main_col_3i_2')) {
    class tnm_carousel_overlay_post_main_col_3i_2 {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_carousel_overlay_post_main_col_3i_2-');
            $carouselID = uniqid('carousel-');
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            $moduleConfigs['title']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );
            $moduleConfigs['carousel_loop'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_carousel_loop', true );   
            $moduleConfigs['carousel_dot_nav'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_carousel_dot_nav', true ); 
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true );  
            $moduleConfigs['limit']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit', true );
            $moduleConfigs['offset']    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );
            $moduleConfigs['load_more'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_load_more', true );
            
            $moduleConfigs['heading_style'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_style', true );
            $moduleConfigs['heading_inverse'] = 'no';
            
            $viewallButton = array();
            if (($moduleConfigs['load_more'] == 'viewall') && ($moduleConfigs['heading_style'] != 'center') && ($moduleConfigs['heading_style'] != 'large-center') && ($moduleConfigs['heading_style'] != 'line-around') && ($moduleConfigs['heading_style'] != 'large-line-around')) :           
                $viewallButton['view_all_link'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_link', true );
                $viewallButton['view_all_text'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_text', true );
                $viewallButton['view_all_target'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_target', true );
            endif;
            
            if(isset($moduleConfigs['heading_style'])) {
                $headingClass = tnm_core::bk_get_block_heading_class($moduleConfigs['heading_style'], $moduleConfigs['heading_inverse']);
            }
            
            //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            $moduleConfigs['post_icon'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true );      
            $the_query = bk_get_query::tnm_query($moduleConfigs);              //get query
            
            if($the_query->post_count < 4):
                $moduleConfigs['carousel_loop'] = 0;
            endif;
            
            if($moduleConfigs['carousel_dot_nav'] != 1) {
                $dotNavClass = 'mnmd-carousel-dots-none mnmd-carousel-nav-c';
            }else {
                $dotNavClass = '';
            }
            
            if ( $the_query->have_posts() ) :
                $block_str .= '<div id="'.$moduleID.'" class="mnmd-block mnmd-carousel '.$dotNavClass.'">';
                $block_str .= tnm_core::bk_get_block_heading($moduleConfigs['title'], $headingClass, $viewallButton);
                
                $block_str .= '<div id="'.$carouselID.'" class="mnmd-carousel__inner owl-carousel js-carousel-3i4m" data-carousel-loop="'.$moduleConfigs['carousel_loop'].'">';
                $block_str .= $this->render_modules($the_query);            //render modules
                $block_str .= '</div>';
                                
                $block_str .= '</div><!-- .mnmd-block -->';
                        
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_modules ($the_query){
            $postOverlayHTML = new tnm_overlay_3;
            $render_modules = '';
            
            // Meta
            $meta = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_meta', true );
            
            if($meta != 0) {
                $metaArray = tnm_core::bk_get_meta_list($meta);
            }else {
                $metaArray = '';
            }
            
            // Category Style ($cat)
            $cat = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_cat_style', true );
            
            $postSource = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_source', true );
            $postIcon = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon', true );
            $bypassPostIconDetech = 0;         
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            if(($postIcon == 'enable') && ($postSource != 'all')) {
                $bypassPostIconDetech = 1;
                $postIconAttr['iconType'] = $postSource;
                $postIconAttr['postIconClass'] = $this->get_post_icon_class($postSource);
            }elseif($postIcon == 'disable') {
                $bypassPostIconDetech = 1;
            }else {
                $bypassPostIconDetech = 0;
            }
            
            if ( $the_query->have_posts() ) :
                $postOverlayAttr = array (
                    'additionalClass'   => 'post--overlay-sm has-badge-bottom',
                    'additionalBGClass' => 'background-img--darkened',
                    'cat'               => $cat?4:0,
                    'catClass'          => 'post__cat post__cat--bg cat-theme-bg',
                    'thumbSize'         => 'tnm-xs-1_1',
                    'meta'              => $metaArray,
                    'typescale'         => 'typescale-2',
                    'additionalTextClass'   => 'inverse-text text-center',
                    'postIcon'          => $postIconAttr,                        
                );
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $postOverlayAttr['postID'] = get_the_ID();
                    if($bypassPostIconDetech != 1) {
                        $postIconAttr['iconType']       = tnm_core::bk_post_format_detect(get_the_ID());
                        $postIconAttr['postIconClass']  = $this->get_post_icon_class($postIconAttr['iconType']);
                        $postOverlayAttr['postIcon']       = $postIconAttr;
                    }
                    $render_modules .= '<div class="slide-content">';
                    $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                    $render_modules .= '</div>';
                endwhile;
            endif;
            
            return $render_modules;
        }
        public function get_post_icon_class($postSource){
            
            $postIconClass = '';
            
            if(($postSource == 'video') || ($postSource == 'review')) {
                $postIconClass = 'badge-bottom';
            }elseif($postSource == 'gallery'){
                $postIconClass = '';
            }else {
                return '';
            }
            
            return $postIconClass;
            
        }
    }
}