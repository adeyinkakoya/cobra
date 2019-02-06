<?php
if ( ! function_exists( 'tnm_custom_css' ) ) {
    function tnm_custom_css() {
        $tnm_option = tnm_core::bk_get_global_var('tnm_option');
        $tnm_css_output = '';
        
        $cat_opt = get_option('bk_cat_opt');
        
        if ( isset($tnm_option)):
            $primary_color = $tnm_option['bk-primary-color'];
            $buttonHover = $tnm_option['bk-button-hover-color'];
            if(isset($tnm_option['bk-header-bg-style']) && ($tnm_option['bk-header-bg-style'] == 'gradient')) {
                if(isset($tnm_option['bk-header-bg-gradient']) && !empty($tnm_option['bk-header-bg-gradient'])) {
                    $tnm_gradient_bg = $tnm_option['bk-header-bg-gradient'];
                    $tnm_gradient_deg = $tnm_option['bk-header-bg-gradient-direction'];
                    if($tnm_gradient_deg == '') {
                        $tnm_gradient_deg = 90;
                    }
                    $tnm_css_output .= ".header-2 .header-main, 
                                        .header-3 .site-header,
                                        .header-4 .navigation-bar,
                                        .header-5 .navigation-bar,
                                        .header-6 .navigation-bar,
                                        .header-7 .header-main,
                                        .header-8 .header-main,
                                        .header-9 .site-header
                                        {background: ".$tnm_gradient_bg['from'].";
                                        background: -webkit-linear-gradient(".$tnm_gradient_deg."deg, ".$tnm_gradient_bg['from']." 0, ".$tnm_gradient_bg['to']." 100%);
                                        background: linear-gradient(".$tnm_gradient_deg."deg, ".$tnm_gradient_bg['from']." 0, ".$tnm_gradient_bg['to']." 100%);}";   
                }
            }else if(isset($tnm_option['bk-header-bg-style']) && ($tnm_option['bk-header-bg-style'] == 'color')) {
                if(isset($tnm_option['bk-header-bg-color']) && !empty($tnm_option['bk-header-bg-color'])) {
                    $tnm_bg_color = $tnm_option['bk-header-bg-color'];
                    $tnm_css_output .= ".header-2 .header-main, 
                                        .header-3 .site-header, 
                                        .header-4 .navigation-bar,
                                        .header-5 .navigation-bar,
                                        .header-6 .navigation-bar,
                                        .header-7 .header-main,
                                        .header-8 .header-main,
                                        .header-9 .site-header
                                        {background: ".$tnm_bg_color['background-color'].";}";
                }
            }
            if (isset($tnm_option['bk-sticky-menu-bg-style']) && ($tnm_option['bk-sticky-menu-bg-style'] == 'gradient')) {
                if(isset($tnm_option['bk-sticky-menu-bg-gradient']) && !empty($tnm_option['bk-sticky-menu-bg-gradient'])) {
                    $tnm_sticky_menu_gradient_bg = $tnm_option['bk-sticky-menu-bg-gradient'];
                    $tnm_sticky_menu_gradient_deg = $tnm_option['bk-sticky-menu-bg-gradient-direction'];
                    if($tnm_sticky_menu_gradient_deg == '') {
                        $tnm_sticky_menu_gradient_deg = 90;
                    }
                    $tnm_css_output .= ".sticky-header.is-fixed > .navigation-bar
                                        {background: ".$tnm_sticky_menu_gradient_bg['from'].";
                                        background: -webkit-linear-gradient(".$tnm_sticky_menu_gradient_deg."deg, ".$tnm_sticky_menu_gradient_bg['from']." 0, ".$tnm_sticky_menu_gradient_bg['to']." 100%);
                                        background: linear-gradient(".$tnm_sticky_menu_gradient_deg."deg, ".$tnm_sticky_menu_gradient_bg['from']." 0, ".$tnm_sticky_menu_gradient_bg['to']." 100%);}";   
                }
            }else if (isset($tnm_option['bk-sticky-menu-bg-style']) && ($tnm_option['bk-sticky-menu-bg-style'] == 'color')) {
                if(isset($tnm_option['bk-sticky-menu-bg-color']) && !empty($tnm_option['bk-sticky-menu-bg-color'])) {
                    $tnm_sticky_menu_bg_color = $tnm_option['bk-sticky-menu-bg-color'];
                    $tnm_css_output .= ".sticky-header.is-fixed > .navigation-bar
                                        {background: ".$tnm_sticky_menu_bg_color['background-color'].";}";
                }
            }
            if (isset($tnm_option['bk-mobile-menu-bg-style']) && ($tnm_option['bk-mobile-menu-bg-style'] == 'gradient')) {
                if(isset($tnm_option['bk-mobile-menu-bg-gradient']) && !empty($tnm_option['bk-mobile-menu-bg-gradient'])) {
                    $tnm_mobile_menu_gradient_bg = $tnm_option['bk-mobile-menu-bg-gradient'];
                    $tnm_mobile_menu_gradient_deg = $tnm_option['bk-mobile-menu-bg-gradient-direction'];
                    if($tnm_mobile_menu_gradient_deg == '') {
                        $tnm_mobile_menu_gradient_deg = 90;
                    }
                    $tnm_css_output .= "#mnmd-mobile-header
                                        {background: ".$tnm_mobile_menu_gradient_bg['from'].";
                                        background: -webkit-linear-gradient(".$tnm_mobile_menu_gradient_deg."deg, ".$tnm_mobile_menu_gradient_bg['from']." 0, ".$tnm_mobile_menu_gradient_bg['to']." 100%);
                                        background: linear-gradient(".$tnm_mobile_menu_gradient_deg."deg, ".$tnm_mobile_menu_gradient_bg['from']." 0, ".$tnm_mobile_menu_gradient_bg['to']." 100%);}";   
                }
            }else if (isset($tnm_option['bk-mobile-menu-bg-style']) && ($tnm_option['bk-mobile-menu-bg-style'] == 'color')) {
                if(isset($tnm_option['bk-mobile-menu-bg-color']) && !empty($tnm_option['bk-mobile-menu-bg-color'])) {
                    $tnm_mobile_menu_bg_color = $tnm_option['bk-mobile-menu-bg-color'];
                    $tnm_css_output .= "#mnmd-mobile-header
                                        {background: ".$tnm_mobile_menu_bg_color['background-color'].";}";
                }
            }
            if (isset($tnm_option['bk-footer-bg-style']) && ($tnm_option['bk-footer-bg-style'] == 'gradient')) {
                if(isset($tnm_option['bk-footer-bg-gradient']) && !empty($tnm_option['bk-footer-bg-gradient'])) {
                    $tnm_footer_gradient_bg = $tnm_option['bk-footer-bg-gradient'];
                    $tnm_footer_gradient_deg = $tnm_option['bk-footer-bg-gradient-direction'];
                    if($tnm_footer_gradient_deg == '') {
                        $tnm_footer_gradient_deg = 90;
                    }
                    $tnm_css_output .= ".site-footer, .footer-3.site-footer, .footer-5.site-footer
                                        {background: ".$tnm_footer_gradient_bg['from'].";
                                        background: -webkit-linear-gradient(".$tnm_footer_gradient_deg."deg, ".$tnm_footer_gradient_bg['from']." 0, ".$tnm_footer_gradient_bg['to']." 100%);
                                        background: linear-gradient(".$tnm_footer_gradient_deg."deg, ".$tnm_footer_gradient_bg['from']." 0, ".$tnm_footer_gradient_bg['to']." 100%);}";   
                }
            }else if (isset($tnm_option['bk-footer-bg-style']) && ($tnm_option['bk-footer-bg-style'] == 'color')) {
                if(isset($tnm_option['bk-footer-bg-color']) && !empty($tnm_option['bk-footer-bg-color'])) {
                    $tnm_footer_bg_color = $tnm_option['bk-footer-bg-color'];
                    $tnm_css_output .= ".site-footer, .footer-3.site-footer, .footer-5.site-footer, .footer-6.site-footer
                                        {background: ".$tnm_footer_bg_color['background-color'].";}";
                }
            }
            if (isset($tnm_option['bk-coming-soon-bg-style']) && ($tnm_option['bk-coming-soon-bg-style'] == 'gradient')) {
                if(isset($tnm_option['bk-coming-soon-bg-gradient']) && !empty($tnm_option['bk-coming-soon-bg-gradient'])) {
                    $tnm_cs_gradient_bg = $tnm_option['bk-coming-soon-bg-gradient'];
                    $tnm_cs_gradient_deg = $tnm_option['bk-coming-soon-bg-gradient-direction'];
                    if($tnm_cs_gradient_deg == '') {
                        $tnm_cs_gradient_deg = 90;
                    }
                    $tnm_css_output .= ".page-coming-soon .background-img>.background-overlay
                                        {background: ".$tnm_cs_gradient_bg['from'].";
                                        background: -webkit-linear-gradient(".$tnm_cs_gradient_deg."deg, ".$tnm_cs_gradient_bg['from']." 0, ".$tnm_cs_gradient_bg['to']." 100%);
                                        background: linear-gradient(".$tnm_cs_gradient_deg."deg, ".$tnm_cs_gradient_bg['from']." 0, ".$tnm_cs_gradient_bg['to']." 100%);}";   
                }
            }else if (isset($tnm_option['bk-coming-soon-bg-style']) && ($tnm_option['bk-coming-soon-bg-style'] == 'color')) {
                if(isset($tnm_option['bk-coming-soon-bg-color']) && !empty($tnm_option['bk-coming-soon-bg-color'])) {
                    $tnm_cs_bg_color = $tnm_option['bk-coming-soon-bg-color'];
                    $tnm_css_output .= ".page-coming-soon .background-img
                                        {background: ".$tnm_cs_bg_color['background-color'].";}";
                }
            }
        endif;
        
        $tnm_css_output .= "::selection {color: #FFF; background: $primary_color;}";
        $tnm_css_output .= "::-webkit-selection {color: #FFF; background: $primary_color;}";
        
        if ( ($primary_color) != null) :
            $tnm_css_output .= "a, a:hover, a:focus, a:active, .color-primary, .site-title, .mnmd-widget-indexed-posts-b .posts-list > li .post__title:after,
            .author-box .author-name a
            {color: $primary_color;}";
            
            $tnm_css_output .= ".category-tile__name, .cat-0.cat-theme-bg.cat-theme-bg, .primary-bg-color, .navigation--main > li > a:before, .mnmd-pagination__item-current, .mnmd-pagination__item-current:hover, 
            .mnmd-pagination__item-current:focus, .mnmd-pagination__item-current:active, .mnmd-pagination--next-n-prev .mnmd-pagination__links a:last-child .mnmd-pagination__item,
            .subscribe-form__fields input[type='submit'], .has-overlap-bg:before, .post__cat--bg, a.post__cat--bg, .entry-cat--bg, a.entry-cat--bg, 
            .comments-count-box, .mnmd-widget--box .widget__title,  .posts-list > li .post__thumb:after, 
            .widget_calendar td a:before, .widget_calendar #today, .widget_calendar #today a, .entry-action-btn, .posts-navigation__label:before, 
            .comment-form .form-submit input[type='submit'], .mnmd-carousel-dots-b .swiper-pagination-bullet-active,
             .site-header--side-logo .header-logo:not(.header-logo--mobile), .list-square-bullet > li > *:before, .list-square-bullet-exclude-first > li:not(:first-child) > *:before,
             .btn-primary, .btn-primary:active, .btn-primary:focus, .btn-primary:hover, 
             .btn-primary.active.focus, .btn-primary.active:focus, .btn-primary.active:hover, .btn-primary:active.focus, .btn-primary:active:focus, .btn-primary:active:hover
            {background-color: $primary_color;}";
            
            $tnm_css_output .= ".site-header--skin-4 .navigation--main > li > a:before
            {background-color: $primary_color !important;}";
            
            $tnm_css_output .= ".post-score-hexagon .hexagon-svg g path
            {fill: $primary_color;}";
            
            $tnm_css_output .= ".has-overlap-frame:before, .mnmd-gallery-slider .fotorama__thumb-border, .bypostauthor > .comment-body .comment-author > img
            {border-color: $primary_color;}";
            
            $tnm_css_output .= ".mnmd-pagination--next-n-prev .mnmd-pagination__links a:last-child .mnmd-pagination__item:after
            {border-left-color: $primary_color;}";
            
            $tnm_css_output .= ".comments-count-box:before
            {border-top-color: $primary_color;}";
            
            $tnm_css_output .= ".navigation--offcanvas li > a:after
            {border-right-color: $primary_color;}";
            
            $tnm_css_output .= ".post--single-cover-gradient .single-header
            {
                background-image: -webkit-linear-gradient( bottom , $primary_color 0%, rgba(252, 60, 45, 0.7) 50%, rgba(252, 60, 45, 0) 100%);
                background-image: linear-gradient(to top, $primary_color 0%, rgba(252, 60, 45, 0.7) 50%, rgba(252, 60, 45, 0) 100%);
            }";
            
            //Button Hover
            $tnm_css_output .= ".subscribe-form__fields input[type='submit']:hover,
            .comment-form .form-submit input[type='submit']:active, .comment-form .form-submit input[type='submit']:focus, .comment-form .form-submit input[type='submit']:hover
            {background-color: $buttonHover;}";
        endif;
        
        $tnm_css_output .= "mnmd-video-box__playlist .is-playing .post__thumb:after { content: '".esc_html__( 'Now playing', 'the-next-mag' )."'; }";
        
        $cat__terms = get_terms( array(
            'taxonomy' => 'category',
            'hide_empty' => true,
        ) );    
        if ((is_array($cat__terms))) :
            
            foreach ($cat__terms as $key => $cat__term) :
                $catColorVal  = tnm_core::tnm_rwmb_meta( 'bk_category__color', array( 'object_type' => 'term' ), $cat__term->term_id );  
                if($catColorVal != '') :
                    $tnm_css_output .= '.cat-'.$cat__term->term_id.' .cat-theme, 
                                        .cat-'.$cat__term->term_id.'.cat-theme.cat-theme, 
                                        .cat-'.$cat__term->term_id.' a:hover .cat-icon
                    {color: '.$catColorVal.' !important;}'; 
                    
                    $tnm_css_output .= '.cat-'.$cat__term->term_id.' .cat-theme-bg,
                                        .cat-'.$cat__term->term_id.'.cat-theme-bg.cat-theme-bg,
                                        .navigation--main > li.menu-item-cat-'.$cat__term->term_id.' > a:before,
                                        .cat-'.$cat__term->term_id.'.post--featured-a .post__text:before,
                                        .mnmd-carousel-b .cat-'.$cat__term->term_id.' .post__text:before,
                                        .cat-'.$cat__term->term_id.' .has-overlap-bg:before,
                                        .cat-'.$cat__term->term_id.'.post--content-overlap .overlay-content__inner:before
                    {background-color: '.$catColorVal.' !important;}'; 
                    
                    $tnm_css_output .= '.cat-'.$cat__term->term_id.' .cat-theme-border,
                                        .cat-'.$cat__term->term_id.'.cat-theme-border.cat-theme-border,
                                        .mnmd-featured-block-a .main-post.cat-'.$cat__term->term_id.':before,
                                        .cat-'.$cat__term->term_id.' .category-tile__inner:before,
                                        .cat-'.$cat__term->term_id.' .has-overlap-frame:before,
                                        .navigation--offcanvas li.menu-item-cat-'.$cat__term->term_id.' > a:after,
                                        .mnmd-featured-block-a .main-post:before
                    {border-color: '.$catColorVal.' !important;}';
                    
                    $tnm_css_output .= '.post--single-cover-gradient.cat-'.$cat__term->term_id.' .single-header
                    {
                    background-image: -webkit-linear-gradient( bottom , '.$catColorVal.' 0%, rgba(25, 79, 176, 0.7) 50%, rgba(25, 79, 176, 0) 100%);
                    background-image: linear-gradient(to top, '.$catColorVal.' 0%, rgba(25, 79, 176, 0.7) 50%, rgba(25, 79, 176, 0) 100%);
                    }';
                endif;
            endforeach;
            
        endif; 
        wp_add_inline_style( 'thenextmag-style', $tnm_css_output );
    }
    add_action( 'wp_enqueue_scripts', 'tnm_custom_css' );
}