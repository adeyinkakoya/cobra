<?php
if (!class_exists('tnm_featured_with_list_horizontal')) {
    class tnm_featured_with_list_horizontal {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_featured_with_list_horizontal-');
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            $contiguousClass = 'mnmd-block--contiguous';
            
            $moduleConfigs['orderby']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true );
            $moduleConfigs['offset'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );
            $moduleConfigs['limit'] = 4;
            
            //Post Source
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            
            $the_query = bk_get_query::tnm_query($moduleConfigs);              //get query
            
            $moduleData['the_query'] = $the_query;
            $moduleData['moduleConfigs'] = $moduleConfigs;
            
            if ( $the_query->have_posts() ) :
            $block_str .= '<div id="'.$moduleID.'" class="mnmd-block mnmd-block--fullwidth mnmd-featured-with-list mnmd-featured-with-list--horizontal-list '.$contiguousClass.'">';
           	$block_str .= '<div class="mnmd-featured-with-list__wrapper mnmd-block__inner js-overlay-bg">';
            $block_str .= $this->render_modules($moduleData);            //render modules
            $block_str .= '</div><!-- .container -->';
            $block_str .= '</div><!-- .mnmd-block -->';
            
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function postText($postID){
            
            $cat_L = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_cat_l', true );
            $meta_L = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_meta_l', true );
            $excerpt_L = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_excerpt_l', true );
            
            
            $bk_permalink = esc_url(get_permalink($postID));
            $bk_post_title = get_the_title($postID);
            $postText = '';            
            $postText .= '<div class="post__text inverse-text text-center max-width-md">';
            if($cat_L == 1) {
                $catClass = 'post__cat post__cat--bg cat-theme-bg';
                $postText .= tnm_core::bk_get_post_cat_link($postID, $catClass);
            }
    		$postText .= '<h3 class="post__title typescale-6"><a href="'.$bk_permalink.'">'.$bk_post_title.'</a></h3>';
    		if($excerpt_L == 1) {
                $postText .= '<div class="post__excerpt post__excerpt--lg hidden-xs">';
                $postText .= tnm_core::bk_get_post_excerpt(20);
    			$postText .= '</div>';
            }
            if($meta_L == 1) {
                $postText .= '<div class="post__meta">';
        		$postText .= '<span class="entry-author">By <a href="'. get_author_posts_url(get_the_author_meta( 'ID' )).'" class="entry-author__name">'. get_the_author() .'</a></span>';
        		$postText .= '</div>';
            }
			$postText .= '</div>';
            
            return $postText;
        }
        public function main_post($postID){
            $customArgs = array (
                'postID'        => $postID,
                'thumbSize'     => 'tnm-s-4_3',                                              
            );
            $ImgBGLink  = tnm_core::bk_get_post_thumbnail_bg_link($customArgs);       
            $BGImg      = "background-image: url('".$ImgBGLink."')";
            
            $mainPost = '';
            $mainPost .= '<article class="main-post post">';
			$mainPost .= '<div class="main-post__inner">';
            $mainPost .= '<div class="background-img background-img--darkened hidden-md hidden-lg" style="'.$BGImg.'"></div>';
			$mainPost .= $this->postText($postID);
			$mainPost .= '</div>';
			$mainPost .= '</article>';
            return $mainPost;                        
        }
        public function render_modules ($moduleData){
            $the_query = $moduleData['the_query'];
            $moduleConfigs = $moduleData['moduleConfigs'];
            $render_modules = '';
            if ( $the_query->have_posts() ) :
                $the_query->the_post();
                $postID = get_the_ID();
                                        
                $customArgs = array (
                    'postID'        => $postID,
                    'thumbSize'     => 'tnm-xxl',                                
                );
                $firstBGLink     = tnm_core::bk_get_post_thumbnail_bg_link($customArgs);       
                $firstBGImg   = "background-image: url('".$firstBGLink."')";
                $render_modules .= '<div class="main-background background-img hidden-xs hidden-sm" style="'.$firstBGImg.'"></div>';
                $render_modules .= '<div class="mnmd-featured-with-list__inner">';
                $render_modules .= $this->main_post($postID);
            endif;
            $postHorizontalHTML = new tnm_horizontal_1;
            $cat_S = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_cat_s', true );
                $postHorizontalAttr = array (
                    'additionalClass'       => 'post--horizontal-middle post--horizontal-xs',
                    'additionalTextClass'   => 'inverse-text',
                    'catClass'              => 'post__cat post__cat--bg cat-theme-bg',
                    'cat'                   => $cat_S?4:0,
                    'thumbSize'             => 'tnm-xxs-1_1',
                    'additionalThumbClass'  => 'post__thumb--circle',
                    'typescale'             => 'typescale-1',
                );
            if ( $the_query->have_posts() ) :
                $render_modules .= '<div class="sub-posts js-overlay-bg-sub-area">';
                $render_modules .= '<div class="js-overlay-bg-sub sub-background background-img blurred hidden-xs hidden-sm" style="'.$firstBGImg.'"></div>';
                $render_modules .= '<div class="sub-posts__inner">';
                $render_modules .= '<ul class="posts-list list-space-md list-seperated list-unstyled">';
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $postHorizontalAttr['postID'] = get_the_ID();
                    $render_modules .= '<li>';
                    $render_modules .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_modules .= '</li> <!-- end small item -->';
                endwhile;                    
                $render_modules .= '</ul><!-- end small item list-->';
                $render_modules .= '</div>';
                $render_modules .= '</div><!-- .sub-posts -->';
            endif;
            
            $render_modules .= '</div><!-- .mnmd-featured-with-list__inner -->';
            
            return $render_modules;
        }
        
    }
}