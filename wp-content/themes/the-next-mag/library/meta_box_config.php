<?php
/********************* META BOX DEFINITIONS ***********************/

/**
 * Prefix of meta keys (optional)
 * Use underscore (_) at the beginning to make keys hidden
 * Alt.: You also can make prefix empty to disable it
 */
add_filter( 'rwmb_meta_boxes', 'bk_register_meta_boxes' );
function bk_register_meta_boxes( $meta_boxes ) {
        
    // Better has an underscore as last sign
    
    global $meta_boxes;
    
    $bk_sidebar = array();
    foreach ( $GLOBALS['wp_registered_sidebars'] as $value => $label ) {
        $bk_sidebar[$value] = ucwords( $label['name'] );
    }
    $bk_sidebar['global_settings']  = esc_html__( 'From Theme Options', 'the-next-mag' );
    
    // Post SubTitle
    $meta_boxes[] = array(
        'id' => 'bk_post_subtitle_section',
        'title' => esc_html__( 'BK SubTitle', 'the-next-mag' ),
        'pages' => array( 'post' ),
        'context' => 'normal',
        'priority' => 'high',
    	'fields' => array(        
            array(
                'name' => esc_html__( 'SubTitle', 'the-next-mag' ),
                'desc' => esc_html__('Insert the SubTitle for this post', 'the-next-mag'),
                'id' => 'bk_post_subtitle',
                'type' => 'textarea',
                'placeholder' => esc_html__('SubTitle ...', 'the-next-mag'),
                'std' => ''
            ),
        )
    );
    // Page Descriptipon
    $meta_boxes[] = array(
        'id'        => 'bk_page_description_section',
        'title'     => esc_html__( 'Page Description', 'the-next-mag' ),
        'pages'     => array( 'page' ),
        'context'   => 'normal',
        'priority'  => 'high',
        'hidden'   => array( 'template', 'in', array('page_builder.php')),
    	'fields'    => array( 
            array(
                'name' => esc_html__( 'Page Description', 'the-next-mag' ),
                'id' => 'bk_page_description',
                'type' => 'textarea',
                'placeholder' => esc_html__('description ...', 'the-next-mag'),
                'std' => ''
            ),
        ),
    );  
    // Page Settings
    $meta_boxes[] = array(
        'id'        => 'bk_page_settings_section',
        'title'     => esc_html__( 'Page Settings', 'the-next-mag' ),
        'pages'     => array( 'page' ),
        'context'   => 'normal',
        'priority'  => 'high',
        'hidden'   => array( 'template', 'in', array('blog.php', 'page_builder.php')),
    	'fields'    => array(   
            array(
                'name' => 'Page Heading',
                'id'   => 'bk_page_header_style',
                'type' => 'select',
                'options'   => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                'grey-bg'           => esc_html__( 'Grey Background', 'the-next-mag' ),
                                'grey-bg-center'    => esc_html__( 'Grey Background -- Align Center', 'the-next-mag' ),
            					'image-bg'          => esc_html__( 'Featured Image Background', 'the-next-mag' ),
                                'image-bg-center'   => esc_html__( 'Featured Image Background -- Align Center', 'the-next-mag' ),
                            ),
                'std'       => 'global_settings',
            ), 
            // Featured Image Config
            array(
                'name'      => esc_html__( 'Featured Image', 'the-next-mag' ),
                'id'        => 'bk_page_feat_img',
                'type'      => 'button_group', 
    			'options'   => array(
                                'global_settings' => esc_html__( 'From Theme Options', 'the-next-mag' ),                
                                1 => esc_html__( 'On', 'the-next-mag' ),
                                0 => esc_html__( 'Off', 'the-next-mag' ),
        				    ),
    			// Select multiple values, optional. Default is false.
    			'multiple'    => false,
    			'std'         => 'global_settings',
            ),
            // Layout
            array(
                'name' => esc_html__( 'Layout', 'the-next-mag' ),
                'id' => 'bk_page_layout',
                'type' => 'select', 
    			'options'  => array(
                                'global_settings' => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                'has_sidebar' => esc_html__( 'Has Sidebar', 'the-next-mag' ),
                                'no_sidebar'  => esc_html__( 'Full Width -- No sidebar', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
            ),
            
            // Sidebar
            array(
                'name' => esc_html__( 'Choose a sidebar for this page', 'the-next-mag' ),
                'id' => 'bk_page_sidebar_select',
                'type' => 'select',
                'options'  => $bk_sidebar,
                'std'  => 'global_settings',
                'hidden' => array( 'bk_page_layout', 'in', array('no_sidebar')),
            ),
            array(
                'name' => esc_html__( 'Sidebar Position -- Left/Right', 'the-next-mag' ),
                'id' => 'bk_page_sidebar_position',
                'type' => 'image_select',
                'options'   => array(
                        'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                        'right' => get_template_directory_uri().'/images/admin_panel/archive/sb-right.png',
                        'left'  => get_template_directory_uri().'/images/admin_panel/archive/sb-left.png',
                ),
                'std'  => 'global_settings',
                'hidden' => array( 'bk_page_layout', 'in', array('no_sidebar')),
            ),
            array(
                'name'      => esc_html__( 'Sticky Sidebar', 'the-next-mag' ),
                'id'        => 'bk_page_sidebar_sticky',
                'type'      => 'button_group',
                'options'   => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                1                   => esc_html__( 'Enable', 'the-next-mag' ),
            					0                   => esc_html__( 'Disable', 'the-next-mag' ),
                            ),
                'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Default Page Template','the-next-mag'),
                'std'       => 'global_settings',
                'hidden' => array( 'bk_page_layout', 'in', array('no_sidebar')),
            ),
        )
    );
    // Post Layout Options
    $meta_boxes[] = array(
        'id' => 'bk_post_ops',
        'title' => esc_html__( 'BK Layout Options', 'the-next-mag' ),
        'desc'   =>  esc_html__( 'From Theme Option: Theme Options -> Single Page', 'the-next-mag' ),        
        'pages' => array( 'post' ),
        'context' => 'normal',
        'priority' => 'low',
    
        'fields' => array(
            array(
    			'id' => 'bk_post_layout_standard',
                'class' => 'post-layout-options',
                'name' => esc_html__( 'Post Layout Option', 'the-next-mag' ),
                'type' => 'image_select', 
    			'options'  => array(
                                'global_settings' => get_template_directory_uri().'/images/admin_panel/default.png',
                                'single-1' => get_template_directory_uri().'/images/admin_panel/single_page/single-1.png',
                                'single-2' => get_template_directory_uri().'/images/admin_panel/single_page/single-2.png',
                                'single-3' => get_template_directory_uri().'/images/admin_panel/single_page/single-3.png',
                                'single-4' => get_template_directory_uri().'/images/admin_panel/single_page/single-4.png',
                                'single-5' => get_template_directory_uri().'/images/admin_panel/single_page/single-5.png',
                                'single-6' => get_template_directory_uri().'/images/admin_panel/single_page/single-6.png',
                                'single-7' => get_template_directory_uri().'/images/admin_panel/single_page/single-7.png',
                                'single-8' => get_template_directory_uri().'/images/admin_panel/single_page/single-8.png',
                                'single-9' => get_template_directory_uri().'/images/admin_panel/single_page/single-9.png',
                                'single-10' => get_template_directory_uri().'/images/admin_panel/single_page/single-10.png',
                                'single-11' => get_template_directory_uri().'/images/admin_panel/single_page/single-11.png',
                                'single-12' => get_template_directory_uri().'/images/admin_panel/single_page/single-12.png',
                                'single-13' => get_template_directory_uri().'/images/admin_panel/single_page/single-13.png',
                                'single-14' => get_template_directory_uri().'/images/admin_panel/single_page/single-14.png',
                                'single-15' => get_template_directory_uri().'/images/admin_panel/single_page/single-15.png',
                                'single-16' => get_template_directory_uri().'/images/admin_panel/single_page/single-16.png',
                                'single-17' => get_template_directory_uri().'/images/admin_panel/single_page/single-17.png',
        				    ),
                'std'         => 'global_settings',
            ),
            array(
                'type' => 'divider',
                'visible' => array(
                         array( 'bk_post_layout_standard', 'in', array('single-7', 'single-8', 'single-9', 'single-10')),
                    ),
            ),
            array(
                'name' => 'Single Header Background',
                'desc' => esc_html__('Leave empty to use the setting from Theme Options', 'the-next-mag'),
                'id'   => 'bk-single-header--bg-color',
                'type' => 'color',
                'std'  => '',
                'visible' => array(
                         array( 'bk_post_layout_standard', 'in', array('single-7', 'single-8', 'single-9', 'single-10')),
                    ),
            ),     
            array(
                'name'      => esc_html__( 'Background Pattern', 'the-next-mag' ),
                'id'        => 'bk-single-header--bg-pattern',
                'type'      => 'button_group', 
    			'options'   => array(
                                'global_settings' => esc_html__( 'From Theme Options', 'the-next-mag' ),                
                                1 => esc_html__( 'Enable', 'the-next-mag' ),
                                0 => esc_html__( 'Disable', 'the-next-mag' ),
        				    ),
    			'std'         => 'global_settings',
                'visible' => array(
                             array( 'bk_post_layout_standard', 'in', array('single-7', 'single-8', 'single-9', 'single-10')),
                        ),
            ), 
            array(
                'name'      => esc_html__( 'Header Text', 'the-next-mag' ),
                'id'        => 'bk-single-header--inverse',
                'type'      => 'button_group', 
    			'options'   => array(
                                'global_settings' => esc_html__( 'From Theme Options', 'the-next-mag' ),                
                                1 => esc_html__( 'White', 'the-next-mag' ),
                                0 => esc_html__( 'Black', 'the-next-mag' ),
        				    ),
    			'std'         => 'global_settings',
                'visible' => array(
                             array( 'bk_post_layout_standard', 'in', array('single-7', 'single-8', 'single-9', 'single-10')),
                        ),
            ),        
            array(
                'type' => 'divider',
                'visible' => array(
                             array( 'bk_post_layout_standard', 'in', array('single-1', 'single-2', 'single-3', 'single-4',
                                                                           'single-5', 'single-6', 'single-9', 'single-10')),
                        ),
            ),
            // Feature Image Config
            array(
                'name' => esc_html__( 'Featured Image Config', 'the-next-mag' ),
                'id' => 'bk-feat-img-status',
                'type'     => 'button_group',
    			'options'  => array(
                                'global_settings' => esc_html__( 'From Theme Options', 'the-next-mag' ),                
                                1 => esc_html__( 'On', 'the-next-mag' ),
                                0 => esc_html__( 'Off', 'the-next-mag' ),
        				    ),
    			'std'         => 'global_settings',
                'visible' => array(
                             array( 'bk_post_layout_standard', 'in', array('single-1', 'single-2', 'single-3', 'single-4',
                                                                           'single-5', 'single-6', 'single-9', 'single-10')),
                        ),
            ),
        )
    );
    $meta_boxes[] = array(
        'id' => 'bk_section_show_hide',
        'title' => esc_html__( 'BK Single Post Section Show/Hide', 'the-next-mag' ),
        'pages' => array( 'post' ),
        'context' => 'normal',
        'priority' => 'low',
        'fields' => array(
            array(
    			'id' => 'bk-authorbox-sw',
                'class' => 'bk-authorbox-sw',
                'name' => esc_html__( 'Author Box', 'the-next-mag' ),
                'type'     => 'button_group',
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                1                   => esc_html__( 'Show', 'the-next-mag' ),
            					0                   => esc_html__( 'Hide', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk-postnav-sw',
                'class' => 'bk-postnav-sw',
                'name' => esc_html__( 'Post Nav Section', 'the-next-mag' ),
                'type'     => 'button_group',
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                1                   => esc_html__( 'Show', 'the-next-mag' ),
            					0                   => esc_html__( 'Hide', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk-related-sw',
                'class' => 'bk-related-sw',
                'name' => esc_html__( 'Related Section', 'the-next-mag' ),
                'type'     => 'button_group',
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                1                   => esc_html__( 'Show', 'the-next-mag' ),
            					0                   => esc_html__( 'Hide', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk-same-cat-sw',
                'class' => 'bk-same-cat-sw',
                'name' => esc_html__( 'Same Category Section', 'the-next-mag' ),
                'type'     => 'button_group',
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                1                   => esc_html__( 'Show', 'the-next-mag' ),
            					0                   => esc_html__( 'Hide', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
        ),
    );
    // Related Post Options
    $meta_boxes[] = array(
        'id' => 'bk_related_post_ops',
        'title' => esc_html__( 'BK Related Post Setting', 'the-next-mag' ),
        'pages' => array( 'post' ),
        'context' => 'normal',
        'priority' => 'low',
        'hidden' => array(
                        'when' => array(
                             array( 'bk_post_layout_standard', 'in', array('global_settings', 'single-3', 'single-6', 'single-8', 'single-10', 'single-13', 'single-16')),
                             array( 'bk-related-sw', 0 )
                         ),
                         'relation' => 'or'
                    ),
        'fields' => array(
            array(
    			'id' => 'bk_related_heading_style',
                'class' => 'related_heading_style',
                'name' => esc_html__( 'Heading Style', 'the-next-mag' ),
                'type' => 'select', 
    			'options'  => array(
                                'global_settings'    => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                'line'              => esc_html__( 'Heading Line', 'the-next-mag' ),
                                'large-line'        => esc_html__( 'Heading Large Line', 'the-next-mag' ),
                                'no-line'           => esc_html__( 'Heading No Line', 'the-next-mag' ),
    							'large-no-line'     => esc_html__( 'Heading Large No Line', 'the-next-mag' ),
                                'line-under'        => esc_html__( 'Heading Line Under', 'the-next-mag' ),
                                'large-line-under'  => esc_html__( 'Heading Large Line Under', 'the-next-mag' ),
                                'center'            => esc_html__( 'Heading Center', 'the-next-mag' ),
                                'large-center'      => esc_html__( 'Heading Large Center', 'the-next-mag' ),
                                'line-around'       => esc_html__( 'Heading Line Around', 'the-next-mag' ),
                                'large-line-around' => esc_html__( 'Heading Large Line Around', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_related_source',
                'class' => 'related_post_options',
                'name' => esc_html__( 'Related Posts', 'the-next-mag' ),
                'type' => 'select', 
    			'options'  => array(
                                'global_settings' => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                'category_tag' => esc_html__( 'Same Categories and Tags', 'the-next-mag' ),
            					'tag'          => esc_html__( 'Same Tags', 'the-next-mag' ),
                                'category'     => esc_html__( 'Same Categories', 'the-next-mag' ),
                                'author'       => esc_html__( 'Same Author', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_number_related',
                'class' => 'related_post_options',
                'name' => esc_html__( 'Number of Related Posts', 'the-next-mag' ),
                'type' => 'select', 
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                '1'                 => esc_html__( '1', 'the-next-mag' ),
            					'2'                 => esc_html__( '2', 'the-next-mag' ),
                                '3'                 => esc_html__( '3', 'the-next-mag' ),
                                '4'                 => esc_html__( '4', 'the-next-mag' ),
                                '5'                 => esc_html__( '5', 'the-next-mag' ),
            					'6'                 => esc_html__( '6', 'the-next-mag' ),
                                '7'                 => esc_html__( '7', 'the-next-mag' ),
                                '8'                 => esc_html__( '8', 'the-next-mag' ),
                                '9'                 => esc_html__( '9', 'the-next-mag' ),
            					'10'                => esc_html__( '10', 'the-next-mag' ),
                                '11'                => esc_html__( '11', 'the-next-mag' ),
                                '12'                => esc_html__( '12', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_related_post_layout',
                'class' => 'related_post_layout',
                'name' => esc_html__( 'Layout', 'the-next-mag' ),
                'type' => 'image_select', 
    			'options'  => array(
                                'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                                'listing_list'       => get_template_directory_uri().'/images/admin_panel/related-module/listing_list.png',
                                'listing_list_alt_a' => get_template_directory_uri().'/images/admin_panel/related-module/listing_list_alt_a.png',
            					'listing_grid'       => get_template_directory_uri().'/images/admin_panel/related-module/listing_grid.png',
                                'listing_grid_small' => get_template_directory_uri().'/images/admin_panel/related-module/listing_grid_small.png',
                                'posts_block_main_col_l' => get_template_directory_uri().'/images/admin_panel/related-module/main_col_l.png',
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_related_post_category',
                'class' => 'related_post_category',
                'name' => esc_html__( 'Category Meta', 'the-next-mag' ),
                'type' => 'button_group', 
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
            					1           => esc_html__( 'Enable', 'the-next-mag' ),
                                0           => esc_html__( 'Disable', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_related_post_excerpt',
                'class' => 'related_post_excerpt',
                'name' => esc_html__( 'Excerpt', 'the-next-mag' ),
                'type'     => 'button_group',
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                1                   => esc_html__( 'Enable', 'the-next-mag' ),
            					0                   => esc_html__( 'Disable', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_related_post_meta',
                'class' => 'related_post_meta',
                'name' => esc_html__( 'Meta List', 'the-next-mag' ),
                'type' => 'select', 
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
            					1       => esc_html__( 'Meta Items: Author', 'the-next-mag' ),
                                2       => esc_html__( 'Meta Items: Author + Date', 'the-next-mag' ),
                                3       => esc_html__( 'Meta Items: Author + Date + Comments', 'the-next-mag' ),
                                4       => esc_html__( 'Meta Items: Author + Date + Views', 'the-next-mag' ),
                                5       => esc_html__( 'Meta Items: Author + Comments + Views', 'the-next-mag' ),
                                6       => esc_html__( 'Meta Items: Author + Views', 'the-next-mag' ),
                                7       => esc_html__( 'Meta Items: Author + Comments', 'the-next-mag' ),
                                8       => esc_html__( 'Meta Items: Date', 'the-next-mag' ),
                                9       => esc_html__( 'Meta Items: Date + Comments', 'the-next-mag' ),
                                10      => esc_html__( 'Meta Items: Date + Views', 'the-next-mag' ),
                                11      => esc_html__( 'Meta Items: Date + Comments + Views', 'the-next-mag' ),
                                12      => esc_html__( 'Meta Items: Comments + Views', 'the-next-mag' ),
                                0       => esc_html__( 'Disable Post Meta', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_related_post_icon',
                'class' => 'related_post_icon',
                'name' => esc_html__( 'Post Icon', 'the-next-mag' ),
                'type' => 'button_group', 
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
            					'disable'           => esc_html__( 'Disable', 'the-next-mag' ),
		                        'enable'            => esc_html__( 'Enable', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
        )
    );
    // Related Post Options
    $meta_boxes[] = array(
        'id' => 'bk_related_post_ops_wide',
        'title' => esc_html__( 'BK Related Post Section - Wide Setting', 'the-next-mag' ),
        'pages' => array( 'post' ),
        'context' => 'normal',
        'priority' => 'low',
        'visible' => array(
                         array( 'bk_post_layout_standard', 'in', array('single-3', 'single-6', 'single-8', 'single-10', 'single-13', 'single-16')),
                         array( 'bk-related-sw', '!=', 0 )
                    ),
        'fields' => array(
            array(
    			'id' => 'bk_related_heading_style_wide',
                'class' => 'related_heading_style',
                'name' => esc_html__( 'Heading Style', 'the-next-mag' ),
                'type' => 'select', 
    			'options'  => array(
                                'global_settings'    => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                'line'              => esc_html__( 'Heading Line', 'the-next-mag' ),
                                'large-line'        => esc_html__( 'Heading Large Line', 'the-next-mag' ),
                                'no-line'           => esc_html__( 'Heading No Line', 'the-next-mag' ),
    							'large-no-line'     => esc_html__( 'Heading Large No Line', 'the-next-mag' ),
                                'line-under'        => esc_html__( 'Heading Line Under', 'the-next-mag' ),
                                'large-line-under'  => esc_html__( 'Heading Large Line Under', 'the-next-mag' ),
                                'center'            => esc_html__( 'Heading Center', 'the-next-mag' ),
                                'large-center'      => esc_html__( 'Heading Large Center', 'the-next-mag' ),
                                'line-around'       => esc_html__( 'Heading Line Around', 'the-next-mag' ),
                                'large-line-around' => esc_html__( 'Heading Large Line Around', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_related_source_wide',
                'class' => 'related_post_options',
                'name' => esc_html__( 'Related Posts', 'the-next-mag' ),
                'type' => 'select', 
    			'options'  => array(
                                'global_settings' => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                'category_tag' => esc_html__( 'Same Categories and Tags', 'the-next-mag' ),
            					'tag'          => esc_html__( 'Same Tags', 'the-next-mag' ),
                                'category'     => esc_html__( 'Same Categories', 'the-next-mag' ),
                                'author'       => esc_html__( 'Same Author', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_related_post_layout_wide',
                'class' => 'related_post_layout',
                'name' => esc_html__( 'Layout', 'the-next-mag' ),
                'type' => 'image_select', 
    			'options'  => array(
                                'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                                'posts_block_b'      => get_template_directory_uri().'/images/admin_panel/related-module/block_b.png',
                                'posts_block_c'      => get_template_directory_uri().'/images/admin_panel/related-module/block_c.png',
                                'posts_block_d'      => get_template_directory_uri().'/images/admin_panel/related-module/block_d.png',
                                'posts_block_e'      => get_template_directory_uri().'/images/admin_panel/related-module/block_e.png',
                                'posts_block_i'      => get_template_directory_uri().'/images/admin_panel/related-module/block_i.png',
                                'posts_block_j'      => get_template_directory_uri().'/images/admin_panel/related-module/block_j.png',
                                'mosaic_a'           => get_template_directory_uri().'/images/admin_panel/related-module/mosaic_a.png',
                                'mosaic_b'           => get_template_directory_uri().'/images/admin_panel/related-module/mosaic_b.png',
                                'mosaic_c'           => get_template_directory_uri().'/images/admin_panel/related-module/mosaic_c.png',
                                'featured_block_c'   => get_template_directory_uri().'/images/admin_panel/related-module/feat_c.png',
                                'featured_block_e'   => get_template_directory_uri().'/images/admin_panel/related-module/feat_e.png',
                                'featured_block_f'   => get_template_directory_uri().'/images/admin_panel/related-module/feat_f.png',
                                'listing_grid_no_sidebar' => get_template_directory_uri().'/images/admin_panel/related-module/listing_grid_no_sidebar.png',
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_related_post_icon_wide',
                'class' => 'related_post_icon',
                'name' => esc_html__( 'Post Icon', 'the-next-mag' ),
                'type' => 'button_group', 
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
            					'disable'           => esc_html__( 'Disable', 'the-next-mag' ),
		                        'enable'            => esc_html__( 'Enable', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
        )
    );  
    // Same Category Posts Options
    $allCategories = get_categories();
    $catArray = array();
    $catArray['current_cat'] = esc_html__('Current Category', 'the-next-mag');
    foreach ( $allCategories as $key => $category ) {
        $catArray[$category->term_id] = $category->name;
    }
    $meta_boxes[] = array(
        'id' => 'bk_same_cat_post_ops',
        'title' => esc_html__( 'BK Same Category Posts Setting', 'the-next-mag' ),
        'pages' => array( 'post' ),
        'context' => 'normal',
        'priority' => 'low',
        'hidden' => array(
                        'when' => array(
                             array( 'bk_post_layout_standard', 'in', array('global_settings', 'single-3', 'single-6', 'single-8', 'single-10', 'single-13', 'single-16')),
                             array( 'bk-same-cat-sw', 0 )
                         ),
                         'relation' => 'or'
                    ),
        'fields' => array(
            array(
    			'id'         => 'bk_same_cat_id',
                'class'      => 'same_cat_id',
                'name'       => esc_html__( 'Category: ', 'the-next-mag' ),
                'type'       => 'select', 
    			'options'    => $catArray,
    			'multiple'   => false,
    			'std'        => 'current_cat',
    		),
            array(
    			'id' => 'bk_same_cat_heading_style',
                'class' => 'same_cat_heading_style',
                'name' => esc_html__( 'Heading Style', 'the-next-mag' ),
                'type' => 'select', 
    			'options'  => array(
                                'global_settings'    => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                'line'              => esc_html__( 'Heading Line', 'the-next-mag' ),
                                'large-line'        => esc_html__( 'Heading Large Line', 'the-next-mag' ),
                                'no-line'           => esc_html__( 'Heading No Line', 'the-next-mag' ),
    							'large-no-line'     => esc_html__( 'Heading Large No Line', 'the-next-mag' ),
                                'line-under'        => esc_html__( 'Heading Line Under', 'the-next-mag' ),
                                'large-line-under'  => esc_html__( 'Heading Large Line Under', 'the-next-mag' ),
                                'center'            => esc_html__( 'Heading Center', 'the-next-mag' ),
                                'large-center'      => esc_html__( 'Heading Large Center', 'the-next-mag' ),
                                'line-around'       => esc_html__( 'Heading Line Around', 'the-next-mag' ),
                                'large-line-around' => esc_html__( 'Heading Large Line Around', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_same_cat_post_layout',
                'class' => 'same_cat_post_layout',
                'name' => esc_html__( 'Layout', 'the-next-mag' ),
                'type' => 'image_select', 
    			'options'  => array(
                                'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                                'listing_list'       => get_template_directory_uri().'/images/admin_panel/related-module/listing_list.png',
                                'listing_list_alt_a' => get_template_directory_uri().'/images/admin_panel/related-module/listing_list_alt_a.png',
            					'listing_grid'       => get_template_directory_uri().'/images/admin_panel/related-module/listing_grid.png',
                                'listing_grid_small' => get_template_directory_uri().'/images/admin_panel/related-module/listing_grid_small.png',
                                'posts_block_main_col_l' => get_template_directory_uri().'/images/admin_panel/related-module/main_col_l.png',
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_same_cat_number_posts',
                'class' => 'same_cat_number_posts',
                'name' => esc_html__( 'Number of Posts', 'the-next-mag' ),
                'type' => 'select', 
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                '1'                 => esc_html__( '1', 'the-next-mag' ),
            					'2'                 => esc_html__( '2', 'the-next-mag' ),
                                '3'                 => esc_html__( '3', 'the-next-mag' ),
                                '4'                 => esc_html__( '4', 'the-next-mag' ),
                                '5'                 => esc_html__( '5', 'the-next-mag' ),
            					'6'                 => esc_html__( '6', 'the-next-mag' ),
                                '7'                 => esc_html__( '7', 'the-next-mag' ),
                                '8'                 => esc_html__( '8', 'the-next-mag' ),
                                '9'                 => esc_html__( '9', 'the-next-mag' ),
            					'10'                => esc_html__( '10', 'the-next-mag' ),
                                '11'                => esc_html__( '11', 'the-next-mag' ),
                                '12'                => esc_html__( '12', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_same_cat_post_category',
                'class' => 'same_cat_post_category',
                'name' => esc_html__( 'Category Meta', 'the-next-mag' ),
                'type' => 'button_group', 
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
            					1           => esc_html__( 'Enable', 'the-next-mag' ),
                                0           => esc_html__( 'Disable', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_same_cat_post_excerpt',
                'class' => 'same_cat_post_excerpt',
                'name' => esc_html__( 'Excerpt', 'the-next-mag' ),
                'type'     => 'button_group',
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                1                   => esc_html__( 'Enable', 'the-next-mag' ),
            					0                   => esc_html__( 'Disable', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_same_cat_post_meta',
                'class' => 'same_cat_post_meta',
                'name' => esc_html__( 'Meta List', 'the-next-mag' ),
                'type' => 'select', 
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
            					1       => esc_html__( 'Meta Items: Author', 'the-next-mag' ),
                                2       => esc_html__( 'Meta Items: Author + Date', 'the-next-mag' ),
                                3       => esc_html__( 'Meta Items: Author + Date + Comments', 'the-next-mag' ),
                                4       => esc_html__( 'Meta Items: Author + Date + Views', 'the-next-mag' ),
                                5       => esc_html__( 'Meta Items: Author + Comments + Views', 'the-next-mag' ),
                                6       => esc_html__( 'Meta Items: Author + Views', 'the-next-mag' ),
                                7       => esc_html__( 'Meta Items: Author + Comments', 'the-next-mag' ),
                                8       => esc_html__( 'Meta Items: Date', 'the-next-mag' ),
                                9       => esc_html__( 'Meta Items: Date + Comments', 'the-next-mag' ),
                                10      => esc_html__( 'Meta Items: Date + Views', 'the-next-mag' ),
                                11      => esc_html__( 'Meta Items: Date + Comments + Views', 'the-next-mag' ),
                                12      => esc_html__( 'Meta Items: Comments + Views', 'the-next-mag' ),
                                0       => esc_html__( 'Disable Post Meta', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_same_cat_post_icon',
                'class' => 'same_cat_post_icon',
                'name' => esc_html__( 'Post Icon', 'the-next-mag' ),
                'type' => 'button_group', 
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
            					'disable'           => esc_html__( 'Disable', 'the-next-mag' ),
		                        'enable'            => esc_html__( 'Enable', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_same_cat_more_link',
                'class' => 'same_cat_more_link',
                'name' => esc_html__( 'More Link', 'the-next-mag' ),
                'type'     => 'button_group',
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                1                   => esc_html__( 'Enable', 'the-next-mag' ),
            					0                   => esc_html__( 'Disable', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
        )
    );
    
    // Related Post Options
    $meta_boxes[] = array(
        'id' => 'bk_same_cat_post_ops_wide',
        'title' => esc_html__( 'BK Same Category Post Section - Wide Setting', 'the-next-mag' ),
        'pages' => array( 'post' ),
        'context' => 'normal',
        'priority' => 'low',
        'visible' => array(
                         array( 'bk_post_layout_standard', 'in', array('single-3', 'single-6', 'single-8', 'single-10', 'single-13', 'single-16')),
                         array( 'bk-same-cat-sw', '!=', 0 )
                    ),
        'fields' => array(
            array(
    			'id'         => 'bk_same_cat_id_wide',
                'class'      => 'same_cat_id_wide',
                'name'       => esc_html__( 'Category: ', 'the-next-mag' ),
                'type'       => 'select', 
    			'options'    => $catArray,
    			'multiple'   => false,
    			'std'        => 'disable',
    		),
            array(
    			'id' => 'bk_same_cat_heading_style_wide',
                'class' => 'same_cat_heading_style',
                'name' => esc_html__( 'Heading Style', 'the-next-mag' ),
                'type' => 'select', 
    			'options'  => array(
                                'global_settings'    => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                'line'              => esc_html__( 'Heading Line', 'the-next-mag' ),
                                'large-line'        => esc_html__( 'Heading Large Line', 'the-next-mag' ),
                                'no-line'           => esc_html__( 'Heading No Line', 'the-next-mag' ),
    							'large-no-line'     => esc_html__( 'Heading Large No Line', 'the-next-mag' ),
                                'line-under'        => esc_html__( 'Heading Line Under', 'the-next-mag' ),
                                'large-line-under'  => esc_html__( 'Heading Large Line Under', 'the-next-mag' ),
                                'center'            => esc_html__( 'Heading Center', 'the-next-mag' ),
                                'large-center'      => esc_html__( 'Heading Large Center', 'the-next-mag' ),
                                'line-around'       => esc_html__( 'Heading Line Around', 'the-next-mag' ),
                                'large-line-around' => esc_html__( 'Heading Large Line Around', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_same_cat_post_layout_wide',
                'class' => 'same_cat_post_layout_wide',
                'name' => esc_html__( 'Layout', 'the-next-mag' ),
                'type' => 'image_select', 
    			'options'  => array(
                                'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                                'posts_block_b'       => get_template_directory_uri().'/images/admin_panel/related-module/block_b.png',
                                'posts_block_c'       => get_template_directory_uri().'/images/admin_panel/related-module/block_c.png',
                                'posts_block_d'       => get_template_directory_uri().'/images/admin_panel/related-module/block_d.png',
                                'posts_block_e'       => get_template_directory_uri().'/images/admin_panel/related-module/block_e.png',
                                'posts_block_i'       => get_template_directory_uri().'/images/admin_panel/related-module/block_i.png',
                                'posts_block_j'       => get_template_directory_uri().'/images/admin_panel/related-module/block_j.png',
                                'mosaic_a'           => get_template_directory_uri().'/images/admin_panel/related-module/mosaic_a.png',
                                'mosaic_b'           => get_template_directory_uri().'/images/admin_panel/related-module/mosaic_b.png',
                                'mosaic_c'           => get_template_directory_uri().'/images/admin_panel/related-module/mosaic_c.png',
                                'featured_block_c'   => get_template_directory_uri().'/images/admin_panel/related-module/feat_c.png',
                                'featured_block_e'   => get_template_directory_uri().'/images/admin_panel/related-module/feat_e.png',
                                'featured_block_f'   => get_template_directory_uri().'/images/admin_panel/related-module/feat_f.png',
                                'listing_grid_no_sidebar' => get_template_directory_uri().'/images/admin_panel/related-module/listing_grid_no_sidebar.png',
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_same_cat_post_icon_wide',
                'class' => 'same_cat_post_icon_wide',
                'name' => esc_html__( 'Post Icon', 'the-next-mag' ),
                'type' => 'button_group', 
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
            					'disable'           => esc_html__( 'Disable', 'the-next-mag' ),
		                        'enable'            => esc_html__( 'Enable', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_same_cat_more_link_wide',
                'class' => 'same_cat_more_link_wide',
                'name' => esc_html__( 'More Link', 'the-next-mag' ),
                'type'     => 'button_group',
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                1                   => esc_html__( 'Enable', 'the-next-mag' ),
            					0                   => esc_html__( 'Disable', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
        )
    );  
    $meta_boxes[] = array(
        'id' => 'bk_single_post_sidebar',
        'title' => esc_html__( 'Sidebar Option', 'the-next-mag' ),
        'pages' => array( 'post' ),
        'context' => 'normal',
        'priority' => 'low',
    
        'fields' => array(
            // Sidebar Select
            array(
                'name' => esc_html__( 'Choose a sidebar for this post', 'the-next-mag' ),
                'id' => 'bk_post_sb_select',
                'type' => 'select',
                'options'  => $bk_sidebar,
                'desc' => esc_html__( 'Sidebar Select', 'the-next-mag' ),
                'std'  => 'global_settings',
            ),
            array(
    			'id' => 'bk_post_sb_position',
                'class' => 'post_sb_position',
                'name' => esc_html__( 'Sidebar Position', 'the-next-mag' ),
                'type' => 'image_select', 
    			'options'  => array(
                                'global_settings'   => get_template_directory_uri().'/images/admin_panel/default.png',
                                'right'             => get_template_directory_uri().'/images/admin_panel/single_page/sb-right.png',
            					'left'              => get_template_directory_uri().'/images/admin_panel/single_page/sb-left.png',
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
            array(
    			'id' => 'bk_post_sb_sticky',
                'class' => 'post_sb_sticky',
                'name' => esc_html__( 'Sidebar Sticky', 'the-next-mag' ),
                'type'     => 'button_group',
    			'options'  => array(
                                'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                1                   => esc_html__( 'Enable', 'the-next-mag' ),
            					0                   => esc_html__( 'Disable', 'the-next-mag' ),
        				    ),
    			'multiple'    => false,
    			'std'         => 'global_settings',
    		),
        )
    );
    
    $meta_boxes[] = array(
        'id' => 'bk_video_post_format',
        'title' => esc_html__( 'BK Video Post Format', 'the-next-mag' ),
        'pages' => array( 'post' ),
        'context' => 'normal',
        'priority' => 'high',
        'visible' => array( 'post_format', 'in', array('video')),
    	'fields' => array(        
            //Video
            array(
                'name' => esc_html__( 'Format Options: Video', 'the-next-mag' ),
                'desc' => esc_html__('Support Youtube, Vimeo Link', 'the-next-mag'),
                'id' => 'bk_video_media_link',
                'type'  => 'oembed',
                'placeholder' => esc_html__('Link ...', 'the-next-mag'),
                'std' => ''
            ),
        )
    );
    $meta_boxes[] = array(
        'id' => 'bk_gallery_post_format',
        'title' => esc_html__( 'BK Gallery Post Format', 'the-next-mag' ),
        'pages' => array( 'post' ),
        'context' => 'normal',
        'priority' => 'high',
        'visible' => array( 'post_format', 'in', array('gallery')),
    	'fields' => array(  
            //Gallery
            array(
                'name' => esc_html__( 'Format Options: Gallery', 'the-next-mag' ),
                'desc' => esc_html__('Gallery Images', 'the-next-mag'),
                'id' => 'bk_gallery_content',
                'type' => 'image_advanced',
                'std' => ''
            ),
            array(
    			'id' => 'bk_gallery_type',
                'name' => esc_html__( 'Gallery Type', 'the-next-mag' ),
                'type' => 'select', 
    			'options'  => array(
            					'gallery-1' => esc_html__( 'Gallery 1', 'the-next-mag' ),
            					'gallery-2' => esc_html__( 'Gallery 2 ', 'the-next-mag' ),
                                'gallery-3' => esc_html__( 'Gallery 3', 'the-next-mag' ),
        				    ),
    			// Select multiple values, optional. Default is false.
    			'multiple'    => false,
    			'std'         => 'left',
    		),
        )
    );
    // Post Review Options
    $meta_boxes[] = array(
        'id' => 'bk_review',
        'title' => esc_html__( 'BK Review System', 'the-next-mag' ),
        'pages' => array( 'post' ),
        'context' => 'normal',
        'priority' => 'high',
    
        'fields' => array(
            // Enable Review
            array(
                'name' => esc_html__( 'Review Box', 'the-next-mag' ),
                'id' => 'bk_review_checkbox',
                'type' => 'checkbox',
                'desc' => esc_html__( 'Enable Review On This Post', 'the-next-mag' ),
                'std'  => 0,
            ),
            array(
                'visible' => array( 'bk_review_checkbox', '=', 1),
                'type' => 'divider',
            ),
            array(
    			'id' => 'bk_review_box_position',
                'name' => esc_html__( 'Review Box Position', 'the-next-mag' ),
                'type' => 'select', 
    			'options'  => array(
            					'default'      => esc_html__( 'Default -- Under the post content', 'the-next-mag' ),
            					'aside-left'   => esc_html__( 'Aside Left ', 'the-next-mag' ),
                                'aside-right'  => esc_html__( 'Aside Right', 'the-next-mag' ),
        				    ),
    			// Select multiple values, optional. Default is false.
    			'multiple'    => false,
    			'std'         => 'default',
                'visible'     => array( 'bk_review_checkbox', '=', 1),
    		),
            array(
                'visible' => array( 'bk_review_checkbox', '=', 1),
                'type' => 'divider',
            ),
            array(
                'name' => 'Product Image',
                'id'   => 'bk_review_product_img',
                'type' => 'single_image',
                'visible'     => array( 'bk_review_checkbox', '=', 1),
            ),  
            array(
                'name' => esc_html__( 'Product name', 'the-next-mag' ),
                'id'   => 'bk_review_box_title',
                'type' => 'textarea',
                'cols' => 20,
                'rows' => 2,
                'visible' => array( 'bk_review_checkbox', '=', 1),
            ),
            array(
                'name' => esc_html__( 'Description', 'the-next-mag' ),
                'id'   => 'bk_review_box_sub_title',
                'type' => 'textarea',
                'cols' => 20,
                'rows' => 2,
                'visible' => array( 'bk_review_checkbox', '=', 1),
            ),
            array(
                'visible' => array( 'bk_review_checkbox', '=', 1),
                'type' => 'divider',
            ),
            //Review Score
            array(
                'name' => esc_html__( 'Review Score', 'the-next-mag' ),
                'id' => 'bk_review_score',
                'class' => 'tnm-',
                'type' => 'slider',
                'visible' => array( 'bk_review_checkbox', '=', 1),
                'js_options' => array(
                    'min'   => 0,
                    'max'   => 10.05,
                    'step'  => .1,
                ),
            ),
            array(
                'visible' => array( 'bk_review_checkbox', '=', 1),
                'type' => 'divider',
            ),
            // Summary
            array(
                'name' => esc_html__( 'Summary', 'the-next-mag' ),
                'id'   => 'bk_review_summary',
                'type' => 'textarea',
                'cols' => 20,
                'rows' => 4,
                'visible' => array( 'bk_review_checkbox', '=', 1),
            ),
            
            array(
                'visible' => array( 'bk_review_checkbox', '=', 1),
                'type' => 'divider',
            ),
            
            //Pros & Cons
            array(
                'name' => esc_html__( 'Pros and Cons', 'the-next-mag' ),
                'id' => 'bk_pros_cons',
                'type' => 'checkbox',
                'desc' => esc_html__( 'Enable Pros and Cons On This Post', 'the-next-mag' ),
                'std'  => 0,
                'visible' => array( 'bk_review_checkbox', '=', 1),
            ),
            array(
                'visible' => array( 'bk_pros_cons', '=', 1),
                'type' => 'divider',
            ),
            array(
                'name' => esc_html__( 'Pros Title', 'the-next-mag' ),
                'id'   => 'bk_review_pros_title',
                'type' => 'textarea',
                'cols' => 20,
                'rows' => 2,
                'visible' => array( 'bk_pros_cons', '=', 1),
            ),
            array(
                'name' => esc_html__( 'Pros (Advantages)', 'the-next-mag' ),
                'id'   => 'bk_review_pros',
                'type' => 'textarea',
                'cols' => 20,
                'clone' => true,
                'rows' => 2,
                'visible' => array( 'bk_pros_cons', '=', 1),
            ),
            array(
                'visible' => array( 'bk_pros_cons', '=', 1),
                'type' => 'divider',
            ),
            array(
                'name' => esc_html__( 'Cons Title', 'the-next-mag' ),
                'id'   => 'bk_review_cons_title',
                'type' => 'textarea',
                'cols' => 20,
                'rows' => 2,
                'visible' => array( 'bk_pros_cons', '=', 1),
            ),
            array(
                'name' => esc_html__( 'Cons (Disadvantages)', 'the-next-mag' ),
                'id'   => 'bk_review_cons',
                'type' => 'textarea',
                'cols' => 20,
                'clone' => true,
                'rows' => 2,
                'visible' => array( 'bk_pros_cons', '=', 1),
            ),
        )
    );
    if ( function_exists( 'mb_term_meta_load' ) ) {
        $meta_boxes[] = array(
            'title'      => 'Advance Category Options',
            'taxonomies' => array('category'), // List of taxonomies. Array or string
    
            'fields' => array(
                array(
        			'id' => 'bk_category_feature_area',
                    'class' => 'bk_archive_feature_area',
                    'name' => esc_html__( 'Feature Area', 'the-next-mag' ),
                    'type' => 'image_select', 
        			'options'  => array(
                                    'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                                    'disable'            => get_template_directory_uri().'/images/admin_panel/disable.png',
                                    'mosaic_a'           => get_template_directory_uri().'/images/admin_panel/archive/mosaic_a.png',
                                    'mosaic_a_bg'        => get_template_directory_uri().'/images/admin_panel/archive/mosaic_a_bg.png',
                                    'mosaic_b'           => get_template_directory_uri().'/images/admin_panel/archive/mosaic_b.png',
                                    'mosaic_b_bg'        => get_template_directory_uri().'/images/admin_panel/archive/mosaic_b_bg.png',
                                    'mosaic_c'           => get_template_directory_uri().'/images/admin_panel/archive/mosaic_c.png',
                                    'mosaic_c_bg'        => get_template_directory_uri().'/images/admin_panel/archive/mosaic_c_bg.png',
                                    'featured_block_e'   => get_template_directory_uri().'/images/admin_panel/archive/featured_block_e.png',
                                    'featured_block_f'   => get_template_directory_uri().'/images/admin_panel/archive/featured_block_f.png',
                                    'posts_block_b'       => get_template_directory_uri().'/images/admin_panel/archive/posts_block_b.png',
                                    'posts_block_c'       => get_template_directory_uri().'/images/admin_panel/archive/posts_block_c.png',
                                    'posts_block_e'       => get_template_directory_uri().'/images/admin_panel/archive/posts_block_e.png',
                                    'posts_block_e_bg'    => get_template_directory_uri().'/images/admin_panel/archive/posts_block_e_bg.png',
                                    'posts_block_i'       => get_template_directory_uri().'/images/admin_panel/archive/posts_block_i.png',
            				    ),
        			'multiple'    => false,
        			'std'         => 'global_settings',
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Archive','the-next-mag'),
        		),
                array(
                    'name' => 'Feature Area Post Option',
                    'id'   => 'bk_category_feature_area__post_option',
                    'type' => 'select',
                    'options'   => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                    'featured'          => esc_html__( 'Show Featured Posts', 'the-next-mag' ),
        			                'latest'            => esc_html__( 'Show Latest Posts', 'the-next-mag' ),
                                ),
                    'std'       => 'global_settings',
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','the-next-mag'),
                ), 
                array(
                    'name' => 'Show Feature Area only on 1st page',
                    'id'   => 'bk_feature_area__show_hide',
                    'type' => 'button_group',
                    'options'   => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                    1                   => esc_html__( 'Yes', 'the-next-mag' ),
        			                0                   => esc_html__( 'No', 'the-next-mag' ),
                                ),
                    'std'       => 'global_settings',
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','the-next-mag'),
                ), 
                array(
                    'name' => 'Page Heading',
                    'id'   => 'bk_category_header_style',
                    'type' => 'select',
                    'visible' => array( 'bk_category_feature_area', 'in', array('mosaic_a', 'mosaic_c', 'featured_block_f', 'posts_block_b', 'posts_block_c', 'posts_block_e', 'posts_block_i')),
                    'options'   => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                    'grey-bg'           => esc_html__( 'Grey Background', 'the-next-mag' ),
                                    'grey-bg-center'    => esc_html__( 'Grey Background -- Align Center', 'the-next-mag' ),
                					'image-bg'          => esc_html__( 'Featured Image Background', 'the-next-mag' ),
                                    'image-bg-center'   => esc_html__( 'Featured Image Background -- Align Center', 'the-next-mag' ),
                                ),
                    'std'       => 'global_settings',
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','the-next-mag'),
                ), 
                array(
    				'name'    => esc_html__('Content Layouts','the-next-mag'),
    				'id'      => 'bk_category_content_layout',
    				'type' => 'image_select', 
        			'options'  => array(
                                    'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                                    'listing_list'       => get_template_directory_uri().'/images/admin_panel/archive/listing_list.png',
                                    'listing_list_alt_a' => get_template_directory_uri().'/images/admin_panel/archive/listing_list_alt_a.png',
                                    'listing_list_alt_b' => get_template_directory_uri().'/images/admin_panel/archive/listing_list_alt_b.png',
                                    'listing_list_alt_c' => get_template_directory_uri().'/images/admin_panel/archive/listing_list_alt_c.png',
                					'listing_grid'       => get_template_directory_uri().'/images/admin_panel/archive/listing_grid.png',
                                    'listing_grid_alt_a' => get_template_directory_uri().'/images/admin_panel/archive/listing_grid_alt_a.png',
                                    'listing_grid_alt_b' => get_template_directory_uri().'/images/admin_panel/archive/listing_grid_alt_b.png',
                                    'listing_grid_small' => get_template_directory_uri().'/images/admin_panel/archive/listing_grid_small.png',
                                    'listing_grid_no_sidebar'         => get_template_directory_uri().'/images/admin_panel/archive/listing_grid_no_sidebar.png',
                                    'listing_grid_small_no_sidebar'   => get_template_directory_uri().'/images/admin_panel/archive/listing_grid_small_no_sidebar.png',
                                    'listing_list_no_sidebar'         => get_template_directory_uri().'/images/admin_panel/archive/listing_list_no_sidebar.png',
                                    'listing_list_alt_a_no_sidebar'   => get_template_directory_uri().'/images/admin_panel/archive/listing_list_alt_a_no_sidebar.png',
                                    'listing_list_alt_b_no_sidebar'   => get_template_directory_uri().'/images/admin_panel/archive/listing_list_alt_b_no_sidebar.png',
                                    'listing_list_alt_c_no_sidebar'   => get_template_directory_uri().'/images/admin_panel/archive/listing_list_alt_c_no_sidebar.png',
            				    ),
                    'std' => 'global_settings',
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','the-next-mag'),
    			),
                array(
                    'name' => 'Pagination',
                    'id'   => 'bk_category_pagination',
                    'type' => 'select',
                    'options'   => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                    'default'           => esc_html__( 'Default Pagination', 'the-next-mag' ),
        			                'ajax-pagination'   => esc_html__( 'Ajax Pagination', 'the-next-mag' ),
                                    'ajax-loadmore'     => esc_html__( 'Ajax Load More', 'the-next-mag' ),
                                ),
                    'std'       => 'global_settings',
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','the-next-mag'),
                ), 
                array(
                    'name' => '[Content Section] Exclude Posts',
                    'id'   => 'bk_category_exclude_posts',
                    'type'     => 'button_group',
                    'hidden'    => array( 'bk_category_feature_area', 'in', array('disable')),
                    'options'   => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                    1                   => esc_html__( 'Enable', 'the-next-mag' ),
                                    0                   => esc_html__( 'Disable', 'the-next-mag' ),
                                ),
                    'std'       => 'global_settings',
                    'desc' => esc_html__('Content Section: Exclude Featured Posts that are shown on the Feature Area','the-next-mag')
                ),
                array(
                    'name' => esc_html__( 'Choose a sidebar for this page', 'the-next-mag' ),
                    'id' => 'bk_category_sidebar_select',
                    'type' => 'select',
                    'options'  => $bk_sidebar,
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','the-next-mag'),
                    'std'  => 'global_settings',
                    'visible' => array( 'bk_category_content_layout', 'in', array('listing_list', 'listing_list_alt_a',
                                                                                 'listing_list_alt_b', 'listing_list_alt_b',
                                                                                 'listing_list_alt_c', 'listing_grid',
                                                                                 'listing_grid_alt_a', 'listing_grid_alt_b',
                                                                                 'listing_grid_small', 'global_settings')),
                ),
                array(
                    'name' => esc_html__( 'Sidebar Position -- Left/Right', 'the-next-mag' ),
                    'id' => 'bk_category_sidebar_position',
                    'type' => 'image_select',
                    'options'   => array(
                            'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                            'right' => get_template_directory_uri().'/images/admin_panel/archive/sb-right.png',
                            'left'  => get_template_directory_uri().'/images/admin_panel/archive/sb-left.png',
                    ),
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','the-next-mag'),
                    'std'  => 'global_settings',
                    'visible' => array( 'bk_category_content_layout', 'in', array('listing_list', 'listing_list_alt_a',
                                                                                 'listing_list_alt_b', 'listing_list_alt_b',
                                                                                 'listing_list_alt_c', 'listing_grid',
                                                                                 'listing_grid_alt_a', 'listing_grid_alt_b',
                                                                                 'listing_grid_small', 'global_settings')),
                ),
                array(
                    'name'      => esc_html__( 'Sticky Sidebar', 'the-next-mag' ),
                    'id'        => 'bk_category_sidebar_sticky',
                    'type'      => 'button_group',
                    'options'   => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                    1                   => esc_html__( 'Enable', 'the-next-mag' ),
                					0                   => esc_html__( 'Disable', 'the-next-mag' ),
                                ),
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','the-next-mag'),
                    'std'       => 'global_settings',
                    'visible' => array( 'bk_category_content_layout', 'in', array('listing_list', 'listing_list_alt_a',
                                                                                 'listing_list_alt_b', 'listing_list_alt_b',
                                                                                 'listing_list_alt_c', 'listing_grid',
                                                                                 'listing_grid_alt_a', 'listing_grid_alt_b',
                                                                                 'listing_grid_small', 'global_settings')),
                ),
                array(
                    'name' => 'Category Color',
                    'id'   => 'bk_category__color',
                    'type' => 'color',
                ),   
                array(
                    'name' => 'Featured Image',
                    'id'   => 'bk_category_feat_img',
                    'type' => 'single_image',
                ),  
            ),
        );
        $meta_boxes[] = array(
            'title'      => ' ',
            'taxonomies' => array('post_tag'), // List of taxonomies. Array or string
    
            'fields' => array(
                array(
                    'name' => 'Page Heading',
                    'id'   => 'bk_archive_header_style',
                    'type' => 'select',
                    'options'   => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                    'grey-bg'           => esc_html__( 'Grey Background', 'the-next-mag' ),
                                    'grey-bg-center'    => esc_html__( 'Grey Background -- Align Center', 'the-next-mag' ),
                					'image-bg'          => esc_html__( 'Featured Image Background', 'the-next-mag' ),
                                    'image-bg-center'   => esc_html__( 'Featured Image Background -- Align Center', 'the-next-mag' ),
                                ),
                    'std'       => 'global_settings',
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Archive','the-next-mag'),
                ), 
                array(
    				'name'    => esc_html__('Content Layouts','the-next-mag'),
    				'id'      => 'bk_archive_content_layout',
    				'type' => 'image_select', 
        			'options'  => array(
                                    'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                                    'listing_list'       => get_template_directory_uri().'/images/admin_panel/archive/listing_list.png',
                                    'listing_list_alt_a' => get_template_directory_uri().'/images/admin_panel/archive/listing_list_alt_a.png',
                                    'listing_list_alt_b' => get_template_directory_uri().'/images/admin_panel/archive/listing_list_alt_b.png',
                                    'listing_list_alt_c' => get_template_directory_uri().'/images/admin_panel/archive/listing_list_alt_c.png',
                					'listing_grid'       => get_template_directory_uri().'/images/admin_panel/archive/listing_grid.png',
                                    'listing_grid_alt_a' => get_template_directory_uri().'/images/admin_panel/archive/listing_grid_alt_a.png',
                                    'listing_grid_alt_b' => get_template_directory_uri().'/images/admin_panel/archive/listing_grid_alt_b.png',
                                    'listing_grid_small' => get_template_directory_uri().'/images/admin_panel/archive/listing_grid_small.png',
                                    'listing_grid_no_sidebar'         => get_template_directory_uri().'/images/admin_panel/archive/listing_grid_no_sidebar.png',
                                    'listing_grid_small_no_sidebar'   => get_template_directory_uri().'/images/admin_panel/archive/listing_grid_small_no_sidebar.png',
                                    'listing_list_no_sidebar'         => get_template_directory_uri().'/images/admin_panel/archive/listing_list_no_sidebar.png',
                                    'listing_list_alt_a_no_sidebar'   => get_template_directory_uri().'/images/admin_panel/archive/listing_list_alt_a_no_sidebar.png',
                                    'listing_list_alt_b_no_sidebar'   => get_template_directory_uri().'/images/admin_panel/archive/listing_list_alt_b_no_sidebar.png',
                                    'listing_list_alt_c_no_sidebar'   => get_template_directory_uri().'/images/admin_panel/archive/listing_list_alt_c_no_sidebar.png',
            				    ),
                    'std' => 'global_settings',
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Archive','the-next-mag'),
    			),
                array(
                    'name' => 'Pagination',
                    'id'   => 'bk_archive_pagination',
                    'type' => 'select',
                    'options'   => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                    'default'           => esc_html__( 'Default Pagination', 'the-next-mag' ),
        			                'ajax-pagination'   => esc_html__( 'Ajax Pagination', 'the-next-mag' ),
                                    'ajax-loadmore'     => esc_html__( 'Ajax Load More', 'the-next-mag' ),
                                ),
                    'std'       => 'global_settings',
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Category','the-next-mag'),
                ), 
                array(
                    'name' => esc_html__( 'Choose a sidebar for this page', 'the-next-mag' ),
                    'id' => 'bk_archive_sidebar_select',
                    'type' => 'select',
                    'options'  => $bk_sidebar,
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Archive','the-next-mag'),
                    'std'  => 'global_settings',
                    'visible' => array( 'bk_archive_content_layout', 'in', array('listing_list', 'listing_list_alt_a',
                                                                                 'listing_list_alt_b', 'listing_list_alt_b',
                                                                                 'listing_list_alt_c', 'listing_grid',
                                                                                 'listing_grid_alt_a', 'listing_grid_alt_b',
                                                                                 'listing_grid_small', 'global_settings')),
                ),
                array(
                    'name' => esc_html__( 'Sidebar Position -- Left/Right', 'the-next-mag' ),
                    'id' => 'bk_archive_sidebar_position',
                    'type' => 'image_select',
                    'options'   => array(
                            'global_settings'    => get_template_directory_uri().'/images/admin_panel/default.png',
                            'right' => get_template_directory_uri().'/images/admin_panel/archive/sb-right.png',
                            'left'  => get_template_directory_uri().'/images/admin_panel/archive/sb-left.png',
                    ),
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Archive','the-next-mag'),
                    'std'  => 'global_settings',
                    'visible' => array( 'bk_archive_content_layout', 'in', array('listing_list', 'listing_list_alt_a',
                                                                                 'listing_list_alt_b', 'listing_list_alt_b',
                                                                                 'listing_list_alt_c', 'listing_grid',
                                                                                 'listing_grid_alt_a', 'listing_grid_alt_b',
                                                                                 'listing_grid_small', 'global_settings')),
                ),
                array(
                    'name'      => esc_html__( 'Sticky Sidebar', 'the-next-mag' ),
                    'id'        => 'bk_archive_sidebar_sticky',
                    'type'      => 'button_group',
                    'options'   => array(
                                    'global_settings'   => esc_html__( 'From Theme Options', 'the-next-mag' ),
                                    1                   => esc_html__( 'Enable', 'the-next-mag' ),
                					0                   => esc_html__( 'Disable', 'the-next-mag' ),
                                ),
                    'desc' => esc_html__('From Theme Options setting option is set in Theme Option -> Archive','the-next-mag'),
                    'std'       => 'global_settings',
                    'visible' => array( 'bk_archive_content_layout', 'in', array('listing_list', 'listing_list_alt_a',
                                                                                 'listing_list_alt_b', 'listing_list_alt_b',
                                                                                 'listing_list_alt_c', 'listing_grid',
                                                                                 'listing_grid_alt_a', 'listing_grid_alt_b',
                                                                                 'listing_grid_small', 'global_settings')),
                ),
                array(
                    'name' => 'Featured Image',
                    'id'   => 'bk_archive_feat_img',
                    'type' => 'single_image',
                ),  
            ),
        );
    }
    return $meta_boxes;
}