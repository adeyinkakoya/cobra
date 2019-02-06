<?php
if (!class_exists('tnm_posts_listing_grid_small_no_sidebar')) {
    class tnm_posts_listing_grid_small_no_sidebar {
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_posts_listing_grid_small_no_sidebar-');
            $moduleConfigs = array();
            
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
                'iconPosition'  => 'top-right',
                'meta'          => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_meta', true ),
                'cat'           => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_cat_style', true ), // Category Style
            );
            
            tnm_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
            
            $the_query = bk_get_query::tnm_query($moduleConfigs, $moduleID);              //get query
            
            $block_str .= '<div id="'.$moduleID.'" class="mnmd-block mnmd-block--fullwidth">';
            $block_str .= '<div class="container">';
            $block_str .= tnm_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
            
            if($moduleConfigs['ajax_load_more'] == 'loadmore') {
                $block_str .= '<div class="js-ajax-load-post" data-posts-to-load="'.$moduleConfigs['limit'].'">';
            }
            
            $block_str .= '<div class="posts-listing posts-list">';
            
            if ( $the_query->have_posts() ) :
                if($moduleConfigs['ajax_load_more'] == 'loadmore') :
                    $block_str .= $this->render_modules_loadmore($the_query, 0, $moduleInfo);            //render modules
                else:
                    $block_str .= $this->render_modules($the_query, 0, $moduleInfo);            //render modules
                endif;
            endif;
            
            $block_str .= '</div>';
            
            $tnmMaxPages = tnm_ajax_function::max_num_pages_cal($the_query, $moduleConfigs['offset'], $moduleConfigs['limit']);
            $block_str .= tnm_ajax_function::ajax_load_buttons($moduleConfigs['ajax_load_more'], $tnmMaxPages, $viewallButton);
            
            if($moduleConfigs['ajax_load_more'] == 'loadmore') {
                $block_str .= '</div><!-- .js-ajax-load-post -->';
            }
            
            $block_str .= '</div><!-- .container -->';
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
            $iconPosition = 'top-right';
            $iconSize = 'small';
            // Category
            $cat = $moduleInfo['cat'];
            if($cat != 0){
                $catStyle = 1; //Top Left
                $cat_Class = tnm_core::bk_get_cat_class($catStyle);
            }else {
                $catStyle = '';
                $cat_Class = '';
                $iconPosition = 'center';
                $iconSize = '';
            }
            
            $meta = $moduleInfo['meta'];
            if($meta != 0) {
                $metaArray = tnm_core::bk_get_meta_list($meta);
            }else {
                $metaArray = '';
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
                $postVerticalHTML = new tnm_vertical_1;
                
                $postVerticalAttr = array (
                    'cat'           => $catStyle,
                    'catClass'      => $cat_Class,
                    'thumbSize'     => 'tnm-xs-2_1',
                    'typescale'     => 'typescale-1',
                    'meta'          => $metaArray,
                    'postIcon'      => $postIconAttr,                  
                );
                
                $openRow = '<div class="row row--space-between">';
                $closeRow = '</div><!-- Close Row -->';
                
                while ( $the_query->have_posts() ): $the_query->the_post();    
                    $currentPost = $the_query->current_post + $the__lastPost;
                    
                    if($currentPost % 4 == 0) {
                        $render_modules .= $openRow;
                    }
                    if($currentPost % 4 == 2) {
                        $render_modules .= '<div class="clearfix visible-sm"></div>';
                    }
                    $postVerticalAttr['postID'] = get_the_ID();
                    if($bypassPostIconDetech != 1) {
                        $addClass = 'overlay-item--sm-p';
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType']   = tnm_core::bk_post_format_detect(get_the_ID());
                        }

                        $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], $iconSize, $iconPosition, $addClass);
                        
                        $postVerticalAttr['postIcon']    = $postIconAttr;
                    }
                    $render_modules .= '<div class="col-xs-12 col-sm-6 col-md-3">';
                    $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                    $render_modules .= '</div>';
                    
                    if($currentPost % 4 == 3) {
                        $render_modules .= $closeRow;
                    }
                endwhile;
                    if($currentPost % 4 != 3) {
                        $render_modules .= $closeRow;
                    }
                
            endif;
            
            return $render_modules;
        }
        public function render_modules_loadmore($the_query, $the__lastPost = 0, $moduleInfo = ''){
            $render_modules = '';
            $render_modules_tmp = '';
            $currentPost = 0;
            
            $postSource = $moduleInfo['post_source'];
            $postIcon = $moduleInfo['post_icon'];
            $iconPosition = 'top-right';
            $iconSize = 'small';
            // Category
            $cat = $moduleInfo['cat'];
            if($cat != 0){
                $catStyle = 1; //Top Left
                $cat_Class = tnm_core::bk_get_cat_class($catStyle);
            }else {
                $catStyle = '';
                $cat_Class = '';
                $iconPosition = 'center';
                $iconSize = '';
            }
            
            $meta = $moduleInfo['meta'];
            if($meta != 0) {
                $metaArray = tnm_core::bk_get_meta_list($meta);
            }else {
                $metaArray = '';
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
                $postVerticalHTML = new tnm_vertical_1;
                
                $postVerticalAttr = array (
                    'cat'           => $catStyle,
                    'catClass'      => $cat_Class,
                    'thumbSize'     => 'tnm-xs-2_1',
                    'typescale'     => 'typescale-1',
                    'meta'          => $metaArray,
                    'postIcon'      => $postIconAttr,    
                );
                
                $openRow = '<div class="row row--space-between">';
                $closeRow = '</div><!-- Close Row -->';
                
                while ( $the_query->have_posts() ): $the_query->the_post();    
                    $currentPost = $the_query->current_post + $the__lastPost;
                    
                    if($currentPost % 4 == 0) {
                        $render_modules_tmp = '';
                        $render_modules_tmp .= $openRow;
                    }
                    if($currentPost % 4 == 2) {
                        $render_modules_tmp .= '<div class="clearfix visible-sm"></div>';
                    }
                    $postVerticalAttr['postID'] = get_the_ID();
                    if($bypassPostIconDetech != 1) {
                        $addClass = 'overlay-item--sm-p';
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType']   = tnm_core::bk_post_format_detect(get_the_ID());
                        }

                        $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], $iconSize, $iconPosition, $addClass);
                        
                        $postVerticalAttr['postIcon']    = $postIconAttr;
                    }
                    $render_modules_tmp .= '<div class="col-xs-12 col-sm-6 col-md-3">';
                    $render_modules_tmp .= $postVerticalHTML->render($postVerticalAttr);
                    $render_modules_tmp .= '</div>';
                    
                    if($currentPost % 4 == 3) {
                        $render_modules_tmp .= $closeRow;
                        $render_modules .= $render_modules_tmp;
                    }
                endwhile;
                    
                if(($currentPost%4 < 3) && ($the_query->post_count < 3)) {
                    $render_modules_tmp .= $closeRow;
                    $render_modules .= $render_modules_tmp;
                }
                
            endif;
            
            return $render_modules;
        }
    }
}