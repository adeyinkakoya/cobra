<?php
if (!class_exists('tnm_carousel_heading_aside_bg')) {
    class tnm_carousel_heading_aside_bg {
        
        static $pageInfo=0;
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_carousel_heading_aside_bg-');
            $carouselID = uniqid('carousel-');
            $moduleConfigs = array();
            
            self::$pageInfo = $page_info;
            
            //get config
            $moduleConfigs['carouselID']    = $carouselID;
            $moduleConfigs['title']         = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );     
            $moduleConfigs['subtitle']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_subtitle', true );   
            $moduleConfigs['carousel_loop'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_carousel_loop', true );  
            $moduleConfigs['orderby']       = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']          = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit']         = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit', true );
            $moduleConfigs['offset']        = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature']       = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['editor_pick']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );
            
            //Post Source & Icon
            $moduleConfigs['post_source'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_source', true );
            $moduleConfigs['post_icon'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true );      
            $the_query = bk_get_query::tnm_query($moduleConfigs);              //get query
            
            if($the_query->post_count < 4):
                $moduleConfigs['carousel_loop'] = 0;
            endif;
            
            if ( $the_query->have_posts() ) :
                $block_str .= '<div id="'.$moduleID.'" class="mnmd-block mnmd-block--fullwidth mnmd-carousel mnmd-carousel-heading-aside has-background">';
                
                $moduleConfigs['bg_option'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_bg_option', true );
                if($moduleConfigs['bg_option'] == 'image') :
                    $moduleConfigs['background_img'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_img', true );            
                    $imgBGStyle = "background-image: url('".$moduleConfigs['background_img']."')";
                    $block_str .= '<div class="background-img" style="'.$imgBGStyle.'"></div>';
                else:
                    $gradient_bg__from  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_gradient_from', true );
                    $gradient_bg__to    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_gradient_to', true );
                    $gradient_bg__direction = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_gradient_direction', true );
                    $background_pattern  = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_background_pattern', true );
                    $patternHTML = '';
                    if($background_pattern == 1) :
                        $patternHTML = '<div class="background-svg-pattern"></div>';
                    endif;  
                                              
                    $block_str .= '<div class="background-img gradient-5" style="
                        background: '.$gradient_bg__from.';
                        background: -webkit-linear-gradient('.$gradient_bg__direction.'deg, '.$gradient_bg__from.' 0, '.$gradient_bg__to.' 100%);
                        background: linear-gradient('.$gradient_bg__direction.'deg, '.$gradient_bg__from.' 0, '.$gradient_bg__to.' 100%);
                    ">'.$patternHTML.'</div>';
                endif; 
                                            
               	$block_str .= '<div class="container">';
                $block_str .= '<div class="row">';
                $block_str .= '<div class="col-xs-12 col-sm-4 col-md-3">';
                $block_str .= $this->heading($moduleConfigs);
    			$block_str .= '</div><!-- end column -->';
                
                $block_str .= '<div class="carousel-wrap col-xs-12 col-sm-8 col-md-9 fullwidth-xs">';
                $block_str .= '<div id="'.$carouselID.'" class="owl-carousel js-mnmd-carousel-heading-aside-3i" data-carousel-loop="'.$moduleConfigs['carousel_loop'].'">';
                $block_str .= $this->render_modules($the_query);            //render modules
                $block_str .= '</div>';
                $block_str .= '</div>';
                
                $block_str .= '</div>';
                $block_str .= '</div><!-- .container -->';
                $block_str .= '</div><!-- .mnmd-block -->';
                        
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function heading( $moduleConfigs ) {
            $heading = '';
            $heading .= '<div class="carousel-heading">';
			$heading .= '<div class="block-heading block-heading--inverse block-heading--vertical">';
			$heading .= '<h4 class="block-heading__title">'.$moduleConfigs['title'].'</h4>';
			$heading .= '<span class="block-heading__subtitle">'.$moduleConfigs['subtitle'].'</span>';
			$heading .= '</div>';
			$heading .= '<div class="mnmd-carousel-nav-custom-holder" data-carouselID="'.$moduleConfigs['carouselID'].'">';
			$heading .= '<div class="owl-prev js-carousel-prev"><i class="mdicon mdicon-arrow_back"></i></div>';
			$heading .= '<div class="owl-next js-carousel-next"><i class="mdicon mdicon-arrow_forward"></i></div>';
			$heading .= '</div>';
			$heading .= '</div>';
            return $heading;
        }
        public function render_modules ($the_query){
            $render_modules = '';
            $postCardHTML = new tnm_card_1;
            
            $footerStyle = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_footer_style', true );
            
            $iconPosition = 'center';
            
            // Meta
            $meta = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_meta', true );
            
            if($meta != 0) {
                $metaArray = tnm_core::bk_get_meta_list($meta);
            }else {
                $metaArray = '';
            }
            
            // Category Style ($cat)
            $cat = get_post_meta( self::$pageInfo['page_id'], self::$pageInfo['block_prefix'].'_cat_style', true );
            if($cat != 0){
                $catStyle = 2; //Overlap
                $cat_Class = tnm_core::bk_get_cat_class($catStyle);
                $articleAddtionalClass = '';
            }else {
                $catStyle = '';
                $cat_Class = '';
                $articleAddtionalClass = 'cat--not-overlap';
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
            
            if ( $the_query->have_posts() ) :
                $postCardAttr = array (
                    'cat'               => $catStyle,
                    'catClass'          => $cat_Class,
                    'additionalClass'   => 'post--card-sm text-center '.$articleAddtionalClass,
                    'thumbSize'         => 'tnm-xs-16_9 400x225',
                    'typescale'         => 'typescale-1',
                    'meta'              => $metaArray,
                    'footerType'        => $footerStyle,
                    'postIcon'          => $postIconAttr, 
                );
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $postCardAttr['postID'] = get_the_ID();
                    if($bypassPostIconDetech != 1) {
                        $addClass = 'overlay-item--sm-p';
                        if($postSource != 'all') {
                            $postIconAttr['iconType'] = $postSource;
                        }else {
                            $postIconAttr['iconType']   = tnm_core::bk_post_format_detect(get_the_ID());
                        }

                        $postIconAttr['postIconClass']  = tnm_core::get_post_icon_class($postIconAttr['iconType'], '', $iconPosition, $addClass);
                        
                        $postCardAttr['postIcon']    = $postIconAttr;
                    }
                    $render_modules .= '<div class="slide-content">';
                    $render_modules .= $postCardHTML->render($postCardAttr);
                    $render_modules .= '</div>';
                endwhile;
            endif;
            
            return $render_modules;
        }
    }
}