<?php
if (!class_exists('tnm_ajax_megamenu')) {
    class tnm_ajax_megamenu {
        //Search Query
        static function tnm_query($CatID) {
            $args = array(
                'cat' => $CatID,  
                'post_type' => 'post',  
                'post_status' => 'publish', 
                'ignore_sticky_posts' => 1,  
                'posts_per_page' => 4
            );
    
            $the_query = new WP_Query($args);
            return $the_query;
        }
        static function tnm_ajax_content( $the_query, $hasBigPost ) {
            $contentReturn = '';
            if($hasBigPost == 1) {
                $contentReturn .= tnm_header::bk_get_megamenu_1stlarge_posts($the_query); 
            }else {
                $contentReturn .= tnm_header::bk_get_megamenu_posts($the_query); 
            }
            return $contentReturn;
        }
    }
}
add_action('wp_ajax_nopriv_tnm_ajax_megamenu', 'tnm_ajax_megamenu');
add_action('wp_ajax_tnm_ajax_megamenu', 'tnm_ajax_megamenu');
if (!function_exists('tnm_ajax_megamenu')) {
    function tnm_ajax_megamenu()
    {        
        check_ajax_referer( 'tnm_ajax_security', 'securityCheck' );
        
        $CatID      = isset( $_POST['thisCatID'] ) ? $_POST['thisCatID'] : null; 
        $hasBigPost = isset( $_POST['hasBigPost'] ) ? $_POST['hasBigPost'] : null; 
        
        $dataReturn = 'no-result';
        
        $the_query = tnm_ajax_megamenu::tnm_query($CatID);
        
        if ( $the_query->have_posts() ) {
            $dataReturn = tnm_ajax_megamenu::tnm_ajax_content($the_query, intval($hasBigPost));
        }else {
            $dataReturn = 'no-result';        
        }
        
        die(json_encode($dataReturn));
    }
}