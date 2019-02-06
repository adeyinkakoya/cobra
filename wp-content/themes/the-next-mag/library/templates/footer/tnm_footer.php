<?php
if (!class_exists('tnm_footer')) {
    class tnm_footer {
        static function bk_footer_mailchimp(){
            $tnm_option = tnm_core::bk_get_global_var('tnm_option');
            $htmlOutput = '';
			
            if(isset($tnm_option['footer-mailchimp--shortcode']) && ($tnm_option['footer-mailchimp--shortcode'] != '')) :
    			$htmlOutput .= do_shortcode($tnm_option['footer-mailchimp--shortcode']);
            endif;
            
            return $htmlOutput;
        }
        
    } // Close tnm_single
    
}