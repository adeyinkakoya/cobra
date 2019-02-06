<?php
if (!class_exists('tnm_horizontal_list')) {
    class tnm_horizontal_list {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_horizontal_list-');
            
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
            
            $moduleConfigs['heading_style'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_style', true );
            $moduleConfigs['heading_inverse'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_inverse', true );
            
            if(isset($moduleConfigs['heading_style'])) {
                $headingClass = tnm_core::bk_get_block_heading_class($moduleConfigs['heading_style'], $moduleConfigs['heading_inverse']);
            }
            
            //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            
            $the_query = bk_get_query::tnm_query($moduleConfigs);              //get query
            
            if ( $the_query->have_posts()) :
            $block_str .= '<div id="'.$moduleID.'" class="mnmd-block mnmd-block--fullwidth has-background mnmd-horizontal-list">';
            $block_str .= '<div class="background-svg-pattern-inverse"></div>';
           	$block_str .= '<div class="container">';
            $block_str .= tnm_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
            $block_str .= '<div class="row row--space-between">';
            $block_str .= $this->render_modules($the_query);            //render modules
            $block_str .= '</div>';
            $block_str .= '</div><!-- .container -->';
            $block_str .= '</div><!-- .mnmd-block -->';
            
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_modules ($the_query){
            $postHTML = new tnm_horizontal_2;
            
            // Category Style ($cat)
            $cat = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_cat_style', true );
            
            // Meta
            $meta = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_meta', true );
            
            if($meta == 1) {
                $metaArray = array('comment_text');
            }else {
                $metaArray = '';
            }    

            $render_modules = '';
            if ( $the_query->have_posts() ) :
                $postAttr = array (
                    'cat'               => $cat?1:0,
                    'catClass'          => 'post__cat cat-theme',
                    'typescale'         => 'typescale-2',
                    'meta'              => $metaArray,
                );
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $postAttr['postID'] = get_the_ID();
                    $postAttr['postCount'] = $the_query->current_post + 1;
                    $render_modules .= '<div class="item-list col-xs-12 col-sm-4">';
                    $render_modules .= $postHTML->render($postAttr);
                    $render_modules .= '</div>';
                endwhile;
            endif;
            
            return $render_modules;
        }
    }
}