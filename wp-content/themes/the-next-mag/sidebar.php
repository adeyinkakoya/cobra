<?php $tnm_option = tnm_core::bk_get_global_var('tnm_option');?>
    <?php            
        if (is_front_page()) {
            dynamic_sidebar('home_sidebar');
        }else if(is_single()){
            if (strlen($sidebar)) {
                dynamic_sidebar($sidebar);
            }else {
                dynamic_sidebar('home_sidebar');
            }
        }else if(is_category()) {
            if(isset($tnm_option['category-page-sidebar'])) {
                $sidebar = $tnm_option['category-page-sidebar'];
            }else {
                $sidebar = '';
            }
            if (strlen($sidebar)) {
                dynamic_sidebar($sidebar);
            }else {
                dynamic_sidebar('home_sidebar');
            }
        }else if (is_author()){
            if(isset($tnm_option['author-page-sidebar'])) {
                $sidebar = $tnm_option['author-page-sidebar'];
            }else {
                $sidebar = '';
            }
            if (strlen($sidebar)) {
                dynamic_sidebar($sidebar);
            }else {
                dynamic_sidebar('home_sidebar');
            }
        }else if (is_archive()) {
            if(isset($tnm_option['archive-page-sidebar'])) {
                $sidebar = $tnm_option['archive-page-sidebar'];
            }else {
                $sidebar = '';
            }
            if (strlen($sidebar)) {
                dynamic_sidebar($sidebar);
            }else {
                dynamic_sidebar('home_sidebar');
            }
        }else if (is_search()) {
            if(isset($tnm_option['search-page-sidebar'])) {
                $sidebar = $tnm_option['search-page-sidebar'];
            }else {
                $sidebar = '';
            }
            if (strlen($sidebar)) {
                dynamic_sidebar($sidebar);
            }else {
                dynamic_sidebar('home_sidebar');
            }
        }else {
            wp_reset_query();
            if (is_page_template('blog.php')) {
                if(isset($tnm_option['blog-page-sidebar'])) {
                    $sidebar = $tnm_option['blog-page-sidebar'];
                }else {
                    $sidebar = '';
                }
                if (strlen($sidebar)) {
                    dynamic_sidebar($sidebar);
                }else {
                    dynamic_sidebar('home_sidebar');
                }
            }else {                     
                dynamic_sidebar('home_sidebar');
            }
        }
    ?>  	
<!--</home sidebar widget>-->