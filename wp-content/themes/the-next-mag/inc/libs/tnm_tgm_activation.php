<?php
/**
 * Load the TGM Plugin Activator class to notify the user
 * to install the Envato WordPress Toolkit Plugin
 */
require_once( get_template_directory() . '/inc/class-tgm-plugin-activation.php' );
function tnm_tgmpa_register_toolkit() {
    // Specify the Envato Toolkit plugin
    $plugins = array(
        
        array(
            'name' => esc_html__('Redux Framework', 'the-next-mag'),
            'slug' => 'redux-framework',
            'img' => get_template_directory_uri() . '/images/plugins/Redux.jpg',
            'required' => true,
            'version' => '',
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('BKNinja Composer', 'the-next-mag'),
            'slug' => esc_html__('bkninja-composer', 'the-next-mag'),
            'img' => get_template_directory_uri() . '/images/plugins/bkninja-composer.jpg',
            'source' => get_template_directory() . '/plugins/bkninja-composer.zip',
            'required' => true,
            'version' => '2.0',
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('Social Login WordPress Plugin - AccessPress Social Login Lite', 'the-next-mag'),
            'slug' => 'accesspress-social-login-lite',
            'img' => get_template_directory_uri() . '/images/plugins/social-login.jpg',
            'version' => '',
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('Meta Box', 'the-next-mag'),
            'slug' => 'meta-box',
            'img' => get_template_directory_uri() . '/images/plugins/meta-box.jpg',
            'required' => true,
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),   
        array(
            'name' => esc_html__('MB Term Meta', 'the-next-mag'),
            'slug' => esc_html__('mb-term-meta', 'the-next-mag'),
            'img' => get_template_directory_uri() . '/images/plugins/Term-Meta.jpg',
            'source' => get_template_directory() . '/plugins/mb-term-meta.zip',
            'required' => true,
            'version' => '1.2.3',
            'external_url' => '',
        ),   
        array(
            'name' => esc_html__('Meta Box Conditional Logic', 'the-next-mag'),
            'slug' => esc_html__('meta-box-conditional-logic', 'the-next-mag'),
            'img' => get_template_directory_uri() . '/images/plugins/Conditional-Logic.jpg',
            'source' => get_template_directory() . '/plugins/meta-box-conditional-logic.zip',
            'required' => true,
            'version' => '1.6.4',
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('TNM Shortcode', 'the-next-mag'),
            'slug' => esc_html__('tnm-shortcode', 'the-next-mag'),
            'img' => get_template_directory_uri() . '/images/plugins/shortcode.jpg',
            'source' => get_template_directory() . '/plugins/tnm-shortcode.zip',
            'required' => '',
            'version' => '1.2',
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('TNM Extension', 'the-next-mag'),
            'slug' => esc_html__('tnm-extension', 'the-next-mag'),
            'img' => get_template_directory_uri() . '/images/plugins/tnm-extension.jpg',
            'source' => get_template_directory() . '/plugins/tnm-extension.zip',
            'version' => '2.0',
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('Login With Ajax', 'the-next-mag'),
            'slug' => 'login-with-ajax',
            'img' => get_template_directory_uri() . '/images/plugins/login-with-ajax.jpg',
            'version' => '',
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('MailChimp for WordPress', 'the-next-mag'),
            'slug' => 'mailchimp-for-wp',
            'img' => get_template_directory_uri() . '/images/plugins/mailchimp.jpg',
            'version' => '',
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('TNM Sidebar Generator', 'the-next-mag'),
            'slug' => 'tnm-sidebar-generator',
            'img' => get_template_directory_uri() . '/images/plugins/sidebar-generator.jpg',
            'source' => get_template_directory() . '/plugins/tnm-sidebar-generator.zip',
            'version' => '',
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('Contact Form 7', 'the-next-mag'),
            'slug' => 'contact-form-7',
            'title' => esc_html__('Contact Form 7 - Optional', 'the-next-mag'),
            'img' => get_template_directory_uri() . '/images/plugins/contact-form-7.jpg',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('TNM Admin Panel', 'the-next-mag'),
            'slug' => 'tnm-admin-panel',
            'title' => esc_html__('TNM Admin Panel - Optional', 'the-next-mag'),
            'source' => get_template_directory() . '/plugins/tnm-admin-panel.zip',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
    );
     
    // Configuration of TGM
    $config = array(
        'domain'           => 'the-next-mag',
        'default_path'     => '',
        'menu'             => 'install-required-plugins',
        'has_notices'      => true,
        'is_automatic'     => true,
        'message'          => '',
        'strings'          => array(
            'page_title'                      => esc_html__( 'Install Required Plugins', 'the-next-mag' ),
            'menu_title'                      => esc_html__( 'Install Plugins', 'the-next-mag' ),
            'installing'                      => esc_html__( 'Installing Plugin: %s', 'the-next-mag' ),
            'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'the-next-mag' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'the-next-mag' ),
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'the-next-mag' ),
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'the-next-mag' ),
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'the-next-mag' ),
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'the-next-mag' ),
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'the-next-mag' ),
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'the-next-mag' ),
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'the-next-mag' ),
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'the-next-mag' ),
            'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'the-next-mag' ),
            'return'                          => esc_html__( 'Return to Required Plugins Installer', 'the-next-mag' ),
            'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'the-next-mag' ),
            'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'the-next-mag' ),
            'nag_type'                        => 'updated'
        )
    );
    tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'tnm_tgmpa_register_toolkit' );