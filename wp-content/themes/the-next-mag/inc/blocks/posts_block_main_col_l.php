<?php
if (!class_exists('tnm_posts_block_main_col_l')) {
    class tnm_posts_block_main_col_l {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_posts_block_main_col_l-');
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
            
            $moduleInfo = array(
                'meta'          => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_meta', true ),
                'cat'           => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_cat_style', true ), // Category Style
            );
            
            $the_query = bk_get_query::query($moduleConfigs);              //get query
            
            if ($the_query->have_posts() ) :
            $block_str .= '<div id="'.$moduleID.'" class="mnmd-block">';
            $block_str .= tnm_core::bk_get_block_heading($moduleConfigs['title'], $headingClass, $viewallButton);
            
            if ( $the_query->have_posts() ) :
                $block_str .= $this->render_modules($the_query, $moduleInfo);            //render modules
            endif;
            
            if($moduleConfigs['viewmore'] == 'yes') {
                $block_str .= '<div class="spacer-sm"></div>';
                $vmArray = array(
                    'class' => 'text-center',
                    'button_class' => 'btn btn-default btn-sm',
                    'text'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_text', true ),
                    'link'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_link', true ),
                    'target' => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_target', true ),
                );
                $block_str .= tnm_ajax_function::get_viewmore_button($vmArray);
            }
            $block_str .= '</div><!-- .mnmd-block -->';
            
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_modules ($the_query, $moduleInfo){
            $render_modules = '';
            $currentPost = 0;
            $postCount = $the_query->post_count;
            $firstColumn = 0;
            $secondColumn = 0;
            
            $meta = $moduleInfo['meta'];
            
            if($meta != 0) {
                $metaArray = tnm_core::bk_get_meta_list($meta);
            }else {
                $metaArray = '';
            }
            
            $cat = $moduleInfo['cat'];
            if($cat != 0){
                $catStyle = 3;
                $cat_Class = tnm_core::bk_get_cat_class($catStyle);
            }else {
                $catStyle = '';
                $cat_Class = '';
            }
            
            if($postCount%2 == 1) {
                $firstColumn = intval($postCount/2) + 1;
            }else {
                $firstColumn = intval($postCount/2);
            }
            
            if ( $the_query->have_posts() ) :
                $postHorizontalHTML = new tnm_horizontal_1;
                $postHorizontalAttr = array (
                    'cat'               => $catStyle,
                    'catClass'          => $cat_Class,
                    'additionalClass'   => 'post--horizontal-xs',
                    'thumbSize'         => 'tnm-xxs-1_1',
                    'meta'              => $metaArray,
                    'typescale'         => 'typescale-1',
                );
                $openColumn = '<div class="col-xs-12 col-sm-6">';
                $closeColumn = '</div><!-- Close Column-->';
                
                $render_modules .= '<div class="row row--space-between">';
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $currentPost = $the_query->current_post;
                    $postHorizontalAttr['postID'] = get_the_ID();
                    if(($currentPost == 0) || ($currentPost == $firstColumn)) {
                        $render_modules .= $openColumn;
                        $render_modules .= '<ul class="list-space-md list-unstyled list-seperated">';
                    }
                    
                    $render_modules .= '<li>';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</li>';

                    if(($currentPost == ($firstColumn - 1)) || ($currentPost == ($postCount - 1))) {
                        $render_modules .= '</ul><!-- End List -->';
                        $render_modules .= $closeColumn;
                    }
                endwhile;
                $render_modules .= '</div>'; 
            endif;
            return $render_modules;
        }
    }
}