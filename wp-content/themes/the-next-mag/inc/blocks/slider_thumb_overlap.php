<?php
if (!class_exists('tnm_slider_thumb_overlap')) {
    class tnm_slider_thumb_overlap {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_slider_thumb_overlap-');
            
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config   
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit', true );
            $moduleConfigs['offset']    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );
            
            //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            $moduleConfigs['post_icon'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true );      
            $the_query = bk_get_query::tnm_query($moduleConfigs);              //get query
            
            if($moduleConfigs['limit'] > 1) :
                $carouselEn__Class = 'owl-carousel js-carousel-1i30m';
            else :
                $carouselEn__Class = '';                            
            endif;
            
            if ( $the_query->have_posts() ) :
                $block_str .= '<div id="'.$moduleID.'" class="mnmd-block mnmd-block--fullwidth mnmd-carousel mnmd-carousel-thumb-overlap mnmd-carousel-nav-none carousel-stage-visible">';
               	$block_str .= '<div class="container fullwidth-xs">';
                $block_str .= '<div class="mnmd-carousel__inner '.$carouselEn__Class.'">';
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
            $postOverlapHTML = new tnm_thumb_overlap;
            
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
                $catStyle = 4;
                $cat_Class = tnm_core::bk_get_cat_class($catStyle);
            }else {
                $catStyle = '';
                $cat_Class = '';
            }
            
            $excerpt = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_excerpt', true );
            
            if($excerpt == 1){
                $exceptLength = 30;
            }else {
                $exceptLength = '';
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
            
            $postOverlapAttr = array (
                'thumbSize'         => 'tnm-s-1_1',
                'thumbSizeMobile'   => 'tnm-xs-2_1',
                'cat'               => $catStyle,
                'catClass'          => $cat_Class,
                'typescale'         => 'typescale-5',
                'except_length'     => $exceptLength,
                'additionalExcerptClass' => 'hidden-xs hidden-sm',
                'meta'              => $metaArray,           
                'postIcon'          => $postIconAttr,                      
            );
            $render_modules = '';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postOverlapAttr['postID'] = get_the_ID();
                if($bypassPostIconDetech != 1) {
                    if($postSource != 'all') {
                        $postIconAttr['iconType'] = $postSource;
                    }else {
                        $postIconAttr['iconType']   = tnm_core::bk_post_format_detect(get_the_ID());
                    }
                    
                    if($postIconAttr['iconType'] == 'review') {
                        $iconPosition = 'top-right';
                    }else {
                        $iconPosition = 'center';
                    }
                    
                    $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], 'large', $iconPosition);
                    
                    $postOverlapAttr['postIcon']    = $postIconAttr;
                }
                $render_modules .= '<div class="slide-content">';
                $render_modules .= $postOverlapHTML->render($postOverlapAttr);
                $render_modules .= '</div>';
            endwhile;
            
            return $render_modules;
        }
    }
}