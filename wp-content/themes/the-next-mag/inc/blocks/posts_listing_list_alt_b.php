<?php
if (!class_exists('tnm_posts_listing_list_alt_b')) {
    class tnm_posts_listing_list_alt_b {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $moduleID = uniqid('tnm_posts_listing_list_alt_b-');
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
            $moduleConfigs['ajax_load_more'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_ajax_load_more', true );
            $viewallButton = array();
            if ($moduleConfigs['ajax_load_more'] == 'viewall') :            
                $viewallButton['view_all_link'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_link', true );
                $viewallButton['view_all_text'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_text', true );
                $viewallButton['view_all_target'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_target', true );
            endif;
            
            $moduleConfigs['heading_style'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_style', true );
            $moduleConfigs['heading_inverse'] = 'no';
            
            if(isset($moduleConfigs['heading_style'])) {
                $headingClass = tnm_core::bk_get_block_heading_class($moduleConfigs['heading_style'], $moduleConfigs['heading_inverse']);
            }
            //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            $moduleInfo = array(
                'post_source'   => $moduleConfigs['post_source'],
                'post_icon'     => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true ),
                'iconPosition_l'  => 'top-right',
                'iconPosition_s'  => 'top-right',
                'meta_l'          => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_meta_l', true ),
                'cat_l'           => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_cat_l', true ),
                'excerpt_l'       => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_excerpt_l', true ),
                'meta_s'          => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_meta_s', true ),
                'cat_s'           => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_cat_s', true ),
                'excerpt_s'       => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_excerpt_s', true ),
                'footer_style'    => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_footer_style', true ),
            );
            
            tnm_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
               
            $the_query = bk_get_query::tnm_query($moduleConfigs, $moduleID);              //get query
            
            $block_str = '';
            $block_str .= '<div id="'.$moduleID.'" class="mnmd-block">';
            $block_str .= tnm_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
            
            if($moduleConfigs['ajax_load_more'] == 'loadmore') {
                $block_str .= '<div class="js-ajax-load-post" data-posts-to-load="'.$moduleConfigs['limit'].'">';
            }
            
            $block_str .= '<div class="posts-list list-unstyled list-space-xl">';
            if ( $the_query->have_posts() ) :
                $block_str .= $this->render_modules($the_query, 0, $moduleInfo);            //render modules
            endif;
            
            $block_str .= '</div>';
            
            $tnmMaxPages = tnm_ajax_function::max_num_pages_cal($the_query, $moduleConfigs['offset'], $moduleConfigs['limit']);
            $block_str .= tnm_ajax_function::ajax_load_buttons($moduleConfigs['ajax_load_more'], $tnmMaxPages, $viewallButton);
            
            if($moduleConfigs['ajax_load_more'] == 'loadmore') {
                $block_str .= '</div>';
            }
            
            $block_str .= '</div><!-- .mnmd-block -->';
                        
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        
        public function render_modules($the_query, $the__lastPost = 0, $moduleInfo = ''){
            $render_modules = '';
            $currentPost = 0;
            
            $postSource = $moduleInfo['post_source'];
            $postIcon = $moduleInfo['post_icon'];
            $iconPosition_L = 'top-right';
            $iconPosition_S = 'top-right';
            
            // Category
            $cat_L = $moduleInfo['cat_l'];
            if($cat_L != 0){
                $cat_L_Style = 1;
                $cat_L_Class = tnm_core::bk_get_cat_class($cat_L_Style);
            }else {
                $cat_L_Style = '';
                $cat_L_Class = '';
            }
            $cat_S = $moduleInfo['cat_s'];
            if($cat_S != 0){
                $cat_S_Style = 3;
                $cat_S_Class = tnm_core::bk_get_cat_class($cat_S_Style);
            }else {
                $cat_S_Style = '';
                $cat_S_Class = '';
            }
            
            $meta_L = $moduleInfo['meta_l'];
            if($meta_L != 0) {
                $metaArray_L = tnm_core::bk_get_meta_list($meta_L);
            }else {
                $metaArray_L = '';
            }
            $meta_S = $moduleInfo['meta_s'];
            if($meta_S != 0) {
                $metaArray_S = tnm_core::bk_get_meta_list($meta_S);
            }else {
                $metaArray_S = '';
            }
            
            $excerpt_L = $moduleInfo['excerpt_l'];
            if($excerpt_L == 1){
                $excerptLength_L = 23;
            }else {
                $excerptLength_L = '';
            }
            
            $excerpt_S = $moduleInfo['excerpt_s'];
            if($excerpt_S == 1){
                $excerptLength_S = 23;
            }else {
                $excerptLength_S = '';
            }
            
            //Footer Style
            $footerArgs = array();
            $footerStyle = $moduleInfo['footer_style'];
            $footerArgs = tnm_core::bk_overlay_footer_style($footerStyle);
            
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
                $postHorizontalHTML = new tnm_horizontal_1;
                $postOverlayHTML = new tnm_overlay_1;
                $postOverlayAttr = array (
                    'additionalClass'   => 'post--overlay-floorfade post--overlay-bottom post--overlay-sm post--overlay-padding-lg',
                    'cat'               => $cat_L_Style,
                    'catClass'          => $cat_L_Class,
                    'thumbSize'         => 'tnm-m-16_9',
                    'typescale'         => 'typescale-4',
                    'footerType'            => $footerArgs['footerType'],
                    'additionalMetaClass'   => $footerArgs['footerClass'],
                    'except_length'     => $excerptLength_L,
                    'meta'              => $metaArray_L,
                    'postIcon'          => $postIconAttr,  
                );
                $postHorizontalAttr = array (
                    'additionalClass'   => 'post--horizontal-sm',
                    'cat'               => $cat_S_Style,
                    'catClass'          => $cat_S_Class,
                    'thumbSize'         => 'tnm-xs-4_3',
                    'typescale'         => 'typescale-2',
                    'except_length'     => $excerptLength_S,
                    'meta'              => $metaArray_S,
                    'postIcon'          => $postIconAttr,  
                );
                
                while ( $the_query->have_posts() ): $the_query->the_post();     
                    $currentPost = $the_query->current_post + $the__lastPost;
                    if($currentPost % 5) : //Small Posts
                        $postHorizontalAttr['postID'] = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            $addClass = 'overlay-item--sm-p';
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType'] = tnm_core::bk_post_format_detect(get_the_ID());
                            }
    
                            $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition_S, $addClass);
                            
                            $postHorizontalAttr['postIcon'] = $postIconAttr;
                        }
                        $render_modules .= '<div class="list-item">';
                        $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                        $render_modules .= '</div>';
                    else: //Large Posts
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
                                    $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], 'medium', $iconPosition_L);
                                }
                            }
                            
                            $postOverlayAttr['postIcon']    = $postIconAttr;
                        } 
                        $render_modules .= '<div class="list-item">';
                        $render_modules .= $postOverlayHTML->render($postOverlayAttr);
                        $render_modules .= '</div>';
                    endif;
                endwhile;
                
            endif;
            
            return $render_modules;
        }
    }
}