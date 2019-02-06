<?php
    require_once (THENEXTMAG_INC.'composer/bk_pd_cfg.php');
    require_once (THENEXTMAG_INC.'composer/render-sections.php');
    
    //require_once (get_template_directory().'/plugins/sitelinks-search-box.php');
// Section
    
// Block Fullwidth
    require_once (THENEXTMAG_BLOCKS.'news_ticker.php');
    require_once (THENEXTMAG_BLOCKS.'featured_with_list_horizontal.php');
    require_once (THENEXTMAG_BLOCKS.'featured_with_list_vertical.php');
    require_once (THENEXTMAG_BLOCKS.'featured_with_overlap.php');
    require_once (THENEXTMAG_BLOCKS.'countdown.php');
    require_once (THENEXTMAG_BLOCKS.'carousel_heading_aside_bg.php');
    require_once (THENEXTMAG_BLOCKS.'slider_thumb_overlap.php');
    require_once (THENEXTMAG_BLOCKS.'carousel_overlap.php');
    require_once (THENEXTMAG_BLOCKS.'posts_block_a.php');
    require_once (THENEXTMAG_BLOCKS.'posts_block_b.php');
    require_once (THENEXTMAG_BLOCKS.'posts_block_c.php');
    require_once (THENEXTMAG_BLOCKS.'posts_block_d.php');
    require_once (THENEXTMAG_BLOCKS.'posts_block_e.php');
    require_once (THENEXTMAG_BLOCKS.'posts_block_e_wide_bg.php');
    require_once (THENEXTMAG_BLOCKS.'posts_block_f.php');
    require_once (THENEXTMAG_BLOCKS.'posts_block_g.php');
    require_once (THENEXTMAG_BLOCKS.'posts_block_i.php');
    require_once (THENEXTMAG_BLOCKS.'posts_block_j.php');
    require_once (THENEXTMAG_BLOCKS.'posts_listing_grid_alt_fw.php');
    require_once (THENEXTMAG_BLOCKS.'featured_block_a.php');
    require_once (THENEXTMAG_BLOCKS.'featured_block_b.php');
    require_once (THENEXTMAG_BLOCKS.'featured_block_c.php');
    require_once (THENEXTMAG_BLOCKS.'featured_block_d.php');
    require_once (THENEXTMAG_BLOCKS.'featured_block_e.php');
    require_once (THENEXTMAG_BLOCKS.'featured_block_f.php');
    require_once (THENEXTMAG_BLOCKS.'featured_block_g.php');
    require_once (THENEXTMAG_BLOCKS.'category_tiles.php');
    require_once (THENEXTMAG_BLOCKS.'carousel_heading_aside.php');
    require_once (THENEXTMAG_BLOCKS.'horizontal_list.php');
    require_once (THENEXTMAG_BLOCKS.'subscribe_form_block.php');
    require_once (THENEXTMAG_BLOCKS.'posts_listing_grid.php');
    require_once (THENEXTMAG_BLOCKS.'mosaic_a.php');
    require_once (THENEXTMAG_BLOCKS.'mosaic_b.php');
    require_once (THENEXTMAG_BLOCKS.'mosaic_b_bg.php');
    require_once (THENEXTMAG_BLOCKS.'mosaic_c.php');
    require_once (THENEXTMAG_BLOCKS.'mosaic_c_bg.php');
    require_once (THENEXTMAG_BLOCKS.'subscribe_form_block_fw.php');
    require_once (THENEXTMAG_BLOCKS.'carousel_overlay_post_3i.php');  
    require_once (THENEXTMAG_BLOCKS.'carousel_overlay_post_3i_2.php');  
    require_once (THENEXTMAG_BLOCKS.'carousel_overlay_post_4i.php');  
    require_once (THENEXTMAG_BLOCKS.'carousel_overlay_post_4i_2.php');
    require_once (THENEXTMAG_BLOCKS.'carousel_card_4i.php');
    require_once (THENEXTMAG_BLOCKS.'carousel_card_3i.php');
    require_once (THENEXTMAG_BLOCKS.'carousel_overlay_post_2i.php'); 
    require_once (THENEXTMAG_BLOCKS.'carousel_overlay_post_1i.php'); 
    require_once (THENEXTMAG_BLOCKS.'posts_listing_grid_no_sidebar.php');
    require_once (THENEXTMAG_BLOCKS.'posts_listing_grid_small_no_sidebar.php');
    require_once (THENEXTMAG_BLOCKS.'posts_listing_list_no_sidebar.php');
    require_once (THENEXTMAG_BLOCKS.'posts_listing_list_alt_a_no_sidebar.php');
    require_once (THENEXTMAG_BLOCKS.'posts_listing_list_alt_b_no_sidebar.php');
    require_once (THENEXTMAG_BLOCKS.'posts_listing_list_alt_c_no_sidebar.php');
    require_once (THENEXTMAG_BLOCKS.'mosaic_a_bg.php');
    
// Block has sidebar
    require_once (THENEXTMAG_BLOCKS.'posts_block_main_col_a.php');
    require_once (THENEXTMAG_BLOCKS.'posts_block_main_col_b.php');
    require_once (THENEXTMAG_BLOCKS.'posts_block_main_col_c.php');
    require_once (THENEXTMAG_BLOCKS.'posts_block_main_col_d.php');    
    require_once (THENEXTMAG_BLOCKS.'posts_block_main_col_e.php');
    require_once (THENEXTMAG_BLOCKS.'posts_block_main_col_f.php');
    require_once (THENEXTMAG_BLOCKS.'posts_block_main_col_j.php');
    require_once (THENEXTMAG_BLOCKS.'posts_block_main_col_h.php');
    require_once (THENEXTMAG_BLOCKS.'posts_block_main_col_i.php');
    require_once (THENEXTMAG_BLOCKS.'posts_block_main_col_g.php');
    require_once (THENEXTMAG_BLOCKS.'posts_block_main_col_k.php');
    require_once (THENEXTMAG_BLOCKS.'posts_block_main_col_l.php');
    require_once (THENEXTMAG_BLOCKS.'carousel_overlay_post_main_col_1i.php'); 
    require_once (THENEXTMAG_BLOCKS.'carousel_overlay_post_main_col_2i.php');
    require_once (THENEXTMAG_BLOCKS.'carousel_overlay_post_main_col_3i.php');
    require_once (THENEXTMAG_BLOCKS.'carousel_overlay_post_main_col_3i_2.php');
    require_once (THENEXTMAG_BLOCKS.'carousel_card_main_col_3i.php');
    require_once (THENEXTMAG_BLOCKS.'carousel_card_main_col_2i.php');
    require_once (THENEXTMAG_BLOCKS.'posts_listing_list_alt_a.php');
    require_once (THENEXTMAG_BLOCKS.'posts_listing_list_alt_b.php');
    require_once (THENEXTMAG_BLOCKS.'posts_listing_list_alt_c.php');
    require_once (THENEXTMAG_BLOCKS.'posts_listing_list.php');
    require_once (THENEXTMAG_BLOCKS.'posts_listing_grid_alt_a.php');
    require_once (THENEXTMAG_BLOCKS.'posts_listing_grid_alt_b.php');
    require_once (THENEXTMAG_BLOCKS.'posts_listing_grid_small.php');
    require_once (THENEXTMAG_BLOCKS.'custom_html.php');
    require_once (THENEXTMAG_BLOCKS.'short_code.php');
        
// Include Post Modules
    require_once(THENEXTMAG_MODULES.'horizontal_1.php');
    require_once(THENEXTMAG_MODULES.'horizontal_2.php');
    require_once(THENEXTMAG_MODULES.'horizontal_feat_block_a.php');
    require_once(THENEXTMAG_MODULES.'vertical_1.php'); 
    require_once(THENEXTMAG_MODULES.'vertical_1_ratio_2by1.php'); 
    require_once(THENEXTMAG_MODULES.'vertical_icon_side_right.php'); 
    require_once(THENEXTMAG_MODULES.'vertical_icon_side_right_ratio_2by1.php'); 
    require_once(THENEXTMAG_MODULES.'vertical_icon_side_left.php');
    require_once(THENEXTMAG_MODULES.'vertical_with_default_thumb.php'); 
    require_once(THENEXTMAG_MODULES.'overlay_1.php');
    require_once(THENEXTMAG_MODULES.'overlay_3.php');
    require_once(THENEXTMAG_MODULES.'overlay_icon_side_right.php');
    require_once(THENEXTMAG_MODULES.'overlay_icon_side_left.php');
    require_once(THENEXTMAG_MODULES.'card_1.php');
    require_once(THENEXTMAG_MODULES.'thumb_overlap.php');
    require_once(THENEXTMAG_MODULES.'category_tile.php');
    
//Libs        
// Header Libs
    require_once(THENEXTMAG_HEADER_TEMPLATES.'tnm_header.php');
    require_once(THENEXTMAG_FOOTER_TEMPLATES.'tnm_footer.php');
    require_once(THENEXTMAG_SINGLE_TEMPLATES.'tnm_single.php');
    
    require_once(THENEXTMAG_INC_LIBS.'tnm_get_configs.php');
    require_once(THENEXTMAG_INC_LIBS.'tnm_core.php');
    require_once(THENEXTMAG_INC_LIBS.'tnm_tgm_activation.php');
    require_once(THENEXTMAG_INC_LIBS.'tnm_query.php');
    require_once(THENEXTMAG_INC_LIBS.'tnm_cache.php');
    require_once(THENEXTMAG_INC_LIBS.'tnm_youtube.php');
    require_once(THENEXTMAG_LIBS.'meta_box_config.php');
    
// Include Ajax Files
    require_once(THENEXTMAG_AJAX.'ajax-function.php');
    require_once(THENEXTMAG_AJAX.'ajax-search.php');
    require_once(THENEXTMAG_AJAX.'ajax-megamenu.php');
    require_once(THENEXTMAG_AJAX.'ajax-post-list.php');
//Widgets
    //include(get_template_directory()."/framework/widgets/widget_facebook.php");
    require_once(THENEXTMAG_INC_LIBS.'tnm_widget.php');
// Archive
    require_once(THENEXTMAG_INC_LIBS.'tnm_archive.php');
