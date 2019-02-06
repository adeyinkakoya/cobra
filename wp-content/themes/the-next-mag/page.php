<?php
/**
 * The Default Page Template
 *
 */
 ?>
<?php
    get_header();
    if ( have_posts() ) : while ( have_posts() ) : the_post();
    $pageID  = get_the_ID();
    $pageLayout     = tnm_single::bk_get_post_option($pageID, 'bk_page_layout');     
?>
<div class="site-content">  
    <?php 
        if ( is_page() && ! is_front_page() ) : 
            if($pageLayout == 'has_sidebar') {
                get_template_part( '/library/templates/page/page_with__sidebar'); //with-sidebar
            }else if($pageLayout == 'no_sidebar') {
                get_template_part( '/library/templates/page/page_fw' ); //full-width
            }
        endif;
    ?>
</div>

<?php endwhile; endif;?>
 <?php get_footer(); ?>