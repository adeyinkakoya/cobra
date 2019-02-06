<?php
if (!class_exists('tnm_featured_block_a')) {
    class tnm_featured_block_a {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_featured_block_a-');
            $moduleConfigs = array();
            $moduleData = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            $contiguousClass = 'mnmd-block--contiguous';
            
            $moduleConfigs['title'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );
            $moduleConfigs['orderby']  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true );
            $moduleConfigs['offset'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );

            $moduleConfigs['limit'] = 5;
            
            //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            $moduleConfigs['post_icon'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true );      
            
            $moduleConfigs['heading_style'] = 'large-center';
            $moduleConfigs['heading_inverse'] = 'yes';
            
            if(isset($moduleConfigs['heading_style'])) {
                $headingClass = tnm_core::bk_get_block_heading_class($moduleConfigs['heading_style'], $moduleConfigs['heading_inverse']);
            }
            
            $heading_str = tnm_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
            
            $the_query = bk_get_query::tnm_query($moduleConfigs);              //get query
            
            $moduleData['the_query'] = $the_query;
            $moduleData['moduleConfigs'] = $moduleConfigs;
            $moduleData['headingString'] = $heading_str;
            
            if ( $the_query->have_posts() ) :
                $block_str .= '<div id="'.$moduleID.'" class="mnmd-block mnmd-block--fullwidth mnmd-featured-block-a has-background '.$contiguousClass.'">';
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
            $postText .= '<div class="post__text inverse-text max-width-sm">';
            if($cat_L == 1) {
                $catClass   = 'post__cat post__cat--bg cat-theme-bg';
                $postText .= tnm_core::bk_get_post_cat_link($postID, $catClass);
            }
    		$postText .= '<h3 class="post__title typescale-6"><a href="'.$bk_permalink.'">'.$bk_post_title.'</a></h3>';
            if($meta_L == 1) {
        		$postText .= '<div class="post__meta">';
        		$postText .= '<span class="entry-author">'.esc_html__('By', 'the-next-mag').' <a href="'. get_author_posts_url(get_the_author_meta( 'ID' )).'" class="entry-author__name">'. get_the_author() .'</a></span>';
        		$postText .= '</div>';
            }
            if($excerpt_L == 1) {
                $postText .= '<div class="post__excerpt">';
                $postText .= tnm_core::bk_get_post_excerpt(20);
    			$postText .= '</div>';
            }
            $postText .= '</div>';
            
            return $postText;
        }
        public function main_post($postID, $moduleData){
            $customArgs = array (
                'postID'        => $postID,
                'thumbSize'     => 'tnm-m-4_3',                                              
            );
            
            $ImgBGLink  = tnm_core::bk_get_post_thumbnail_bg_link($customArgs);       
            $BGImg      = "background-image: url('".$ImgBGLink."')";
            $category   = get_the_category($postID); 
            if(isset($category[0]) && $category[0]){
                $catID = 'cat-'.$category[0]->term_id;
            }
            $mainPost = '';
            $mainPost .= '<div class="main-post-wrap">';
            $mainPost .= '<div class="background-img background-img--darkened visible-xs" style="'.$BGImg.'"></div>';
            
            $mainPost .= $moduleData['headingString'];
            
            $mainPost .= '<article class="main-post post '.$catID.'">';
			$mainPost .= $this->postText($postID);
			$mainPost .= '</article>';
            
            $mainPost .= '</div>';
            return $mainPost;                        
        }    
        public function render_modules ($moduleData){
            $the_query = $moduleData['the_query'];
            
            $iconPosition = 'center';
            
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
            $subPostIDs = array();            
                                                            
            if ( $the_query->have_posts() ) :
                $the_query->the_post();
                $postID = get_the_ID();
                                        
                $customArgs = array (
                    'postID'        => $postID,
                    'thumbSize'     => 'tnm-xxl',                                
                );
                $firstBGLink     = tnm_core::bk_get_post_thumbnail_bg_link($customArgs);       
                $firstBGImg   = "background-image: url('".$firstBGLink."')";
                $render_modules .= '<div class="background-img"><div class="background-img background-img--darkened blurred hidden-xs" style="'.$firstBGImg.'"></div></div>';
                $render_modules .= '<div class="container">';
                $render_modules .= $this->main_post($postID, $moduleData);
                $render_modules .= '</div><!-- .container -->';
            endif;
            if ( $the_query->have_posts() ) :
                $postVerticalHTML = new tnm_vertical_1;
                $cat_S = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_cat_s', true );
                if($cat_S != 0){
                    $catStyle = 2; //Overlap Style
                    $cat_S_Class = tnm_core::bk_get_cat_class($catStyle);
                    $articleAdditionalClass = 'post--vertical-cat-overlap text-center';
                }else {
                    $catStyle = '';
                    $cat_S_Class = '';
                    $articleAdditionalClass = 'text-center';
                }
                         
                $postVerticalAttr = array (
                    'cat'           => $catStyle,
                    'catClass'      => $cat_S_Class,
                    'additionalClass' => $articleAdditionalClass,
                    'additionalTextClass' => 'inverse-text',
                    'thumbSize'     => 'tnm-xs-2_1',
                    'typescale'     => 'typescale-1',
                    'meta'          => array('author'),
                    'postIcon'      => $postIconAttr,
                );
                $render_modules .= '<div class="container">';
                $render_modules .= '<div class="sub-posts-wrap">';
                $render_modules .= '<div class="sub-posts hidden-xs">';
                $render_modules .= '<div class="row row--space-between">';
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $postVerticalAttr['postID'] = get_the_ID();
                    $subPostIDs[] = get_the_ID();
                    
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
                                                                                
                    $render_modules .= '<div class="col-xs-6 col-md-3">';
                    $render_modules .= $postVerticalHTML->render($postVerticalAttr);
                    $render_modules .= '</div> <!-- end small item -->';
                endwhile; 
                $render_modules .= '</div>';
                $render_modules .= '</div><!-- .sub-posts -->';
                
                $postHTML = new tnm_horizontal_feat_block_a;
                $postAttr = array (
                    'additionalClass'       => 'post--horizontal-middle post--horizontal-xxs',
                    'additionalTextClass'   => 'inverse-text',
                    'catClass'              => 'post__cat post__cat--bg cat-theme-bg',
                    'thumbSize'             => 'tnm-xs-1_1',
                    'typescale'             => 'typescale-0',
                );
                $render_modules .= '<div class="sub-posts inverse-text visible-xs">';
                $render_modules .= '<ul class="list-unstyled list-space-sm list-seperated">';
                foreach($subPostIDs as $postID) :
                    $postAttr['postID'] = $postID;
                    $render_modules .= $postHTML->render($postAttr);
                endforeach;
                $render_modules .= '</ul><!-- end small item list-->';
                $render_modules .= '</div>';
                                                
                $render_modules .= '</div>';
                $render_modules .= '</div><!-- .container -->';
            endif;            
            
            return $render_modules;
        }
    }
}