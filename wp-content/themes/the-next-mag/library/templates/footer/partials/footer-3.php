<?php 
    $tnm_option = tnm_core::bk_get_global_var('tnm_option');
    if ((isset($tnm_option['bk-footer-inverse'])) && (($tnm_option['bk-footer-inverse']) == 1)){ 
        $inverseClass = 'yes';
    }else {
        $inverseClass = '';
    }
    if ((isset($tnm_option['bk-footer-pattern'])) && (($tnm_option['bk-footer-pattern']) == 1)){ 
        $has_Pattern = 'yes';
    }else {
        $has_Pattern = '';
    }
?>	
<footer class="site-footer footer-3 <?php if($has_Pattern == "yes") echo " has-bg-pattern";?> <?php if($inverseClass == "yes") echo " site-footer--inverse inverse-text";?>">
    <div class="site-footer__inner">
        <?php if(isset($tnm_option['footer-mailchimp--shortcode']) && ($tnm_option['footer-mailchimp--shortcode'] != '')) :?>
        <div class="site-footer__section">
			<div class="container">
				<div class="subscribe-form subscribe-form--horizontal text-center max-width-sm">
					<?php echo tnm_footer::bk_footer_mailchimp();?>
				</div>
			</div>
        </div>
        <?php endif;?>
    </div>
    <div class="site-footer__section site-footer__section--bordered-inner site-footer__section--flex">
        <div class="container">
			<div class="site-footer__section-inner">
                <?php if ( has_nav_menu( 'footer-menu' ) ) : ?>
                <div class="site-footer__section-left">
                    <?php 
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer-menu', 
                            'depth' => '1', 
                            'menu_class' => 'navigation navigation--footer navigation--inline',
                            )
                        ); 
                    ?>
                </div>
                <?php endif;?>
                <?php if(isset($tnm_option['footer-copyright-text']) && ($tnm_option['footer-copyright-text'] != '')) :?>
                <div class="site-footer__section-right">
                    <?php
                        $tnm_allow_html = array(
                            'a' => array(
                                'href' => array(),
                                'title' => array()
                            ),
                            'br' => array(),
                            'em' => array(),
                            'strong' => array(),
                        );
                        echo wp_kses($tnm_option['footer-copyright-text'], $tnm_allow_html);
                    ?>
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</footer>
<?php 
    if((isset($tnm_option['bk-sticky-menu-switch'])) && ($tnm_option['bk-sticky-menu-switch'] == 1)):
        get_template_part( 'library/templates/header/tnm-sticky-header' );
    endif;
    
    if ( function_exists('login_with_ajax') ) {
        get_template_part( 'library/templates/tnm-login-modal' );
    }
    
    if ( isset($tnm_option ['bk-offcanvas-desktop-switch']) && ($tnm_option ['bk-offcanvas-desktop-switch'] != 0) ){
        get_template_part( 'library/templates/offcanvas/offcanvas-desktop' );
    }
    
    get_template_part( 'library/templates/offcanvas/offcanvas-mobile' );
    
    if((isset($tnm_option['bk-header-subscribe-switch'])) && ($tnm_option['bk-header-subscribe-switch'] == 1)):
        get_template_part( 'library/templates/tnm-subscribe-modal' );
    endif;
    
?>
<!-- go top button -->
<a href="#" class="mnmd-go-top btn btn-default hidden-xs js-go-top-el"><i class="mdicon mdicon-arrow_upward"></i></a>