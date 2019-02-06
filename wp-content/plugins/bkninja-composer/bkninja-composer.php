<?php
    /*
    Plugin Name: BKNinja Composer
    Plugin URI: http://bk-ninja.com
    Description: Powerful Drag and Drop Pagebuilder for WordPress Themes -- By BKNinja
    Author: BKNinja
    Version: 2.0
    Author URI: http://bk-ninja.com
    */
?>
<?php
if (!defined('BKNINJA_COMPOSER_VERSION')) {
    define('BKNINJA_COMPOSER_VERSION', '1.0');
}

if (!defined('BKNINJA_COMPOSER_URL')) {
    define('BKNINJA_COMPOSER_URL', plugin_dir_url( __FILE__ ) );
}
if (!defined('BKNINJA_COMPOSER_DIR')) {
    define('BKNINJA_COMPOSER_DIR', plugin_dir_path( __FILE__ ) );
}
if (!defined('BKNINJA_COMPOSER_CONTROLLER')) {
    define('BKNINJA_COMPOSER_CONTROLLER', BKNINJA_COMPOSER_DIR.'controller/');
}

if (!defined('BKNINJA_COMPOSER_CSS_DIR')) {
    define('BKNINJA_COMPOSER_CSS_DIR', plugin_dir_url(__FILE__) . 'css');
}

function bk_scripts_method() {
    wp_enqueue_style('composer_style', BKNINJA_COMPOSER_CSS_DIR.'/composer_style.css',false,BKNINJA_COMPOSER_VERSION);
}
add_action('admin_enqueue_scripts', 'bk_scripts_method');

require_once (BKNINJA_COMPOSER_CONTROLLER.'bk_pd_template.php');
require_once (BKNINJA_COMPOSER_CONTROLLER.'bk_pd_save.php');
require_once (BKNINJA_COMPOSER_CONTROLLER.'bk_pd_del.php');

/**-------------------------------------------------------------------------------------------------------------------------
 * Enqueue Pagebuilder Scripts
 */
if ( ! function_exists( 'bk_composer_script' ) ) {
function bk_composer_script($hook) {
    if( $hook == 'post.php' || $hook == 'post-new.php' ) {
        wp_enqueue_script( 'bk-composer-script', BKNINJA_COMPOSER_URL.'controller/js/page-builder.js', array( 'jquery' ), null, true );
        wp_localize_script( 'bk-composer-script', 'bkpb_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}
}
}
add_action('admin_enqueue_scripts', 'bk_composer_script', 9);

//pagebuilder_classic_editor
function pagebuilder_classic_editor() {
    wp_enqueue_script( 'tnm-pagebuilder-classic-init', BKNINJA_COMPOSER_URL.'controller/js/pagebuilder-classic-init.js', array('jquery-ui-sortable'), '', true );
}

//pagebuilder_gutenberg_editor
function pagebuilder_gutenberg_editor() {
	wp_enqueue_script( 'tnm-pagebuilder-gutenberg-init', BKNINJA_COMPOSER_URL.'controller/js/pagebuilder-gutenberg-init.js', array('jquery-ui-sortable'), '', true );
}

add_action( 'after_setup_theme', 'bk_setup_page_builder' );
function bk_setup_page_builder() {
    global $wp_version;
    
    if ( function_exists( 'bk_init_sections' ) ) {
	   add_action( 'admin_enqueue_scripts', 'bk_init_sections' );
    }
    
    if(is_admin()) {
        if ( version_compare( $wp_version, '5.0', '>=' ) ) {
            if ( !class_exists( 'Classic_Editor' ) ) {
                add_action( 'enqueue_block_assets', 'bk_page_builder_temp' );   
                add_action('admin_enqueue_scripts', 'pagebuilder_gutenberg_editor');
            }else {
                add_action( 'edit_form_after_title', 'bk_page_builder_temp' );    
                add_action('admin_enqueue_scripts', 'pagebuilder_classic_editor');
                add_action( 'save_post', 'bk_classic_save_page' );
            }
        }else {
            if(!function_exists('gutenberg_pre_init')) {
                add_action( 'edit_form_after_title', 'bk_page_builder_temp' );    
                add_action('admin_enqueue_scripts', 'pagebuilder_classic_editor');
                add_action( 'save_post', 'bk_classic_save_page' );
            }else {
                add_action( 'enqueue_block_assets', 'bk_page_builder_temp' );   
                add_action('admin_enqueue_scripts', 'pagebuilder_gutenberg_editor');
            }
        }
    }
	
}