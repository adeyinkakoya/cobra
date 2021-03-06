<?php
if (!class_exists('tnm_posts_block_main_col_f')) {
    class tnm_posts_block_main_col_f {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_posts_block_main_col_f-');
            
            $moduleConfigs_1 = array();
            $moduleConfigs_2 = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            
            $moduleConfigs_1['left_title']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_left_title', true );
            $moduleConfigs_1['orderby']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby_1', true );
            $moduleConfigs_1['tags']        = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags_1', true ); 
            $moduleConfigs_1['limit']       = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit_1', true );
            $moduleConfigs_1['offset']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset_1', true );
            $moduleConfigs_1['feature']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature_1', true );
            $moduleConfigs_1['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category_1', true );
            $moduleConfigs_1['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude_1', true );
            $moduleConfigs_1['load_more'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_load_more_1', true );
            $moduleConfigs_1['heading_style'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_style_1', true );
            $moduleConfigs_1['heading_inverse'] = 'no';
            $moduleConfigs_1['viewmore'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_viewmore_1', true );
            
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
            $moduleConfigs_2['orderby']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby_2', true );
            $moduleConfigs_2['tags']        = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags_2', true ); 
            $moduleConfigs_2['limit']       = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit_2', true );
            $moduleConfigs_2['offset']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset_2', true );
            $moduleConfigs_2['feature']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature_2', true );
            $moduleConfigs_2['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category_2', true );
            $moduleConfigs_2['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude_2', true );
            $moduleConfigs_2['load_more'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_load_more_2', true );
            $moduleConfigs_2['heading_style'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_style_2', true );
            $moduleConfigs_2['heading_inverse'] = 'no';
            $moduleConfigs_2['viewmore'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_viewmore_2', true );
            
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
            $block_str .= '<div id="'.$moduleID.'" class="mnmd-block">';
           	$block_str .= '<div class="row row--space-between">';
            //Column 1
            $block_str .= '<div class="col-xs-12 col-sm-6">';
            $block_str .= tnm_core::bk_get_block_heading($moduleConfigs_1['left_title'], $headingClass_1, $viewallButton_1);
            if ( $the_query_1->have_posts() ) :
                $block_str .= '<div class="row row--space-between">';
                $block_str .= $this->render_modules($the_query_1);            //render modules
                $block_str .= '</div><!-- End Row -->';
            endif;
            if($moduleConfigs_1['viewmore'] == 'yes') {
                $block_str .= '<div class="spacer-sm"></div>';
                $vmArray = array(
                    'class' => 'text-center',
                    'button_class' => 'btn btn-default btn-sm',
                    'text'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_text_1', true ),
                    'link'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_link_1', true ),
                    'target' => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_target_1', true ),
                );
                $block_str .= tnm_ajax_function::get_viewmore_button($vmArray);
            }
            $block_str .= '</div><!-- end Column 1 -->';
            
            //Column 2
            $block_str .= '<div class="col-xs-12 col-sm-6">';
            $block_str .= tnm_core::bk_get_block_heading($moduleConfigs_2['right_title'], $headingClass_2, $viewallButton_2);
            if ( $the_query_2->have_posts() ) :
                $block_str .= '<div class="row row--space-between">';
                $block_str .= $this->render_modules($the_query_2);            //render modules
                $block_str .= '</div><!-- End Row -->';
            endif;
            if($moduleConfigs_2['viewmore'] == 'yes') {
                $block_str .= '<div class="spacer-sm"></div>';
                $vmArray = array(
                    'class' => 'text-center',
                    'button_class' => 'btn btn-default btn-sm',
                    'text'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_text_2', true ),
                    'link'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_link_2', true ),
                    'target' => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_target_2', true ),
                );
                $block_str .= tnm_ajax_function::get_viewmore_button($vmArray);
            }
            $block_str .= '</div><!-- end Column 2 -->';
            $block_str .= '</div>';
            $block_str .= '</div><!-- .mnmd-block -->';
            
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_modules ($the_query){
            $render_modules = '';
            $postHTML = new tnm_vertical_1;
            $postHTMLsmall = new tnm_horizontal_1;
            
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
            }
            $cat_S = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_cat_s', true );
            if($cat_S != 0){
                $cat_S_Style = 1;
                $cat_S_Class = tnm_core::bk_get_cat_class($cat_S_Style);
            }else {
                $cat_S_Style = '';
                $cat_S_Class = '';
            }
          
            if ( $the_query->have_posts() ) : $the_query->the_post();
                
                $postAttr = array (
                    'postID'        => get_the_ID(),
                    'cat'           => $cat_L_Style,
                    'catClass'      => $cat_L_Class,
                    'thumbSize'     => 'tnm-xs-2_1',
                    'typescale'     => 'typescale-2',
                    'meta'          => $metaArray_L,
                );
                $render_modules .= '<div class="col-xs-12">';
                $render_modules .= $postHTML->render($postAttr);
                $render_modules .= '</div>';
            endif;
            if ( $the_query->have_posts() ) :
                while ( $the_query->have_posts() ): $the_query->the_post();
                    
                    if(($the_query->current_post == 1) || ($the_query->current_post == 2)) :
                        $postAttr = array (
                            'postID'        => get_the_ID(),
                            'thumbSize'     => 'tnm-xs-16_9 400x225',
                            'typescale'     => 'typescale-0',
                            'cat'           => $cat_S_Style,
                            'catClass'      => $cat_S_Class,
                            'except_length' => '',
                            'meta'          => $metaArray_S,                         
                        );
                        $render_modules .= '<div class="col-xs-6">';
                        $render_modules .= $postHTML->render($postAttr);
                        $render_modules .= '</div>';
                    else:
                        $postAttrSmall = array (
                            'postID'        => get_the_ID(),
                            'thumbSize'     => '',
                            'meta'          => '',
                            'typescale'     => 'typescale-0',
                        );
                        if ($the_query->current_post == 3) :
                            $render_modules .= '<div class="col-xs-12">';
                            $render_modules .= '<ul class="list-space-xs list-unstyled list-seperated list-square-bullet">';
                        endif;
                        $render_modules .= '<li>';
                        $render_modules .= $postHTMLsmall->render($postAttrSmall);
                        $render_modules .= '</li>';
                        if ($the_query->current_post == ($the_query->post_count - 1)) :
                            $render_modules .= '</ul>';
                            $render_modules .= '</div>';
                        endif;
                    endif;
                    
                endwhile;
            endif;
            return $render_modules;
        }
    }
}