<?php
if (!class_exists('tnm_posts_listing_grid_alt_fw')) {
    class tnm_posts_listing_grid_alt_fw {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_posts_listing_grid_alt_fw-');
            
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            
            $moduleConfigs['title']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit']     = 10;
            $moduleConfigs['offset']    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );
            $moduleConfigs['load_more'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_load_more', true );
            $moduleConfigs['viewmore'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_viewmore', true );
            
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
            
            //Mailchimp
            $mailchimpConfigs['mailchimp_title'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_mailchimp_title', true );
            $mailchimpConfigs['mailchimp_shortcode'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_mailchimp_shortcode', true );
            
            //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            $moduleConfigs['post_icon'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true );      
            $the_query = bk_get_query::tnm_query($moduleConfigs);              //get query
            
            $block_str .= '<div id="'.$moduleID.'" class="mnmd-block mnmd-block--fullwidth">';
            $block_str .= '<div class="container">';
            $block_str .= tnm_core::bk_get_block_heading($moduleConfigs['title'], $headingClass, $viewallButton);
            $block_str .= '<div class="posts-listing">';
            if ( $the_query->have_posts() ) :
                $block_str .= $this->render_modules($the_query, $mailchimpConfigs);            //render modules
            endif;
            $block_str .= '</div>';
            if($moduleConfigs['viewmore'] == 'yes') {
                $block_str .= '<div class="spacer-sm"></div>';
                $vmArray = array(
                    'class' => 'text-center',
                    'button_class' => 'btn btn-default',
                    'text'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_text', true ),
                    'link'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_link', true ),
                    'target' => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_target', true ),
                );
                $block_str .= tnm_ajax_function::get_viewmore_button($vmArray);
            }
            $block_str .= '</div><!-- container -->';
            $block_str .= '</div><!-- .mnmd-block -->';
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        
        public function render_modules ($the_query, $mailchimpConfigs = ''){
            $render_modules = '';
            $itemCount = 0;
            $postOverlayHTML = new tnm_overlay_1;
            $postVerticalHTML = new tnm_vertical_1;
            
            $iconPosition_L = 'top-right';
            $iconPosition_S = 'top-right';
            $iconSize_L = 'medium';
            $iconSize_S = '';
            
            // Meta
            $meta_L = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_meta_l', true );
            $meta_S = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_meta_s', true );
            
            if($meta_L != 0) {
                $metaArray_L = tnm_core::bk_get_meta_list($meta_L);
            }else {
                $metaArray_L = '';
            }
            if($meta_S == 1) {
                $metaArray_S = array('author', 'date');
            }else {
                $metaArray_S = '';
            }
            
            // Category
            $cat_L = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_cat_l', true );
            if($cat_L != 0){
                $cat_L_Style = 1; //Category Top Left
                $cat_L_Class = tnm_core::bk_get_cat_class($cat_L_Style);
            }else {
                $cat_L_Style = '';
                $cat_L_Class = '';
            }
            
            $cat_S = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_cat_s', true );
            if($cat_S != 0){
                $cat_S_Style = 1; //Category Top Left
                $cat_S_Class = tnm_core::bk_get_cat_class($cat_S_Style);
            }else {
                $cat_S_Style = '';
                $cat_S_Class = '';
                $iconPosition_S = 'top-right';
                $iconSize_S = '';
            }
            
            $excerpt_L = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_excerpt_l', true );
            
            if($excerpt_L == 1){
                $excerptLength = 20;
            }else {
                $excerptLength = '';
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
            
            $postOverlayAttr = array (
                    'additionalClass'   => 'post--overlay-bottom post--overlay-floorfade post--overlay-sm',
                    'cat'               => $cat_L_Style,
                    'catClass'          => $cat_L_Class,
                    'meta'              => $metaArray_L,
                    'comment_box'       => 1,
                    'thumbSize'         => 'tnm-xs-16_9',
                    'typescale'         => 'typescale-3',
                    'except_length'     => $excerptLength,
                    'postIcon'          => $postIconAttr,
                );
            $postVerticalAttr = array (
                    'meta'              => $metaArray_S,
                    'cat'               => $cat_S_Style,
                    'catClass'          => $cat_S_Class,
                    'thumbSize'         => 'tnm-xs-4_3',
                    'typescale'         => 'typescale-1',
                    'postIcon'          => $postIconAttr,
                );
            $rowOpen = '<div class="row row--space-between">';
            $rowClose = '</div><!-- Close Row -->';
            //Column 1
            
            if ( $the_query->have_posts() ) :
                $itemCount += 1;
                
                while ( $the_query->have_posts() ): $the_query->the_post();
                    if(($itemCount == 1) || ($itemCount == 4) || ($itemCount == 8)) {
                        $render_modules .= $rowOpen;
                    }                
                    if(($itemCount == 1) || ($itemCount == 10)) :
                        $postOverlayAttr['postID'] = get_the_ID();
                        
                        $postOverlayAttr['footerType']          = $footerArgs['footerType'];
                        $postOverlayAttr['additionalMetaClass'] = $footerArgs['footerClass'];
                            
                        if($bypassPostIconDetech != 1) {
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = tnm_core::bk_post_format_detect(get_the_ID());
                            }
                            
                            if($iconPosition_L == 'left-bottom') {
                                $postOverlayHTML = new tnm_overlay_icon_side_left;
                                if($postIconAttr['iconType'] != 'gallery') { 
                                    $postIconAttr['postIconClass']  = '';
                                }else {
                                    $postIconAttr['postIconClass']  = 'overlay-item gallery-icon';
                                }
                                $postOverlayAttr['additionalTextClass'] = 'inverse-text';
                            }else if($iconPosition_L == 'right-bottom') {
                                $postOverlayHTML = new tnm_overlay_icon_side_right;
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
                                    $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], $iconSize_L, $iconPosition_L);
                                }
                            }
                            
                            $postOverlayAttr['postIcon']    = $postIconAttr;
                        }                    
                        $render_modules .= '<div class="col-xs-12 col-md-6">';
                        $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                        $render_modules .= '</div>';
                    else:
                    
                        $postVerticalAttr['postID'] = get_the_ID();
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
                        $render_modules .= '<div class="col-xs-12 col-sm-6 col-md-3">';
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                        $render_modules .= '</div>';
                        
                        if(($itemCount == 2) && ($mailchimpConfigs['mailchimp_shortcode'] != null)) {
                            $render_modules .= '<div class="col-xs-12 col-sm-6 col-md-3">';
                            $render_modules .= '<div class="mnmd-widget widget widget-subscribe widget-subscribe--stack-bottom widget--centered">';
                            $render_modules .= '<div class="widget-subscribe__inner">';
                            $render_modules .= '<div class="subscribe-form">';
                            $render_modules .= '<h3>'.$mailchimpConfigs['mailchimp_title'].'</h3>';
    						$render_modules .= do_shortcode($mailchimpConfigs['mailchimp_shortcode']);
                            $render_modules .= '</div>';
                            $render_modules .= '</div>';
                            $render_modules .= '</div>';
                            $render_modules .= '</div>';
                            $itemCount += 1;
                        }
                        
                    endif;
                    if(($itemCount == 3) || ($itemCount == 7) || ($itemCount == 10)) {
                        $render_modules .= $rowClose;
                    } 
                    if($itemCount == $the_query->post_count) :
                        break;
                    endif;
                    $itemCount += 1;
                endwhile;
                if(($itemCount != 3) && ($itemCount != 7) && ($itemCount != 10)) {
                    $render_modules .= $rowClose;
                }
            endif;
            
            return $render_modules;
        }
    }
}