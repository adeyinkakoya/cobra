<?php
if (!class_exists('tnm_carousel_card_4i')) {
    class tnm_carousel_card_4i {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_carousel_card_4i-');
            $carouselID = uniqid('carousel-');
            
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            $moduleConfigs['carouselID'] = $carouselID;
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
            
            if($the_query->post_count < 5):
                $moduleConfigs['carousel_loop'] = 0;
            endif;
            
            if($moduleConfigs['carousel_dot_nav'] != 1) {
                $dotNavClass = 'mnmd-carousel-dots-none';
            }else {
                $dotNavClass = '';
            }
            
            if ( $the_query->have_posts() ) :
                $block_str .= '<div id="'.$moduleID.'" class="mnmd-block mnmd-block--fullwidth mnmd-carousel '.$dotNavClass.'">';
               	$block_str .= '<div class="container">';
                $block_str .= tnm_core::bk_get_block_heading($moduleConfigs['title'], $headingClass, $viewallButton);
                
                $block_str .= '<div id="'.$carouselID.'" class="mnmd-carousel__inner owl-carousel js-carousel-4i20m" data-carousel-loop="'.$moduleConfigs['carousel_loop'].'">';
                $block_str .= $this->render_modules($the_query);            //render modules
                $block_str .= '</div>';
                
                $block_str .= '</div><!-- .container -->';
                $block_str .= '</div><!-- .mnmd-block -->';
                        
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_modules ($the_query){
            $postCardHTML = new tnm_card_1;
            $render_modules = '';
            
            $postCardHTML = new tnm_card_1;
            
            $footerStyle = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_footer_style', true );
            
            $iconPosition = 'center';
            
            // Meta
            $meta = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_meta', true );
            
            if($meta != 0) {
                $metaArray = tnm_core::bk_get_meta_list($meta);
            }else {
                $metaArray = '';
            }
            
            // Category Style ($cat)
            $cat = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_cat_style', true );
            if($cat != 0){
                $catStyle = 2; //Overlap
                $cat_Class = tnm_core::bk_get_cat_class($catStyle);
                $articleAddtionalClass = '';
            }else {
                $catStyle = '';
                $cat_Class = '';
                $articleAddtionalClass = 'cat--not-overlap';
            }
            
            $postSource = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_source', true );
            $postIcon = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon', true );
            $bypassPostIconDetech = 0;         
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            if($postIcon == 'disable') {
                $bypassPostIconDetech = 1;
            }else {
                $bypassPostIconDetech = 0;
            }            
            
            if ( $the_query->have_posts() ) :
                $postCardAttr = array (
                    'additionalClass'   => 'post--card-sm text-center '.$articleAddtionalClass,
                    'cat'               => $catStyle,
                    'catClass'          => $cat_Class,
                    'thumbSize'         => 'tnm-xs-16_9 400x225',
                    'typescale'         => 'typescale-1',
                    'meta'              => $metaArray,
                    'footerType'        => $footerStyle,
                    'postIcon'          => $postIconAttr,       
                );
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $postCardAttr['postID'] = get_the_ID();
                    if($bypassPostIconDetech != 1) {
                        $addClass = 'overlay-item--sm-p';
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType']   = tnm_core::bk_post_format_detect(get_the_ID());
                        }

                        $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition, $addClass);
                        
                        $postCardAttr['postIcon']    = $postIconAttr;
                    }
                    $render_modules .= '<div class="slide-content">';
                    $render_modules .= $postCardHTML->render($postCardAttr);
                    $render_modules .= '</div>';
                endwhile;
            endif;
            
            return $render_modules;
        }
    }
}