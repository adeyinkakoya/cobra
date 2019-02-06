<?php
if (!class_exists('tnm_posts_block_g')) {
    class tnm_posts_block_g {
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_posts_block_g-');
            
            $moduleConfigs_1 = array();
            $moduleConfigs_2 = array();
            $moduleConfigs_3 = array();
            $moduleConfigs_4 = array();
            $moduleData = array();
            
            //get config
            
            $moduleConfigs_1['title']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title_1', true );
            $moduleConfigs_1['orderby'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby_1', true );
            $moduleConfigs_1['tags']    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags_1', true ); 
            $moduleConfigs_1['limit']   = 4;
            $moduleConfigs_1['offset']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset_1', true );
            $moduleConfigs_1['feature'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature_1', true );
            $moduleConfigs_1['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category_1', true );
            $moduleConfigs_1['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude_1', true );
            $moduleConfigs_1['viewmore'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_viewmore_1', true );
            $backgroundID_1 = get_term_meta( $moduleConfigs_1['category_id'], 'bk_category_feat_img', false );
            if((tnm_core::bk_check_array($backgroundID_1)) && ($backgroundID_1[0] != '')) {
                $tmp = wp_get_attachment_image_src( $backgroundID_1[0], 'tnm-l-4_3' );
                $moduleConfigs_1['background'] = $tmp[0];
            }else {
                $moduleConfigs_1['background'] = '';
            }
            
            $moduleConfigs_2['title']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title_2', true );
            $moduleConfigs_2['orderby'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby_2', true );
            $moduleConfigs_2['tags']    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags_2', true ); 
            $moduleConfigs_2['limit']   = 4;
            $moduleConfigs_2['offset']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset_2', true );
            $moduleConfigs_2['feature'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature_2', true );
            $moduleConfigs_2['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category_2', true );
            $moduleConfigs_2['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude_2', true );
            $moduleConfigs_2['viewmore'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_viewmore_2', true );
            $backgroundID_2 = get_term_meta( $moduleConfigs_2['category_id'], 'bk_category_feat_img', false );
            if((tnm_core::bk_check_array($backgroundID_2)) && ($backgroundID_2[0] != '')) {
                $tmp = wp_get_attachment_image_src( $backgroundID_2[0], 'tnm-l-4_3' );
                $moduleConfigs_2['background'] = $tmp[0];
            }else {
                $moduleConfigs_2['background'] = '';
            }

            $moduleConfigs_3['title']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title_3', true );
            $moduleConfigs_3['orderby'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby_3', true );
            $moduleConfigs_3['tags']    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags_3', true ); 
            $moduleConfigs_3['limit']   = 4;
            $moduleConfigs_3['offset']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset_3', true );
            $moduleConfigs_3['feature'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature_3', true );
            $moduleConfigs_3['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category_3', true );
            $moduleConfigs_3['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude_3', true );
            $moduleConfigs_3['viewmore'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_viewmore_3', true );
            $backgroundID_3 = get_term_meta( $moduleConfigs_3['category_id'], 'bk_category_feat_img', false );
            if((tnm_core::bk_check_array($backgroundID_3)) && ($backgroundID_3[0] != '')) {
                $tmp = wp_get_attachment_image_src( $backgroundID_3[0], 'tnm-l-4_3' );
                $moduleConfigs_3['background'] = $tmp[0];
            }else {
                $moduleConfigs_3['background'] = '';
            }
            
            
            $moduleConfigs_4['title']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title_4', true );
            $moduleConfigs_4['orderby'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby_4', true );
            $moduleConfigs_4['tags']    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags_4', true ); 
            $moduleConfigs_4['limit']   = 4;
            $moduleConfigs_4['offset']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset_4', true );
            $moduleConfigs_4['feature'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature_4', true );
            $moduleConfigs_4['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category_4', true );
            $moduleConfigs_4['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude_4', true );
            $moduleConfigs_4['viewmore'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_viewmore_4', true );
            $backgroundID_4 = get_term_meta( $moduleConfigs_4['category_id'], 'bk_category_feat_img', false );
            if((tnm_core::bk_check_array($backgroundID_4)) && ($backgroundID_4[0] != '')) {
                $tmp = wp_get_attachment_image_src( $backgroundID_4[0], 'tnm-l-4_3' );
                $moduleConfigs_4['background'] = $tmp[0];
            }else {
                $moduleConfigs_4['background'] = '';
            }
            

            $the_query_1 = bk_get_query::query($moduleConfigs_1);              //get query
            $the_query_2 = bk_get_query::query($moduleConfigs_2);
            $the_query_3 = bk_get_query::query($moduleConfigs_3);
            $the_query_4 = bk_get_query::query($moduleConfigs_4);
            
            if (( $the_query_1->have_posts() ) || ( $the_query_2->have_posts() ) || ( $the_query_3->have_posts() ) || ( $the_query_4->have_posts() )) :
            $block_str .= '<div id="'.$moduleID.'" class="mnmd-block mnmd-block--fullwidth mnmd-posts-listing-a grid-gutter-10">';
            $block_str .= '<div class="container">';
           	$block_str .= '<div class="row row--space-between">';
           
            //Column 1
            $imgBGStyle = "background-image: url('".$moduleConfigs_1['background']."')";
            $block_str .= '<div class="col-sm-6 col-md-3">';
            $block_str .= '<div class="mnmd-posts-listing-a__cat-wrap">';
            $block_str .= '<div class="background-img background-img--darkened grayscale" style="'.$imgBGStyle.'"></div>';
            $block_str .= '<div class="background-overlay cat-theme-bg cat-'.$moduleConfigs_1['category_id'].'"></div>';
            $block_str .= '<div class="mnmd-posts-listing-a__cat-inner inverse-text">';
            $block_str .= '<h4 class="cat-title">'.$moduleConfigs_1['title'].'</h4>';
            if ( $the_query_1->have_posts() ) :
                $block_str .= $this->render_modules($the_query_1);            //render modules
            endif;

            if($moduleConfigs_1['viewmore'] == 'yes') {
                $block_str .= '<div class="spacer-xs"></div>';
                $vmArray = array(
                    'class' => 'tnm-block-g-viewmore',
                    'text'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_text_1', true ),
                    'link'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_link_1', true ),
                    'target' => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_target_1', true ),
                );
                $block_str .= tnm_ajax_function::get_viewmore_link($vmArray);
            }
            $block_str .= '</div>';
            $block_str .= '</div>';
            $block_str .= '</div><!-- end Column 1 -->';
            
            //Column 2
            $imgBGStyle = "background-image: url('".$moduleConfigs_2['background']."')";
            $block_str .= '<div class="col-sm-6 col-md-3">';
            $block_str .= '<div class="mnmd-posts-listing-a__cat-wrap">';
            $block_str .= '<div class="background-img background-img--darkened grayscale" style="'.$imgBGStyle.'"></div>';
            $block_str .= '<div class="background-overlay cat-theme-bg cat-'.$moduleConfigs_2['category_id'].'"></div>';
            $block_str .= '<div class="mnmd-posts-listing-a__cat-inner inverse-text">';
            $block_str .= '<h4 class="cat-title">'.$moduleConfigs_2['title'].'</h4>';
            if ( $the_query_2->have_posts() ) :
                $block_str .= $this->render_modules($the_query_2);            //render modules
            endif;

            if($moduleConfigs_2['viewmore'] == 'yes') {
                $block_str .= '<div class="spacer-xs"></div>';
                $vmArray = array(
                    'class' => 'tnm-block-g-viewmore',
                    'text'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_text_2', true ),
                    'link'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_link_2', true ),
                    'target' => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_target_2', true ),
                );
                $block_str .= tnm_ajax_function::get_viewmore_link($vmArray);
            }
            $block_str .= '</div>';
            $block_str .= '</div>';
            $block_str .= '</div><!-- end Column 2 -->';
            
            $block_str .= '<div class="clearfix visible-sm"></div>';
            
            //Column 3
            $imgBGStyle = "background-image: url('".$moduleConfigs_3['background']."')";
            $block_str .= '<div class="col-sm-6 col-md-3">';
            $block_str .= '<div class="mnmd-posts-listing-a__cat-wrap">';
            $block_str .= '<div class="background-img background-img--darkened grayscale" style="'.$imgBGStyle.'"></div>';
            $block_str .= '<div class="background-overlay cat-theme-bg cat-'.$moduleConfigs_3['category_id'].'"></div>';
            $block_str .= '<div class="mnmd-posts-listing-a__cat-inner inverse-text">';
            $block_str .= '<h4 class="cat-title">'.$moduleConfigs_3['title'].'</h4>';
            if ( $the_query_3->have_posts() ) :
                $block_str .= $this->render_modules($the_query_3);            //render modules
            endif;

            if($moduleConfigs_3['viewmore'] == 'yes') {
                $block_str .= '<div class="spacer-xs"></div>';
                $vmArray = array(
                    'class' => 'tnm-block-g-viewmore',
                    'text'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_text_3', true ),
                    'link'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_link_3', true ),
                    'target' => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_target_3', true ),
                );
                $block_str .= tnm_ajax_function::get_viewmore_link($vmArray);
            }
            $block_str .= '</div>';
            $block_str .= '</div>';
            $block_str .= '</div><!-- end Column 3 -->';
            
            //Column 4
            $imgBGStyle = "background-image: url('".$moduleConfigs_4['background']."')";
            $block_str .= '<div class="col-sm-6 col-md-3">';
            $block_str .= '<div class="mnmd-posts-listing-a__cat-wrap">';
            $block_str .= '<div class="background-img background-img--darkened grayscale" style="'.$imgBGStyle.'"></div>';
            $block_str .= '<div class="background-overlay cat-theme-bg cat-'.$moduleConfigs_4['category_id'].'"></div>';
            $block_str .= '<div class="mnmd-posts-listing-a__cat-inner inverse-text">';
            $block_str .= '<h4 class="cat-title">'.$moduleConfigs_4['title'].'</h4>';
            if ( $the_query_4->have_posts() ) :
                $block_str .= $this->render_modules($the_query_4);            //render modules
            endif;

            if($moduleConfigs_4['viewmore'] == 'yes') {
                $block_str .= '<div class="spacer-xs"></div>';
                $vmArray = array(
                    'class' => 'tnm-block-g-viewmore',
                    'text'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_text_4', true ),
                    'link'   => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_link_4', true ),
                    'target' => get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_view_more_target_4', true ),
                );
                $block_str .= tnm_ajax_function::get_viewmore_link($vmArray);
            }
            $block_str .= '</div>';
            $block_str .= '</div>';            
            $block_str .= '</div><!-- end Column 4 -->';
            
            $block_str .= '</div>';
            $block_str .= '</div><!-- container -->';
            $block_str .= '</div><!-- .mnmd-block -->';
            
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function render_modules ($the_query){
            $render_modules = '';
            if ( $the_query->have_posts() ) :
                $render_modules .= '<ul class="list-space-sm list-seperated list-unstyled">';
                while ( $the_query->have_posts() ): $the_query->the_post();
                    
                    $render_modules .= '<li>';
					$render_modules .= '<article class="post">';
					$render_modules .= '<h3 class="post__title typescale-0">'.tnm_core::bk_get_post_title_link(get_the_ID()).'</h3>';
					$render_modules .= '</article>';
					$render_modules .= '</li>';
                    
                endwhile; 
                $render_modules .= '</ul>';
            endif;
            return $render_modules;
        }
    }
}