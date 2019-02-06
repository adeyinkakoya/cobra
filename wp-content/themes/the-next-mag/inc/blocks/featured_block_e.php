<?php
if (!class_exists('tnm_featured_block_e')) {
    class tnm_featured_block_e {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_featured_block_e-');
            
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
            $moduleConfigs['module_inverse'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_module_inverse', true );
            
            $inverseClass = '';
            if($moduleConfigs['module_inverse'] == 'yes') :
                $inverseClass = 'inverse-text';
            endif;
            
            $viewallButton = array();
            if (($moduleConfigs['load_more'] == 'viewall') && ($moduleConfigs['heading_style'] != 'center') && ($moduleConfigs['heading_style'] != 'large-center') && ($moduleConfigs['heading_style'] != 'line-around') && ($moduleConfigs['heading_style'] != 'large-line-around')) :           
                $viewallButton['view_all_link'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_link', true );
                $viewallButton['view_all_text'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_text', true );
                $viewallButton['view_all_target'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_target', true );
            endif;
            
            if(isset($moduleConfigs['heading_style'])) {
                $headingClass = tnm_core::bk_get_block_heading_class($moduleConfigs['heading_style'], $moduleConfigs['module_inverse']);
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
            
            $moduleConfigs['bg_option'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_bg_option', true );
            if($moduleConfigs['bg_option'] == 'image') :
                $moduleConfigs['background_img'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_img', true );            
                if($moduleConfigs['background_img'] != '') {          
                    $imgBGStyle = "background-image: url('".$moduleConfigs['background_img']."')";
                    $moduleBackground = '<div class="background-img" style="'.$imgBGStyle.'"></div>';
                    $hasBG_Class = 'has-background';
                }else {
                    $moduleBackground = '';
                    $hasBG_Class = '';
                }
            else:
                $gradient_bg__from  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_gradient_from', true );
                $gradient_bg__to    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_gradient_to', true );
                $gradient_bg__direction = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_gradient_direction', true );
                $background_pattern  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_pattern', true );
                $patternHTML = '';
                if($background_pattern == 1) :
                    $patternHTML = '<div class="background-svg-pattern"></div>';
                endif;  
                
                if(($gradient_bg__to != '') || ($gradient_bg__to != '')) {                        
                    $moduleBackground = '<div class="background-img gradient-4" style="
                        background: '.$gradient_bg__from.';
                        background: -webkit-linear-gradient('.$gradient_bg__direction.'deg, '.$gradient_bg__from.' 0, '.$gradient_bg__to.' 100%);
                        background: linear-gradient('.$gradient_bg__direction.'deg, '.$gradient_bg__from.' 0, '.$gradient_bg__to.' 100%);
                    ">'.$patternHTML.'</div>';
                    $hasBG_Class = 'has-background';
                }else {
                    $moduleBackground = '';
                    $hasBG_Class = '';
                }
            endif; 
            
            $the_query = bk_get_query::tnm_query($moduleConfigs);              //get query
            
            if ( $the_query->have_posts()) :
            $block_str .= '<div id="'.$moduleID.'" class="mnmd-block mnmd-block--fullwidth mnmd-featured-block-e '.$hasBG_Class.' '.$inverseClass.' '.$contiguousClass.'">';
            
            $block_str .= $moduleBackground;
            
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
                $cat_L_Style = 2; //Overlap
                $cat_L_Class = tnm_core::bk_get_cat_class($cat_L_Style);
                $articleAdditionalClass_L = 'post--vertical-cat-overlap text-center';
            }else {
                $cat_L_Style = '';
                $cat_L_Class = '';
                $articleAdditionalClass_L = 'text-center';
            }
            
            $cat_S = $moduleInfo['cat_S'];
            if($cat_S != 0){
                $cat_S_Style = 2; //Overlap
                $cat_S_Class = tnm_core::bk_get_cat_class($cat_S_Style);
                $articleAdditionalClass_S = 'post--vertical-cat-overlap text-center';
            }else {
                $cat_S_Style = '';
                $cat_S_Class = '';
                $articleAdditionalClass_S = 'text-center';
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
                    'thumbSize'         => 'tnm-xs-2_1',
                    'typescale'         => 'typescale-1',
                    'cat'               => $cat_S_Style,
                    'catClass'          => $cat_S_Class,
                    'postIcon'          => $postIconAttr,
                    'meta'              => $metaArray_S,
                    'additionalClass'   => $articleAdditionalClass_S,
                );
                $render_modules .= '<div class="row row--space-between">';
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $postVerticalAttr['postID'] = get_the_ID(); 
                    $currentPost = $the_query->current_post;
                    if($currentPost == 0){
                        $postVerticalAttr_L = $postVerticalAttr;
                        $postVerticalAttr_L['thumbSize']     = 'tnm-s-2_1';
                        $postVerticalAttr_L['typescale']     = 'typescale-4';
                        $postVerticalAttr_L['meta']          = $metaArray_L;
                        $postVerticalAttr_L['except_length'] = $excerptLength;
                        $postVerticalAttr_L['cat']           = $cat_L_Style;
                        $postVerticalAttr_L['catClass']      = $cat_L_Class;
                        $postVerticalAttr_L['additionalClass']  = $articleAdditionalClass_L;
                        
                        if($bypassPostIconDetech != 1) {
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = tnm_core::bk_post_format_detect(get_the_ID());
                            }
                            $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], 'large', $iconPosition_L);
                            
                            $postVerticalAttr_L['postIcon']    = $postIconAttr;
                        }
                        
                        $render_modules .= '<div class="col-xs-12 col-md-6 col-md-push-3">';
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr_L);
                        $render_modules .= '</div>';
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
                        
                        if($currentPost == 1){
                            $render_modules .= '<div class="col-xs-12 col-md-3 col-md-pull-6">';
                            $render_modules .= '<div class="row row--space-between">';
                        }else if($currentPost == 3){
                            $render_modules .= '<div class="col-xs-12 col-md-3">';
                            $render_modules .= '<div class="row row--space-between">';
                        }
                        $render_modules .= '<div class="col-xs-6 col-md-12">';
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                        $render_modules .= '</div>';
                        if(($currentPost == 2) || ($currentPost == 4)){
                            $render_modules .= '</div></div><!--Close Column-->';
                        }
                    }
                    
                endwhile;
                if(($currentPost > 0) && ($currentPost != 2) && ($currentPost != 4)){
                    $render_modules .= '</div></div><!--Close Column-->';
                }
                $render_modules .= '</div> <!-- End Row -->';
            endif;
            
            return $render_modules;
        }
    }
}