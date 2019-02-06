<?php
if (!class_exists('tnm_posts_block_main_col_k')) {
    class tnm_posts_block_main_col_k {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_posts_block_main_col_k-');
            $moduleConfigs = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            
            $moduleConfigs['title']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );
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
            
            $block_str .= '<div id="'.$moduleID.'" class="mnmd-block">';
            $block_str .= tnm_core::bk_get_block_heading($moduleConfigs['title'], $headingClass, $viewallButton);
            $block_str .= '<div class="row row--space-between">';
            
            if ( $the_query->have_posts() ) :
                $block_str .= $this->render_modules($the_query);            //render modules
            endif;
            
            $block_str .= '</div>';
            $block_str .= '</div><!-- .mnmd-block -->';
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        
        public function render_modules ($the_query){
            $postOverlayHTML = new tnm_overlay_1;
            $postVerticalHTML = new tnm_vertical_1;
            $currentPost = 0;
            $render_modules = '';
            
            $iconPosition_L = 'top-right';
            $iconPosition_S = 'center';
            
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
                $cat_L_Style = 1;
                $cat_L_Class = tnm_core::bk_get_cat_class($cat_L_Style);
            }else {
                $cat_L_Style = '';
                $cat_L_Class = '';
            }
            
            $excerpt_L = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_excerpt_l', true );
            if($excerpt_L == 1){
                $excerptLength_L = 23;
            }else {
                $excerptLength_L = '';
            }
            
            //Footer Style
            $footerArgs = array();
            $footerStyle = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_footer_style', true );
            $footerArgs = tnm_core::bk_overlay_footer_style($footerStyle);
            
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
                $postOverlayAttr = array (
                    'additionalClass'       => 'post--overlay-bottom post--overlay-floorfade post--overlay-sm',
                    'cat'                   => $cat_L_Style,
                    'catClass'              => $cat_L_Class,
                    'meta'                  => $metaArray_L,
                    'thumbSize'             => 'tnm-m-2_1',
                    'typescale'             => 'typescale-3',
                    'additionalTextClass'   => 'inverse-text',
                    'except_length'         => $excerptLength_L,
                    'footerType'            => $footerArgs['footerType'],
                    'additionalMetaClass'   => $footerArgs['footerClass'],
                    'postIcon'              => $postIconAttr,
                );
                $postOverlayAttr['postID'] = get_the_ID();
                if($bypassPostIconDetech != 1) {
                    if($postSource != 'all') {
                        $postIconAttr['iconType'] = $postSource;
                    }else {
                        $postIconAttr['iconType']   = tnm_core::bk_post_format_detect(get_the_ID());
                    }
                    
                    if($iconPosition_L == 'left-bottom') {
                        $postOverlayHTML = new tnm_overlay_icon_side_left;
                        if($postIconAttr['iconType'] != 'gallery') { 
                            $postIconAttr['postIconClass']  = 'post-type-icon--md';
                        }else {
                            $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                        }
                    }else if($iconPosition_L == 'right-bottom') {
                        $postOverlayHTML = new tnm_overlay_icon_side_right;
                        if($postIconAttr['iconType'] != 'gallery') { 
                            $postIconAttr['postIconClass']  = 'post-type-icon--md';
                        }else {
                            $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                        }
                        $postOverlayAttr['additionalTextClass'] = 'inverse-text';
                    }else {
                        $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $iconPosition_L);
                    }
                    
                    $postOverlayAttr['postIcon']    = $postIconAttr;
                }
                $render_modules .= '<div class="col-xs-12">';
                $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                $render_modules .= '</div>';
            endif;
            
            if ( $the_query->have_posts() ) :
                $postVerticalAttr = array (
                    'cat'           => '',
                    'thumbSize'     => 'tnm-xs-16_9 400x225',
                    'typescale'     => 'typescale-0',
                    'meta'          => $metaArray_S,
                    'postIcon'      => $postIconAttr,
                );
                $render_modules .= '<div class="col-xs-12">';
                $openRow = '<div class="row row--space-between">';
                $closeRow = '</div><!-- Close Row -->';
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $currentPost = $the_query->current_post;
                    $postVerticalAttr['postID'] = get_the_ID();
                    if($bypassPostIconDetech != 1) {
                        $addClass = 'overlay-item--sm-p';
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType']   = tnm_core::bk_post_format_detect(get_the_ID());
                        }
                        $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], 'small', $iconPosition_S, $addClass);
                        $postVerticalAttr['postIcon']   = $postIconAttr;
                    }
                    if($currentPost % 4 == 1) {
                        $render_modules .= $openRow;
                    }
                    if($currentPost % 4 == 3 ){
                        $render_modules .= '<div class="clearfix visible-sm"></div>';
                    }
                    $render_modules .= '<div class="col-xs-12 col-sm-6 col-md-3">';
                    $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                    $render_modules .= '</div>';
                    if($currentPost % 4 == 0) {
                        $render_modules .= $closeRow;
                    }
                endwhile;
                if($currentPost % 4 != 0) {
                    $render_modules .= $closeRow;
                }
                $render_modules .= '</div>';
            endif;
            
            return $render_modules;
        }
    }
}