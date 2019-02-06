<?php
if (!class_exists('tnm_posts_block_a')) {
    class tnm_posts_block_a {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_posts_block_a-');
            
            $moduleConfigs_1 = array();
            $moduleConfigs_2 = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            
            $moduleConfigs_1['left_title'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_left_title', true );
            $moduleConfigs_1['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby_1', true );
            $moduleConfigs_1['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags_1', true ); 
            $moduleConfigs_1['limit'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit_1', true );
            $moduleConfigs_1['offset'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset_1', true );
            $moduleConfigs_1['feature'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature_1', true );
            $moduleConfigs_1['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category_1', true );
            $moduleConfigs_1['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude_1', true );
            $moduleConfigs_1['heading_style'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_style_1', true );
            $moduleConfigs_1['load_more'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_load_more_1', true );
            $moduleConfigs_1['heading_inverse'] = 'no';
            
            $viewallButton_1 = array();
            if (($moduleConfigs_1['load_more'] == 'viewall') && ($moduleConfigs_1['heading_style'] != 'center') && ($moduleConfigs_1['heading_style'] != 'large-center') && ($moduleConfigs_1['heading_style'] != 'line-around') && ($moduleConfigs_1['heading_style'] != 'large-line-around')) :           
                $viewallButton_1['view_all_link'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_link_1', true );
                $viewallButton_1['view_all_text'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_text_1', true );
                $viewallButton_1['view_all_target'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_target_1', true );
            endif;
            
            if(isset($moduleConfigs_1['heading_style'])) {
                $headingClass_1 = tnm_core::bk_get_block_heading_class($moduleConfigs_1['heading_style'], $moduleConfigs_1['heading_inverse']);
            }
            
            $moduleConfigs_2['right_title'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_right_title', true );
            $moduleConfigs_2['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby_2', true );
            $moduleConfigs_2['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags_2', true ); 
            $moduleConfigs_2['limit'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit_2', true );
            $moduleConfigs_2['offset'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset_2', true );
            $moduleConfigs_2['feature'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature_2', true );
            $moduleConfigs_2['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category_2', true );
            $moduleConfigs_2['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude_2', true );
            $moduleConfigs_2['heading_style'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_style_2', true );
            $moduleConfigs_2['load_more'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_load_more_2', true );
            $moduleConfigs_2['heading_inverse'] = 'no';
            
            $viewallButton_2 = array();
            if (($moduleConfigs_2['load_more'] == 'viewall') && ($moduleConfigs_2['heading_style'] != 'center') && ($moduleConfigs_2['heading_style'] != 'large-center') && ($moduleConfigs_2['heading_style'] != 'line-around') && ($moduleConfigs_2['heading_style'] != 'large-line-around')) :           
                $viewallButton_2['view_all_link'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_link_2', true );
                $viewallButton_2['view_all_text'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_text_2', true );
                $viewallButton_2['view_all_target'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_target_2', true );
            endif;
            
            if(isset($moduleConfigs_2['heading_style'])) {
                $headingClass_2 = tnm_core::bk_get_block_heading_class($moduleConfigs_2['heading_style'], $moduleConfigs_2['heading_inverse']);
            }
            
            $the_query_1 = bk_get_query::query($moduleConfigs_1);              //get query
            $the_query_2 = bk_get_query::query($moduleConfigs_2);
            
            if (( $the_query_1->have_posts() ) || ( $the_query_2->have_posts() )) :
            $block_str .= '<div id="'.$moduleID.'" class="mnmd-block mnmd-block--fullwidth">';
           	$block_str .= '<div class="container">';
            $block_str .= '<div class="row row--space-between">';
            //Column 1
            $block_str .= '<div class="col-xs-12 col-md-4 col-lg-3">';
            $block_str .= tnm_core::bk_get_block_heading($moduleConfigs_1['left_title'], $headingClass_1, $viewallButton_1);
            $block_str .= '<ul class="list-space-sm list-unstyled list-seperated">';
            $block_str .= $this->render_modules_1($the_query_1);            //render modules
            $block_str .= '</ul>';
            $block_str .= '</div><!-- end Column 1 -->';
            
            //Column 2
            $block_str .= '<div class="col-xs-12 col-md-8 col-lg-9">';
            $block_str .= tnm_core::bk_get_block_heading($moduleConfigs_2['right_title'], $headingClass_2, $viewallButton_2);
            $block_str .= '<div class="row row--space-between">';
            if ( $the_query_2->have_posts() ) :
                $block_str .= $this->render_modules_2($the_query_2);            //render modules
            endif;
            $block_str .= '</div>';
            $block_str .= '</div><!-- end Column 2 -->';
            $block_str .= '</div>';
            $block_str .= '</div><!-- .container -->';
            $block_str .= '</div><!-- .mnmd-block -->';
            
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_modules_1 ($the_query){
            $render_modules = '';
            $postHTML = new tnm_horizontal_1;

            $postAttr = array (
                'additionalClass'   => 'post--horizontal-xxs',
                'catClass'          => 'post__cat cat-theme',
                'thumbSize'         => 'tnm-xxs-1_1',
                'meta'              => array('date'),
                'typescale'         => 'typescale-0',
            );
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postAttr['postID'] = get_the_ID();
                $render_modules .= '<li>';
                $render_modules .= $postHTML->render($postAttr);
                $render_modules .= '</li> <!-- end small item -->';
            endwhile; 
            
            return $render_modules;
        }
        public function render_modules_2 ($the_query){
            $render_modules = '';
            
            // Category
            $cat_L = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_cat_l', true );
            if($cat_L != 0){
                $cat_L_Style = 1; //Top-Left
                $cat_L_Class = tnm_core::bk_get_cat_class($cat_L_Style);
            }else {
                $cat_L_Style = '';
                $cat_L_Class = '';
            }
            
            $cat_S = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_cat_s', true );
            if($cat_S != 0){
                $cat_S_Style = 1; //Top-Left
                $cat_S_Class = tnm_core::bk_get_cat_class($cat_S_Style);
            }else {
                $cat_S_Style = '';
                $cat_S_Class = '';
            }

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
            
            $excerpt_L = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_excerpt_l', true );
            
            if($excerpt_L == 1){
                $excerptLength = 25;
            }else {
                $excerptLength = '';
            }
            
            //Column 1
            if ( $the_query->have_posts() ) : $the_query->the_post();
                $postHTML = new tnm_vertical_1;
                $postID = get_the_ID();
                                        
                $postAttr = array (
                    'postID'                 => $postID,
                    'cat'                    => $cat_L_Style,
                    'catClass'               => $cat_L_Class,
                    'thumbSize'              => 'tnm-s-2_1',
                    'typescale'              => 'typescale-3',
                    'except_length'          => $excerptLength,
                    'additionalExcerptClass' => 'hidden-xs hidden-sm',
                    'meta'                   => $metaArray_L,
                );
                $render_modules .= '<div class="col-xs-12 col-sm-8">';
                $render_modules .= $postHTML->render($postAttr);
                $render_modules .= '</div>';
            endif;
            
            if ( $the_query->have_posts() ) :
                $postHTML = new tnm_vertical_1;
                $postAttr = array (
                    'cat'           => $cat_S_Style,
                    'catClass'      => $cat_S_Class,
                    'thumbSize'     => 'tnm-xs-16_9 400x225',
                    'typescale'     => 'typescale-0',
                    'except_length' => '',
                    'meta'          => $metaArray_S,
                );
                $render_modules .= '<div class="col-xs-12 col-sm-4">';
                $render_modules .= '<div class="row row--space-between">';
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $postAttr['postID'] = get_the_ID();
                    $render_modules .= '<div class="col-xs-6 col-sm-12">';
                    $render_modules .= $postHTML->render($postAttr);
                    $render_modules .= '</div> <!-- end small item -->';
                endwhile;
                $render_modules .= '</div>';
                $render_modules .= '</div>';
            endif;
            
            return $render_modules;
        }
    }
}