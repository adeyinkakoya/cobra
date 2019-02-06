<?php
/**
 * Index Page -- Latest Page
 *
 */
 ?>
<?php get_header();?>
<div class="site-content">
    <div class="mnmd-block mnmd-block--fullwidth">
        <div class="container">
            <div class="row">
                <div class="mnmd-main-col" role="main">
                <?php //echo tnm_archive::archive_main_col('listing_list');?>
                <?php
                    $cat = 3; //Above the Title - No BG
                    $cat_Class = tnm_core::bk_get_cat_class($cat);
                ?>
                <div class="posts-list list-unstyled list-space-xl">
                    <?php$counter = 0; while (have_posts()): the_post(); $postID = get_the_ID(); $counter ++;?>
                    <div class="list-item">
                        <article class="post post--horizontal post--horizontal-sm <?php if(is_sticky($postID)) echo 'sticky-tnm-post';?>">
                            <?php
                            $uu = "http://localhost/cobratest/wp-contents/uploads/";
                             if($counter == 0) $uu .= "akin.jpg";
                             elseif($counter == 1) $uu .= "toyin.jpg";
                             elseif($counter == 3) $uu .= "cisi.jpg";
                            ?>
                            <div class="post__thumb">
                                <div class="background-img " style="background-image: url('<?=$uu?>');"></div>
                            </div>
                            
                            <div class="post__text">
                                <?php echo tnm_core::bk_get_post_cat_link($postID, $cat_Class);?>
                                <?php if(is_sticky($postID)) echo '<span class="tnmStickyMark">sticky</span>';?>
                                <h3 class="post__title typescale-2">
                                    <?php echo tnm_core::bk_get_post_title_link($postID);?>
                                </h3>
                                <div class="post__excerpt">
                                    <?php echo tnm_core::bk_get_post_excerpt(23);?>
                                </div>
                                <div class="post__meta">
                                    <?php echo tnm_core::bk_get_post_meta(array('author', 'date', 'comment'));?>
                                </div>
                            </div>
                        </article>
                    </div>
                    <?php endwhile;?>
                </div>
                <?php
                    if (function_exists('tnm_paginate')) {
                        echo tnm_core::tnm_get_pagination();
                    }
                ?>
                </div><!-- .mnmd-main-col -->

                <div class="mnmd-sub-col mnmd-sub-col--right sidebar js-sticky-sidebar" role="complementary">
                    <div class="theiaStickySidebar">
                        <?php dynamic_sidebar( 'home_sidebar' );?>
                    </div>
                </div> <!-- .mnmd-sub-col -->
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .mnmd-block -->
</div>
<?php get_footer();?>