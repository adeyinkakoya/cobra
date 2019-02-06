<?php
    /*
    Plugin Name: TNM Admin Panel
    Plugin URI: http://bk-ninja.com
    Description: The Next Mag theme admin panel
    Author: BKNinja
    Version: 2.0
    Author URI: http://bk-ninja.com
    */
?>
<?php
define( 'BK_HOMEPAGE', 'Home Demo' );
define( 'BK_AD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'BK_AD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

delete_option( 'bk_import_process_data');
delete_option('bk_demo_5_status' );

require_once (BK_AD_PLUGIN_DIR.'templates/welcome_template.php');
require_once (BK_AD_PLUGIN_DIR.'templates/demos_template.php');
require_once (BK_AD_PLUGIN_DIR.'templates/plugins_template.php');
require_once (BK_AD_PLUGIN_DIR.'templates/status_report.php');
require_once (BK_AD_PLUGIN_DIR.'library/ajax_check.php');
require_once (BK_AD_PLUGIN_DIR.'library/demo_import.php');
require_once (BK_AD_PLUGIN_DIR.'library/demo_config_options.php');

if ( ! function_exists( 'bk_admin_panel_scripts_method' ) ) {
    function bk_admin_panel_scripts_method() {
        wp_enqueue_style( 'bkadstyle', BK_AD_PLUGIN_URL . 'assets/css/style.css', array(), '' );
        wp_enqueue_script('bkadscript', BK_AD_PLUGIN_URL . 'assets/js/main.js', array('jquery'),false, true);
    }
}

add_action('admin_enqueue_scripts', 'bk_admin_panel_scripts_method');

/**-------------------------------------------------------------------------------------------------------------------------
 * register ajax
 */
if ( ! function_exists( 'bk_admin_enqueue_ajax_url' ) ) {
	function bk_admin_enqueue_ajax_url() {
        echo '<script type="application/javascript">var ajaxurl = "' . esc_url(admin_url( 'admin-ajax.php' )) . '"</script>';
	}
	add_action( 'admin_enqueue_scripts', 'bk_admin_enqueue_ajax_url' );
}

function bk_theme_welcome() {
	// Check that the user is allowed to update options  
	if (current_user_can('manage_options')) {  
	   //add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
        add_menu_page(esc_html__('The Next Mag', 'bkninja'), esc_html__('The Next Mag', 'bkninja'), 'edit_theme_options', 'bk-theme-welcome', 'bk_welcome_template', 'dashicons-admin-site', 4 );
    }
}
add_action('admin_menu', 'bk_theme_welcome');

function bk_theme_plugins() {
	// Check that the user is allowed to update options  
	if (current_user_can('manage_options')) {  
        add_submenu_page( 'bk-theme-welcome', 'Install Plugins', 'Install Plugins', 'edit_theme_options', 'bk-theme-plugins',  'bk_plugins_template' );
    }
}
add_action('admin_menu', 'bk_theme_plugins');

function bk_theme_demos() {
	// Check that the user is allowed to update options  
	if (current_user_can('manage_options')) { 
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
            add_submenu_page( 'bk-theme-welcome', 'Install Demos', 'Install Demos', 'edit_theme_options', 'bk-theme-demos',  'bk_theme_demo_html' );
    	}
    }
}
add_action('admin_menu', 'bk_theme_demos');

function bk_system_status() {
	// Check that the user is allowed to update options  
	if (current_user_can('manage_options')) {  
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
            add_submenu_page( 'bk-theme-welcome', 'Theme Options', 'Theme Options', 'edit_theme_options', ' ?page=_options',  '');
            add_submenu_page( 'bk-theme-welcome', 'System Status', 'System Status', 'edit_theme_options', 'bk-system-status',  'bk_system_status_template' );
        }
    }
    global $submenu; // this is a global from WordPress
    $submenu['bk-theme-welcome'][0][0] = 'Welcome';
}
add_action('admin_menu', 'bk_system_status');