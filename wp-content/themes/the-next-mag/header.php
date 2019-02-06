<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
    
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    
    <link rel="profile" href="http://gmpg.org/xfn/11" />
	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <link rel="icon" href="http://localhost/cobratest/wp-content/uploads/2019/01/fav.png" sizes="16x16" type="image/png"> (

	<?php wp_head(); ?>
    
    <?php get_template_part( 'library/templates/single/single-schema-meta');?>
</head>
<body <?php body_class(tnm_header::tnm_get_header_class()); ?>>
    <div class="site-wrapper">
        <?php
            if(!is_404()) :
                tnm_header::tnm_get_header();
            endif;
        ?>