<?php if(!is_404()) :?>
<?php $tnm_option = tnm_core::bk_get_global_var('tnm_option');?>

<?php
    if (isset($tnm_option) && ($tnm_option != '')): 
        $bkFooterTemplate = $tnm_option['bk-footer-template'];
    else :
        $bkFooterTemplate = 'footer-1';
    endif;
    if ($bkFooterTemplate == 'footer-1') {
        get_template_part( 'library/templates/footer/partials/footer', '1' );
    }elseif ($bkFooterTemplate == 'footer-2') {
        get_template_part( 'library/templates/footer/partials/footer', '2' );
    }elseif ($bkFooterTemplate == 'footer-3') {
        get_template_part( 'library/templates/footer/partials/footer', '3' );
    }elseif ($bkFooterTemplate == 'footer-4') {
        get_template_part( 'library/templates/footer/partials/footer', '4' );
    }elseif ($bkFooterTemplate == 'footer-5') {
        get_template_part( 'library/templates/footer/partials/footer', '5' );
    }elseif ($bkFooterTemplate == 'footer-6') {
        get_template_part( 'library/templates/footer/partials/footer', '6' );
    }elseif ($bkFooterTemplate == 'footer-7') {
        get_template_part( 'library/templates/footer/partials/footer', '7' );
    }elseif ($bkFooterTemplate == 'footer-8') {
        get_template_part( 'library/templates/footer/partials/footer', '8' );
    }
?>
</div><!-- .site-wrapper -->
<?php
    tnm_core::tnm_create_ajax_security_code();
    wp_localize_script( 'thenextmag-scripts', 'ajax_buff', tnm_core::$globalBuff );
?>
<?php endif; //End if is_404?>
<?php wp_footer(); ?>

</body>
</html>