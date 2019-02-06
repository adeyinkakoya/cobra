<?php
if (!class_exists('tnm_posts_block_b')) {
    class tnm_posts_block_b {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_posts_block_b-');
            $moduleConfigs = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            
            $moduleConfigs['title']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit']     = 6;
            $moduleConfigs['offset']    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );
            $moduleConfigs['align'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_align', true );
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
            
            $moduleInfo = array(
                'post_source'   => $moduleConfigs['post_source'],
                'post_icon'     => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true ),
                'iconPosition_L'  => 'top-right',
                'iconPosition_S'  => 'top-right',
                'meta_L'          => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_meta_l', true ),
                'meta_S'          => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_meta_s', true ),
                'cat_L'           => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_cat_l', true ),
                'cat_S'           => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_cat_s', true ),
                'footerStyle'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_footer_style', true ),
            );
            
            $the_query = bk_get_query::tnm_query($moduleConfigs);              //get query
            
            if ( $the_query->have_posts()) :
            $block_str .= '<div id="'.$moduleID.'"  class="mnmd-block mnmd-block--fullwidth">';
           	$block_str .= '<div class="container">';
            $block_str .= tnm_core::bk_get_block_heading($moduleConfigs['title'], $headingClass, $viewallButton);
            
            $block_str .= $this->render_modules($the_query, $moduleInfo);            //render modules

            $block_str .= '</div><!-- .container -->';
            $block_str .= '</div><!-- .mnmd-block -->';
            
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_modules ($the_query, $moduleInfo){
            $postOverlayHTML = new tnm_overlay_1;
            $postVerticalHTML = new tnm_vertical_1;
            $currentPost = 0;
            $render_modules = '';
            
            $iconPosition_L = $moduleInfo['iconPosition_L'];
            $iconPosition_S = $moduleInfo['iconPosition_S'];
            $iconSize_L = 'medium';
            $iconSize_S = '';
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
                $cat_L_Style = 1; //Top-Left
                $cat_L_Class = tnm_core::bk_get_cat_class($cat_L_Style);
            }else {
                $cat_L_Style = '';
                $cat_L_Class = '';
            }
            
            $cat_S = $moduleInfo['cat_S'];
            if($cat_S != 0){
                $cat_S_Style = 1; //Top-Left
                $cat_S_Class = tnm_core::bk_get_cat_class($cat_S_Style);
            }else {
                $cat_S_Style = '';
                $cat_S_Class = '';
                $iconPosition_S = 'center';
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
                $postOverlayAttr = array (
                    'additionalClass'   => 'post--overlay-sm post--overlay-floorfade post--overlay-bottom',
                    'cat'               => $cat_L_Style,
                    'catClass'          => $cat_L_Class,
                    'meta'              => $metaArray_L,
                    'thumbSize'         => 'tnm-s-2_1',
                    'typescale'         => 'typescale-3',
                    'footerType'            => $footerArgs['footerType'],
                    'additionalMetaClass'   => $footerArgs['footerClass'],
                    'postIcon'          => $postIconAttr,
                );
                $postVerticalAttr = array (
                    'cat'               => $cat_S_Style,
                    'catClass'          => $cat_S_Class,
                    'meta'              => $metaArray_S,
                    'thumbSize'         => 'tnm-xs-2_1',
                    'typescale'         => 'typescale-1',
                    'postIcon'          => $postIconAttr,
                );
                $openRow = '<div class="row row--space-between">';
                $closeRow = '</div> <!-- End Row -->';
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $currentPost = $the_query->current_post;
                    if($currentPost == 4) {
                        $render_modules .= '<div class="clearfix visible-sm"></div>';
                    }
                    if(($currentPost == 0) || ($currentPost == 2)) {
                        $render_modules .= $openRow;
                    }
                    if(($currentPost == 0) || ($currentPost == 1)){
                        $colClass = "col-xs-12 col-sm-6";
                    }else {
                        $colClass = "col-sm-6 col-md-3";
                    }
                    
                    $render_modules .= '<div class="'.$colClass.'">';
                    if(($currentPost == 0) || ($currentPost == 1)){
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
                                $postOverlayAttr['additionalTextClass'] = 'inverse-text';
                            }else if($iconPosition_L == 'right-bottom') {
                                $postOverlayHTML = new tnm_overlay_icon_side_right;
                                if($postIconAttr['iconType'] != 'gallery') { 
                                    $postIconAttr['postIconClass']  = 'post-type-icon--md';
                                }else {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }
                                $postOverlayAttr['additionalTextClass'] = 'inverse-text';
                            }else {
                                if($postIconAttr['iconType'] == 'gallery') {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }else {
                                    $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], $iconSize_L, $iconPosition_L);
                                }
                            }
                            
                            $postOverlayAttr['postIcon']    = $postIconAttr;
                        } 
                        $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                    }else {
                        $postVerticalAttr['postID']         = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            $addClass = 'overlay-item--sm-p';
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = tnm_core::bk_post_format_detect(get_the_ID());
                            }
  
                            $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], $iconSize_S, $iconPosition_S, $addClass);
                            
                            $postVerticalAttr['postIcon']    = $postIconAttr;
                        }
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                    }
                    $render_modules .= '</div>';
                    if($currentPost == 1) {
                        $render_modules .= $closeRow;
                    }
                endwhile;
                if($currentPost != 1) {
                    $render_modules .= $closeRow;
                }
            endif;
            
            return $render_modules;
        }
    }
}