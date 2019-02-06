<?php
if (!class_exists('tnm_featured_block_b')) {
    class tnm_featured_block_b {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_featured_block_b-');
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            $contiguousClass = 'mnmd-block--contiguous';
            
            $moduleConfigs['orderby']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true );
            $moduleConfigs['bg_option'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_bg_option', true );
            $moduleConfigs['offset'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );
            $moduleConfigs['limit'] = 4;
            
            //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            $moduleConfigs['post_icon'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true );      
            
            $the_query = bk_get_query::tnm_query($moduleConfigs);              //get query
            
            if ( $the_query->have_posts() ) :
            $block_str .= '<div id="'.$moduleID.'" class="mnmd-block mnmd-block--fullwidth mnmd-featured-block-b '.$contiguousClass.'">';
            
            if($moduleConfigs['bg_option'] == 'image') :
                $moduleConfigs['background_img'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_img', true );            
                $imgBGStyle = "background-image: url('".$moduleConfigs['background_img']."')";
                $block_str .= '<div class="mnmd-block__background background-img" style="'.$imgBGStyle.'"></div>';
            else:
                $gradient_bg__from  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_gradient_from', true );
                $gradient_bg__to    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_gradient_to', true );
                $gradient_bg__direction = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_gradient_direction', true );
                $background_pattern  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_pattern', true );
                $patternHTML = '';
                if($background_pattern == 1) :
                    $patternHTML = '<div class="background-svg-pattern"></div>';
                endif; 
                $block_str .= '<div class="mnmd-block__background background-img gradient-5" style="
                    background: '.$gradient_bg__from.';
                    background: -webkit-linear-gradient('.$gradient_bg__direction.'deg, '.$gradient_bg__from.' 0, '.$gradient_bg__to.' 100%);
                    background: linear-gradient('.$gradient_bg__direction.'deg, '.$gradient_bg__from.' 0, '.$gradient_bg__to.' 100%);
                ">'.$patternHTML.'</div>';
            endif;            
                                    
            $block_str .= '<div class="mnmd-block__inner">';
            $block_str .= '<div class="container">';
            $block_str .= $this->render_modules($the_query);            //render modules
            $block_str .= '<div class="spacer-md"></div>';
            $block_str .= $this->news_ticker($page_info);            //render modules
            $block_str .= '</div><!-- .container -->';
            $block_str .= '</div>';
            $block_str .= '</div><!-- .mnmd-block -->';
            
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function news_ticker($page_info) {
            $moduleConfigs = array();
            $news_ticker = new tnm_news_ticker;
            $block_str = '';
            
            $moduleConfigs['title'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_ticker_title', true );    
            $moduleConfigs['limit'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_ticker_limit', true );
            $moduleConfigs['offset'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_ticker_offset', true );
            $moduleConfigs['feature'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_ticker_feature', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_ticker_category', true );
            $moduleConfigs['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_ticker_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_ticker_editor_exclude', true );
        
            $the_query = bk_get_query::query($moduleConfigs);              //get query
            
            if ( $the_query->have_posts() ) :
                $block_str = '';
               	$block_str .= '<div class="mnmd-news-ticker">';
                $block_str .= '<div class="mnmd-news-ticker__inner">';
                
                if($moduleConfigs['title'] != null) {
                    $block_str .= '<div class="mnmd-news-ticker__heading hidden-xs">';
                    $block_str .= '<span>'.$moduleConfigs['title'].'</span>';
                    $block_str .= '</div>';
                }
                
                $block_str .= '<div class="mnmd-news-ticker__content js-mnmd-news-ticker">';
                $block_str .= '<ul>';
                $block_str .= $news_ticker->render_modules($the_query); 
                $block_str .= '</ul>';
                $block_str .= '</div><!-- End .mnmd-news-ticker__content -->';
                $block_str .= $news_ticker->newsticker_nav();
                
                $block_str .= '</div>';
                $block_str .= '</div><!-- End Block -->';
            endif;
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;
        }
        public function render_modules ($the_query){
            $render_modules = '';
            
            $iconPosition_L = 'top-right';
            $iconPosition_S = 'top-right';
            $iconSize_L = 'large';
            $iconSize_S = '';
            // Meta
            $meta_L = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_meta_l', true );
            $meta_S = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_meta_s', true );
            
            if($meta_L != 0) {
                $metaArray_L = tnm_core::bk_get_meta_list($meta_L);
            }else {
                $metaArray_L = '';
            }
            if($meta_S != 0) {
                $metaArray_S = tnm_core::bk_get_meta_list($meta_S);
            }else {
                $metaArray_S = '';
            }
            // Category
            $cat_L = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_cat_l', true );
            if($cat_L != 0){
                $cat_L_Style = 4; //Category Above Title (Has Background)
                $cat_L_Class = tnm_core::bk_get_cat_class($cat_L_Style);
            }else {
                $cat_L_Style = '';
                $cat_L_Class = '';
            }
            
            $excerpt_L = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_excerpt_l', true );
            
            if($excerpt_L == 1){
                $excerptLength = 20;
            }else {
                $excerptLength = '';
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
            
            if ( $the_query->have_posts() ) : $the_query->the_post();
            
                $postHorizontalHTML = new tnm_horizontal_1;
                $postHorizontalAttr = array (
                    'additionalClass'       => 'post--horizontal-lg post--horizontal-reverse',
                    'additionalTextClass'   => 'inverse-text',
                    'cat'                   => $cat_L_Style,
                    'catClass'              => 'post__cat post__cat--bg cat-theme-bg',
                    'thumbSize'             => 'tnm-m-16_9',
                    'except_length'         => $excerptLength,
                    'meta'                  => $metaArray_L,
                    'typescale'             => 'typescale-5',
                    'postIcon'              => $postIconAttr,
                );
                $postHorizontalAttr['postID'] = get_the_ID();
                
                if($bypassPostIconDetech != 1) {
                    if($postSource != 'all') {
                        $postIconAttr['iconType'] = $postSource;
                    }else {
                        $postIconAttr['iconType']   = tnm_core::bk_post_format_detect(get_the_ID());
                    }
                    $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], $iconSize_L, $iconPosition_L);
                    $postHorizontalAttr['postIcon']   = $postIconAttr;
                }
                
                $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
            endif;
            
            if ( $the_query->have_posts() ) :
                $render_modules .= '<div class="spacer-sm"></div>';
                $render_modules .= '<div class="row row--space-between">';
                
                $postVerticalHTML = new tnm_vertical_1;
                
                $cat_S = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_cat_s', true );
                if($cat_S != 0){
                    $cat_S_Style = 1;
                    $cat_S_Class = tnm_core::bk_get_cat_class($cat_S_Style);
                }else {
                    $cat_S_Style = '';
                    $cat_S_Class = '';
                    $iconPosition_S = 'center';
                    $iconSize_S= 'medium';
                }
                
                $postVerticalAttr = array (
                    'cat'                   => $cat_S_Style,
                    'catClass'              => $cat_S_Class,
                    'thumbSize'             => 'tnm-xs-2_1',
                    'typescale'             => 'typescale-2',
                    'additionalTextClass'   => 'inverse-text',
                    'meta'                  => $metaArray_S,
                    'postIcon'              => $postIconAttr,
                );
                
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $postVerticalAttr['postID'] = get_the_ID();
                    $subPostIDs[] = get_the_ID();
                    
                    if($bypassPostIconDetech != 1) {
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType']   = tnm_core::bk_post_format_detect(get_the_ID());
                        }
                        $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], $iconSize_S, $iconPosition_S);
                        $postVerticalAttr['postIcon']   = $postIconAttr;
                    }
                    
                    $render_modules .= '<div class="col-xs-12 col-sm-4">';
                    $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                    $render_modules .= '</div> <!-- end small item -->';
                endwhile; 
                
                $render_modules .= '</div>';
            
            endif;
            
            return $render_modules;
        }
    }
}