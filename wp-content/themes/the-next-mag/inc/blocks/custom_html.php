<?php
if (!class_exists('tnm_custom_html')) {
    class tnm_custom_html {
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_custom_html-');
            
            $moduleConfigs['title']             = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );
            $moduleConfigs['heading_style']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_heading_style', true );
            $moduleConfigs['heading_inverse']   = 'no';
            $moduleConfigs['customHTML']        = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_html', true );
            
            if(isset($moduleConfigs['heading_style'])) {
                $headingClass = tnm_core::bk_get_block_heading_class($moduleConfigs['heading_style'], $moduleConfigs['heading_inverse']);
            }
            
            if (substr( $page_info['block_prefix'], 0, 10 ) == 'bk_has_rsb') {
                $blockOpen  = '<div id="'.$moduleID.'" class="mnmd-block mnmd-custom-html">';  
                $blockClose = '</div><!-- .mnmd-block -->';                       
            }else {
                $blockOpen  = '<div id="'.$moduleID.'" class="mnmd-block mnmd-block--fullwidth mnmd-custom-html"><div class="container">';  
                $blockClose = '</div><!-- .container --></div><!-- .mnmd-block -->';
            }
            
            $block_str .= $blockOpen;
            $block_str .= tnm_core::bk_get_block_heading($moduleConfigs['title'], $headingClass);
            $block_str .= $moduleConfigs['customHTML'];
            $block_str .= $blockClose;

            return $block_str;
    	}
        
    }
}