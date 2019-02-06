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
<footer class="site-footer footer-1 <?php if($has_Pattern == "yes") echo " has-bg-pattern";?> <?php if($inverseClass == "yes") echo " site-footer--inverse inverse-text";?>">
    <?php if(isset($tnm_option['footer-mailchimp--shortcode']) && ($tnm_option['footer-mailchimp--shortcode'] != '')) :?>
    <?php
        if ((isset($tnm_option['bk-footer--mailchimp-bg']['background-image'])) && ($tnm_option['bk-footer--mailchimp-bg']['background-image'] != '')) :
            $imgBGStyle = "background-image: url('".$tnm_option['bk-footer--mailchimp-bg']['background-image'] ."')";
        else :
            $imgBGStyle = '';
        endif;
    ?>
	<div class="site-footer__section site-footer__section--seperated">
        <?php
        if($tnm_option['bk-footer--mailchimp-bg']['background-image'] != '') {
            echo '<div class="background-img" style="'.$imgBGStyle.'"></div>';
        }else {
            echo '<div class="background-img gradient-5"></div>';
        }
        ?>
		<div class="container">
			<div class="site-footer__section-inner">
				<div class="subscribe-form subscribe-form--horizontal text-center max-width-sm">
					<?php echo tnm_footer::bk_footer_mailchimp();?>
				</div>
			</div>
		</div>
	</div>
    <?php endif;?>
    <?php if ( has_nav_menu( 'footer-menu' ) ) : ?>
	<div class="site-footer__section site-footer__section--seperated site-footer__section--bordered">
		<div class="container">
			<nav class="footer-menu footer-menu--bold text-center">
                <?php 
                wp_nav_menu(
                    array(
                        'theme_location' => 'footer-menu', 
                        'depth' => '1', 
                        'menu_class' => 'navigation navigation--footer navigation--inline',
                        )
                ); 
                ?>
			</nav>
		</div>
	</div>
    <?php endif;?>
    <?php if(isset($tnm_option['footer-social']) && ($tnm_option['footer-social'] != '')) :?>
	<div class="site-footer__section">
		<div class="container">
			<ul class="social-list social-list--lg list-center">
				<?php 
                    echo tnm_core::bk_get_social_media_links($tnm_option['footer-social']);
                ?>
			</ul>
		</div>
	</div>
    <?php endif;?>
    <?php if(isset($tnm_option['footer-copyright-text']) && ($tnm_option['footer-copyright-text'] != '')) :?>
	<div class="site-footer__section">
		<div class="container">
			<div class="text-center">
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
		</div>
	</div>
    <?php endif;?>
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