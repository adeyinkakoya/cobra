<?php
if (!class_exists('tnm_posts_listing_grid_alt_b')) {
    class tnm_posts_listing_grid_alt_b {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_posts_listing_grid_alt_b-');
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
                'iconPosition_l'  => 'top-right',
                'iconPosition_s'  => 'top-right',
                'meta_l'          => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_meta_l', true ),
                'cat_l'           => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_cat_l', true ),
                'excerpt_l'       => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_excerpt_l', true ),
                'meta_s'          => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_meta_s', true ),
                'cat_s'           => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_cat_s', true ),
                'excerpt_s'       => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_excerpt_s', true ),
            );
            
            tnm_core::bk_add_buff('query', $moduleID, 'moduleInfo', $moduleInfo);
               
            $the_query = bk_get_query::tnm_query($moduleConfigs, $moduleID);              //get query
            
            $block_str .= '<div id="'.$moduleID.'" class="mnmd-block">';
            $block_str .= tnm_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
            
            if($moduleConfigs['ajax_load_more'] == 'loadmore') {
                $block_str .= '<div class="js-ajax-load-post" data-posts-to-load="'.$moduleConfigs['limit'].'">';
            }
            
            $block_str .= '<div class="posts-list">';
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
            
            $block_str .= '</div><!-- .mnmd-block -->';
                        
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        
        public function render_modules($the_query, $the__lastPost = 0, $moduleInfo = ''){
            $render_modules = '';
            $currentPost = 0;
            $render_modules_tmp = 0;
            
            $postSource = $moduleInfo['post_source'];
            $postIcon = $moduleInfo['post_icon'];
            $iconPosition_L = 'top-right';
            $iconPosition_S = 'top-right';
            $iconSize_L = 'medium';            
            $iconSize_S = '';
            
            // Category
            $cat_L = $moduleInfo['cat_l'];
            if($cat_L != 0){
                $cat_L_Style = 1;
                $cat_L_Class = tnm_core::bk_get_cat_class($cat_L_Style);
            }else {
                $cat_L_Style = '';
                $cat_L_Class = '';
                $iconPosition_L = 'center';
                $iconSize_L = 'large';  
            }
            $cat_S = $moduleInfo['cat_s'];
            if($cat_S != 0){
                $cat_S_Style = 1;
                $cat_S_Class = tnm_core::bk_get_cat_class($cat_S_Style);
            }else {
                $cat_S_Style = '';
                $cat_S_Class = '';
                $iconPosition_S = 'center';
                $iconSize_S = 'medium';
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
                $excerptLength_S = 17;
            }else {
                $excerptLength_S = '';
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
                $postID = get_the_ID();
                $postVerticalAttr_L = array (
                    'postID'        => $postID,
                    'cat'           => $cat_L_Style,
                    'catClass'      => $cat_L_Class,
                    'thumbSize'     => 'tnm-m-2_1',
                    'typescale'     => 'typescale-4',
                    'additionalExcerptClass' => 'post__excerpt--lg',
                    'except_length'     => $excerptLength_L,
                    'meta'              => $metaArray_L,
                    'postIcon'          => $postIconAttr,    
                );
                
                $postVerticalAttr = array (
                    'cat'               => $cat_S_Style,
                    'catClass'          => $cat_S_Class,
                    'thumbSize'         => 'tnm-xs-2_1',
                    'typescale'         => 'typescale-2',
                    'except_length'     => $excerptLength_S,
                    'meta'              => $metaArray_S,
                    'postIcon'          => $postIconAttr,  
                );
                $openRow = '<div class="row row--space-between">';
                $closeRow = '</div><!--Close Row -->';
                while ( $the_query->have_posts() ): $the_query->the_post();    
                    $currentPost = $the_query->current_post + $the__lastPost;
                    $currentPostINBLK = $currentPost % 5; //1 BLK has 5 Post (Include: 1 Large Post and 4 Small Post))
                    if(($currentPostINBLK == 1) || ($currentPostINBLK == 3)) {
                        $render_modules .= $openRow;
                    }
                    if($currentPostINBLK % 5) : // Normal Posts
                        $postVerticalAttr['postID'] = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = tnm_core::bk_post_format_detect(get_the_ID());
                            }
    
                            $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], $iconSize_S, $iconPosition_S);
                            
                            $postVerticalAttr['postIcon']    = $postIconAttr;
                        }
                        $render_modules .= '<div class="col-xs-12 col-sm-6">';
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                        $render_modules .= '</div>';
                    else: // Large Posts
                        $postVerticalAttr_L['postID'] = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType'] = tnm_core::bk_post_format_detect(get_the_ID());
                            }
    
                            $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], $iconSize_L, $iconPosition_L);
                            
                            $postVerticalAttr_L['postIcon'] = $postIconAttr;
                        }  
                        $render_modules .= $openRow;
                        $render_modules .= '<div class="col-xs-12">';
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr_L);
                        $render_modules .= '</div>';
                        $render_modules .= $closeRow;
                    endif;
                                        
                    if(($currentPostINBLK == 2) || ($currentPostINBLK == 4)) {
                        $render_modules .= $closeRow;
                    } 
                endwhile;

                if(($currentPostINBLK == 1) || ($currentPostINBLK == 3)) {
                    $render_modules .= $closeRow;
                } 
            endif;
            
            return $render_modules;
        }
        
        public function render_modules_loadmore($the_query, $the__lastPost = 0, $moduleInfo = ''){
            $render_modules = '';
            $currentPost = 0;
            $render_modules_tmp = 0;
            
            $postSource = $moduleInfo['post_source'];
            $postIcon = $moduleInfo['post_icon'];
            $iconPosition_L = 'top-right';
            $iconPosition_S = 'top-right';
            $iconSize_L = 'medium';            
            $iconSize_S = '';
            
            // Category
            $cat_L = $moduleInfo['cat_l'];
            if($cat_L != 0){
                $cat_L_Style = 1;
                $cat_L_Class = tnm_core::bk_get_cat_class($cat_L_Style);
            }else {
                $cat_L_Style = '';
                $cat_L_Class = '';
                $iconPosition_L = 'center';
                $iconSize_L = 'large'; 
            }
            $cat_S = $moduleInfo['cat_s'];
            if($cat_S != 0){
                $cat_S_Style = 1;
                $cat_S_Class = tnm_core::bk_get_cat_class($cat_S_Style);
            }else {
                $cat_S_Style = '';
                $cat_S_Class = '';
                $iconPosition_S = 'center';
                $iconSize_S = 'medium'; 
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
                $excerptLength_S = 17;
            }else {
                $excerptLength_S = '';
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
                
                $postVerticalAttr_L = array (
                    'cat'           => $cat_L_Style,
                    'catClass'      => $cat_L_Class,
                    'thumbSize'     => 'tnm-m-2_1',
                    'typescale'     => 'typescale-4',
                    'additionalExcerptClass' => 'post__excerpt--lg',
                    'except_length'     => $excerptLength_L,
                    'meta'              => $metaArray_L,
                    'postIcon'          => $postIconAttr,    
                );
                
                $postVerticalAttr = array (
                    'cat'               => $cat_S_Style,
                    'catClass'          => $cat_S_Class,
                    'thumbSize'         => 'tnm-xs-2_1',
                    'typescale'         => 'typescale-2',
                    'except_length'     => $excerptLength_S,
                    'meta'              => $metaArray_S,
                    'postIcon'          => $postIconAttr,   
                );
                
                $openRow = '<div class="row row--space-between">';
                $closeRow = '</div><!--Close Row -->';
                while ( $the_query->have_posts() ): $the_query->the_post();    
                    $currentPost = $the_query->current_post + $the__lastPost;
                    $currentPostINBLK = $currentPost % 5; //1 BLK has 5 Posts (Include: 1 Large Post and 4 Small Posts))
                    if(($currentPostINBLK == 1) || ($currentPostINBLK == 3)) {
                        $render_modules_tmp = '';
                        $render_modules_tmp .= $openRow;
                    }
                    if($currentPostINBLK % 5) : //Small Posts
                        $postVerticalAttr['postID'] = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType']   = tnm_core::bk_post_format_detect(get_the_ID());
                            }
    
                            $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], $iconSize_S, $iconPosition_S);
                            
                            $postVerticalAttr['postIcon']    = $postIconAttr;
                        }
                        $render_modules_tmp .= '<div class="col-xs-12 col-sm-6">';
                        $render_modules_tmp .= $postVerticalHTML->render($postVerticalAttr);
                        $render_modules_tmp .= '</div>';
                    else: //Large Posts
                        $postVerticalAttr_L['postID'] = get_the_ID();
                        if($bypassPostIconDetech != 1) {
                            if($postSource != 'all') {
                                $postIconAttr['iconType'] = $postSource;
                            }else {
                                $postIconAttr['iconType'] = tnm_core::bk_post_format_detect(get_the_ID());
                            }
    
                            $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], $iconSize_L, $iconPosition_L);
                            
                            $postVerticalAttr_L['postIcon'] = $postIconAttr;
                        }  
                        $render_modules .= $openRow;
                        $render_modules .= '<div class="col-xs-12">';
                        $render_modules .= $postVerticalHTML->render($postVerticalAttr_L);
                        $render_modules .= '</div>';
                        $render_modules .= $closeRow;
                    endif;
                                        
                    if(($currentPostINBLK == 2) || ($currentPostINBLK == 4)) {
                        $render_modules_tmp .= $closeRow;
                        $render_modules .= $render_modules_tmp;
                    } 
                    if((($currentPostINBLK == 1) || ($currentPostINBLK == 3)) && ($the_query->post_count == 1)) {
                        $render_modules_tmp .= $closeRow;
                        $render_modules .= $render_modules_tmp;
                    }
                endwhile;

            endif;
            
            return $render_modules;
        }
    }
}