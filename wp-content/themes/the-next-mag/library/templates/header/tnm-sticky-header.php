<?php 
    $tnm_option = tnm_core::bk_get_global_var('tnm_option');
    if ((isset($tnm_option['bk-mobile-logo'])) && (!empty($tnm_option['bk-mobile-logo']))){ 
        $mobileLogo = $tnm_option['bk-mobile-logo'];
    }else {
        $mobileLogo = '';
    }
    if (($mobileLogo != null) && (array_key_exists('url',$mobileLogo))) {
        if ($mobileLogo['url'] == '') {
            $mobileLogo = tnm_core::bk_get_theme_option('bk-logo');
        }
    }else {
        $mobileLogo = tnm_core::bk_get_theme_option('bk-logo');
    }
    if ((isset($tnm_option['bk-sticky-menu-inverse'])) && (($tnm_option['bk-sticky-menu-inverse']) == 1)){ 
        $inverseClass = 'navigation-bar--inverse';
        $socialInverseClass = 'social-list--inverse';
    }else {
        $inverseClass = '';
        $socialInverseClass = '';
    }
    
    $headerSkin = '';
    
    $bkHeaderType = '';
    $bkStickyNavClass = '';
    if ((isset($tnm_option['bk-header-type'])) && (($tnm_option['bk-header-type']) != NULL)){ 
        $bkHeaderType = $tnm_option['bk-header-type'];
    }else {
        $bkHeaderType == 'site-header-1';
    }
    
    $bkStickyNavClass = 'navigation-bar navigation-bar--fullwidth hidden-xs hidden-sm '.$inverseClass;
    
    // For Default Header Style
    if ($bkHeaderType == 'site-header-3') {
        $headerSkin = 'site-header--skin-1';
    }
    elseif ($bkHeaderType == 'site-header-5') {
        $headerSkin = 'site-header--skin-2';
    }
    elseif ($bkHeaderType == 'site-header-7') {
        $headerSkin = 'site-header--skin-5';
    }
    elseif ($bkHeaderType == 'site-header-8') {
        $headerSkin = 'site-header--skin-3';
    }
    elseif ($bkHeaderType == 'site-header-9') {
        $headerSkin = 'site-header--skin-4';
    }
?>
<!-- Sticky header -->
<div id="mnmd-sticky-header" class="sticky-header js-sticky-header <?php echo esc_attr($headerSkin);?>">
	<!-- Navigation bar -->
	<nav class="<?php echo esc_html($bkStickyNavClass);?>">
		<div class="navigation-bar__inner">
			<div class="navigation-bar__section">
                <?php if (is_active_sidebar('offcanvas-widget-area') || has_nav_menu( 'main-menu' ) || has_nav_menu( 'offcanvas-menu' )):?> 
                    <?php if ( isset($tnm_option ['bk-offcanvas-desktop-switch']) && ($tnm_option ['bk-offcanvas-desktop-switch'] != 0) ):?>
                        <?php if ($bkHeaderType != 'site-header-4') :?>
        				<a href="#mnmd-offcanvas-primary" class="offcanvas-menu-toggle navigation-bar-btn js-mnmd-offcanvas-toggle">
        					<i class="mdicon mdicon-menu icon--2x"></i>
        				</a>
                        <?php endif;?>
                    <?php endif;?>
                <?php endif;?>
                <?php if (($mobileLogo != null) && (array_key_exists('url',$mobileLogo))) {
                        if ($mobileLogo['url'] != '') {
                ?>
				<div class="site-logo header-logo">
					<a href="<?php echo esc_url(get_home_url('/'));?>">                    
                        <img src="<?php echo esc_url($mobileLogo['url']);?>" alt="<?php esc_attr_e('logo', 'the-next-mag');?>"/>
                    </a>
				</div>
                <?php 
                        }
                    } 
                ?>
			</div>
            
			<div class="navigation-wrapper navigation-bar__section js-priority-nav">
				<?php 
                    $sticky_header = true; $fw_navbar = true;
                    if ( has_nav_menu( 'main-menu' ) ) : 
                        $menuSettings = array( 
                            'theme_location' => 'main-menu',
                            'container_id' => 'sticky-main-menu',
                            'menu_class'    => 'navigation navigation--main navigation--inline',
                            'walker' => new BK_Walker,
                            'depth' => '5' 
                        );
                        wp_nav_menu($menuSettings);
                    endif;
                ?>
			</div>
            
            <?php if (($bkHeaderType == 'site-header-5') || ($bkHeaderType == 'site-header-6')) {?>
            <div class="navigation-bar__section">
                <?php if ( isset($tnm_option ['bk-social-header']) && !empty($tnm_option ['bk-social-header']) ){ ?>
    					<ul class="social-list list-horizontal <?php if($socialInverseClass != '') echo esc_attr($socialInverseClass);?>">
    						<?php echo tnm_core::bk_get_social_media_links($tnm_option['bk-social-header']);?>            						
    					</ul>
                <?php }?> 
			</div>
            <?php }?>
            
            <div class="navigation-bar__section lwa lwa-template-modal">
                <?php 
                    if ( function_exists('login_with_ajax') ) {  
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
                            if ($bkHeaderType == 'site-header-4') {
                                echo '<a href="#login-modal" class="navigation-bar__login-btn navigation-bar-btn" data-toggle="modal" data-target="#login-modal"><i class="mdicon mdicon-person"></i><span>'.esc_html__('Login', 'the-next-mag').'</span></a>';
                            }else {
                                echo '<a href="#login-modal" class="navigation-bar__login-btn navigation-bar-btn" data-toggle="modal" data-target="#login-modal"><i class="mdicon mdicon-person"></i></a>';
                            }
                        }
                }?>
                <?php 
                if ($bkHeaderType == 'site-header-4') {
                    echo '<button type="submit" class="navigation-bar-btn js-search-dropdown-toggle"><i class="mdicon mdicon-search"></i>'.esc_html__('Search', 'the-next-mag').'</button>';
                }else {
                    echo '<button type="submit" class="navigation-bar-btn js-search-dropdown-toggle"><i class="mdicon mdicon-search"></i></button>';
                }
				?>
            </div>
		</div><!-- .navigation-bar__inner -->
	</nav><!-- Navigation-bar -->
</div><!-- Sticky header -->