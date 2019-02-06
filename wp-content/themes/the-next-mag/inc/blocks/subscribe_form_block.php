<?php
if (!class_exists('tnm_subscribe_form_block')) {
    class tnm_subscribe_form_block {
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_subscribe_form_block-');
            $moduleConfigs = array();
            
            $moduleConfigs['title'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );     
            $moduleConfigs['mailchim_shortcode'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_mailchim_shortcode', true );          
            
            $block_str .= '<div id="'.$moduleID.'" class="mnmd-block">';
            $block_str .= '<div class="subscribe-form-wrap">';
            $block_str .= '<div class="subscribe-form subscribe-form--has-background subscribe-form--horizontal text-center">';
            $block_str .= '<div class="subscribe-form__inner">';
            
            if($moduleConfigs['title'] != '') :
                $block_str .= '<h3>';
    			$block_str .= '<b>'.$moduleConfigs['title'].'</b>';
    			$block_str .= '</h3>';
            endif;

            if($moduleConfigs['mailchim_shortcode'] != ''):
                $block_str .= do_shortcode($moduleConfigs['mailchim_shortcode']);
			endif;
                        
            $block_str .= '</div><!-- .subscribe-form__inner -->';
            $block_str .= '</div>';
            $block_str .= '</div>';
            $block_str .= '</div><!-- .mnmd-block -->';
            
            unset($moduleConfigs); 
            wp_reset_postdata();
            return $block_str;            
    	}        
    }
}