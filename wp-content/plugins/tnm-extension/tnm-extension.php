<?php
/*
Plugin Name: TNM Extension
Plugin URI: 
Description: The Next Mag extension (more functional, widgets, etc.)
Author: bkninja
Version: 2.0
Author URI: http://bk-ninja.com
*/
if (!defined('RUBIK_FUNCTIONS_PLUGIN_DIR')) {
    define('RUBIK_FUNCTIONS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}
include(RUBIK_FUNCTIONS_PLUGIN_DIR."/widgets/widget-posts-list.php");
include(RUBIK_FUNCTIONS_PLUGIN_DIR."/widgets/widget-most-commented.php");
include(RUBIK_FUNCTIONS_PLUGIN_DIR."/widgets/widget-review-list.php");
include(RUBIK_FUNCTIONS_PLUGIN_DIR."/widgets/widget-social-counters.php");
include(RUBIK_FUNCTIONS_PLUGIN_DIR."/widgets/widget-subscribe.php");
include(RUBIK_FUNCTIONS_PLUGIN_DIR."/widgets/widget-category-tiles.php");
include(RUBIK_FUNCTIONS_PLUGIN_DIR."/widgets/widget-instagram.php");

if ( ! function_exists( 'bk_contact_data' ) ) {  
    function bk_contact_data($contactmethods) {
    
        unset($contactmethods['aim']);
        unset($contactmethods['yim']);
        unset($contactmethods['jabber']);
        $contactmethods['publicemail'] = 'Public Email';
        $contactmethods['twitter'] = 'Twitter URL';
        $contactmethods['facebook'] = 'Facebook URL';
        $contactmethods['youtube'] = 'Youtube Username';
        $contactmethods['googleplus'] = 'Google+ (Entire URL)';
         
        return $contactmethods;
    }
}
add_filter('user_contactmethods', 'bk_contact_data');

/**-------------------------------------------------------------------------------------------------------------------------
 * remove redux sample config & notice
 */
if ( ! function_exists( 'tnm_redux_remove_notice' ) ) {
	function tnm_redux_remove_notice() {
		if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
			remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::instance(), 'plugin_metalinks' ), null, 2 );
			remove_action( 'admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );
		}
	}
	add_action( 'redux/loaded', 'tnm_redux_remove_notice' );
}
if ( ! function_exists( 'bk_set__cookie' ) ) {
    function bk_set__cookie(){
        if (class_exists('tnm_core')) {
            $tnm_option = tnm_core::bk_get_global_var('tnm_option');
            $cookietime = $tnm_option['bk-post-view--cache-time'];
            //echo (preg_replace('/[^A-Za-z0-9]/', '', $_SERVER["REQUEST_URI"]));
            $bk_uri = explode('/', $_SERVER["REQUEST_URI"]);
            $bkcookied = 0;
            if($bk_uri[count($bk_uri) - 1] !== '') {
                $cookie_name = preg_replace('/[^A-Za-z0-9]/', '', $bk_uri[count($bk_uri) - 1]);
            }else {
                $cookie_name = preg_replace('/[^A-Za-z0-9]/', '', $bk_uri[count($bk_uri) - 2]);
            }
            if(!isset($_COOKIE[$cookie_name])) {
                setcookie($cookie_name, '1', time() + $cookietime);  /* expire in 1 hour */
                $bkcookied = 1;
            }else {
                $bkcookied = 0;
            }
            return $bkcookied;
        }
    }
}
/**-------------------------------------------------------------------------------------------------------------------------
 * tnm_extension_single_entry_interaction
 */
if ( ! function_exists( 'tnm_extension_single_entry_interaction' ) ) {
	function tnm_extension_single_entry_interaction($postID) {
	   ?>
        <div class="entry-interaction entry-interaction--horizontal">
        	<div class="entry-interaction__left">
        		<div class="post-sharing post-sharing--simple">
        			<ul>
        				<?php echo tnm_single::bk_entry_interaction_share($postID);?>
        			</ul>
        		</div>
        	</div>
        
        	<div class="entry-interaction__right">
        		<?php echo tnm_single::bk_entry_interaction_comments($postID);?>
        	</div>
        </div>
    <?php
    }
}
?>