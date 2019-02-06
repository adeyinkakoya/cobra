<?php 
    $tnm_option = tnm_core::bk_get_global_var('tnm_option');
    if ((isset($tnm_option['bk-offcanvas-desktop-logo'])) && (($tnm_option['bk-offcanvas-desktop-logo']) != NULL)){ 
        $logo = $tnm_option['bk-offcanvas-desktop-logo'];
        if (($logo != null) && (array_key_exists('url',$logo))) {
            if ($logo['url'] == '') {
                $logo = tnm_core::bk_get_theme_option('bk-logo');
            }
        }
    }else {
        $logo = tnm_core::bk_get_theme_option('bk-logo');
    }
?>
<!-- Off-canvas menu -->
<div id="mnmd-offcanvas-primary" class="mnmd-offcanvas js-mnmd-offcanvas js-perfect-scrollbar">
	<div class="mnmd-offcanvas__title">
		<h2 class="site-logo">
            <a href="<?php echo esc_url(get_home_url('/'));?>">
				<!-- logo open -->
                <?php if (($logo != null) && (array_key_exists('url',$logo))) {
                        if ($logo['url'] != '') {
                    ?>
                    <img src="<?php echo esc_url($logo['url']);?>" alt="<?php esc_attr_e('logo', 'the-next-mag');?>"/>
    			<!-- logo close -->
                <?php } else {?>
                    <?php echo esc_attr(bloginfo( 'name' ));?>
                <?php }
                } else {?>
                    <?php echo esc_attr(bloginfo( 'name' ));?>
                <?php } ?>
			</a>
        </h2>
        <?php if ( isset($tnm_option ['bk-offcanvas-desktop-social']) && ($tnm_option ['bk-offcanvas-desktop-social'] != '') ){ ?>
		<ul class="social-list list-horizontal">
			<?php echo tnm_core::bk_get_social_media_links($tnm_option['bk-offcanvas-desktop-social']);?>
		</ul>
        <?php }?>
		<a href="#mnmd-offcanvas-primary" class="mnmd-offcanvas-close js-mnmd-offcanvas-close" aria-label="Close"><span aria-hidden="true">&#10005;</span></a>
	</div>

	<div class="mnmd-offcanvas__section mnmd-offcanvas__section-navigation">
		<?php 
            if ( isset($tnm_option ['bk-offcanvas-desktop-menu']) && ($tnm_option ['bk-offcanvas-desktop-menu'] != '') ){
                if ( has_nav_menu( $tnm_option ['bk-offcanvas-desktop-menu'] ) ) : 
                    $menuSettings = array( 
                        'theme_location' => $tnm_option ['bk-offcanvas-desktop-menu'],
                        'container_id' => 'offcanvas-menu-desktop',
                        'menu_class'    => 'navigation navigation--offcanvas',
                        'depth' => '5' 
                    );
                    wp_nav_menu($menuSettings);
                elseif ( has_nav_menu( 'main-menu' ) ) : 
                    $menuSettings = array( 
                        'theme_location' => 'main-menu',
                        'container_id' => 'offcanvas-menu-desktop',
                        'menu_class'    => 'navigation navigation--offcanvas',
                        'depth' => '5' 
                    );
                    wp_nav_menu($menuSettings);
                endif;   
            }
        ?>
	</div>
    
    <?php if(isset($tnm_option['bk-offcanvas-desktop-mailchimp-shortcode']) && ($tnm_option['bk-offcanvas-desktop-mailchimp-shortcode'] != '')) :?>
    <div class="mnmd-offcanvas__section">
		<div class="subscribe-form subscribe-form--horizontal text-center">
            <?php echo do_shortcode($tnm_option['bk-offcanvas-desktop-mailchimp-shortcode']);?>
		</div>
	</div>
    <?php endif;?>
    <?php if(is_active_sidebar('offcanvas-widget-area')):?>
    <div class="mnmd-offcanvas__section">
        <?php dynamic_sidebar( 'offcanvas-widget-area' );?>
	</div>
    <?php endif;?>
    
    <?php if ( function_exists('login_with_ajax') ) {  ?>
	<div class="mnmd-offcanvas__section visible-xs visible-sm">
		<div class="text-center">
            <?php 
                $bk_home_url = esc_url(get_home_url('/'));
                $ajaxArgs = array(
                    'profile_link' => true,
                    'template' => 'modal',
                    'registration' => true,
                    'remember' => true,
                    'redirect'  => $bk_home_url
                );
                login_with_ajax($ajaxArgs);  
                if(!is_user_logged_in()) {
                    echo '<a href="#login-modal" class="btn btn-default" data-toggle="modal" data-target="#login-modal"><i class="mdicon mdicon-person mdicon--first"></i><span>'.esc_html_e('Login/Sign up', 'the-next-mag').'</span></a>';
                }
            ?>
		</div>
	</div>
    <?php }?>
</div><!-- Off-canvas menu -->