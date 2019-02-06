<?php 
    $tnm_option = tnm_core::bk_get_global_var('tnm_option');
    $logo   = tnm_core::bk_get_theme_option('bk-logo');
    $mobileLogo   = tnm_core::bk_get_theme_option('bk-mobile-logo');
    $logoSOption  = tnm_core::bk_get_theme_option('bk-site-logo-size-option');
    if($logoSOption == 'customize') {
        $logoW   = tnm_core::bk_get_theme_option('site-logo-width');
    }else {
        $logoW = '';
    }
    if ((isset($tnm_option['bk-header-inverse'])) && (($tnm_option['bk-header-inverse']) == 1)){ 
        $inverseClass = 'yes';
    }else {
        $inverseClass = '';
    }
    if ((isset($tnm_option['bk-mobile-menu-inverse'])) && (($tnm_option['bk-mobile-menu-inverse']) == 1)){ 
        $inverseClass_Mobile = 'yes';
    }else {
        $inverseClass_Mobile = '';
    }
?>
<header class="site-header site-header--skin-3">
    <!-- Header content -->
	<div class="header-main hidden-xs hidden-sm <?php if($inverseClass == "yes") echo " header-main--inverse";?>">
        <?php if (isset($tnm_option['bk-header-bg-style']) && ($tnm_option['bk-header-bg-style'] == 'image')) :?>
		<div class="background-img-wrapper">
			<div class="background-img"></div>
		</div>
        <?php endif;?>
		<div class="container">
			<div class="row row--flex row--vertical-center">
				<div class="col-xs-8">
					<div class="site-logo header-logo text-left">
						<a href="<?php echo esc_url(get_home_url('/'));?>">
    						<!-- logo open -->
                            <?php if (($logo != null) && (array_key_exists('url',$logo))) {
                                    if ($logo['url'] != '') {
                                ?>
                                <img src="<?php echo esc_url($logo['url']);?>" alt="<?php esc_attr_e('logo', 'the-next-mag');?>" <?php if($logoW != '') {echo 'width="'.esc_attr($logoW).'px"';}?>/>
                            <?php } else {?>
                                <span class="logo-text">
                                <?php echo esc_attr(bloginfo( 'name' ));?>
                                </span>
                            <?php }
                            } else {?>
                                <span class="logo-text">
                                <?php echo esc_attr(bloginfo( 'name' ));?>
                                </span>
                            <?php } ?>
                            <!-- logo close -->
    					</a>
					</div>
				</div>

				<div class="col-xs-4">
					<div class="site-header__social <?php if($inverseClass == "yes") echo " inverse-text";?>">
                        <?php if ( isset($tnm_option ['bk-social-header']) && !empty($tnm_option ['bk-social-header']) ){ ?>
            					<ul class="social-list social-list--lg list-horizontal text-right">
            						<?php echo tnm_core::bk_get_social_media_links($tnm_option['bk-social-header']);?>            						
            					</ul>
                        <?php }?>
					</div>
				</div>
			</div>
		</div>
	</div><!-- Header content -->
    <!-- Mobile header -->
    <div id="mnmd-mobile-header" class="mobile-header visible-xs visible-sm <?php if($inverseClass_Mobile == "yes") echo " mobile-header--inverse";?>">
    	<div class="mobile-header__inner mobile-header__inner--flex">
            <!-- mobile logo open -->
    		<div class="header-branding header-branding--mobile mobile-header__section text-left">
    			<div class="header-logo header-logo--mobile flexbox__item text-left">
                    <a href="<?php echo esc_url(get_home_url('/'));?>">
                        <?php if (($mobileLogo != null) && (array_key_exists('url',$mobileLogo))) {
                            if ($mobileLogo['url'] != '') {
                        ?>                    
                        <img src="<?php echo esc_url($mobileLogo['url']);?>" alt="<?php esc_attr_e('logo', 'the-next-mag');?>"/>
                        <?php 
                        } else {?>
                                <span class="logo-text">
                                <?php echo esc_attr(bloginfo( 'name' ));?>
                                </span>
                        <?php }
                        } else {?>
                            <span class="logo-text">
                            <?php echo esc_attr(bloginfo( 'name' ));?>
                            </span>
                        <?php } ?>                        
                    </a>               
    			</div>
    		</div>
            <!-- logo close -->
    		<div class="mobile-header__section text-right">
    			<button type="submit" class="mobile-header-btn js-search-dropdown-toggle">
    				<span class="hidden-xs"><?php esc_html_e('Search', 'the-next-mag');?></span><i class="mdicon mdicon-search mdicon--last hidden-xs"></i><i class="mdicon mdicon-search visible-xs-inline-block"></i>
    			</button>
                <?php if (is_active_sidebar('mobile-offcanvas-widget-area') || has_nav_menu( 'main-menu' ) || has_nav_menu( 'offcanvas-menu' )):?>
    			<a href="#mnmd-offcanvas-mobile" class="offcanvas-menu-toggle mobile-header-btn js-mnmd-offcanvas-toggle">
    				<span class="hidden-xs">Menu</span><i class="mdicon mdicon-menu mdicon--last hidden-xs"></i><i class="mdicon mdicon-menu visible-xs-inline-block"></i>
    			</a>
                <?php endif;?>
    		</div>
    	</div>
    </div><!-- Mobile header -->
    <!-- Navigation bar -->
	<nav class="navigation-bar navigation-bar--inverse navigation-bar--fullwidth hidden-xs hidden-sm js-sticky-header-holder">
		<div class="container">
			<div class="navigation-bar__inner">
                <?php if (is_active_sidebar('offcanvas-widget-area') || has_nav_menu( 'main-menu' ) || has_nav_menu( 'offcanvas-menu' )):?>
                    <?php if ( isset($tnm_option ['bk-offcanvas-desktop-switch']) && ($tnm_option ['bk-offcanvas-desktop-switch'] != 0) ){ ?>
    				<div class="navigation-bar__section">
    					<a href="#mnmd-offcanvas-primary" class="offcanvas-menu-toggle navigation-bar-btn js-mnmd-offcanvas-toggle">
    						<i class="mdicon mdicon-menu"></i>
    					</a>
    				</div>
                    <?php }?>
                <?php endif;?>

				<div class="navigation-wrapper navigation-bar__section js-priority-nav">
					<?php 
                        if ( has_nav_menu( 'main-menu' ) ) : 
                            $menuSettings = array( 
                                'theme_location' => 'main-menu',
                                'container_id' => 'main-menu',
                                'menu_class'    => 'navigation navigation--main navigation--inline',
                                'walker' => new BK_Walker,
                                'depth' => '5' 
                            );
                            wp_nav_menu($menuSettings);
                        endif;
                    ?>
				</div>

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
                                echo '<a href="#login-modal" class="navigation-bar__login-btn navigation-bar-btn" data-toggle="modal" data-target="#login-modal"><i class="mdicon mdicon-person"></i></a>';
                            }
                    }?>
    				<button type="submit" class="navigation-bar-btn js-search-dropdown-toggle"><i class="mdicon mdicon-search"></i></button>
                </div>
			</div><!-- .navigation-bar__inner -->

			<?php get_template_part( 'library/templates/header/header-search-dropdown' );?>
		</div><!-- .container -->
	</nav><!-- Navigation-bar -->
</header><!-- Site header -->