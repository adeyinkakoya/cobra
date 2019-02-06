<?php
if (!class_exists('tnm_posts_block_main_col_a')) {
    class tnm_posts_block_main_col_a {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_posts_block_main_col_a-');
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
            
            $render_modules = '';
            $currentPost = 0;
            
            $iconPosition_L = 'top-right';
            $iconPosition_S = 'top-right';
            $iconSize_L = 'medium';
            $iconSize_S = 'small';
            
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
                $iconPosition_L = 'center';
                $iconSize_L = 'large';
            }

            $cat_S = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_cat_s', true );
            if($cat_S != 0){
                $cat_S_Style = 1;
                $cat_S_Class = tnm_core::bk_get_cat_class($cat_S_Style);
            }else {
                $cat_S_Style = '';
                $cat_S_Class = '';
                $iconPosition_S = 'center';
                $iconSize_S = '';
            }
            
            $excerpt_L = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_excerpt_l', true );           
            if($excerpt_L == 1){
                $excerptLength = 23;
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
            
            if ( $the_query->have_posts() ) :
                $postVerticalHTML = new tnm_vertical_1;
                $postHorizontalHTML = new tnm_horizontal_1;
                $currentPost = 0;
                $postCount = $the_query->post_count;
                $postLAttr = array (
                    'cat'           => $cat_L_Style,
                    'catClass'      => $cat_L_Class,
                    'thumbSize'     => 'tnm-s-2_1',
                    'typescale'     => 'typescale-3',
                    'except_length' => $excerptLength,
                    'additionalExcerptClass' => 'hidden-xs hidden-sm',
                    'meta'          => $metaArray_L,
                    'postIcon'      => $postIconAttr,
                );
                $postMAttr = array (
                    'cat'           => $cat_S_Style,
                    'catClass'      => $cat_S_Class,
                    'thumbSize'     => 'tnm-xs-2_1',
                    'typescale'     => 'typescale-1',
                    'except_length' => '',
                    'meta'          => $metaArray_S,
                    'postIcon'      => $postIconAttr,
                );
                $postSAttr = array (
                    'cat'           => $cat_S?4:0,
                    'catClass'      => 'post__cat cat-theme',
                    'thumbSize'     => '',
                    'typescale'     => 'typescale-0',
                    'meta'          => $metaArray_S,
                    'postIcon'      => $postIconAttr,
                );
                
                while ( $the_query->have_posts() ): $the_query->the_post();  
                    $currentPost = $the_query->current_post;
                    if($currentPost == 0) {
                        $render_modules .= '<div class="col-xs-12 col-md-8"><div class="row row--space-between">';
                    }
                    if($currentPost == 0):
                        $postLAttr['postID'] = get_the_ID();
                        $render_modules .= '<div class="col-xs-12">';
                                                
                        if($bypassPostIconDetech != 1) {
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = tnm_core::bk_post_format_detect(get_the_ID());
                            }

                            $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], $iconSize_L, $iconPosition_L);

                            $postLAttr['postIcon']    = $postIconAttr;
                        }
                        
                        $render_modules .= $postVerticalHTML->render($postLAttr);
                        $render_modules .= '</div>';
                    elseif(($currentPost == 1) || ($currentPost == 2)):
                        $postMAttr['postID'] = get_the_ID();
                        
                        if($bypassPostIconDetech != 1) {
                            $addClass = 'overlay-item--sm-p';
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = tnm_core::bk_post_format_detect(get_the_ID());
                            }
                            $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], $iconSize_S, $iconPosition_S, $addClass);
                            $postMAttr['postIcon']   = $postIconAttr;
                        }
                        
                        $render_modules .= '<div class="col-xs-12 col-sm-6">';
                        $render_modules .= $postVerticalHTML->render($postMAttr);
                        $render_modules .= '</div>';
                    else:
                        $postSAttr['postID'] = get_the_ID();
                        if($currentPost == 3) {
                            $render_modules .= '<div class="col-xs-12 col-md-4">';
                            $render_modules .= '<ul class="list-space-xs list-unstyled list-seperated">';
                        }     
                        $render_modules .= '<li>';
                        $render_modules .= $postHorizontalHTML->render($postSAttr);
                        $render_modules .= '</li>';
                        if($currentPost == ($postCount - 1)) {
                            $render_modules .= '</ul>';
                            $render_modules .= '</div><!-- Close 2nd Column-->';
                        }
                    endif;
                    if($currentPost == 2) {
                        $render_modules .= '</div></div><!--Close 1st Column-->';
                    }
                endwhile;
                if($currentPost < 2) {
                    $render_modules .= '</div>';
                    $render_modules .= '</div><!-- Close 1nd Column -->';
                }else if(($currentPost > 2) && ($currentPost != ($postCount - 1))) {
                    $render_modules .= '</ul>';
                    $render_modules .= '</div><!-- Close 2nd Column-->';
                }
            endif;
            
            return $render_modules;
        }
    }
}