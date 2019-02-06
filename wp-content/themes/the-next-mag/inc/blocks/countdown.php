<?php
if (!class_exists('tnm_countdown')) {
    class tnm_countdown {
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_countdown-');
            $moduleConfigs = array();
            $moduleData = array();
            
            //get config
            
            $moduleConfigs['title'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );     
            $moduleConfigs['subtitle'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_subtitle', true );     
            $moduleConfigs['date'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_date', true );
            $moduleConfigs['des_link'] = esc_url(get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_des_link', true ));
            $moduleConfigs['button_text'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_button_text', true );            
            
            if($moduleConfigs['des_link'] != null) {
                $desLink = $moduleConfigs['des_link'];
            }else {
                $desLink = '#';
            }
            
            if($moduleConfigs['button_text'] != null) {
                $buttonText = $moduleConfigs['button_text'];
            }else {
                $buttonText = '';
            }
            
            if($moduleConfigs['date'] != null) :
                $block_str .= '<div id="'.$moduleID.'" class="mnmd-block mnmd-block--fullwidth mnmd-countdown-block">';
                $block_str .= '<div class="container">';
                $block_str .= '<div class="mnmd-block__inner inverse-text">';
                
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

                $block_str .= '<div class="row row--space-between row--flex row--vertical-center">';
                $block_str .= '<div class="col-xs-12 col-md-6">';
                $block_str .= '<div class="mnmd-countdown">';
                $block_str .= '<div class="mnmd-countdown__inner meta-font js-countdown" data-countdown="'.$moduleConfigs['date'].'"></div>';
                $block_str .= '</div>';
                $block_str .= '</div>';
                
                $block_str .= '<div class="col-xs-12 col-md-6 text-center">';
                
                if($moduleConfigs['subtitle'] != null) :
                    $block_str .= '<h3 class="typescale-4"><a href="#" class="link">'.$moduleConfigs['title'].'</a></h3>';
                endif;
                if($moduleConfigs['subtitle'] != null) :
                    if($buttonText != null) :
                        $block_str .= '<p class="text-secondary">'.$moduleConfigs['subtitle'].'</p>';
                        $block_str .= '<br/>';
                        $block_str .= '<a href="'.$desLink.'" class="btn btn-primary">'.$buttonText.'</a>';
                    else :
                        $block_str .= '<span class="text-secondary">'.$moduleConfigs['subtitle'].'</span>';
                    endif;
                endif;
                
                $block_str .= '</div>';
                $block_str .= '</div>';
                $block_str .= '<a href="'.$desLink.'" class="link-overlay"></a>';
                $block_str .= '</div>';
                $block_str .= '</div><!-- .container -->';
                $block_str .= '</div><!-- .mnmd-block -->';
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}        
    }
}