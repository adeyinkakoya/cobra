<?php
if (!class_exists('tnm_featured_block_f')) {
    class tnm_featured_block_f {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_featured_block_f-');
            
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            $contiguousClass = 'mnmd-block--contiguous';
            
            //get config
            
            $moduleConfigs['title']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true );
            $moduleConfigs['limit']     = 5;
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
            
            $moduleInfo = array(
                'post_source'   => $moduleConfigs['post_source'],
                'post_icon'     => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true ),
                'iconPosition_L'  => 'center',
                'iconPosition_S'  => 'center',
                'meta_L'          => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_meta_l', true ),
                'meta_S'          => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_meta_s', true ),
                'cat_L'           => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_cat_l', true ),
                'cat_S'           => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_cat_s', true ),
                'excerpt_L'       => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_excerpt_l', true ),
            );
            
            $the_query = bk_get_query::tnm_query($moduleConfigs);              //get query
            
            if ( $the_query->have_posts()) :
            $block_str .= '<div id="'.$moduleID.'" class="mnmd-block mnmd-block--fullwidth mnmd-featured-block-f has-background lightgray-bg '.$contiguousClass.'">';
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
        public function render_modules ($the_query, $moduleInfo = ''){
            $postVerticalHTML = new tnm_vertical_1;
            $currentPost = 0;
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
                $cat_L_Style = 3; //Above Title No BG
                $cat_L_Class = tnm_core::bk_get_cat_class($cat_L_Style);
            }else {
                $cat_L_Style = '';
                $cat_L_Class = '';
            }
            
            $cat_S = $moduleInfo['cat_S'];
            if($cat_S != 0){
                $cat_S_Style = 3; //Above Title No BG
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
                $postVerticalAttr = array (
                    'thumbSize'         => 'tnm-xs-16_9 400x225',
                    'typescale'         => 'typescale-1',
                    'cat'               => $cat_S_Style,
                    'catClass'          => $cat_S_Class,
                    'postIcon'          => $postIconAttr,
                    'meta'              => $metaArray_S,
                );
                $render_modules .= '<div class="row row--space-between">';
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $postVerticalAttr['postID'] = get_the_ID();
                
                    $currentPost = $the_query->current_post;
                    if($currentPost == 0) {
                        $postVerticalAttr_L = $postVerticalAttr;
                        $postVerticalAttr_L['thumbSize']     = 'tnm-xs-16_9';
                        $postVerticalAttr_L['typescale']     = 'typescale-5';
                        $postVerticalAttr_L['meta']          = $metaArray_L;
                        $postVerticalAttr_L['except_length'] = $excerptLength;
                        $postVerticalAttr_L['cat']           = $cat_L_Style;
                        $postVerticalAttr_L['catClass']      = $cat_L_Class;
                        
                        if($bypassPostIconDetech != 1) {
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = tnm_core::bk_post_format_detect(get_the_ID());
                            }
                            $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], 'large', $iconPosition_L);
                            
                            $postVerticalAttr_L['postIcon']    = $postIconAttr;
                        }
                        
                        $render_modules .= '<div class="col-xs-12 col-sm-6">';
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr_L);
                        $render_modules .= '</div><!-- End The Main Column -->';
                    }else {
                        
                        if($bypassPostIconDetech != 1) {
                            $addClass = 'overlay-item--sm-p';
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = tnm_core::bk_post_format_detect(get_the_ID());
                            }
  
                            $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition_S, $addClass);
                            
                            $postVerticalAttr['postIcon']    = $postIconAttr;
                        }
                        
                        
                        if($currentPost == 1) {
                            $render_modules .= '<div class="col-xs-12 col-sm-6">';
                        }
                        if(($currentPost == 1) || ($currentPost == 3)) {
                            $render_modules .= '<div class="row row--space-between">';
                        } 
                        $render_modules .= '<div class="col-sm-6">';  
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                        $render_modules .= '</div>';
                        if(($currentPost == 2) || ($currentPost == 5)) {
                            $render_modules .= '</div>';
                        }
                    }
                endwhile;
                if(($currentPost != 2) && ($currentPost != 5)) {
                    $render_modules .= '</div>';
                }
                if($currentPost != 0) {
                    $render_modules .= '</div><!-- End The Sub Column -->';
                }
                $render_modules .= '</div>';
            endif;
            
            return $render_modules;
        }
    }
}