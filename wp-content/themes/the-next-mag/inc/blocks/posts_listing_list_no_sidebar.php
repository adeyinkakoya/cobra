<?php
if (!class_exists('tnm_posts_listing_list_no_sidebar')) {
    class tnm_posts_listing_list_no_sidebar {
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_posts_listing_list_no_sidebar-');
            $moduleConfigs = array();
            $moduleData = array();
            
            //get config
            
            $moduleConfigs['title'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit', true );
            $moduleConfigs['offset'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
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
                'iconPosition'  => 'center',
                'meta'          => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_meta', true ),
                'cat'           => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_cat_style', true ), // Category Style
                'excerpt'       => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_excerpt', true ),
            );
            
            tnm_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
            $the_query = bk_get_query::tnm_query($moduleConfigs, $moduleID);              //get query
            
            $block_str .= '<div id="'.$moduleID.'" class="mnmd-block mnmd-block--fullwidth">';
            $block_str .= '<div class="container container--narrow">';
            $block_str .= tnm_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
            
            if($moduleConfigs['ajax_load_more'] == 'loadmore') {
                $block_str .= '<div class="js-ajax-load-post" data-posts-to-load="'.$moduleConfigs['limit'].'">';
            }
            
            $block_str .= '<div class="posts-list list-unstyled list-space-xl">';
            if ( $the_query->have_posts() ) :
                $block_str .= $this->render_modules($the_query, $moduleInfo);            //render modules
            endif;
            
            $block_str .= '</div>';
            
            $tnmMaxPages = tnm_ajax_function::max_num_pages_cal($the_query, $moduleConfigs['offset'], $moduleConfigs['limit']);
            $block_str .= tnm_ajax_function::ajax_load_buttons($moduleConfigs['ajax_load_more'], $tnmMaxPages, $viewallButton);
            
            if($moduleConfigs['ajax_load_more'] == 'loadmore') {
                $block_str .= '</div><!-- .js-ajax-load-post-->';
            }
            $block_str .= '</div><!-- .container -->';
            $block_str .= '</div><!-- .mnmd-block -->';
                        
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        
        public function render_modules($the_query, $moduleInfo = ''){
            $render_modules = '';
            
            $postSource = $moduleInfo['post_source'];
            $postIcon = $moduleInfo['post_icon'];
            $iconPosition = 'top-right';
            $iconSize = '';
            
            $cat = $moduleInfo['cat'];
            if($cat != 0){
                $catStyle = 3;
                $cat_Class = tnm_core::bk_get_cat_class($catStyle);
            }else {
                $catStyle = '';
                $cat_Class = '';
            }
            
            $meta = $moduleInfo['meta'];
            if($meta != 0) {
                $metaArray = tnm_core::bk_get_meta_list($meta);
            }else {
                $metaArray = '';
            }
            
            $excerpt = $moduleInfo['excerpt'];
            if($excerpt == 1){
                $excerptLength = 23;
            }else {
                $excerptLength = '';
            }
            
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
                                        
                $postHorizontalAttr = array (
                    'additionalClass'   => 'post--horizontal-sm',
                    'cat'               => $catStyle,
                    'catClass'          => $cat_Class,
                    'thumbSize'         => 'tnm-xs-4_3',
                    'typescale'         => 'typescale-3',
                    'except_length'     => $excerptLength,
                    'meta'              => $metaArray,
                    'postIcon'          => $postIconAttr,  
                );
                
                while ( $the_query->have_posts() ): $the_query->the_post();                    
                    $postHorizontalAttr['postID'] = get_the_ID();
                    if($bypassPostIconDetech != 1) {
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType'] = tnm_core::bk_post_format_detect(get_the_ID());
                        }
                        
                        $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], $iconSize, $iconPosition);
                        
                        $postHorizontalAttr['postIcon'] = $postIconAttr;
                    }
                    $render_modules .= '<div class="list-item">';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</div>';
                endwhile;
                
            endif;
            
            return $render_modules;
        }
    }
}