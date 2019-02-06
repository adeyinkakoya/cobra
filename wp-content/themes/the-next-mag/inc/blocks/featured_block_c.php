<?php
if (!class_exists('tnm_featured_block_c')) {
    class tnm_featured_block_c {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_featured_block_c-');
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
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
            
            //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            $moduleInfo = array(
                'post_source'   => $moduleConfigs['post_source'],
                'post_icon'     => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true ),
                'iconPosition_L'  => 'top-right',
                'iconPosition_S'  => 'top-right',
                'meta'            => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_meta', true ),
                'cat_L'           => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_cat_l', true ),
                'cat_S'           => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_cat_s', true ),
                'excerpt_L'       => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_excerpt_l', true ),
                'footerStyle'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_footer_style', true ),
            );
            
            if(isset($moduleConfigs['heading_style'])) {
                $headingClass = tnm_core::bk_get_block_heading_class($moduleConfigs['heading_style'], $moduleConfigs['heading_inverse']);
            }
            
            $the_query = bk_get_query::tnm_query($moduleConfigs);   //get query
            
            if ( $the_query->have_posts()) :
            $block_str .= '<div id="'.$moduleID.'" class="mnmd-block mnmd-block--fullwidth mnmd-featured-block-c">';
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
            $postHorizontalHTML = new tnm_horizontal_1;
            $currentPost = 0;
            $postCount = $the_query->post_count;
            
            $iconPosition_L = $moduleInfo['iconPosition_L'];
            $iconPosition_S = $moduleInfo['iconPosition_S'];
            
            // Category
            $cat_L = $moduleInfo['cat_L'];
            if($cat_L != 0){
                $cat_L_Style = 1; //Category Top Left
                $cat_L_Class = tnm_core::bk_get_cat_class($cat_L_Style);
            }else {
                $cat_L_Style = '';
                $cat_L_Class = '';
            }
            $cat_S = $moduleInfo['cat_S'];
            if($cat_S != 0){
                $cat_S_Style = 1; //Category Top Left
                $cat_S_Class = tnm_core::bk_get_cat_class($cat_S_Style);
            }else {
                $cat_S_Style = '';
                $cat_S_Class = '';
            }
            $meta = $moduleInfo['meta'];
            
            if($meta != 0) {
                $metaArray = tnm_core::bk_get_meta_list($meta);
            }else {
                $metaArray = '';
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
            
            $render_modules = '';
            if ( $the_query->have_posts() ) :
                $postOverlayAttr = array (
                    'additionalClass'       => 'post--overlay-bottom post--overlay-md post--overlay-floorfade post--overlay-padding-lg post--overlay-primary-xs',
                    'cat'                   => $cat_L_Style,
                    'catClass'              => $cat_L_Class,
                    'meta'                  => $metaArray,
                    'footerType'            => $footerArgs['footerType'],
                    'additionalMetaClass'   => $footerArgs['footerClass'],
                    'thumbSize'             => 'tnm-m-4_3',
                    'typescale'             => 'typescale-4',
                    'except_length'         => $excerptLength,
                    'additionalExcerptClass' => 'post__excerpt--lg hidden-xs hidden-sm',
                    'postIcon'              => $postIconAttr,
                );
                $postHorizontalAttr = array (
                    'additionalClass'       => 'post--horizontal-middle post--horizontal-xs',
                    'cat'                   => 4,
                    'catClass'              => tnm_core::bk_get_cat_class(4),
                    'thumbSize'             => 'tnm-xxs-1_1',
                    'additionalThumbClass'  => 'post__thumb--circle',
                    'typescale'             => 'typescale-1',
                );
                
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $currentPost = $the_query->current_post;
                    if($currentPost == 0) {
                        $postOverlayHTML_L = $postOverlayHTML;
                        $render_modules .= '<div class="row row--space-between grid-gutter-20">';
                        $render_modules .= '<div class="col-xs-12 col-sm-7 col-md-8">';
                        $postOverlayAttr['postID'] = get_the_ID();
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
                                $postOverlayAttr['additionalTextClass'] = 'inverse-text';
                            }else if($iconPosition_L == 'right-bottom') {
                                $postOverlayHTML_L = new tnm_overlay_icon_side_right;
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
                                    $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $iconPosition_L);
                                }
                            }
                            
                            $postOverlayAttr['postIcon']    = $postIconAttr;
                        } 
                        $render_modules .= $postOverlayHTML_L->render($postOverlayAttr);
                        $render_modules .= '</div>';
                    }elseif($currentPost == 1) {
                        $postOverlayHTML_S = $postOverlayHTML;
                        $render_modules .= '<div class="col-xs-12 col-sm-5 col-md-4">';
                        $postOverlayAttr['postID'] = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = tnm_core::bk_post_format_detect(get_the_ID());
                            }
                            
                            if($iconPosition_S == 'left-bottom') {
                                $postOverlayHTML_S = new tnm_overlay_icon_side_left;
                                if($postIconAttr['iconType'] != 'gallery') { 
                                    $postIconAttr['postIconClass']  = 'post-type-icon--md';
                                }else {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }
                                $postOverlayAttr['additionalTextClass'] = 'inverse-text';
                            }else if($iconPosition_S == 'right-bottom') {
                                $postOverlayHTML_S = new tnm_overlay_icon_side_right;
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
                                    $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $iconPosition_S);
                                }
                            }
                            
                            $postOverlayAttr['postIcon']    = $postIconAttr;
                        } 
                        $postOverlayAttr['additionalClass'] = 'post--overlay-bottom post--overlay-md post--overlay-floorfade post--overlay-padding-lg';
                        $postOverlayAttr['typescale'] = 'typescale-3';
                        $postOverlayAttr['thumbSize'] = 'tnm-s-1_1';
                        $postOverlayAttr['except_length'] = 0;
                        $postOverlayAttr['cat'] = $cat_S_Style;
                        $postOverlayAttr['catClass'] = $cat_S_Class;
                        
                        $render_modules .= $postOverlayHTML_S->render($postOverlayAttr);
                        $render_modules .= '</div>';
                        $render_modules .= '</div> <!-- End Row -->';
                    }else {
                        $postHorizontalAttr['postID'] = get_the_ID();
                        if($currentPost == 2) {
                            $render_modules .= '<div class="row row--space-between">';
                        }
                        $render_modules .= '<div class="col-xs-12 col-md-4">';
                        $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                        $render_modules .= '</div>';
                    }
                endwhile;
                if($currentPost != 1)  {
                    $render_modules .= '</div> <!-- End Row -->';
                }
            endif;
            
            return $render_modules;
        }
    }
}