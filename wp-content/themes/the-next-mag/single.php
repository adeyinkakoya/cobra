<?php
    $tnm_option = tnm_core::bk_get_global_var('tnm_option');
    
    if(function_exists('bk_set__cookie')) {
        $tnm_cookie = bk_set__cookie();
    }else {
        $tnm_cookie = 1;
    }
    
    get_header();
    
    if ( have_posts() ) : while ( have_posts() ) : the_post(); 
    
    $postID = get_the_ID();  
    
    if ($tnm_cookie == 1) {
        tnm_core::bk_setPostViews($postID);
    }
    
    $tnm_single_template = 'single-1';
    
    if (isset($tnm_option) && ($tnm_option != '')): 
        $bk_single_template = $tnm_option['bk-single-template'];
    endif;
    
    if(function_exists('has_post_format')):
        $postFormat = get_post_format($postID);
    else :
        $postFormat = 'standard';
    endif;
    
    $bkPostLayout = get_post_meta($postID,'bk_post_layout_standard',true);
    
    if($bkPostLayout == 'global_settings') {
        get_template_part( '/library/templates/single/partials/'.$bk_single_template );
    }else if($bkPostLayout == 'single-1') {
        get_template_part( '/library/templates/single/partials/single-1' ); //single-1
    }else if($bkPostLayout == 'single-2') {
        get_template_part( '/library/templates/single/partials/single-2' ); //single-1-alt
    }else if($bkPostLayout == 'single-3') {
        get_template_part( '/library/templates/single/partials/single-3' ); //single-1--no-sidebar
    }else if($bkPostLayout == 'single-4') {
        get_template_part( '/library/templates/single/partials/single-4' ); //single-2
    }else if($bkPostLayout == 'single-5') {
        get_template_part( '/library/templates/single/partials/single-5' ); //single-2-alt
    }else if($bkPostLayout == 'single-6') {
        get_template_part( '/library/templates/single/partials/single-6' ); //single-2--no-sidebar
    }else if($bkPostLayout == 'single-7') {
        get_template_part( '/library/templates/single/partials/single-7' ); //single-3
    }else if($bkPostLayout == 'single-8') {
        get_template_part( '/library/templates/single/partials/single-8' ); //single-3--no-sidebar
    }else if($bkPostLayout == 'single-9') {
        get_template_part( '/library/templates/single/partials/single-9' ); //single-4
    }else if($bkPostLayout == 'single-10') {
        get_template_part( '/library/templates/single/partials/single-10' ); //single-4--no-sidebar
    }else if($bkPostLayout == 'single-11') {
        get_template_part( '/library/templates/single/partials/single-11' ); //single-5
    }else if($bkPostLayout == 'single-12') {
        get_template_part( '/library/templates/single/partials/single-12' ); //single-5--Center
    }else if($bkPostLayout == 'single-13') {
        get_template_part( '/library/templates/single/partials/single-13' ); //single-5--No Sidebar
    }else if($bkPostLayout == 'single-14') {
        get_template_part( '/library/templates/single/partials/single-14' ); //single-6
    }else if($bkPostLayout == 'single-15') {
        get_template_part( '/library/templates/single/partials/single-15' ); //single-6--Center
    }else if($bkPostLayout == 'single-16') {
        get_template_part( '/library/templates/single/partials/single-16' ); //single-6--No Sidebar
    }else if($bkPostLayout == 'single-17') {
        if($postFormat != 'video') :
            get_template_part( '/library/templates/single/single-1' );
        else :
            get_template_part( '/library/templates/single/partials/single-17' ); //single-7 - Video
        endif;        
    }else {
        get_template_part( '/library/templates/single/partials/'.$bk_single_template );
    }
    
    endwhile; endif;
    
    get_footer(); 
?>