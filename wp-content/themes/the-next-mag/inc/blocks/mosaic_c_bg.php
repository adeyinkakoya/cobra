<?php
if (!class_exists('tnm_mosaic_c_bg')) {
    class tnm_mosaic_c_bg {
        
        static $pageInfo=0;
                
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_mosaic_c_bg-');
            
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            $contiguousClass = 'mnmd-block--contiguous';
            
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true );
            $moduleConfigs['limit']     = 3;
            $moduleConfigs['offset']    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );
            
            //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            $moduleInfo = array(
                'post_source'   => $moduleConfigs['post_source'],
                'post_icon'     => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true ),
                'iconPosition_L'  => 'top-right',
                'iconPosition_S'  => 'top-right',
                'meta_L'          => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_meta_l', true ),
                'meta_S'          => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_meta_s', true ),
                'cat_L'           => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_cat_l', true ),
                'cat_S'           => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_cat_s', true ),
                'excerpt_L'       => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_excerpt_l', true ),
                'footerStyle'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_footer_style', true ),
            );
             
            $the_query = bk_get_query::tnm_query($moduleConfigs);              //get query
            
            $block_str .= '<div id="'.$moduleID.'" class="mnmd-block mnmd-block--fullwidth mnmd-mosaic mnmd-mosaic--has-shadow has-overlap-background mnmd-mosaic--gutter-10 '.$contiguousClass.'">';
            
            $moduleConfigs['bg_option'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_bg_option', true );
            if($moduleConfigs['bg_option'] == 'image') :
                $moduleConfigs['background_img'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_img', true );            
                $imgBGStyle = "background-image: url('".$moduleConfigs['background_img']."')";
                $block_str .= '<div class="overlap-background background-img" style="'.$imgBGStyle.'"></div>';
            else:
                $gradient_bg__from  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_gradient_from', true );
                $gradient_bg__to    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_gradient_to', true );
                $gradient_bg__direction = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_gradient_direction', true );
                $background_pattern  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_pattern', true );
                $patternHTML = '';
                if($background_pattern == 1) :
                    $patternHTML = '<div class="background-svg-pattern"></div>';
                endif; 
                $block_str .= '<div class="overlap-background background-img gradient-4" style="
                    background: '.$gradient_bg__from.';
                    background: -webkit-linear-gradient('.$gradient_bg__direction.'deg, '.$gradient_bg__from.' 0, '.$gradient_bg__to.' 100%);
                    background: linear-gradient('.$gradient_bg__direction.'deg, '.$gradient_bg__from.' 0, '.$gradient_bg__to.' 100%);
                ">'.$patternHTML.'</div>';
            endif; 
            
            $block_str .= '<div class="container container--wide">';
            $block_str .= '<div class="row row--space-between">';
            if ( $the_query->have_posts() ) :
                $block_str .= $this->render_modules($the_query, $moduleInfo);            //render modules
            endif;
            $block_str .= '</div>';
            $block_str .= '</div>';
            $block_str .= '</div><!-- .mnmd-block -->';
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        
        public function render_modules ($the_query, $moduleInfo){
            $render_modules = '';
            
            $iconPosition_L = $moduleInfo['iconPosition_L'];
            $iconPosition_S = $moduleInfo['iconPosition_S'];
            
            // Meta
            $meta_L = $moduleInfo['meta_L'];
            $meta_S = $moduleInfo['meta_S'];
            
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
            $cat_L = $moduleInfo['cat_L'];
            if($cat_L != 0){
                $cat_L_Style = 1; //top-left
                $cat_L_Class = tnm_core::bk_get_cat_class($cat_L_Style);
            }else {
                $cat_L_Style = '';
                $cat_L_Class = '';
            }
            $cat_S = $moduleInfo['cat_S'];
            if($cat_S != 0){
                $cat_S_Style = 1; //top-left
                $cat_S_Class = tnm_core::bk_get_cat_class($cat_S_Style);
            }else {
                $cat_S_Style = '';
                $cat_S_Class = '';
            }
            
            $excerpt_L = $moduleInfo['excerpt_L'];
            
            if($excerpt_L == 1){
                $excerptLength = 20;
            }else {
                $excerptLength = '';
            }
            
            //Footer Style
            $footerArgs = array();
            $footerStyle = $moduleInfo['footerStyle'];
            $footerArgs = tnm_core::bk_overlay_footer_style($footerStyle);
            
            $postSource = $moduleInfo['post_source'];
            $postIcon = $moduleInfo['post_icon'];
            
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
                $postOverlayHTML_L = new tnm_overlay_1;
                $postOverlayHTML_S = new tnm_overlay_1;
                                        
                $postOverlayAttr = array (
                    'thumbSize'         => 'tnm-xs-4_3',
                    'typescale'         => 'typescale-2',
                    'cat'               => $cat_S_Style,
                    'catClass'          => $cat_S_Class,
                    'additionalClass'   => 'post--overlay-bottom post--overlay-floorfade post--overlay-padding-lg',
                    'additionalTextClass' => 'inverse-text',
                    'additionalExcerptClass' => 'post__excerpt--lg',
                    'meta'              => $metaArray_S,
                    'except_length'     => '',
                    'postIcon'          => $postIconAttr,
                );
                
                while ( $the_query->have_posts() ): $the_query->the_post();       
                    $postOverlayAttr['postID'] = get_the_ID();       
                    if($the_query->current_post == 0) :
                        $postOverlayAttr_L = $postOverlayAttr;
                        $postOverlayAttr_L['thumbSize']     = 'tnm-m-4_3';
                        $postOverlayAttr_L['typescale']     = 'typescale-5';
                        $postOverlayAttr_L['except_length'] = $excerptLength;
                        $postOverlayAttr_L['meta']          = $metaArray_L;
                        $postOverlayAttr_L['cat']           = $cat_L_Style;
                        $postOverlayAttr_L['catClass']      = $cat_L_Class;
                        $postOverlayAttr_L['footerType']          = $footerArgs['footerType'];
                        $postOverlayAttr_L['additionalMetaClass'] = $footerArgs['footerClass'];
                        
                        if($bypassPostIconDetech != 1) {
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = tnm_core::bk_post_format_detect(get_the_ID());
                            }
                                                                                    
                            if($iconPosition_L == 'left-bottom') {
                                $postOverlayHTML_L = new tnm_overlay_icon_side_left;
                                if($postIconAttr['iconType'] != 'gallery') { 
                                    $postIconAttr['postIconClass']  = 'post-type-icon--md';
                                }else {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }
                                $postOverlayAttr_L['additionalTextClass'] = 'inverse-text';
                            }else if($iconPosition_L == 'right-bottom') {
                                $postOverlayHTML_L = new tnm_overlay_icon_side_right;
                                if($postIconAttr['iconType'] != 'gallery') { 
                                    $postIconAttr['postIconClass']  = 'post-type-icon--md';
                                }else {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }
                                $postOverlayAttr_L['additionalTextClass'] = 'inverse-text';
                            }else {
                                if($postIconAttr['iconType'] == 'gallery') {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }else {
                                    $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $iconPosition_L);
                                }
                            }
                            
                            $postOverlayAttr_L['postIcon']    = $postIconAttr;
                        } 
                        
                        $render_modules .= '<div class="mosaic-item col-xs-12 col-md-8">';
                        $render_modules .= $postOverlayHTML_L->render($postOverlayAttr_L);
                        $render_modules .= '</div>';
                    else:
                        $addClass = 'overlay-item--sm-p';
                        if($bypassPostIconDetech != 1) {
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = tnm_core::bk_post_format_detect(get_the_ID());
                            }
                            
                            if($iconPosition_S == 'left-bottom') {
                                $postOverlayHTML_S = new tnm_overlay_icon_side_left;
                                if($postIconAttr['iconType'] != 'gallery') { 
                                    $postIconAttr['postIconClass']  = '';
                                }else {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }
                                $postOverlayAttr['additionalTextClass'] = 'inverse-text';
                            }else if($iconPosition_S == 'right-bottom') {
                                $postOverlayHTML_S = new tnm_overlay_icon_side_right;
                                if($postIconAttr['iconType'] != 'gallery') { 
                                    $postIconAttr['postIconClass']  = '';
                                }else {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }
                                $postOverlayAttr['additionalTextClass'] = 'inverse-text';
                            }else {
                                if($postIconAttr['iconType'] == 'gallery') {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }else {
                                    $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition_S, $addClass);
                                }
                            }
                            
                            $postOverlayAttr['postIcon']    = $postIconAttr;
                        }  
                        $render_modules .= '<div class="mosaic-item mosaic-item--half col-xs-12 col-sm-6 col-md-4">';
                        $render_modules .= $postOverlayHTML_S->render($postOverlayAttr);
                        $render_modules .= '</div>';
                    endif;
                endwhile;
                
            endif;
            
            return $render_modules;
        }
    }
}