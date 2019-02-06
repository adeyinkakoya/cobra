<?php
if (!class_exists('tnm_featured_with_overlap')) {
    class tnm_featured_with_overlap {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_featured_with_overlap-');
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
            $moduleConfigs['limit'] = 5;
            
            //Post Source & Icons
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            $moduleConfigs['post_icon'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true );                        
            
            $the_query = bk_get_query::tnm_query($moduleConfigs);              //get query
            
            $moduleData['the_query'] = $the_query;
            $moduleData['moduleConfigs'] = $moduleConfigs;
            
            if ( $the_query->have_posts() ) :
            $block_str .= '<div id="'.$moduleID.'" class="mnmd-block mnmd-block--fullwidth featured-with-overlap-posts '.$contiguousClass.'">';
            $block_str .= $this->render_modules($moduleData);            //render modules
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
            $postText .= '<div class="post__text inverse-text">';
            $postText .= '<div class="container">';
            $postText .= '<div class="post__text-inner max-width-sm text-center">';
            if($cat_L == 1) {
                $catClass = 'post__cat post__cat--bg cat-theme-bg';
                $postText .= tnm_core::bk_get_post_cat_link($postID, $catClass);
            }
    		$postText .= '<h3 class="post__title typescale-5"><a href="'.$bk_permalink.'">'.$bk_post_title.'</a></h3>';
            if($excerpt_L == 1) {
                $postText .= '<div class="post__excerpt post__excerpt--lg hidden-xs">';
                $postText .= tnm_core::bk_get_post_excerpt(20);
    			$postText .= '</div>';
            }
            if($meta_L == 1) {
        		$postText .= '<div class="post__meta">';
        		$postText .= tnm_core::bk_get_post_meta(array('author', 'date', 'comment'));
        		$postText .= '</div>';
            }
            $postText .= '</div>';
            $postText .= '</div><!-- Close Main Post Container-->';
			$postText .= '</div>';
            
            return $postText;
        }
        public function main_post($postID){
            $customArgs = array (
                'postID'        => $postID,
                'thumbSize'     => 'tnm-xxl',                                              
            );
            $ImgBGLink  = tnm_core::bk_get_post_thumbnail_bg_link($customArgs);       
            $BGImg      = "background-image: url('".$ImgBGLink."')";
            
            $mainPost = '';
            $mainPost .= '<article class="main-post post">';
            $mainPost .= '<div class="background-img" style="'.$BGImg.'"></div>';
			$mainPost .= $this->postText($postID);
			$mainPost .= '</article>';
            return $mainPost;                        
        }
        public function render_modules ($moduleData){
            $the_query = $moduleData['the_query'];
            $moduleConfigs = $moduleData['moduleConfigs'];
            
            $cat_S = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_cat_s', true );
            if($cat_S != 0){
                $catStyle = 2; //Overlap Style
                $cat_S_Class = tnm_core::bk_get_cat_class($catStyle);
                $articleAdditionalClass = 'post--vertical-cat-overlap';
            }else {
                $catStyle = '';
                $cat_S_Class = '';
                $articleAdditionalClass = '';
            }
            
            $postSource = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_source', true );
            $postIcon = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_post_icon', true );
            $bypassPostIconDetech = 0;         
            $postIconAttr = array(); 
            $postIconAttr['postIconClass'] = '';
            $postIconAttr['iconType'] = '';
            
            if($postIcon == 'disable') {
                $bypassPostIconDetech = 1;
            }else {
                $bypassPostIconDetech = 0;
            }
            
            $render_modules = '';
            
            $iconPosition = 'center';
            
            if ( $the_query->have_posts() ) :
                $the_query->the_post();
                $postID = get_the_ID();
                                        
                $customArgs = array (
                    'postID'        => $postID,
                    'thumbSize'     => 'tnm-xxl',                                
                );
                $firstBGLink     = tnm_core::bk_get_post_thumbnail_bg_link($customArgs);       
                $firstBGImg   = "background-image: url('".$firstBGLink."')";
                $render_modules .= $this->main_post($postID);
            endif;
            
            $postVerticalHTML = new tnm_vertical_with_default_thumb;           
                                    
            $postVerticalAttr = array (
                'cat'               => $catStyle,
                'catClass'          => $cat_S_Class,
                'meta'              => array('date'),
                'thumbSize'         => 'tnm-xs-2_1',
                'typescale'         => 'typescale-1',
                'additionalTextClass'   => 'text-center',
                'postIcon'              => $postIconAttr,
                'additionalClass'   => $articleAdditionalClass,
                
            );
            if ( $the_query->have_posts() ) :
                $render_modules .= '<div class="container">';
                $render_modules .= '<div class="sub-posts">';
                $render_modules .= '<ul class="row row--space-between">';
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $postVerticalAttr['postID'] = get_the_ID();
                    
                    if($bypassPostIconDetech != 1) {
                        $addClass = 'overlay-item--sm-p';
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType']   = tnm_core::bk_post_format_detect(get_the_ID());
                        }
                        $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition, $addClass);
                        $postVerticalAttr['postIcon']   = $postIconAttr;
                    }
                
                    $render_modules .= '<li class="col-xs-6 col-md-3">';
                    $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                    $render_modules .= '</li> <!-- end small item -->';
                endwhile;                    
                $render_modules .= '</ul><!-- end small item list-->';
                $render_modules .= '</div><!-- .sub-posts -->';
            endif;
            
            $render_modules .= '</div><!-- .container -->';
            
            return $render_modules;
        }
    }
}