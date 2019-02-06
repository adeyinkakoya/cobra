<?php
if (!class_exists('tnm_category_tiles')) {
    class tnm_category_tiles {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_category_tiles-');
            $moduleConfigs = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            
            $moduleConfigs['title'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['category_description'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category_description', true );
            $moduleConfigs['heading_style'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_style', true );
            $moduleConfigs['heading_inverse'] = 'no';
            $moduleConfigs['image'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_image', true );
            $moduleConfigs['load_more'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_load_more', true );
            
            $viewallButton = array();
            if (($moduleConfigs['load_more'] == 'viewall') && ($moduleConfigs['heading_style'] != 'center') && ($moduleConfigs['heading_style'] != 'large-center') && ($moduleConfigs['heading_style'] != 'line-around') && ($moduleConfigs['heading_style'] != 'large-line-around')) :           
                $viewallButton['view_all_link'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_link', true );
                $viewallButton['view_all_text'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_text', true );
                $viewallButton['view_all_target'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_all_target', true );
            endif;
            
            $categoryIDs = explode(',',$moduleConfigs['category_id']);
            
            $categoryCount = tnm_core::bk_count_post_in_category($categoryIDs);
            
            if(isset($moduleConfigs['heading_style'])) {
                $headingClass = tnm_core::bk_get_block_heading_class($moduleConfigs['heading_style'], $moduleConfigs['heading_inverse']);
            }
            
            $block_str .= '<div id="'.$moduleID.'" class="mnmd-block mnmd-block--fullwidth">';
           	$block_str .= '<div class="container">';
            $block_str .= tnm_core::bk_get_block_heading($moduleConfigs['title'], $headingClass, $viewallButton);
            $block_str .= $this->render_modules($categoryCount);            //render modules
            $block_str .= '</div><!-- .container -->';
            $block_str .= '</div><!-- .mnmd-block -->';
            
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_modules ($categoryCount){
            $catDescription = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_category_description', true );
            $moduleHTML = new tnm_category_tile;
            $render_modules = '';
            $counter = 0;
            $openRow = '<div class="row row--space-between">';
            $closeRow = '</div><!-- End Row-->';
            foreach ($categoryCount as $catID => $postCount) {
                $counter += 1;
                if($counter % 4 == 1) {
                    $render_modules .= $openRow;
                }
                $categoryAttr = array(
                    'thumbSize'     => 'tnm-xs-4_3',
                    'catID'         => $catID,
                    'description'   => ''
                );
                if($catDescription == 'description') {
                    $categoryAttr['description'] = category_description( $catID ); 
                }else if($catDescription == 'post-count') {
                    $categoryInfo = get_category($catID); 
                    $categoryAttr['description'] = $categoryInfo->category_count . esc_html__(' Articles', 'the-next-mag');
                }else {
                    $categoryAttr['description'] = '';
                }
                $render_modules .= '<div class="col-xs-6 col-md-3">';
                $render_modules .= $moduleHTML->render($categoryAttr);
                $render_modules .= '</div>';
                if($counter % 4 == 0) {
                    $render_modules .= $closeRow;
                }
            }
            if($counter % 4 != 0) {
                    $render_modules .= $closeRow;
                }
            return $render_modules;
        }
    }
}