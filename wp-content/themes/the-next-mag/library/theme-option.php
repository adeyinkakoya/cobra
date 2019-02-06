<?php

/**
	ReduxFramework Config File
	For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
**/

if ( !class_exists( "ReduxFramework" ) ) {
	return;
} 

if ( !class_exists( "Redux_Framework_config" ) ) {
	class Redux_Framework_config {

		public $args = array();
		public $sections = array();
		public $theme;
		public $ReduxFramework;

		public function __construct( ) {

			// Just for demo purposes. Not needed per say.
			$this->theme = wp_get_theme();

			// Set the default arguments
			$this->setArguments();
			
			// Set a few help tabs so you can see how it's done
			$this->setHelpTabs();

			// Create the sections and fields
			$this->setSections();
			
			if ( !isset( $this->args['opt_name'] ) ) { // No errors please
				return;
			}
			
			$this->ReduxFramework = new ReduxFramework($this->sections, $this->args);

			add_filter('redux/options/'.$this->args['opt_name'].'/sections', array( $this, 'dynamic_section' ) );

		}


		/**

			This is a test function that will let you see when the compiler hook occurs. 
			It only runs if a field	set with compiler=>true is changed.

		**/

		function compiler_action($options, $css) {

		}

		/**
		 
		 	Custom function for filtering the sections array. Good for child themes to override or add to the sections.
		 	Simply include this function in the child themes functions.php file.
		 
		 	NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
		 	so you must use get_template_directory_uri() if you want to use any of the built in icons
		 
		 **/

		function dynamic_section($sections){
		    return $sections;
		}
		
		
		/**

			Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

		**/
		
		function change_arguments($args){
		    //$args['dev_mode'] = true;
		    
		    return $args;
		}
			
		
		/**

			Filter hook for filtering the default value of any given field. Very useful in development mode.

		**/

		function change_defaults($defaults){
		    $defaults['str_replace'] = "Testing filter hook!";
		    
		    return $defaults;
		}


		public function setSections() {

			/**
			 	Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
			 **/


			// Background Patterns Reader
			$sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
			$sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
			$sample_patterns      = array();

			ob_start();

			$ct = wp_get_theme();
			$this->theme = $ct;
			$item_name = $this->theme->get('Name'); 
			$tags = $this->theme->Tags;
			$screenshot = $this->theme->get_screenshot();
			$class = $screenshot ? 'has-screenshot' : '';

			$customize_title = sprintf( esc_html__( 'Customize &#8220;%s&#8221;','the-next-mag' ), $this->theme->display('Name') );

			?>
			<div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
				<?php if ( $screenshot ) : ?>
					<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
					<a href="<?php echo esc_url(wp_customize_url()); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr( $customize_title ); ?>">
						<img src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview', 'the-next-mag' ); ?>" />
					</a>
					<?php endif; ?>
					<img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview', 'the-next-mag' ); ?>" />
				<?php endif; ?>

				<h4>
					<?php echo esc_attr($this->theme->display('Name')); ?>
				</h4>

				<div>
					<ul class="theme-info">
						<li><?php printf( esc_html__('By %s','the-next-mag'), $this->theme->display('Author') ); ?></li>
						<li><?php printf( esc_html__('Version %s','the-next-mag'), $this->theme->display('Version') ); ?></li>
						<li><?php echo '<strong>'.__('Tags', 'the-next-mag').':</strong> '; ?><?php printf( $this->theme->display('Tags') ); ?></li>
					</ul>
					<p class="theme-description"><?php echo esc_attr($this->theme->display('Description')); ?></p>
					<?php if ( $this->theme->parent() ) {
						printf( ' <p class="howto">' . esc_html__( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'the-next-mag' ) . '</p>',
							__( 'http://codex.wordpress.org/Child_Themes','the-next-mag' ),
							$this->theme->parent()->display( 'Name' ) );
					} ?>
					
				</div>

			</div>

			<?php
			$item_info = ob_get_contents();
			    
			ob_end_clean();

			$sampleHTML = '';

            /*
             * ---> CSS selectors outputs
             */

            $primary_color_output_bg = '';
            $primary_color_output = '';

            // Primary color background.
            $primary_color_output_bg .= '.primary-color-bg, .btn[class*="st-btn-"]:before, input[type="submit"][type="submit"]:hover, .st-btn-solid-primary, a.btn.st-btn-solid-primary';

            // Primary color.
            $primary_color_output .= 'a, a:visited, a:hover, a:focus, a:active, .primary-color, .bypostauthor .comment-author .fn, .st-btn-primary, .st-btn-primary:hover, .st-btn-primary:focus, .st-btn-primary:active, input[type="submit"][type="submit"], .st-btn-outline-primary, a.btn.st-btn-outline-primary';

            $primary_font = array('.post__title, .entry-title, h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .text-font-primary, .social-tile__title, .widget_recent_comments .recentcomments > a, .widget_recent_entries li > a, .modal-title.modal-title, .author-box .author-name a, .comment-author, .widget_calendar caption, .widget_categories li>a, .widget_meta ul, .widget_recent_comments .recentcomments>a, .widget_recent_entries li>a, .widget_pages li>a');

            $secondary_font = array('.text-font-secondary, .block-heading__subtitle, .widget_nav_menu ul, .navigation .sub-menu, .typography-copy blockquote, .comment-content blockquote');

            $tertiary_font = array('.mobile-header-btn, .navigation-bar-btn, .navigation, .menu, .mnmd-mega-menu__inner > .sub-menu > li > a, .meta-text, a.meta-text, .meta-font, a.meta-font, .text-font-tertiary, .block-heading, .block-heading__title, .block-heading-tabs, .block-heading-tabs > li > a, input[type="button"]:not(.btn), input[type="reset"]:not(.btn), input[type="submit"]:not(.btn), .btn, label, .category-tile__name, .page-nav, .post-score, .post-score-hexagon .post-score-value, .post__cat, a.post__cat, .entry-cat, a.entry-cat, .read-more-link, .post__meta, .entry-meta, .entry-author__name, a.entry-author__name, .comments-count-box, .widget__title-text, .mnmd-widget-indexed-posts-a .posts-list > li .post__thumb:after, .mnmd-widget-indexed-posts-b .posts-list > li .post__title:after, .mnmd-widget-indexed-posts-c .list-index, .social-tile__count, .widget_recent_comments .comment-author-link, .mnmd-video-box__playlist .is-playing .post__thumb:after, .mnmd-posts-listing-a .cat-title, .mnmd-news-ticker__heading, .page-heading__title, .post-sharing__title, .post-sharing--simple .sharing-btn, .entry-action-btn, .entry-tags-title, .post-categories__title, .posts-navigation__label, .comments-title, .comments-title__text, .comments-title .add-comment, .comment-metadata, .comment-metadata a, .comment-reply-link, .comment-reply-title, .countdown__digit, .modal-title, .comment-reply-title, .comment-meta, .comment .reply, .wp-caption, .gallery-caption, .widget-title, .btn, .navigation, .logged-in-as, .countdown__digit, .mnmd-widget-indexed-posts-a .posts-list>li .post__thumb:after, .mnmd-widget-indexed-posts-b .posts-list>li .post__title:after, .mnmd-widget-indexed-posts-c .list-index, .mnmd-horizontal-list .index, .mnmd-pagination, .mnmd-pagination--next-n-prev .mnmd-pagination__label');

            /*
             * ---> END CSS selectors outputs
             */

            
			// ACTUAL DECLARATION OF SECTIONS
            
                $this->sections[] = array(
    				'icon' => 'el-icon-wrench',
    				'title' => esc_html__('General Settings', 'the-next-mag'),
    				'fields' => array(
                        array(
    						'id'=>'bk-primary-color',
    						'type' => 'color',
    						'title' => esc_html__('Primary color', 'the-next-mag'), 
    						'subtitle' => esc_html__('Pick a primary color for the theme.', 'the-next-mag'),
    						'default' => '#EF3A2B',
                            'transparent' => false,
    						'validate' => 'color',
						),
                        array(
    						'id'=>'bk-dark-color',
    						'type' => 'color',
    						'title' => esc_html__('Dark color', 'the-next-mag'), 
    						'subtitle' => esc_html__('Pick a dark color for the theme.', 'the-next-mag'),
    						'default' => '#23282D',
                            'transparent' => false,
    						'validate' => 'color',
						),
                        array(
    						'id'=>'bk-button-hover-color',
    						'type' => 'color',
    						'title' => esc_html__('Button Hover Color', 'the-next-mag'), 
    						'subtitle' => esc_html__('Pick a color for the button when hover.', 'the-next-mag'),
    						'default' => '#ef392b',
                            'transparent' => false,
    						'validate' => 'color',
						),
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-font',
    				'title' => esc_html__('Typography', 'the-next-mag'),
                    'desc'  => esc_html__( 'It is recommended to use maximum 3 different font families for the sake of design consistency and load speed.', 'the-next-mag' ),
    				'fields' => array(
                        array(
                            'id'          => 'body-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Body text', 'the-next-mag' ),
                            'google'      => true,
                            // Disable google fonts. Won't work if you haven't defined your google api key
                            'font-backup' => true,
                            // Select a backup non-google font in addition to a google font
                            'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                            'font-weight'    => false,
                            'subsets'       => true, // Only appears if google is true and subsets not set to false
                            'font-size'     => false,
                            'line-height'   => false,
                            'text-align'    => false,
                            //'word-spacing'  => true,  // Defaults to false
                            'letter-spacing'=> true,  // Defaults to false
                            'color'         => false,
                            'preview'       => true, // Disable the previewer
                            'all_styles'  => true,
                            // Enable all Google Font style/weight variations to be added to the page
                            'output'      => 'body',
                            // An array of CSS selectors to apply this font style to dynamically
                            'units'       => 'px',
                            // Defaults to px
                            'subtitle'    => esc_html__( 'Typography option for body text.', 'the-next-mag' ),
                            'default'     => array(
                                'font-family' => 'Rubik',
                                'font-backup' => 'Arial, Helvetica, sans-serif'
                            ),
                        ),
                        array(
                            'id'          => 'heading-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Heading', 'the-next-mag' ),
                            'google'      => true,
                            // Disable google fonts. Won't work if you haven't defined your google api key
                            'font-backup' => true,
                            // Select a backup non-google font in addition to a google font
                            'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                            'font-weight'    => false,
                            'subsets'       => true, // Only appears if google is true and subsets not set to false
                            'font-size'     => false,
                            'line-height'   => false,
                            'text-align'    => false,
                            //'word-spacing'  => true,  // Defaults to false
                            'letter-spacing'=> true,  // Defaults to false
                            'color'         => false,
                            'preview'       => true, // Disable the previewer
                            'all_styles'  => true,
                            // Enable all Google Font style/weight variations to be added to the page
                            'output'      => $primary_font,
                            // An array of CSS selectors to apply this font style to dynamically
                            'units'       => 'px',
                            // Defaults to px
                            'subtitle'    => esc_html__( 'Typography option for title and heading.', 'the-next-mag' ),
                            'default'     => array(
                                'font-family' => 'Rubik',
                                'font-backup' => 'Arial, Helvetica, sans-serif'
                            ),
                        ),
                        array(
                            'id'          => 'meta-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Secondary', 'the-next-mag' ),
                            'google'      => true,
                            // Disable google fonts. Won't work if you haven't defined your google api key
                            'font-backup' => true,
                            // Select a backup non-google font in addition to a google font
                            'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                            'font-weight'    => false,
                            'subsets'       => true, // Only appears if google is true and subsets not set to false
                            'font-size'     => false,
                            'line-height'   => false,
                            'text-align'    => false,
                            //'word-spacing'  => true,  // Defaults to false
                            'letter-spacing'=> true,  // Defaults to false
                            'color'         => false,
                            //'preview'       => false, // Disable the previewer
                            'all_styles'  => true,
                            // Enable all Google Font style/weight variations to be added to the page
                            'output'      => $secondary_font,
                            // An array of CSS selectors to apply this font style to dynamically
                            'units'       => 'px',
                            // Defaults to px
                            'subtitle'    => esc_html__( 'Typography option for secondary text such as subtitle, sub menu, ...', 'the-next-mag' ),
                            'default'     => array(
                                'font-family' => 'Rubik',
                                'font-backup' => 'Arial, Helvetica, sans-serif'
                            ),
                        ),
                        array(
                            'id'          => 'tertiary-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Tertiary font', 'the-next-mag' ),
                            'google'      => true,
                            // Disable google fonts. Won't work if you haven't defined your google api key
                            'font-backup' => true,
                            // Select a backup non-google font in addition to a google font
                            'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                            'font-weight'    => false,
                            'text-align'    => false,
                            'subsets'       => true, // Only appears if google is true and subsets not set to false
                            'font-size'     => false,
                            'line-height'   => false,
                            'word-spacing'  => false,  // Defaults to false
                            'letter-spacing'=> true,  // Defaults to false
                            'color'         => false,
                            //'preview'       => false, // Disable the previewer
                            'all_styles'  => true,
                            // Enable all Google Font style/weight variations to be added to the page
                            'output'      => $tertiary_font,
                            // An array of CSS selectors to apply this font style to dynamically
                            'units'       => 'px',
                            // Defaults to px
                            'subtitle'    => esc_html__( 'Typography option for tertiary text such as post meta, button, ...', 'the-next-mag' ),
                            'default'     => array(
                                'font-family' => 'Rubik',
                                'font-backup' => 'Arial, Helvetica, sans-serif'
                            ),
                        ),
                        array(
                            'id'=>'section-text-button-start',
                            'title' => esc_html__('Text Button', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
    						'id'      =>'bk-load-more-text',
    						'type'    => 'text',
    						'title'   => esc_html__('Load More Text', 'the-next-mag'),
                            'default' => esc_html__('Load more news', 'the-next-mag'),
						),
                        array(
    						'id'      =>'bk-no-more-text',
    						'type'    => 'text',
    						'title'   => esc_html__('No More Text', 'the-next-mag'),
                            'default' => esc_html__('No more news', 'the-next-mag'),
						),
                        array(
                            'id'=>'section-text-button-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-wrench',
    				'title' => esc_html__('Module Heading Style', 'the-next-mag'),
    				'fields' => array(
                        array(
    						'id'=>'bk-default-module-heading',
    						'type' => 'select',
    						'title' => esc_html__('Default Module Heading', 'the-next-mag'), 
    						'subtitle' => esc_html__('Default setting of all module heading style.', 'the-next-mag'),
    						'options'   => array(
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
                            'default'    => 'line',
						),
                        array(
    						'id'=>'bk-default-widget-heading',
    						'type' => 'select',
    						'title' => esc_html__('Default Widget Heading', 'the-next-mag'), 
    						'subtitle' => esc_html__('Default setting of all widget heading style.', 'the-next-mag'),
                            'options'   => array(
                                            'line'              => esc_html__( 'Heading Line', 'the-next-mag' ),
                                            'no-line'           => esc_html__( 'Heading No Line', 'the-next-mag' ),
                                            'line-under'        => esc_html__( 'Heading Line Under', 'the-next-mag' ),
                                            'center'            => esc_html__( 'Heading Center', 'the-next-mag' ),
                                            'line-around'       => esc_html__( 'Heading Line Around', 'the-next-mag' ),
                    				    ),
                			'default'    => 'line',
						),
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-photo',
    				'title' => esc_html__('Header', 'the-next-mag'),
    				'fields' => array(
    					array(
    						'id'=>'bk-header-type',
    						'title' => esc_html__('Header Type', 'the-next-mag'),
    						'subtitle' => esc_html__('Choose a Header Type', 'the-next-mag'),
                            'type' => 'image_select', 
                            'options'  => array(
                                'site-header-1' => get_template_directory_uri().'/images/admin_panel/header/1.jpg',
                                'site-header-2' => get_template_directory_uri().'/images/admin_panel/header/2.jpg',
                                'site-header-3' => get_template_directory_uri().'/images/admin_panel/header/3.jpg',
                                'site-header-4' => get_template_directory_uri().'/images/admin_panel/header/4.jpg',
            					'site-header-5' => get_template_directory_uri().'/images/admin_panel/header/5.jpg',
                                'site-header-6' => get_template_directory_uri().'/images/admin_panel/header/6.jpg',
                                'site-header-7' => get_template_directory_uri().'/images/admin_panel/header/7.jpg',
                                'site-header-8' => get_template_directory_uri().'/images/admin_panel/header/8.jpg',
                                'site-header-9' => get_template_directory_uri().'/images/admin_panel/header/9.jpg',
                            ),
                            'default' => 'site-header-1',
						),
                        array(
    						'id'=>'bk-header-bg-style',                            
    						'type' => 'select',
    						'title' => esc_html__('Header Background Style', 'the-next-mag'),
    						'default'   => 'default',
                            'options'   => array(
                                'default'    => esc_html__( 'Default Background', 'the-next-mag' ),
				                'image'      => esc_html__( 'Background Image', 'the-next-mag' ),
                                'gradient'   => esc_html__( 'Background Gradient', 'the-next-mag' ),
                                'color'      => esc_html__( 'Background Color', 'the-next-mag' ),
                            ),
						),
                        array(
    						'id'=>'bk-header-bg-image',
                            'required' => array(
                                array ('bk-header-bg-style', 'equals' , array( 'image' )),
                            ),
    						'type' => 'background',
    						'output' => array('.site-header .background-img, .header-4 .navigation-bar, .header-5 .navigation-bar, .header-6 .navigation-bar'),
    						'title' => esc_html__('Header Background Image', 'the-next-mag'), 
    						'subtitle' => esc_html__('Choose background image for the site header', 'the-next-mag'),
                            'background-position' => false,
                            'background-repeat' => false,
                            'background-size' => false,
                            'background-attachment' => false,
                            'preview_media' => false,
                            'transparent' => false,
                            'background-color' => false,
                            'default'  => array(
                                'background-color' => '#fff',
                            ),
						),
                        array(
    						'id'=>'bk-header-bg-gradient',
                            'required' => array(
                                array ('bk-header-bg-style', 'equals' , array( 'gradient' )),
                            ),
    						'type' => 'color_gradient',
    						'title'    => esc_html__('Header Background Gradient', 'the-next-mag'),
                            'validate' => 'color',
                            'transparent' => false,
                            'default'  => array(
                                'from' => '#1e73be',
                                'to'   => '#00897e', 
                            ),
						),
                        array(
    						'id'=>'bk-header-bg-gradient-direction',
                            'required' => array(
                                array ('bk-header-bg-style', 'equals' , array( 'gradient' )),
                            ),
    						'type' => 'text',
    						'title'    => esc_html__('Gradient Direction(Degree Number)', 'the-next-mag'),
                            'validate' => 'numeric',
						),
                        array(
    						'id'=>'bk-header-bg-color',
                            'required' => array(
                                array ('bk-header-bg-style', 'equals' , array( 'color' )),
                            ),
    						'type' => 'background',
    						'title' => esc_html__('Header Background Color', 'the-next-mag'), 
    						'subtitle' => esc_html__('Choose background color for the site header', 'the-next-mag'),
                            'background-position' => false,
                            'background-repeat' => false,
                            'background-size' => false,
                            'background-attachment' => false,
                            'preview_media' => false,
                            'background-image' => false,
                            'transparent' => false,
                            'default'  => array(
                                'background-color' => '#fff',
                            ),
						),
                        array(
                            'id'             =>'bk-header-spacing',
                            'type'           => 'spacing',
                            'output'         => array('.header-main'),
                            'mode'           => 'padding',
                            'left'           => 'false',
                            'right'          => 'false',
                            'units'          => array('px'),
                            'units_extended' => 'false',
                            'title'          => esc_html__('Header Padding', 'the-next-mag'),
                            'default'            => array(
                                'padding-top'     => '40px', 
                                'padding-bottom'  => '40px', 
                                'units'          => 'px', 
                            )
                        ),
                        array(
    						'id'=>'bk-header-inverse',
    						'type' => 'button_set',
    						'title' => esc_html__('Header Text', 'the-next-mag'),
    						'default'   => 0,
                            'options'   => array(
					                0   => esc_html__( 'Black', 'the-next-mag' ),
                                    1   => esc_html__( 'White', 'the-next-mag' ),
                            ),
						),
                        array(
                            'id' => 'section-sticky-menu-start',
                            'title' => esc_html__('Sticky Menu', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),	
                        array(
    						'id'=>'bk-sticky-menu-switch',
    						'type' => 'button_set',
    						'title' => esc_html__('Sticky Menu', 'the-next-mag'),
    						'subtitle' => esc_html__('Enable / Disable Sticky Menu Function', 'the-next-mag'),
    						'default'   => 1,
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'the-next-mag' ),
				                0   => esc_html__( 'Disable', 'the-next-mag' ),
                            ),
						),
                        array(
    						'id'=>'bk-sticky-menu-bg-style',
                            'required' => array(
                                'bk-sticky-menu-switch','equals', 1
                            ),
    						'type' => 'select',
    						'title' => esc_html__('Sticky Menu Background Style', 'the-next-mag'),
    						'default'   => 'default',
                            'options'   => array(
                                'default'    => esc_html__( 'Default Background', 'the-next-mag' ),
                                'gradient'   => esc_html__( 'Background Gradient', 'the-next-mag' ),
                                'color'      => esc_html__( 'Background Color', 'the-next-mag' ),
                            ),
						),
                        array(
    						'id'=>'bk-sticky-menu-bg-gradient',
                            'required' => array(
                                array ('bk-sticky-menu-switch','equals', 1),
                                array ('bk-sticky-menu-bg-style', 'equals' , array( 'gradient' )),
                            ),
    						'type' => 'color_gradient',
    						'title'    => esc_html__('Background Gradient', 'the-next-mag'),
                            'validate' => 'color',
                            'transparent' => false,
                            'default'  => array(
                                'from' => '#1e73be',
                                'to'   => '#00897e', 
                            ),
						),
                        array(
    						'id'=>'bk-sticky-menu-bg-gradient-direction',
                            'required' => array(
                                array ('bk-sticky-menu-switch','equals', 1),
                                array ('bk-sticky-menu-bg-style', 'equals' , array( 'gradient' )),
                            ),
    						'type' => 'text',
    						'title'    => esc_html__('Gradient Direction(Degree Number)', 'the-next-mag'),
                            'validate' => 'numeric',
						),
                        array(
    						'id'=>'bk-sticky-menu-bg-color',
                            'required' => array(
                                array ('bk-sticky-menu-switch','equals', 1),
                                array ('bk-sticky-menu-bg-style', 'equals' , array( 'color' )),
                            ),
    						'type' => 'background',
    						'title' => esc_html__('Background Color', 'the-next-mag'), 
    						'subtitle' => esc_html__('Choose background color for the sticky menu', 'the-next-mag'),
                            'background-position' => false,
                            'background-repeat' => false,
                            'background-size' => false,
                            'background-attachment' => false,
                            'preview_media' => false,
                            'background-image' => false,
                            'transparent' => false,
                            'default'  => array(
                                'background-color' => '#fff',
                            ),
						),
                        array(
    						'id'=>'bk-sticky-menu-inverse',
    						'type' => 'button_set',
    						'title' => esc_html__('Sticky Menu Text', 'the-next-mag'),
    						'default'   => 0,
                            'options'   => array(
					                0   => esc_html__( 'Black', 'the-next-mag' ),
                                    1   => esc_html__( 'White', 'the-next-mag' ),
                            ),
						),
                        array(
                            'id' => 'section-sticky-menu-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id' => 'section-mobile-menu-start',
                            'title' => esc_html__('Mobile Menu', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),	
                        array(
    						'id'=>'bk-mobile-menu-bg-style',
    						'type' => 'select',
    						'title' => esc_html__('Mobile Menu Background Style', 'the-next-mag'),
    						'default'   => 'default',
                            'options'   => array(
                                'default'    => esc_html__( 'Default Background', 'the-next-mag' ),
                                'gradient'   => esc_html__( 'Background Gradient', 'the-next-mag' ),
                                'color'      => esc_html__( 'Background Color', 'the-next-mag' ),
                            ),
						),
                        array(
    						'id'=>'bk-mobile-menu-bg-gradient',
                            'required' => array(
                                array ('bk-mobile-menu-bg-style', 'equals' , array( 'gradient' )),
                            ),
    						'type' => 'color_gradient',
    						'title'    => esc_html__('Background Gradient', 'the-next-mag'),
                            'validate' => 'color',
                            'transparent' => false,
                            'default'  => array(
                                'from' => '#1e73be',
                                'to'   => '#00897e', 
                            ),
						),
                        array(
    						'id'=>'bk-mobile-menu-bg-gradient-direction',
                            'required' => array(
                                array ('bk-mobile-menu-bg-style', 'equals' , array( 'gradient' )),
                            ),
    						'type' => 'text',
    						'title'    => esc_html__('Gradient Direction(Degree Number)', 'the-next-mag'),
                            'validate' => 'numeric',
						),
                        array(
    						'id'=>'bk-mobile-menu-bg-color',
                            'required' => array(
                                array ('bk-mobile-menu-bg-style', 'equals' , array( 'color' )),
                            ),
    						'type' => 'background',
    						'title' => esc_html__('Background Color', 'the-next-mag'), 
    						'subtitle' => esc_html__('Choose background color for the mobile menu', 'the-next-mag'),
                            'background-position' => false,
                            'background-repeat' => false,
                            'background-size' => false,
                            'background-attachment' => false,
                            'preview_media' => false,
                            'background-image' => false,
                            'transparent' => false,
                            'default'  => array(
                                'background-color' => '#fff',
                            ),
						),
                        array(
    						'id'=>'bk-mobile-menu-inverse',
    						'type' => 'button_set',
    						'title' => esc_html__('Mobile Menu Text', 'the-next-mag'),
    						'default'   => 0,
                            'options'   => array(
					                0   => esc_html__( 'Black', 'the-next-mag' ),
                                    1   => esc_html__( 'White', 'the-next-mag' ),
                            ),
						),
                        array(
                            'id' => 'section-mobile-menu-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id' => 'section-site-branding-start',
                            'title' => esc_html__('Site Branding', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
    						'id'=>'bk-logo',
    						'type' => 'media', 
    						'url'=> true,
    						'title' => esc_html__('Site Logo', 'the-next-mag'),
    						'subtitle' => esc_html__('Upload logo of your site that is displayed in header', 'the-next-mag'),
                            'placeholder' => esc_html__('No media selected','the-next-mag')
						),
                        array(
    						'id'=>'bk-site-logo-size-option',
    						'type' => 'select',
                            'required'  => array (
                                'bk-header-type','equals',array( 'site-header-1', 'site-header-2', 'site-header-3', 'site-header-7', 'site-header-8', 'site-header-9' )
                            ),
    						'title' => esc_html__('Site Logo Size Option ', 'the-next-mag'),
    						'subtitle' => esc_html__('Select between Original Logo Image Size or Customize the Logo Size', 'the-next-mag'),
    						'default' => 'original',
                            'options'   => array(
				                'original'      => esc_html__( 'Original Logo Image Size', 'the-next-mag' ),
                                'customize'     => esc_html__( 'Customize the Logo Size', 'the-next-mag' ),
                            ),
						),
                        array(
                            'id' => 'site-logo-width',
                            'type' => 'slider',
                            'required' => array(
                                'bk-site-logo-size-option', 'equals' , array( 'customize' )
                            ),
                            'title' => esc_html__('Site Logo Width (px)', 'the-next-mag'),
                            'default' => 300,
                            'min' => 0,
                            'step' => 10,
                            'max' => 1000,
                            'display_value' => 'text'
                        ),
                        array(
    						'id'=>'bk-mobile-logo',
    						'type' => 'media', 
    						'url'=> true,
    						'title' => esc_html__('Mobile Logo', 'the-next-mag'),
    						'subtitle' => esc_html__('Upload logo of your site that is displayed in mobile header', 'the-next-mag'),
                            'placeholder' => esc_html__('No media selected','the-next-mag')
						),
                        array(
                            'id' => 'section-site-branding-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id' => 'section-offcanvas-desktop-menu-start',
                            'title' => esc_html__('Off-Canvas Menu - Desktop', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),	
                        array(
    						'id'=>'bk-offcanvas-desktop-switch',
    						'type' => 'button_set',
    						'title' => esc_html__('Off-Canvas Switch ', 'the-next-mag'),
    						'subtitle' => esc_html__('Enable/Disable the Offcanvas Menu', 'the-next-mag'),
    						'default' => 1,
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'the-next-mag' ),
				                0   => esc_html__( 'Disable', 'the-next-mag' ),
                            ),
						),	
                        array(
    						'id'=>'bk-offcanvas-desktop-menu',
                            'required' => array('bk-offcanvas-desktop-switch','=',1),
    						'type' => 'select',
                            'data' => 'menu_location',
    						'title' => esc_html__('Select a Menu', 'the-next-mag'),
    						'default' => 'offcanvas-menu',
						),
                        array(
    						'id'=>'bk-offcanvas-desktop-logo',
                            'required' => array('bk-offcanvas-desktop-switch','=',1),
    						'type' => 'media', 
    						'url'=> true,
    						'title' => esc_html__('Off-Canvas Logo', 'the-next-mag'),
    						'subtitle' => esc_html__('Upload logo of your site that is displayed in Off-Canvas Menu', 'the-next-mag'),
                            'placeholder' => esc_html__('No media selected','the-next-mag')
						),
                        array(
    						'id'       =>'bk-offcanvas-desktop-social',
    						'type'     => 'select',
                            'required' => array('bk-offcanvas-desktop-switch','=',1),
                            'multi'    => true,
    						'title' => esc_html__('Off-Canvas Social Media', 'the-next-mag'),
    						'subtitle' => esc_html__('Set up social items for site', 'the-next-mag'),
    						'options'  => array('fb'=>'Facebook', 'twitter'=>'Twitter', 'gplus'=>'GooglePlus', 'linkedin'=>'Linkedin',
                                               'pinterest'=>'Pinterest', 'instagram'=>'Instagram', 'dribbble'=>'Dribbble', 
                                               'youtube'=>'Youtube', 'vimeo'=>'Vimeo', 'vk'=>'VK', 'vine'=>'Vine',
                                               'snapchat'=>'SnapChat', 'rss'=>'RSS'),
    						'default' => array('fb'=>'', 'twitter'=>'', 'gplus'=>'', 'linkedin'=>'', 'pinterest'=>'', 'instagram'=>'', 'dribbble'=>'', 
                                                'youtube'=>'', 'vimeo'=>'', 'vk'=>'', 'vine'=>'', 'snapchat'=>'', 'rss'=>'')
						),
                        array(
    						'id'=>'bk-offcanvas-desktop-subscribe-switch',
                            'required' => array('bk-offcanvas-desktop-switch','=',1),
    						'type' => 'switch',
    						'title' => esc_html__('Off-Canvas Menu Subscribe Switch', 'the-next-mag'),
    						'subtitle'=> esc_html__('On/Off Social Media', 'the-next-mag'),
    						'default' => 0
						),
                        array(
    						'id'=>'bk-offcanvas-desktop-mailchimp-shortcode',
                            'required' => array( 
                                array('bk-offcanvas-desktop-subscribe-switch','equals',1), 
                                array('bk-offcanvas-desktop-switch','=',1),
                            ),
    						'type' => 'text', 
    						'title' => esc_html__('Mailchimp Shortcode', 'the-next-mag'),
    						'subtitle' => esc_html__('Insert the Mailchimp Shortcode here', 'the-next-mag'),
                            'default' => '',
						),
                        array(
                            'id' => 'section-offcanvas-desktop-menu-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id' => 'section-offcanvas-mobile-menu-start',
                            'title' => esc_html__('Off-canvas Menu - Mobile', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),	
                        array(
    						'id'=>'bk-offcanvas-mobile-menu',
    						'type' => 'select',
                            'data' => 'menu_location',
    						'title' => esc_html__('Select a Menu', 'the-next-mag'),
    						'default' => 'main-menu',
						),	
                        array(
    						'id'=>'bk-offcanvas-mobile-logo',
    						'type' => 'media', 
    						'url'=> true,
    						'title' => esc_html__('Off-Canvas Logo', 'the-next-mag'),
    						'subtitle' => esc_html__('Upload logo of your site that is displayed in Off-Canvas Menu', 'the-next-mag'),
                            'placeholder' => esc_html__('No media selected','the-next-mag')
						),
                        array(
    						'id'       =>'bk-offcanvas-mobile-social',
    						'type'     => 'select',
                            'multi'    => true,
    						'title' => esc_html__('Off-Canvas Social Media', 'the-next-mag'),
    						'subtitle' => esc_html__('Set up social links for site', 'the-next-mag'),
    						'options'  => array('fb'=>'Facebook', 'twitter'=>'Twitter', 'gplus'=>'GooglePlus', 'linkedin'=>'Linkedin',
                                               'pinterest'=>'Pinterest', 'instagram'=>'Instagram', 'dribbble'=>'Dribbble', 
                                               'youtube'=>'Youtube', 'vimeo'=>'Vimeo', 'vk'=>'VK', 'vine'=>'Vine',
                                               'snapchat'=>'SnapChat', 'rss'=>'RSS'),
    						'default' => array('fb'=>'', 'twitter'=>'', 'gplus'=>'', 'linkedin'=>'', 'pinterest'=>'', 'instagram'=>'', 'dribbble'=>'', 
                                                'youtube'=>'', 'vimeo'=>'', 'vk'=>'', 'vine'=>'', 'snapchat'=>'', 'rss'=>'')
						),
                        array(
    						'id'=>'bk-offcanvas-mobile-subscribe-switch',
    						'type' => 'switch',
    						'title' => esc_html__('Off-Canvas Menu Subscribe Switch', 'the-next-mag'),
    						'subtitle'=> esc_html__('On/Off Social Media', 'the-next-mag'),
    						'default' => 0
						),
                        array(
    						'id'=>'bk-offcanvas-mobile-mailchimp-shortcode',
                            'required' => array( 
                                array('bk-offcanvas-mobile-subscribe-switch','equals',1), 
                            ),
    						'type' => 'text', 
    						'title' => esc_html__('Mailchimp Shortcode', 'the-next-mag'),
    						'subtitle' => esc_html__('Insert the Mailchimp Shortcode here', 'the-next-mag'),
                            'default' => '',
						),
                        array(
                            'id' => 'section-offcanvas-mobile-menu-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id' => 'section-social-header-start',
                            'title' => esc_html__('Header Social Items', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),	
                        array(
    						'id'       =>'bk-social-header',
    						'type'     => 'select',
                            'multi'    => true,
    						'title' => esc_html__('Social Media', 'the-next-mag'),
    						'subtitle' => esc_html__('Select social items for the website', 'the-next-mag'),
    						'options'  => array('fb'=>'Facebook', 'twitter'=>'Twitter', 'gplus'=>'GooglePlus', 'linkedin'=>'Linkedin',
                                               'pinterest'=>'Pinterest', 'instagram'=>'Instagram', 'dribbble'=>'Dribbble', 
                                               'youtube'=>'Youtube', 'vimeo'=>'Vimeo', 'vk'=>'VK', 'vine'=>'Vine',
                                               'snapchat'=>'SnapChat', 'rss'=>'RSS'),
    						'default' => array('fb'=>'', 'twitter'=>'', 'gplus'=>'', 'linkedin'=>'', 'pinterest'=>'', 'instagram'=>'', 'dribbble'=>'', 
                                                'youtube'=>'', 'vimeo'=>'', 'vk'=>'', 'vine'=>'', 'snapchat'=>'', 'rss'=>'')
						),
                        array(
                            'id' => 'section-social-header-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id' => 'section-header-subscribe-start',
                            'title' => esc_html__('Header Subscribe Form', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
    						'id'=>'bk-header-subscribe-switch',
    						'type' => 'switch',
    						'title' => esc_html__('Header Subscribe Switch', 'the-next-mag'),
    						'subtitle'=> esc_html__('On/Off Header Subscribe', 'the-next-mag'),
    						'default' => 0
						),
                        array(
    						'id'=>'bk-mailchimp-title',
                            'required' => array('bk-header-subscribe-switch','=',1),
    						'type' => 'text', 
    						'title' => esc_html__('Mailchimp Form Title', 'the-next-mag'),
                            'default' => '',
						),
                        array(
    						'id'=>'bk-mailchimp-shortcode',
                            'required' => array('bk-header-subscribe-switch','=',1),
    						'type' => 'text', 
    						'title' => esc_html__('Mailchimp Shortcode', 'the-next-mag'),
    						'subtitle' => esc_html__('Insert the Mailchimp Shortcode here', 'the-next-mag'),
                            'default' => '',
						),
                        array(
                            'id' => 'section-header-subscribe-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-share',
    				'title' => esc_html__('Social Media Links', 'the-next-mag'),
    				'fields' => array(
                        array(
    						'id'=>'bk-social-media-links',
    						'type' => 'text',
    						'title' => esc_html__('Social media', 'the-next-mag'),
    						'subtitle' => esc_html__('Set up social links for the website', 'the-next-mag'),
    						'options' => array('fb'=>'Facebook Url', 'twitter'=>'Twitter Url', 'gplus'=>'GPlus Url', 'linkedin'=>'Linkedin Url',
                                               'pinterest'=>'Pinterest Url', 'instagram'=>'Instagram Url', 'dribbble'=>'Dribbble Url', 
                                               'youtube'=>'Youtube Url', 'vimeo'=>'Vimeo Url', 'vk'=>'VK Url', 'vine'=>'Vine URL',
                                               'snapchat'=>'SnapChat Url', 'rss'=>'RSS Url'),
    						'default' => array('fb'=>'', 'twitter'=>'', 'gplus'=>'', 'linkedin'=>'', 'pinterest'=>'', 'instagram'=>'', 'dribbble'=>'', 
                                                'youtube'=>'', 'vimeo'=>'', 'vk'=>'', 'vine'=>'', 'snapchat'=>'', 'rss'=>'')
						),
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-indent-left',
    				'title' => esc_html__('Single Page', 'the-next-mag'),
    				'fields' => array(
                        array(
                			'id'        => 'bk-post-view--cache-time',
                            'title'     => esc_html__('Post View Cache Time (in second)', 'the-next-mag'),
                            'desc'      => esc_html__('Default: 300 means 5 minutes', 'the-next-mag'),
                            'type'      => 'slider',
                            'default'   => 300,
                            'min'       => 0,
                            'step'      => 5,
                            'max'       => 3600,
                            'display_value' => 'text'
                		),
                        array(
    						'id'=>'bk-single-template',
    						'type' => 'image_select', 
                            'class' => 'bk-single-post-layout--global-option',
    						'title' => esc_html__('Post Layout', 'the-next-mag'),
                            'options' => array(
                                'single-1' => array(
                                    'alt' => 'Single Template 1',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-1.png',
                                ),
                                'single-2' => array(
                                    'alt' => 'Single Template 2',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-2.png',
                                ),
                                'single-3' => array(
                                    'alt' => 'Single Template 3',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-3.png',
                                ),
                                'single-4' => array(
                                    'alt' => 'Single Template 4',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-4.png',
                                ),
                                'single-5' => array(
                                    'alt' => 'Single Template 5',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-5.png',
                                ),
                                'single-6' => array(
                                    'alt' => 'Single Template 6',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-6.png',
                                ),
                                'single-7' => array(
                                    'alt' => 'Single Template 7',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-7.png',
                                ),
                                'single-8' => array(
                                    'alt' => 'Single Template 8',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-8.png',
                                ),
                                'single-9' => array(
                                    'alt' => 'Single Template 9',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-9.png',
                                ),
                                'single-10' => array(
                                    'alt' => 'Single Template 10',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-10.png',
                                ),
                                'single-11' => array(
                                    'alt' => 'Single Template 11',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-11.png',
                                ),
                                'single-12' => array(
                                    'alt' => 'Single Template 12',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-12.png',
                                ),
                                'single-13' => array(
                                    'alt' => 'Single Template 13',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-13.png',
                                ),
                                'single-14' => array(
                                    'alt' => 'Single Template 14',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-14.png',
                                ),
                                'single-15' => array(
                                    'alt' => 'Single Template 15',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-15.png',
                                ),
                                'single-16' => array(
                                    'alt' => 'Single Template 16',
                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/single-16.png',
                                ),
                            ),
                            'default' => 'single-1',
						),
                        array(
                            'title' => 'Single Header Background',
                            'id'   => 'bk-single-header--bg-color',
                            'type' => 'color',
                            'default'  => '#12162d',
                        ), 
                        array(
                            'title'      => esc_html__( 'Background Pattern', 'the-next-mag' ),
                            'id'        => 'bk-single-header--bg-pattern',
                            'type'      => 'button_set', 
                			'options'   => array(              
                                1   => esc_html__( 'Enable', 'the-next-mag' ),
                                0   => esc_html__( 'Disable', 'the-next-mag' ),
        				    ),
                			'default'         => 1,
                        ),     
                        array(
                            'title'      => esc_html__( 'Header Text', 'the-next-mag' ),
                            'id'        => 'bk-single-header--inverse',
                            'type'      => 'button_set', 
                			'options'   => array(             
                                1 => esc_html__( 'White', 'the-next-mag' ),
                                0 => esc_html__( 'Black', 'the-next-mag' ),
        				    ),
                			'default'    => 1,
                        ), 
                        array(
                            'title' => esc_html__( 'Featured Image Config', 'the-next-mag' ),
                            'id' => 'bk-feat-img-status',
                            'type'     => 'button_set',
                			'options'  => array(              
                                1 => esc_html__( 'On', 'the-next-mag' ),
                                0 => esc_html__( 'Off', 'the-next-mag' ),
        				    ),
                			'default'   => 1,
                        ),
                        array(
                            'title' => esc_html__( 'Single Page Meta Items', 'the-next-mag' ),
                            'id' => 'bk-single-meta-items',
                            'type'     => 'select',
                			'options'  => array(              
                                8 => esc_html__( 'Author + Date', 'the-next-mag' ),
                                9 => esc_html__( 'Author + Date + Comments', 'the-next-mag' ),
                                10 => esc_html__( 'Author + Date + Views', 'the-next-mag' ),
                                11 => esc_html__( 'Author + Date + Comments + Views', 'the-next-mag' ),
                                12 => esc_html__( 'Author + Comments + Views', 'the-next-mag' ),
        				    ),
                			'default'   => 10,
                        ),
                        array(
                            'id'=>'section-single-sorter-start',
                            'title' => esc_html__('Sections Sorter', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'      => 'single-sections-sorter',
                            'type'    => 'sorter',
                            'title'   => 'Manage Layouts',
                            'desc'    => 'Organize the layout of Singe Page',
                            'options' => array(
                                'enabled'  => array(
                                    'related'  => esc_html__('Related Section', 'the-next-mag'),
                                    'comment'  => esc_html__('Comment Section', 'the-next-mag'),
                                    'same-cat' => esc_html__('Same Category Section', 'the-next-mag'),
                                ),
                            ),
                        ),
                        array(
                            'id'=>'section-single-sorter-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'=>'section-single-sidebar-start',
                            'title' => esc_html__('Sidebar', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'        => 'bk_post_sb_select',  
                            'type'      => 'select',
                            'data'      => 'sidebars', 
                            'multi'     => false,
                            'title'     => esc_html__('Single Page Sidebar', 'the-next-mag'),
                            'subtitle'  => esc_html__('Choose sidebar for single page', 'the-next-mag'),
                            'default'   => 'home_sidebar',
                        ),
                        array(
                            'id'        => 'bk_post_sb_position',  
                            'type'      => 'image_select',
                            'multi'     => false,
                            'title'     => esc_html__('Sidebar Postion', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                                'right' => array(
                                                    'alt' => 'Sidebar Right',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/sb-right.png',
                                                ),
                                                'left' => array(
                                                    'alt' => 'Sidebar Left',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/single_page/sb-left.png',
                                                ),
                                        ),
                            'default' => 'right',
                        ),
                        array(
                            'id'        => 'bk_post_sb_sticky',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Stick Sidebar', 'the-next-mag'),
                            'subtitle'  => esc_html__('Enable Stick Sidebar / Disable Stick Sidebar', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'the-next-mag' ),
				                0   => esc_html__( 'Disable', 'the-next-mag' ),
                            ),
                            'default' => 1,
                        ),
                        array(
                            'id'=>'section-single-sidebar-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'=>'section-sharebox-start',
                            'title' => esc_html__('Social Share', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
    						'id'=>'bk-sharebox-sw',
    						'type' => 'switch', 
    						'title' => esc_html__('Enable share box', 'the-next-mag'),
    						'subtitle' => esc_html__('Enable share links below single post', 'the-next-mag'),
    						'default' => 1,
    						'on' => esc_html__('Enabled', 'the-next-mag'),
    						'off' => esc_html__('Disabled', 'the-next-mag'),
                            'indent' => true
						),
                        array(
                            'id'=>'bk-fb-sw',
                            'required' => array('bk-sharebox-sw','=','1'),
                            'type' => 'switch',
                            'title' => esc_html__('Enable Facebook share link', 'the-next-mag'),
                            'default' => 1,
    						'on' => esc_html__('Enabled', 'the-next-mag'),
    						'off' => esc_html__('Disabled', 'the-next-mag'),
                        ),
                        array(
                            'id'=>'bk-fb-text',
                            'required' => array('bk-sharebox-sw','=','1'),
                            'type' => 'text',
                            'required' => array('bk-fb-sw','=','1'),
                            'title' => esc_html__('Facebook Share Text', 'the-next-mag'),
                            'default' => 'Share',
                        ),
                        array(
                            'id'=>'bk-tw-sw',
                            'required' => array('bk-sharebox-sw','=','1'),
                            'type' => 'switch',
                            'title' => esc_html__('Enable Twitter share link', 'the-next-mag'),
                            'default' => 1,
    						'on' => esc_html__('Enabled', 'the-next-mag'),
    						'off' => esc_html__('Disabled', 'the-next-mag'),
                        ),
                        array(
                            'id'=>'bk-tw-text',
                            'required' => array('bk-sharebox-sw','=','1'),
                            'type' => 'text',
                            'required' => array('bk-tw-sw','=','1'),
                            'title' => esc_html__('Twitter Share Text', 'the-next-mag'),
                            'default' => 'Tweet',
                        ),
                        array(
                            'id'=>'bk-gp-sw',
                            'required' => array('bk-sharebox-sw','=','1'),
                            'type' => 'switch',
                            'title' => esc_html__('Enable Google+ share link', 'the-next-mag'),
                            'default' => 1,
    						'on' => esc_html__('Enabled', 'the-next-mag'),
    						'off' => esc_html__('Disabled', 'the-next-mag'),
                        ),
                        array(
                            'id'=>'bk-gp-text',
                            'required' => array('bk-sharebox-sw','=','1'),
                            'type' => 'text',
                            'required' => array('bk-gp-sw','=','1'),
                            'title' => esc_html__('Google Plus Share Text', 'the-next-mag'),
                            'default' => '',
                        ),
                        array(
                            'id'=>'bk-pi-sw',
                            'required' => array('bk-sharebox-sw','=','1'),
                            'type' => 'switch',
                            'title' => esc_html__('Enable Pinterest share link', 'the-next-mag'),
                            'default' => 1,
    						'on' => esc_html__('Enabled', 'the-next-mag'),
    						'off' => esc_html__('Disabled', 'the-next-mag'),
                        ),
                        array(
                            'id'=>'bk-pi-text',
                            'required' => array('bk-sharebox-sw','=','1'),
                            'type' => 'text',
                            'required' => array('bk-pi-sw','=','1'),
                            'title' => esc_html__('Pinterest Share Text', 'the-next-mag'),
                            'default' => '',
                        ),
                        array(
                            'id'=>'bk-li-sw',
                            'required' => array('bk-sharebox-sw','=','1'),
                            'type' => 'switch',
                            'title' => esc_html__('Enable Linkedin share link', 'the-next-mag'),
                            'default' => 1,
    						'on' => esc_html__('Enabled', 'the-next-mag'),
    						'off' => esc_html__('Disabled', 'the-next-mag'),
                        ),
                        array(
                            'id'=>'bk-li-text',
                            'required' => array('bk-sharebox-sw','=','1'),
                            'type' => 'text',
                            'required' => array('bk-li-sw','=','1'),
                            'title' => esc_html__('Linkedin Share Text', 'the-next-mag'),
                            'default' => '',
                        ),
                        array(
                            'id'=>'section-sharebox-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
                        array(
                            'id'=>'section-author-start',
                            'title' => esc_html__('Post Author Section Setting', 'the-next-mag'),                        
                            'type' => 'section', 
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ), 
                        array(
    						'id'=>'bk-authorbox-sw',
    						'type' => 'switch', 
    						'title' => esc_html__('Enable author box', 'the-next-mag'),
    						'subtitle' => esc_html__('Enable author information below single post', 'the-next-mag'),
    						'default' => 1,
    						'on' => esc_html__('Enabled', 'the-next-mag'),
    						'off' => esc_html__('Disabled', 'the-next-mag'),
						),
                        array(
                            'id'=>'section-author-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
                        array(
                            'id'=>'section-postnav-start',
                            'title' => esc_html__('Post Nav Section Setting', 'the-next-mag'),                        
                            'type' => 'section', 
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ), 
                        array(
    						'id'=>'bk-postnav-sw',
    						'type' => 'switch', 
    						'title' => esc_html__('Enable post navigation', 'the-next-mag'),
    						'subtitle' => esc_html__('Enable post navigation below single post', 'the-next-mag'),
    						'default' => 1,
    						'on' => esc_html__('Enabled', 'the-next-mag'),
    						'off' => esc_html__('Disabled', 'the-next-mag'),
						),
                        array(
                            'id'=>'section-postnav-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-indent-left',
    				'title' => esc_html__('Advance Single Page - With Sidebar', 'the-next-mag'),
    				'fields' => array(
                        array(
                            'id' => 'section-related-start',
                            'title' => esc_html__('Related Posts Section Setting - Has Sidebar Layout', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),  
                         array(
    						'id'=>'bk-related-sw',
    						'type' => 'switch',
    						'title' => esc_html__('Enable related posts', 'the-next-mag'),
    						'subtitle' => esc_html__('Enable related posts below single post', 'the-next-mag'),
    						'default' => 1,
    						'on' => esc_html__('Enabled', 'the-next-mag'),
    						'off' => esc_html__('Disabled', 'the-next-mag'),
						),
                        array(
                			'id'        => 'bk_related_post_layout',
                            'required' => array('bk-related-sw','=','1'),
                            'title'     => esc_html__('Layout', 'the-next-mag'),
                            'type'      => 'image_select', 
                			'options'  => array(
                                'listing_list'       => get_template_directory_uri().'/images/admin_panel/related-module/listing_list.png',
                                'listing_list_alt_a' => get_template_directory_uri().'/images/admin_panel/related-module/listing_list_alt_a.png',
            					'listing_grid'       => get_template_directory_uri().'/images/admin_panel/related-module/listing_grid.png',
                                'listing_grid_small' => get_template_directory_uri().'/images/admin_panel/related-module/listing_grid_small.png',
                                'posts_block_main_col_l' => get_template_directory_uri().'/images/admin_panel/related-module/main_col_l.png',
        				    ),
                			'default'   => 'listing_list',
                		),
                        array(
                			'id'        => 'bk_related_heading_style',
                            'required' => array('bk-related-sw','=','1'),
                            'title'     => esc_html__('Heading Style', 'the-next-mag'),
                            'type'      => 'select', 
                			'options'   => array(
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
                			'default'    => 'no-line',
                		),
                        array(
                			'id'        => 'bk_related_source',
                            'required' => array('bk-related-sw','=','1'),
                            'title'     => esc_html__('Related Posts', 'the-next-mag'),
                            'type'      => 'select', 
                			'options'   => array(
                                            'category_tag' => esc_html__( 'Same Categories and Tags', 'the-next-mag' ),
                        					'tag'          => esc_html__( 'Same Tags', 'the-next-mag' ),
                                            'category'     => esc_html__( 'Same Categories', 'the-next-mag' ),
                                            'author'       => esc_html__( 'Same Author', 'the-next-mag' ),
                    				    ),
                			'default'    => 'category_tag',
                		),
                        array(
                			'id'        => 'bk_number_related',
                            'required' => array('bk-related-sw','=','1'),
                            'title'     => esc_html__('Number of Related Posts', 'the-next-mag'),
                            'type'      => 'text', 
                            'validate'  => 'numeric',
                			'default'   => '3',
                		),
                        array(
                			'id'        => 'bk_related_post_category',
                            'required' => array('bk-related-sw','=','1'),
                            'title'     => esc_html__('Category Meta', 'the-next-mag'),
                            'type'      => 'button_set', 
                			'options'   => array(
                                1   => esc_html__( 'Enable', 'the-next-mag' ),
                                0   => esc_html__( 'Disable', 'the-next-mag' ),
        				    ),
                			'default'   => 1,
                		),
                        array(
                			'id'        => 'bk_related_post_excerpt',
                            'required' => array('bk-related-sw','=','1'),
                            'title'     => esc_html__('Excerpt', 'the-next-mag'),
                            'type'      => 'button_set', 
                			'options'   => array(
                                1   => esc_html__( 'Enable', 'the-next-mag' ),
					            0   => esc_html__( 'Disable', 'the-next-mag' ),
        				    ),
                			'default'   => 0,
                		),
                        array(
                			'id'        => 'bk_related_post_meta',
                            'required' => array('bk-related-sw','=','1'),
                            'title'     => esc_html__('Meta List', 'the-next-mag'),
                            'type'      => 'select', 
                			'options'   => array(
                                            1   => esc_html__( 'Meta Items: Author', 'the-next-mag' ),
                                            2   => esc_html__( 'Meta Items: Author + Date', 'the-next-mag' ),
                                            3   => esc_html__( 'Meta Items: Author + Date + Comments', 'the-next-mag' ),
                                            4   => esc_html__( 'Meta Items: Author + Date + Views', 'the-next-mag' ),
                                            5   => esc_html__( 'Meta Items: Author + Comments + Views', 'the-next-mag' ),
                                            6   => esc_html__( 'Meta Items: Author + Views', 'the-next-mag' ),
                                            7   => esc_html__( 'Meta Items: Author + Comments', 'the-next-mag' ),
                                            8   => esc_html__( 'Meta Items: Date', 'the-next-mag' ),
                                            9   => esc_html__( 'Meta Items: Date + Comments', 'the-next-mag' ),
                                            10  => esc_html__( 'Meta Items: Date + Views', 'the-next-mag' ),
                                            11  => esc_html__( 'Meta Items: Date + Comments + Views', 'the-next-mag' ),
                                            12  => esc_html__( 'Meta Items: Comments + Views', 'the-next-mag' ),
                                            0   => esc_html__( 'Disable Post Meta', 'the-next-mag' ),
                    				    ),
                			'default'   => 3,
                		),
                        array(
                			'id'        => 'bk_related_post_icon',
                            'required' => array('bk-related-sw','=','1'),
                            'title'     => esc_html__('Post Icon', 'the-next-mag'),
                            'type'      => 'button_set', 
                			'options'   => array(
                                'enable'    => esc_html__( 'Enable', 'the-next-mag' ),
                                'disable'   => esc_html__( 'Disable', 'the-next-mag' ),
        				    ),
                			'default'   => 'disable',
                		),
                        array(
                            'id' => 'section-related-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id' => 'section-same-cat-start',
                            'title' => esc_html__('More From Category Section Setting - Has Sidebar Layout', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
    						'id'=>'bk-same-cat-sw',
    						'type' => 'switch',
    						'title' => esc_html__('Enable More From Category Section', 'the-next-mag'),
    						'default' => 1,
    						'on' => esc_html__('Enabled', 'the-next-mag'),
    						'off' => esc_html__('Disabled', 'the-next-mag'),
						),
                        array(
                			'id'        => 'bk_same_cat_post_layout',
                            'required' => array('bk-same-cat-sw','=','1'),
                            'title'     => esc_html__('Layout', 'the-next-mag'),
                            'type'      => 'image_select', 
                			'options'  => array(
                                'listing_list'       => get_template_directory_uri().'/images/admin_panel/related-module/listing_list.png',
                                'listing_list_alt_a' => get_template_directory_uri().'/images/admin_panel/related-module/listing_list_alt_a.png',
            					'listing_grid'       => get_template_directory_uri().'/images/admin_panel/related-module/listing_grid.png',
                                'listing_grid_small' => get_template_directory_uri().'/images/admin_panel/related-module/listing_grid_small.png',
                                'posts_block_main_col_l' => get_template_directory_uri().'/images/admin_panel/related-module/main_col_l.png',
        				    ),
                			'default'   => 'listing_list',
                		),
                        array(
                			'id'        => 'bk_same_cat_heading_style',
                            'required' => array('bk-same-cat-sw','=','1'),
                            'title'     => esc_html__('Heading Style', 'the-next-mag'),
                            'type'      => 'select', 
                			'options'   => array(
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
                			'default'    => 'no-line',
                		),
                        array(
                			'id'        => 'bk_same_cat_number_posts',
                            'required' => array('bk-same-cat-sw','=','1'),
                            'title'     => esc_html__('Number of Posts', 'the-next-mag'),
                            'type'      => 'text', 
                            'validate'  => 'numeric',
                			'default'   => '3',
                		),
                        array(
                			'id'        => 'bk_same_cat_post_category',
                            'required' => array('bk-same-cat-sw','=','1'),
                            'title'     => esc_html__('Category Meta', 'the-next-mag'),
                            'type'      => 'button_set', 
                			'options'   => array(
                                1   => esc_html__( 'Enable', 'the-next-mag' ),
                                0   => esc_html__( 'Disable', 'the-next-mag' ),
        				    ),
                			'default'   => 1,
                		),
                        array(
                			'id'        => 'bk_same_cat_post_excerpt',
                            'required' => array('bk-same-cat-sw','=','1'),
                            'title'     => esc_html__('Excerpt', 'the-next-mag'),
                            'type'      => 'button_set', 
                			'options'   => array(
                                1   => esc_html__( 'Enable', 'the-next-mag' ),
					            0   => esc_html__( 'Disable', 'the-next-mag' ),
        				    ),
                			'default'   => 0,
                		),
                        array(
                			'id'        => 'bk_same_cat_post_meta',
                            'required' => array('bk-same-cat-sw','=','1'),
                            'title'     => esc_html__('Meta List', 'the-next-mag'),
                            'type'      => 'select', 
                			'options'   => array(
                                            1   => esc_html__( 'Meta Items: Author', 'the-next-mag' ),
                                            2   => esc_html__( 'Meta Items: Author + Date', 'the-next-mag' ),
                                            3   => esc_html__( 'Meta Items: Author + Date + Comments', 'the-next-mag' ),
                                            4   => esc_html__( 'Meta Items: Author + Date + Views', 'the-next-mag' ),
                                            5   => esc_html__( 'Meta Items: Author + Comments + Views', 'the-next-mag' ),
                                            6   => esc_html__( 'Meta Items: Author + Views', 'the-next-mag' ),
                                            7   => esc_html__( 'Meta Items: Author + Comments', 'the-next-mag' ),
                                            8   => esc_html__( 'Meta Items: Date', 'the-next-mag' ),
                                            9   => esc_html__( 'Meta Items: Date + Comments', 'the-next-mag' ),
                                            10  => esc_html__( 'Meta Items: Date + Views', 'the-next-mag' ),
                                            11  => esc_html__( 'Meta Items: Date + Comments + Views', 'the-next-mag' ),
                                            12  => esc_html__( 'Meta Items: Comments + Views', 'the-next-mag' ),
                                            0   => esc_html__( 'Disable Post Meta', 'the-next-mag' ),
                    				    ),
                			'default'   => 3,
                		),
                        array(
                			'id'        => 'bk_same_cat_post_icon',
                            'required' => array('bk-same-cat-sw','=','1'),
                            'title'     => esc_html__('Post Icon', 'the-next-mag'),
                            'type'      => 'button_set', 
                			'options'   => array(
                                'enable'    => esc_html__( 'Enable', 'the-next-mag' ),
                                'disable'   => esc_html__( 'Disable', 'the-next-mag' ),
        				    ),
                			'default'   => 'disable',
                		),
                        array(
                			'id'        => 'bk_same_cat_more_link',
                            'required' => array('bk-same-cat-sw','=','1'),
                            'title'     => esc_html__('More Link', 'the-next-mag'),
                            'type'      => 'button_set', 
                			'options'   => array(
                                1    => esc_html__( 'Enable', 'the-next-mag' ),
                                0    => esc_html__( 'Disable', 'the-next-mag' ),
        				    ),
                			'default'   => 0,
                		),
                        array(
                            'id' => 'section-same-cat-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                    )
                );
                $this->sections[] = array(
    				'icon' => 'el-icon-indent-left',
    				'title' => esc_html__('Advance Single Page - Full Width', 'the-next-mag'),
    				'fields' => array(
                        array(
                            'id' => 'section-related-wide-start',
                            'title' => esc_html__('Related Posts Section Setting - Full Width Post Layout', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),  
                        array(
    						'id'=>'bk-related-sw-wide',
    						'type' => 'switch',
    						'title' => esc_html__('Enable related posts - Wide', 'the-next-mag'),
    						'subtitle' => esc_html__('Enable related posts below single post', 'the-next-mag'),
    						'default' => 1,
    						'on' => esc_html__('Enabled', 'the-next-mag'),
    						'off' => esc_html__('Disabled', 'the-next-mag'),
						),
                        array(
                			'id'        => 'bk_related_post_layout_wide',
                            'required' => array('bk-related-sw-wide','=','1'),
                            'title'     => esc_html__('Layout - Wide', 'the-next-mag'),
                            'type'      => 'image_select', 
                			'options'  => array(
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
                			'default'   => 'listing_grid_no_sidebar',
                		),
                        array(
                			'id'        => 'bk_related_heading_style_wide',
                            'required' => array('bk-related-sw-wide','=','1'),
                            'title'     => esc_html__('Heading Style - Wide', 'the-next-mag'),
                            'type'      => 'select', 
                			'options'   => array(
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
                			'default'    => 'no-line',
                		),
                        array(
                			'id'        => 'bk_related_source_wide',
                            'required' => array('bk-related-sw-wide','=','1'),
                            'title'     => esc_html__('Related Posts - Wide', 'the-next-mag'),
                            'type'      => 'select', 
                			'options'   => array(
                                            'category_tag' => esc_html__( 'Same Categories and Tags', 'the-next-mag' ),
                        					'tag'          => esc_html__( 'Same Tags', 'the-next-mag' ),
                                            'category'     => esc_html__( 'Same Categories', 'the-next-mag' ),
                                            'author'       => esc_html__( 'Same Author', 'the-next-mag' ),
                    				    ),
                			'default'    => 'category_tag',
                		),
                        array(
                			'id'        => 'bk_related_post_icon_wide',
                            'required' => array('bk-related-sw-wide','=','1'),
                            'title'     => esc_html__('Post Icon', 'the-next-mag'),
                            'type'      => 'button_set', 
                            'options'   => array(
                                'enable'    => esc_html__( 'Enable', 'the-next-mag' ),
                                'disable'   => esc_html__( 'Disable', 'the-next-mag' ),
        				    ),
                			'default'   => 'disable',
                		),
                        array(
                            'id' => 'section-related-wide-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id' => 'section-same-cat-wide-start',
                            'title' => esc_html__('More From Category Section Setting - Full Width Post Layout', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
    						'id'=>'bk-same-cat-sw-wide',
    						'type' => 'switch',
    						'title' => esc_html__('Enable More From Category Section - Wide', 'the-next-mag'),
    						'default' => 1,
    						'on' => esc_html__('Enabled', 'the-next-mag'),
    						'off' => esc_html__('Disabled', 'the-next-mag'),
						),
                        array(
                			'id'        => 'bk_same_cat_post_layout_wide',
                            'required' => array('bk-same-cat-sw-wide','=','1'),
                            'title'     => esc_html__('Layout - Wide', 'the-next-mag'),
                            'type'      => 'image_select', 
                			'options'  => array(
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
                			'default'   => 'posts_block_c',
                		),
                        array(
                			'id'        => 'bk_same_cat_heading_style_wide',
                            'required' => array('bk-same-cat-sw-wide','=','1'),
                            'title'     => esc_html__('Heading Style - Wide', 'the-next-mag'),
                            'type'      => 'select', 
                			'options'   => array(
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
                			'default'    => 'no-line',
                		),
                        array(
                			'id'        => 'bk_same_cat_post_icon_wide',
                            'required' => array('bk-same-cat-sw-wide','=','1'),
                            'title'     => esc_html__('Post Icon', 'the-next-mag'),
                            'type'      => 'button_set', 
                			'options'   => array(
                                'enable'    => esc_html__( 'Enable', 'the-next-mag' ),
                                'disable'   => esc_html__( 'Disable', 'the-next-mag' ),
        				    ),
                			'default'   => 'disable',
                		),
                        array(
                			'id'        => 'bk_same_cat_more_link_wide',
                            'required' => array('bk-same-cat-sw-wide','=','1'),
                            'title'     => esc_html__('More Link', 'the-next-mag'),
                            'type'      => 'button_set', 
                			'options'   => array(
                                1   => esc_html__( 'Enable', 'the-next-mag' ),
                                0   => esc_html__( 'Disable', 'the-next-mag' ),
        				    ),
                			'default'   => 1,
                		),
                        array(
                            'id' => 'section-same-cat-wide-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                    )
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-inbox-box',
    				'title' => esc_html__('Category', 'the-next-mag'),
                    'heading'   => esc_html__('Category Pages', 'the-next-mag'),
                    'desc'   => esc_html__('Only use for category pages', 'the-next-mag'),
    				'fields' => array(
                        array(
    						'id'=>'bk_category_feature_area',
    						'type' => 'image_select', 
    						'title' => esc_html__('Feature Area Layout', 'the-next-mag'),
                            'options'  => array(
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
                            'default' => 'mosaic_a',
						),
                        array(
                            'id'        => 'bk_category_feature_area__post_option',  
                            'type'      => 'select',
                            'multi'     => false,
                            'title'     => esc_html__('Show Feature Area on only first page', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                'featured'          => esc_html__( 'Show Featured Posts', 'the-next-mag' ),
	                            'latest'            => esc_html__( 'Show Latest Posts', 'the-next-mag' ),
                            ),
                            'default' => 'latest',
                        ),
                        array(
                            'id'        => 'bk_feature_area__show_hide',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Show Feature Area on only first page', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                1    => esc_html__( 'Yes', 'the-next-mag' ),
    			                0    => esc_html__( 'No', 'the-next-mag' ),
                            ),
                            'default' => 0,
                        ),
                        array(
    						'id'=>'bk_category_header_style',
    						'type' => 'select', 
                            'required' => array(
                                'bk_category_feature_area', 'equals', array('mosaic_a', 'mosaic_c', 'featured_block_f', 'posts_block_b', 'posts_block_c', 'posts_block_e', 'posts_block_i')
                            ),
    						'title' => esc_html__('Page Heading', 'the-next-mag'),
                            'options'  => array(
                                'grey-bg'           => esc_html__( 'Grey Background', 'the-next-mag' ),
                                'grey-bg-center'    => esc_html__( 'Grey Background -- Align Center', 'the-next-mag' ),
            					'image-bg'          => esc_html__( 'Featured Image Background', 'the-next-mag' ),
                                'image-bg-center'   => esc_html__( 'Featured Image Background -- Align Center', 'the-next-mag' ),
                            ),
                            'default' => 'grey-bg',
						),
                        array(
    						'id'=>'bk_category_content_layout',
    						'type' => 'image_select', 
    						'title' => esc_html__('Content Layout', 'the-next-mag'),
                            'options'  => array(
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
                            'default' => 'listing_list',
						),
                        array(
                            'id'        => 'bk_category_post_icon',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Post Icon', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                'enable'    => esc_html__( 'Enable', 'the-next-mag' ),
                                'disable'   => esc_html__( 'Disable', 'the-next-mag' ),
                            ),
                            'default' => 'enable',
                        ),
                        array(
                            'id'        => 'bk_category_pagination',  
                            'type'      => 'select',
                            'multi'     => false,
                            'title'     => esc_html__('Pagination', 'the-next-mag'),
                            'subtitle'  => esc_html__('Select an option for the pagination', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                                'default'           => esc_html__( 'Default Pagination', 'the-next-mag' ),
            					                'ajax-pagination'   => esc_html__( 'Ajax Pagination', 'the-next-mag' ),
                                                'ajax-loadmore'     => esc_html__( 'Ajax Load More', 'the-next-mag' ),
                                        ),
                            'default' => 'default',
                        ),
                        array(
    						'id'=>'bk_category_exclude_posts',
    						'type' => 'button_set', 
                            'required' => array('bk_category_feature_area','!=','disable'),
    						'title' => esc_html__('[Content Section] Exclude Posts', 'the-next-mag'),
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'the-next-mag' ),
                                0   => esc_html__( 'Disable', 'the-next-mag' ),
                            ),
                            'default' => 1,
						),
                        array(
                            'id'=>'section-category-sidebar-start',
                            'title' => esc_html__('Sidebar', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'        => 'bk_category_sidebar_select',  
                            'type'      => 'select',
                            'data'      => 'sidebars', 
                            'multi'     => false,
                            'title'     => esc_html__('Category Page Sidebar', 'the-next-mag'),
                            'subtitle'  => esc_html__('Choose a sidebar for the category page', 'the-next-mag'),
                            'default'   => 'home_sidebar',
                        ),
                        array(
                            'id'        => 'bk_category_sidebar_position',  
                            'type'      => 'image_select',
                            'multi'     => false,
                            'title'     => esc_html__('Sidebar Postion', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                                'right' => array(
                                                    'alt' => 'Sidebar Right',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-right.png',
                                                ),
                                                'left' => array(
                                                    'alt' => 'Sidebar Left',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-left.png',
                                                ),
                                        ),
                            'default' => 'right',
                        ),
                        array(
                            'id'        => 'bk_category_sidebar_sticky',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Stick Sidebar', 'the-next-mag'),
                            'subtitle'  => esc_html__('Enable Stick Sidebar / Disable Stick Sidebar', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'the-next-mag' ),
				                0   => esc_html__( 'Disable', 'the-next-mag' ),
                            ),
                            'default' => 1,
                        ),
                        array(
                            'id'=>'section-archive-sidebar-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-tags',
    				'title' => esc_html__('Archive', 'the-next-mag'),
                    'heading'   => esc_html__('Archive Pages', 'the-next-mag'),
                    'desc'   => esc_html__('Use for Tag / Archive Pages', 'the-next-mag'),
    				'fields' => array(
                        array(
    						'id'=>'bk_archive_header_style',
    						'type' => 'select', 
    						'title' => esc_html__('Page Heading', 'the-next-mag'),
                            'options'  => array(
                                'grey-bg'           => esc_html__( 'Grey Background', 'the-next-mag' ),
                                'grey-bg-center'    => esc_html__( 'Grey Background -- Align Center', 'the-next-mag' ),
            					'image-bg'          => esc_html__( 'Featured Image Background', 'the-next-mag' ),
                                'image-bg-center'   => esc_html__( 'Featured Image Background -- Align Center', 'the-next-mag' ),
                            ),
                            'default' => 'grey-bg',
						),
                        array(
    						'id'=>'bk_archive_content_layout',
    						'type' => 'image_select', 
    						'title' => esc_html__('Content Layout', 'the-next-mag'),
                            'options'  => array(
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
                            'default' => 'listing_list',
						),
                        array(
                            'id'        => 'bk_archive_post_icon',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Post Icon', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                'enable'    => esc_html__( 'Enable', 'the-next-mag' ),
                                'disable'   => esc_html__( 'Disable', 'the-next-mag' ),
                            ),
                            'default' => 'enable',
                        ),
                        array(
                            'id'        => 'bk_archive_pagination',  
                            'type'      => 'select',
                            'multi'     => false,
                            'title'     => esc_html__('Pagination', 'the-next-mag'),
                            'subtitle'  => esc_html__('Select an option for the pagination', 'the-next-mag'),
                            'desc'      => esc_html__('This option is only valid on Tag Pages', 'the-next-mag'),
                            'options'   => array(
                                                'default'           => esc_html__( 'Default Pagination', 'the-next-mag' ),
            					                'ajax-pagination'   => esc_html__( 'Ajax Pagination', 'the-next-mag' ),
                                                'ajax-loadmore'     => esc_html__( 'Ajax Load More', 'the-next-mag' ),
                                        ),
                            'default' => 'default',
                        ),
                        array(
                            'id'=>'section-archive-sidebar-start',
                            'title' => esc_html__('Sidebar', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'        => 'bk_archive_sidebar_select',  
                            'type'      => 'select',
                            'data'      => 'sidebars', 
                            'multi'     => false,
                            'title'     => esc_html__('Archive Page Sidebar', 'the-next-mag'),
                            'subtitle'  => esc_html__('Choose a sidebar for the archive page', 'the-next-mag'),
                            'default'   => 'home_sidebar',
                        ),
                        array(
                            'id'        => 'bk_archive_sidebar_position',  
                            'type'      => 'image_select',
                            'multi'     => false,
                            'title'     => esc_html__('Sidebar Postion', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                                'right' => array(
                                                    'alt' => 'Sidebar Right',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-right.png',
                                                ),
                                                'left' => array(
                                                    'alt' => 'Sidebar Left',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-left.png',
                                                ),
                                        ),
                            'default' => 'right',
                        ),
                        array(
                            'id'        => 'bk_archive_sidebar_sticky',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Stick Sidebar', 'the-next-mag'),
                            'subtitle'  => esc_html__('Enable Stick Sidebar / Disable Stick Sidebar', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'the-next-mag' ),
				                0   => esc_html__( 'Disable', 'the-next-mag' ),
                            ),
                            'default' => 1,
                        ),
                        array(
                            'id'=>'section-archive-sidebar-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-group',
    				'title' => esc_html__('Author Page', 'the-next-mag'),
    				'fields' => array(
                        array(
    						'id'=>'bk_author_content_layout',
    						'type' => 'image_select', 
    						'title' => esc_html__('Content Layout', 'the-next-mag'),
                            'options'  => array(
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
                            'default' => 'listing_list',
						),
                        array(
                            'id'        => 'bk_author_post_icon',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Post Icon', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                'enable'    => esc_html__( 'Enable', 'the-next-mag' ),
                                'disable'   => esc_html__( 'Disable', 'the-next-mag' ),
                            ),
                            'default' => 'enable',
                        ),
                        array(
                            'id'        => 'bk_author_pagination',  
                            'type'      => 'select',
                            'multi'     => false,
                            'title'     => esc_html__('Pagination', 'the-next-mag'),
                            'subtitle'  => esc_html__('Select an option for the pagination', 'the-next-mag'),
                            'options'   => array(
                                            'default'           => esc_html__( 'Default Pagination', 'the-next-mag' ),
        					                'ajax-pagination'   => esc_html__( 'Ajax Pagination', 'the-next-mag' ),
                                            'ajax-loadmore'     => esc_html__( 'Ajax Load More', 'the-next-mag' ),
                                        ),
                            'default' => 'default',
                        ),
                        array(
                            'id'=>'section-author-sidebar-start',
                            'title' => esc_html__('Sidebar', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'        => 'bk_author_sidebar_select',  
                            'type'      => 'select',
                            'data'      => 'sidebars', 
                            'multi'     => false,
                            'title'     => esc_html__('Author Page Sidebar', 'the-next-mag'),
                            'subtitle'  => esc_html__('Choose a sidebar for the author page', 'the-next-mag'),
                            'default'   => 'home_sidebar',
                        ),
                        array(
                            'id'        => 'bk_author_sidebar_position',  
                            'type'      => 'image_select',
                            'multi'     => false,
                            'title'     => esc_html__('Sidebar Postion', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                                'right' => array(
                                                    'alt' => 'Sidebar Right',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-right.png',
                                                ),
                                                'left' => array(
                                                    'alt' => 'Sidebar Left',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-left.png',
                                                ),
                                        ),
                            'default' => 'right',
                        ),
                        array(
                            'id'        => 'bk_author_sidebar_sticky',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Stick Sidebar', 'the-next-mag'),
                            'subtitle'  => esc_html__('Enable Stick Sidebar / Disable Stick Sidebar', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'the-next-mag' ),
				                0   => esc_html__( 'Disable', 'the-next-mag' ),
                            ),
                            'default' => 1,
                        ),
                        array(
                            'id'=>'section-author-sidebar-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-search',
    				'title' => esc_html__('Search Page', 'the-next-mag'),
    				'fields' => array(
                        array(
    						'id'=>'bk_search_content_layout',
    						'type' => 'image_select', 
    						'title' => esc_html__('Content Layout', 'the-next-mag'),
                            'options'  => array(
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
                            'default' => 'listing_list',
						),
                        array(
                            'id'        => 'bk_search_post_icon',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Post Icon', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                'enable'    => esc_html__( 'Enable', 'the-next-mag' ),
                                'disable'   => esc_html__( 'Disable', 'the-next-mag' ),
                            ),
                            'default' => 'enable',
                        ),
                        array(
                            'id'        => 'bk_search_pagination',  
                            'type'      => 'select',
                            'multi'     => false,
                            'title'     => esc_html__('Pagination', 'the-next-mag'),
                            'subtitle'  => esc_html__('Select an option for the pagination', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                                'default'           => esc_html__( 'Default Pagination', 'the-next-mag' ),
            					                'ajax-pagination'   => esc_html__( 'Ajax Pagination', 'the-next-mag' ),
                                                'ajax-loadmore'     => esc_html__( 'Ajax Load More', 'the-next-mag' ),
                                        ),
                            'default' => 'default',
                        ),
                        array(
                            'id'=>'section-author-results-start',
                            'title' => esc_html__('Author Search Results', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        
                        array(
                            'id'        => 'bk_author_results_active',  
                            'type'      => 'button_set',
                            'title'     => esc_html__('Show Author Result', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                1   => esc_html__( 'Yes', 'the-next-mag' ),
				                0   => esc_html__( 'No', 'the-next-mag' ),
                            ),
                            'default'   => 1,
                        ),
                        array(
                            'id'        => 'bk_author_results_entries',  
                            'type'      => 'text',
                            'title'     => esc_html__('Number of Author results per page: ', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'validate'  => 'numeric',
                            'default'   => '',
                        ),
                        array(
                            'id'        => 'bk_author_results_pagination',  
                            'type'      => 'select',
                            'multi'     => false,
                            'title'     => esc_html__('Pagination', 'the-next-mag'),
                            'subtitle'  => esc_html__('Select an option for the pagination', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
            					                'ajax-pagination'   => esc_html__( 'Ajax Pagination', 'the-next-mag' ),
                                                'ajax-loadmore'     => esc_html__( 'Ajax Load More', 'the-next-mag' ),
                                        ),
                            'default' => 'ajax-pagination',
                        ),
                        array(
                            'id'=>'section-author-results-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),                         
                        array(
                            'id'=>'section-search-sidebar-start',
                            'title' => esc_html__('Sidebar', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'        => 'bk_search_sidebar_select',  
                            'type'      => 'select',
                            'data'      => 'sidebars', 
                            'multi'     => false,
                            'title'     => esc_html__('Search Page Sidebar', 'the-next-mag'),
                            'subtitle'  => esc_html__('Choose a sidebar for the search page', 'the-next-mag'),
                            'default'   => 'home_sidebar',
                        ),
                        array(
                            'id'        => 'bk_search_sidebar_position',  
                            'type'      => 'image_select',
                            'multi'     => false,
                            'title'     => esc_html__('Sidebar Postion', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                                'right' => array(
                                                    'alt' => 'Sidebar Right',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-right.png',
                                                ),
                                                'left' => array(
                                                    'alt' => 'Sidebar Left',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-left.png',
                                                ),
                                        ),
                            'default' => 'right',
                        ),
                        array(
                            'id'        => 'bk_search_sidebar_sticky',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Stick Sidebar', 'the-next-mag'),
                            'subtitle'  => esc_html__('Enable Stick Sidebar / Disable Stick Sidebar', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'the-next-mag' ),
				                0   => esc_html__( 'Disable', 'the-next-mag' ),
                            ),
                            'default' => 1,
                        ),
                        array(
                            'id'=>'section-search-sidebar-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-pencil',
    				'title' => esc_html__('Blog Page', 'the-next-mag'),
    				'fields' => array(
                        array(
    						'id'=>'bk_blog_header_style',
    						'type' => 'select', 
    						'title' => esc_html__('Page Heading', 'the-next-mag'),
                            'options'  => array(
                                'grey-bg'           => esc_html__( 'Grey Background', 'the-next-mag' ),
                                'grey-bg-center'    => esc_html__( 'Grey Background -- Align Center', 'the-next-mag' ),
            					'image-bg'          => esc_html__( 'Featured Image Background', 'the-next-mag' ),
                                'image-bg-center'   => esc_html__( 'Featured Image Background -- Align Center', 'the-next-mag' ),
                            ),
                            'default' => 'grey-bg',
						),
                        array(
    						'id'=>'bk_blog_content_layout',
    						'type' => 'image_select', 
    						'title' => esc_html__('Content Layout', 'the-next-mag'),
                            'options'  => array(
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
                            'default' => 'listing_list',
						),
                        array(
                            'id'        => 'bk_blog_post_icon',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Post Icon', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                'enable'    => esc_html__( 'Enable', 'the-next-mag' ),
                                'disable'   => esc_html__( 'Disable', 'the-next-mag' ),
                            ),
                            'default' => 'enable',
                        ),
                        array(
                            'id'        => 'bk_blog_pagination',  
                            'type'      => 'select',
                            'multi'     => false,
                            'title'     => esc_html__('Pagination', 'the-next-mag'),
                            'subtitle'  => esc_html__('Select an option for the pagination', 'the-next-mag'),
                            'options'   => array(
                                'default'           => esc_html__( 'Default Pagination', 'the-next-mag' ),
                                'ajax-loadmore'     => esc_html__( 'Ajax Load More', 'the-next-mag' ),
                            ),
                            'default' => 'default',
                        ),
                        array(
                            'id'=>'section-blog-sidebar-start',
                            'title' => esc_html__('Sidebar', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'        => 'bk_blog_sidebar_select',  
                            'type'      => 'select',
                            'data'      => 'sidebars', 
                            'multi'     => false,
                            'title'     => esc_html__('Blog Page Sidebar', 'the-next-mag'),
                            'subtitle'  => esc_html__('Choose a sidebar for the blog page', 'the-next-mag'),
                            'default'   => 'home_sidebar',
                        ),
                        array(
                            'id'        => 'bk_blog_sidebar_position',  
                            'type'      => 'image_select',
                            'multi'     => false,
                            'title'     => esc_html__('Sidebar Postion', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                                'right' => array(
                                                    'alt' => 'Sidebar Right',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-right.png',
                                                ),
                                                'left' => array(
                                                    'alt' => 'Sidebar Left',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-left.png',
                                                ),
                                        ),
                            'default' => 'right',
                        ),
                        array(
                            'id'        => 'bk_blog_sidebar_sticky',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Stick Sidebar', 'the-next-mag'),
                            'subtitle'  => esc_html__('Enable Stick Sidebar / Disable Stick Sidebar', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'the-next-mag' ),
				                0   => esc_html__( 'Disable', 'the-next-mag' ),
                            ),
                            'default' => 1,
                        ),
                        array(
                            'id'=>'section-blog-sidebar-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-error-alt',
    				'title' => esc_html__('404 Page', 'the-next-mag'),
    				'fields' => array(
                        array(
                            'id'=>'section-404-logo-start',
                            'title' => esc_html__('404 Logo', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
    						'id'=>'404-logo',
    						'type' => 'media', 
    						'url'=> true,
    						'title' => esc_html__('Logo', 'the-next-mag'),
    						'subtitle' => esc_html__('Upload the logo that should be displayed in 404 page', 'the-next-mag'),
                            'placeholder' => esc_html__('No media selected','the-next-mag')
						),
                        array(
                            'id' => '404-logo-width',
                            'type' => 'slider',
                            'title' => esc_html__('Site Logo Width (px)', 'the-next-mag'),
                            'default' => 200,
                            'min' => 0,
                            'step' => 10,
                            'max' => 1000,
                            'display_value' => 'text'
                        ),
                        array(
                            'id'=>'section-404-logo-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
                        array(
    						'id'=>'bk-404-image',
    						'type' => 'media', 
    						'url'=> true,
    						'title' => esc_html__('404 Image', 'the-next-mag'),
    						'subtitle' => esc_html__('Leave this field empty if you would like to use the default option', 'the-next-mag'),
                            'placeholder' => esc_html__('No media selected','the-next-mag')
						),
                        array(
                            'id'=>'section-404-text-start',
                            'title' => esc_html__('404 Text', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'       => '404--main-text',
                            'type'     => 'textarea',
                            'rows'     => 3,
                            'title'    => esc_html__('Main Text', 'the-next-mag'),
                            'default'  => ''
                        ),   
                        array(
                            'id'       => '404--sub-text',
                            'type'     => 'textarea',
                            'rows'     => 3,
                            'title'    => esc_html__('Sub Text', 'the-next-mag'),
                            'default'  => ''
                        ),
                        array(
                            'id'=>'section-404-text-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'        => '404-search',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Search Field', 'the-next-mag'),
                            'subtitle'  => esc_html__('Enable / Disable Search Field', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'the-next-mag' ),
				                0   => esc_html__( 'Disable', 'the-next-mag' ),
                            ),
                            'default' => 1,
                        ),                        
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-error-alt',
    				'title' => esc_html__('Coming Soon Page', 'the-next-mag'),
    				'fields' => array(
                        array(
                            'id'=>'section-coming-soon-background-start',
                            'title' => esc_html__('Coming Soon Background', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
    						'id'=>'bk-coming-soon-bg-style',                            
    						'type' => 'select',
    						'title' => esc_html__('Background Style', 'the-next-mag'),
    						'default'   => 'default',
                            'options'   => array(
                                'default'    => esc_html__( 'Default Background', 'the-next-mag' ),                            
				                'image'      => esc_html__( 'Background Image', 'the-next-mag' ),
                                'gradient'   => esc_html__( 'Background Image + Gradient Overlay', 'the-next-mag' ),
                                'color'      => esc_html__( 'Background Color', 'the-next-mag' ),
                            ),
						),
                        array(
    						'id'=>'bk-coming-soon-bg-image',
                            'required' => array(
                                array ('bk-coming-soon-bg-style', 'equals' , array( 'image', 'gradient' )),
                            ),
    						'type' => 'background',
    						'output' => array('.page-coming-soon .background-img>.background-img'),
    						'title' => esc_html__('Background Image', 'the-next-mag'), 
    						'subtitle' => esc_html__('Choose background image for the site header', 'the-next-mag'),
                            'background-position' => false,
                            'background-repeat' => false,
                            'background-size' => false,
                            'background-attachment' => false,
                            'preview_media' => false,
                            'transparent' => false,
                            'background-color' => false,
                            'default'  => array(
                                'background-color' => '#fff',
                            ),
						),
                        array(
    						'id'=>'bk-coming-soon-bg-gradient',
                            'required' => array(
                                array ('bk-coming-soon-bg-style', 'equals' , array( 'gradient' )),
                            ),
    						'type' => 'color_gradient',
    						'title'    => esc_html__('Background Gradient', 'the-next-mag'),
                            'validate' => 'color',
                            'transparent' => false,
                            'default'  => array(
                                'from' => '#1e73be',
                                'to'   => '#00897e', 
                            ),
						),
                        array(
    						'id'=>'bk-coming-soon-bg-gradient-direction',
                            'required' => array(
                                array ('bk-coming-soon-bg-style', 'equals' , array( 'gradient' )),
                            ),
    						'type' => 'text',
    						'title'    => esc_html__('Gradient Direction(Degree Number)', 'the-next-mag'),
                            'validate' => 'numeric',
						),
                        array(
    						'id'=>'bk-coming-soon-bg-color',
                            'required' => array(
                                array ('bk-coming-soon-bg-style', 'equals' , array( 'color' )),
                            ),
    						'type' => 'background',                            
    						'title' => esc_html__('Background Color', 'the-next-mag'), 
    						'subtitle' => esc_html__('Choose background color', 'the-next-mag'),
                            'background-position' => false,
                            'background-repeat' => false,
                            'background-size' => false,
                            'background-attachment' => false,
                            'preview_media' => false,
                            'background-image' => false,
                            'transparent' => false,
                            'default'  => array(
                                'background-color' => '#fff',
                            ),
						),
                        array(
    						'id'=>'bk-coming-soon-bg-blur-switch',
    						'type' => 'button_set',
    						'title' => esc_html__('Background Blur', 'the-next-mag'),
    						'default'   => 1,
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'the-next-mag' ),
				                0   => esc_html__( 'Disable', 'the-next-mag' ),
                            ),
						),
                        array(
                            'id'=>'section-coming-soon-background-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),                      
                        array(
                            'id'=>'section-coming-soon-logo-start',
                            'title' => esc_html__('Coming Soon Logo', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
    						'id'=>'coming-soon-logo',
    						'type' => 'media', 
    						'url'=> true,
    						'title' => esc_html__('Logo', 'the-next-mag'),
    						'subtitle' => esc_html__('Upload the logo that should be displayed in coming soon page', 'the-next-mag'),
                            'placeholder' => esc_html__('No media selected','the-next-mag')
						),
                        array(
                            'id' => 'coming-soon-logo-width',
                            'type' => 'slider',
                            'title' => esc_html__('Site Logo Width (px)', 'the-next-mag'),
                            'default' => 400,
                            'min' => 0,
                            'step' => 10,
                            'max' => 1000,
                            'display_value' => 'text'
                        ),
                        array(
                            'id'=>'section-coming-soon-logo-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
                        array(
                            'id'=>'section-coming-soon-introduction-start',
                            'title' => esc_html__('Coming Soon Introduction', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'       => 'coming-soon-introduction--main-text',
                            'type'     => 'textarea',
                            'rows'     => 3,
                            'title'    => esc_html__('Introduction Text', 'the-next-mag'),
                            'default'  => esc_html__('Be ready, we are launching soon.', 'the-next-mag'),
                        ),  
                        array(
                            'id'=>'section-coming-soon-introduction-text-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'=>'section-coming-soon-social-start',
                            'title' => esc_html__('Coming Soon Social', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
    						'id'       =>'bk-coming-soon--social',
    						'type'     => 'select',
                            'multi'    => true,
    						'title' => esc_html__('Coming Soon Social Media', 'the-next-mag'),
    						'subtitle' => esc_html__('Set up social items for the page', 'the-next-mag'),
    						'options'  => array('fb'=>'Facebook', 'twitter'=>'Twitter', 'gplus'=>'GooglePlus', 'linkedin'=>'Linkedin',
                                               'pinterest'=>'Pinterest', 'instagram'=>'Instagram', 'dribbble'=>'Dribbble', 
                                               'youtube'=>'Youtube', 'vimeo'=>'Vimeo', 'vk'=>'VK', 'vine'=>'Vine',
                                               'snapchat'=>'SnapChat', 'rss'=>'RSS'),
    						'default' => array('fb'=>'', 'twitter'=>'', 'gplus'=>'', 'linkedin'=>'', 'pinterest'=>'', 'instagram'=>'', 'dribbble'=>'', 
                                                'youtube'=>'', 'vimeo'=>'', 'vk'=>'', 'vine'=>'', 'snapchat'=>'', 'rss'=>'')
						),  
                        array(
                            'id'=>'section-coming-soon-social-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),     
                        array(
                            'id'=>'section-coming-soon-date-start',
                            'title' => esc_html__('Coming Soon Date', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'       => 'coming-soon--date',
                            'type'     => 'text',
                            'title'    => esc_html__('Date (yyyy-mm-dd)', 'the-next-mag'),
                            'default'  => ''
                        ),  
                        array(
                            'id'=>'section-coming-soon-date-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),    
                        array(
                            'id'=>'section-coming-soon-mailchimp-start',
                            'title' => esc_html__('Mailchimp Form', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ), 
                        array(
    						'id'=>'bk-coming-soon-mailchimp-shortcode',
    						'type' => 'text', 
    						'title' => esc_html__('Mailchimp Shortcode', 'the-next-mag'),
    						'subtitle' => esc_html__('Insert the Mailchimp Shortcode here', 'the-next-mag'),
                            'default' => '',
						),    
                        array(
                            'id'=>'section-coming-soon-mailchimp-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),  
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-minus',
    				'title' => esc_html__('Default Page Template', 'the-next-mag'),
                    'heading'   => esc_html__('Default Page Template', 'the-next-mag'),
                    'desc'   => esc_html__('Default Page Template Configuration', 'the-next-mag'),
    				'fields' => array(
                        array(
                            'id'    => 'bk_page_header_style',
                            'title' => 'Page Heading',
                            'type'  => 'select',
                            'options'   => array(
                                            'grey-bg'           => esc_html__( 'Grey Background', 'the-next-mag' ),
                                            'grey-bg-center'    => esc_html__( 'Grey Background -- Align Center', 'the-next-mag' ),
                        					'image-bg'          => esc_html__( 'Featured Image Background', 'the-next-mag' ),
                                            'image-bg-center'   => esc_html__( 'Featured Image Background -- Align Center', 'the-next-mag' ),
                                        ),
                            'default'       => 'grey-bg',
                        ), 
                        array(
                            'id'        => 'bk_page_feat_img',
                            'title'     => esc_html__( 'Feature Image Show/Hide', 'the-next-mag' ),
                            'type'      => 'switch', 
                			'options'   => array(          
                                            1 => esc_html__( 'Show', 'the-next-mag' ),
                                            0 => esc_html__( 'Hide', 'the-next-mag' ),
                    				    ),
                			'default'    => 1,
                        ),
                        array(
    						'id'=>'bk_page_layout',
    						'type' => 'select', 
    						'title' => esc_html__('Layout', 'the-next-mag'),
                            'options'  => array(
                                'has_sidebar' => esc_html__( 'Has Sidebar', 'the-next-mag' ),
                                'no_sidebar'  => esc_html__( 'Full Width -- No sidebar', 'the-next-mag' ),
        				    ),
                            'default' => 'has_sidebar',
						),
                        array(
                            'id'=>'section-default-page--sidebar-start',
                            'title' => esc_html__('Sidebar', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'        => 'bk_page_sidebar_select',  
                            'type'      => 'select',
                            'data'      => 'sidebars', 
                            'multi'     => false,
                            'title'     => esc_html__('Page Sidebar', 'the-next-mag'),
                            'subtitle'  => esc_html__('Choose a sidebar for the page', 'the-next-mag'),
                            'default'   => 'home_sidebar',
                        ),
                        array(
                            'id'        => 'bk_page_sidebar_position',  
                            'type'      => 'image_select',
                            'multi'     => false,
                            'title'     => esc_html__('Sidebar Postion', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                                'right' => array(
                                                    'alt' => 'Sidebar Right',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-right.png',
                                                ),
                                                'left' => array(
                                                    'alt' => 'Sidebar Left',
                                                    'img' => get_template_directory_uri().'/images/admin_panel/archive/sb-left.png',
                                                ),
                                        ),
                            'default' => 'right',
                        ),
                        array(
                            'id'        => 'bk_page_sidebar_sticky',  
                            'type'      => 'button_set',
                            'multi'     => false,
                            'title'     => esc_html__('Stick Sidebar', 'the-next-mag'),
                            'subtitle'  => esc_html__('Enable Stick Sidebar / Disable Stick Sidebar', 'the-next-mag'),
                            'desc'      => esc_html__('', 'the-next-mag'),
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'the-next-mag' ),
				                0   => esc_html__( 'Disable', 'the-next-mag' ),
                            ),
                            'default' => 1,
                        ),
                        array(
                            'id'=>'section-default-page--sidebar-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-website',
    				'title' => esc_html__('Footer', 'the-next-mag'),
    				'fields' => array(
                        array(
    						'id'=>'bk-footer-template',
                            'class' => 'bk-footer-layout--global-option',
    						'title' => esc_html__('Footer Layout', 'the-next-mag'),
                            'type' => 'image_select', 
                            'options'  => array(
                                'footer-1' => get_template_directory_uri().'/images/admin_panel/footer/1.png',
                                'footer-2' => get_template_directory_uri().'/images/admin_panel/footer/2.png',
                                'footer-3' => get_template_directory_uri().'/images/admin_panel/footer/3.png',
                                'footer-4' => get_template_directory_uri().'/images/admin_panel/footer/4.png',
            					'footer-5' => get_template_directory_uri().'/images/admin_panel/footer/5.png',
                                'footer-6' => get_template_directory_uri().'/images/admin_panel/footer/6.png',
                                'footer-7' => get_template_directory_uri().'/images/admin_panel/footer/7.png',
                                'footer-8' => get_template_directory_uri().'/images/admin_panel/footer/8.png',
                            ),
                            'default' => 'footer-1',
						),
                        
                        array(
                            'id' => 'section-footer-bg-start',
                            'required' => array(
                                'bk-footer-template', 'equals', array('footer-1', 'footer-2', 'footer-3', 'footer-4', 'footer-5', 'footer-6')
                            ),
                            'title' => esc_html__('Footer Background', 'the-next-mag'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),	
                        array(
    						'id'=>'bk-footer-bg-style',
    						'type' => 'select',
    						'title' => esc_html__('Footer Background Style', 'the-next-mag'),
    						'default'   => 'default',
                            'options'   => array(
                                'default'    => esc_html__( 'Default Background', 'the-next-mag' ),
                                'gradient'   => esc_html__( 'Background Gradient', 'the-next-mag' ),
                                'color'      => esc_html__( 'Background Color', 'the-next-mag' ),
                            ),
						),
                        array(
    						'id'=>'bk-footer-bg-gradient',
                            'required' => array(
                                array ('bk-footer-bg-style', 'equals' , array( 'gradient' )),
                            ),
    						'type' => 'color_gradient',
    						'title'    => esc_html__('Background Gradient', 'the-next-mag'),
                            'validate' => 'color',
                            'transparent' => false,
                            'default'  => array(
                                'from' => '#1e73be',
                                'to'   => '#00897e', 
                            ),
						),
                        array(
    						'id'=>'bk-footer-bg-gradient-direction',
                            'required' => array(
                                array ('bk-footer-bg-style', 'equals' , array( 'gradient' )),
                            ),
    						'type' => 'text',
    						'title'    => esc_html__('Gradient Direction(Degree Number)', 'the-next-mag'),
                            'validate' => 'numeric',
						),
                        array(
    						'id'=>'bk-footer-bg-color',
                            'required' => array(
                                array ('bk-footer-bg-style', 'equals' , array( 'color' )),
                            ),
    						'type' => 'background',
    						'title' => esc_html__('Background Color', 'the-next-mag'), 
    						'subtitle' => esc_html__('Choose background color for the Footer', 'the-next-mag'),
                            'background-position' => false,
                            'background-repeat' => false,
                            'background-size' => false,
                            'background-attachment' => false,
                            'preview_media' => false,
                            'background-image' => false,
                            'transparent' => false,
                            'default'  => array(
                                'background-color' => '#333',
                            ),
						),
                        array(
    						'id'=>'bk-footer-pattern',
    						'type' => 'button_set',
    						'title' => esc_html__('Footer Pattern', 'the-next-mag'),
    						'default'   => 0,
                            'options'   => array(
                                1   => esc_html__( 'Enable', 'the-next-mag' ),
				                0   => esc_html__( 'Disable', 'the-next-mag' ),
                            ),
						),
                        array(
    						'id'=>'bk-footer-inverse',
    						'type' => 'button_set',
    						'title' => esc_html__('Footer Text', 'the-next-mag'),
    						'default'   => 0,
                            'options'   => array(
				                0   => esc_html__( 'Black', 'the-next-mag' ),
                                1   => esc_html__( 'White', 'the-next-mag' ),
                            ),
						),
                        array(
                            'id' => 'section-footer-bg-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        
                        array(
                            'id'       => 'footer-col-scale',
                            'required' => array(
                                'bk-footer-template','equals',array( 'footer-7', 'footer-8' )
                            ),
                            'type'     => 'select',
                            'multi'    => false,
                            'title'    => esc_html__('Footer Column Width', 'the-next-mag'),
                            'options'   => array(
                                            1   => esc_html__( '1/3 1/3 1/3', 'the-next-mag' ),
            					            2   => esc_html__( '1/2 1/4 1/4', 'the-next-mag' ),
                             ),
                             'default'  => 1,
                        ),
                        array(
                            'id'       => 'footer-col-1',
                            'required' => array(
                                'bk-footer-template','equals',array( 'footer-7', 'footer-8' )
                            ),
                            'type'     => 'select',
                            'data'     => 'sidebars',
                            'multi'    => false,
                            'title'    => esc_html__('Footer Column 1', 'the-next-mag'),
                            'default'  => 'footer_sidebar_1',
                        ),
                        array(
                            'id'       => 'footer-col-2',
                            'required' => array(
                                'bk-footer-template','equals',array( 'footer-7', 'footer-8' )
                            ),
                            'type'     => 'select',
                            'data'     => 'sidebars',
                            'multi'    => false,
                            'title'    => esc_html__('Footer Column 2', 'the-next-mag'),
                            'default'  => 'footer_sidebar_2',
                        ),
                        array(
                            'id'       => 'footer-col-3',
                            'required' => array(
                                'bk-footer-template','equals',array( 'footer-7', 'footer-8' )
                            ),
                            'type'     => 'select',
                            'data'     => 'sidebars',
                            'multi'    => false,
                            'title'    => esc_html__('Footer Column 3', 'the-next-mag'),
                            'default'  => 'footer_sidebar_3',
                        ),
                        array(
                            'id' => 'section-footer-mailchimp-start',
                            'required' => array(
                                'bk-footer-template','equals',array( 'footer-1', 'footer-3', 'footer-5' )
                            ),
                            'title' => esc_html__('Mailchimp Subscribe Form Setting', 'the-next-mag'),
                            'subtitle' => '',
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),  
                        array(
    						'id'=>'bk-footer--mailchimp-bg',
    						'type' => 'background',
                            'required' => array(
                                'bk-footer-template','equals',array( 'footer-1' )
                            ),
    						'title' => esc_html__('Mailchimp background', 'the-next-mag'), 
                            'transparent' => false,
                            'background-color' => false,
                            'background-repeat' => false,
                            'background-position' => false,
                            'background-attachment' => false,
                            'background-size'   => false,
                            'preview'   => false,
    						'subtitle' => esc_html__('Leave empty if you wish to use the default background', 'the-next-mag'),
						),
                        array(
                            'id'       => 'footer-mailchimp--shortcode',
                            'type'     => 'textarea',
                            'rows'     => 3,
                            'title'    => esc_html__('Mailchimp Subscribe Form Shortcode', 'the-next-mag'),
                            'default'  => ''
                        ),
                        array(
                            'id' => 'section-footer-mailchimp-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id' => 'section-footer-logo-start',
                            'required' => array(
                                'bk-footer-template','equals',array( 'footer-2', 'footer-4', 'footer-6' )
                            ),
                            'title' => esc_html__('Footer Logo', 'the-next-mag'),
                            'subtitle' => '',
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ), 
                        array(
    						'id'=>'bk-footer-logo',
    						'type' => 'media', 
    						'url'=> true,
    						'title' => esc_html__('Footer Logo', 'the-next-mag'),
    						'subtitle' => esc_html__('Upload the logo image that will be displayed in footer', 'the-next-mag'),
                            'placeholder' => esc_html__('No media selected','the-next-mag')
						),
                        array(
                            'id' => 'footer-logo-width',
                            'type' => 'slider',
                            'title' => esc_html__('Footer Logo Width (px)', 'the-next-mag'),
                            'default' => 200,
                            'min' => 0,
                            'step' => 10,
                            'max' => 1000,
                            'display_value' => 'text'
                        ),
                        array(
                            'id' => 'section-footer-logo-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id' => 'section-footer-bottom-start',
                            'title' => esc_html__('Footer Bottom', 'the-next-mag'),
                            'subtitle' => '',
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'       => 'footer-social',
                            'required' => array(
                                'bk-footer-template','equals',array( 'footer-1', 'footer-2', 'footer-4', 'footer-5', 'footer-6' )
                            ),
                            'type'     => 'select',
                            'multi'    => true,
                            'title'    => esc_html__('Footer Social', 'the-next-mag'),
                            'options'  => array('fb'=>'Facebook', 'twitter'=>'Twitter', 'gplus'=>'GooglePlus', 'linkedin'=>'Linkedin',
                                               'pinterest'=>'Pinterest', 'instagram'=>'Instagram', 'dribbble'=>'Dribbble', 
                                               'youtube'=>'Youtube', 'vimeo'=>'Vimeo', 'vk'=>'VK', 'vine'=>'Vine',
                                               'snapchat'=>'SnapChat', 'rss'=>'RSS'),
                        ),
                        array(
                            'id'       => 'footer-copyright-text',
                            'type'     => 'textarea',
                            'required' => array(
                                'bk-footer-template','equals',array( 'footer-1', 'footer-2', 'footer-3', 'footer-4', 'footer-5', 'footer-6','footer-7', 'footer-8' )
                            ),
                            'rows'     => 3,
                            'title'    => esc_html__('Footer Copyright Text', 'the-next-mag'),
                            'default'  => 'By <a href="https://themeforest.net/user/bkninja/portfolio">BKNinja</a>'
                        ),
                        array(
                            'id' => 'section-footer-bottom-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ) 
    				)
    			);
			$theme_info = '<div class="redux-framework-section-desc">';
			$theme_info .= '<p class="redux-framework-theme-data description theme-uri">'.__('<strong>Theme URL:</strong> ', 'the-next-mag').'<a href="'.$this->theme->get('ThemeURI').'" target="_blank">'.$this->theme->get('ThemeURI').'</a></p>';
			$theme_info .= '<p class="redux-framework-theme-data description theme-author">'.__('<strong>Author:</strong> ', 'the-next-mag').$this->theme->get('Author').'</p>';
			$theme_info .= '<p class="redux-framework-theme-data description theme-version">'.__('<strong>Version:</strong> ', 'the-next-mag').$this->theme->get('Version').'</p>';
			$theme_info .= '<p class="redux-framework-theme-data description theme-description">'.$this->theme->get('Description').'</p>';
			$tabs = $this->theme->get('Tags');
			if ( !empty( $tabs ) ) {
				$theme_info .= '<p class="redux-framework-theme-data description theme-tags">'.__('<strong>Tags:</strong> ', 'the-next-mag').implode(', ', $tabs ).'</p>';	
			}
			$theme_info .= '</div>';

			$this->sections[] = array(
				'type' => 'divide',
			);

		}	

		public function setHelpTabs() {

		}


		/**
			
			All the possible arguments for Redux.
			For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

		 **/
		public function setArguments() {
			
			$theme = wp_get_theme(); // For use with some settings. Not necessary.

			$this->args = array(
	            
	            // TYPICAL -> Change these values as you need/desire
				'opt_name'          	=> 'tnm_option', // This is where your data is stored in the database and also becomes your global variable name.
				'display_name'			=> $theme->get('Name'), // Name that appears at the top of your panel
				'display_version'		=> $theme->get('Version'), // Version that appears at the top of your panel
				'menu_type'          	=> 'menu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
				'allow_sub_menu'     	=> true, // Show the sections below the admin menu item or not
				'menu_title'			=> esc_html__( 'Theme Options', 'the-next-mag' ),
	            'page'		 	 		=> esc_html__( 'Theme Options', 'the-next-mag' ),
	            'google_api_key'   	 	=> 'AIzaSyBdxbxgVuwQcnN5xCZhFDSpouweO-yJtxw', // Must be defined to add google fonts to the typography module
	            'global_variable'    	=> '', // Set a different name for your global variable other than the opt_name
	            'dev_mode'           	=> false, // Show the time the page took to load, etc
	            'customizer'         	=> true, // Enable basic customizer support
                'google_update_weekly'  => true, //This will only function if you have a google_api_key provided. This argument tells the core to grab the Google fonts cache weekly, ensuring your font list is always up to date.

	            // OPTIONAL -> Give you extra features
	            'page_priority'      	=> null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
	            'page_parent'        	=> 'themes.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
	            'page_permissions'   	=> 'manage_options', // Permissions needed to access the options panel.
	            'menu_icon'          	=> '', // Specify a custom URL to an icon
	            'last_tab'           	=> '', // Force your panel to always open to a specific tab (by id)
	            'page_icon'          	=> 'icon-themes', // Icon displayed in the admin panel next to your menu_title
	            'page_slug'          	=> '_options', // Page slug used to denote the panel
	            'save_defaults'      	=> true, // On load save the defaults to DB before user clicks save or not
	            'default_show'       	=> false, // If true, shows the default value next to each field that is not the default value.
	            'default_mark'       	=> '', // What to print by the field's title if the value shown is default. Suggested: *


	            // CAREFUL -> These options are for advanced use only
	            'transient_time' 	 	=> 60 * MINUTE_IN_SECONDS,
	            'output'            	=> true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
	            'output_tag'            	=> true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
	            //'domain'             	=> 'redux-framework', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
	            //'footer_credit'      	=> '', // Disable the footer credit of Redux. Please leave if you can help it.
	            

	            // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
	            'database'           	=> '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
	            
	        
	            'show_import_export' 	=> true, // REMOVE
	            'system_info'        	=> false, // REMOVE
	            
	            'help_tabs'          	=> array(),
	            'help_sidebar'       	=> '', // esc_html__( '', $this->args['domain'] );            
				);


			// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.		
			$this->args['share_icons'][] = array(
			    'url' => 'https://github.com/ReduxFramework/ReduxFramework',
			    'title' => 'Visit us on GitHub', 
			    'icon' => 'el-icon-github'
			    // 'img' => '', // You can use icon OR img. IMG needs to be a full URL.
			);		
			$this->args['share_icons'][] = array(
			    'url' => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
			    'title' => 'Like us on Facebook', 
			    'icon' => 'el-icon-facebook'
			);
			$this->args['share_icons'][] = array(
			    'url' => 'http://twitter.com/reduxframework',
			    'title' => 'Follow us on Twitter', 
			    'icon' => 'el-icon-twitter'
			);
			$this->args['share_icons'][] = array(
			    'url' => 'http://www.linkedin.com/company/redux-framework',
			    'title' => 'Find us on LinkedIn', 
			    'icon' => 'el-icon-linkedin'
			);

			
	 
			// Panel Intro text -> before the form
			if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false ) {
				if (!empty($this->args['global_variable'])) {
					$v = $this->args['global_variable'];
				} else {
					$v = str_replace("-", "_", $this->args['opt_name']);
				}
				$this->args['intro_text'] = '';
			} else {
				$this->args['intro_text'] = '';
			}

			// Add content after the form.
			$this->args['footer_text'] = '' ;

		}
	}
	new Redux_Framework_config();

}


/** 

	Custom function for the callback referenced above

 */
if ( !function_exists( 'redux_my_custom_field' ) ):
	function redux_my_custom_field($field, $value) {
	    print_r($field);
	    print_r($value);
	}
endif;

/**
 
	Custom function for the callback validation referenced above

**/
if ( !function_exists( 'redux_validate_callback_function' ) ):
	function redux_validate_callback_function($field, $value, $existing_value) {
	    $error = false;
	    $value =  'just testing';
	    
	    $return['value'] = $value;
	    if($error == true) {
	        $return['error'] = $field;
	    }
	    return $return;
	}
endif;
