<?php
define('THENEXTMAG_NAME', 'The Next Mag');

define('THENEXTMAG_LIBS', get_template_directory().'/library/');
define('THENEXTMAG_LIBS_ADMIN', THENEXTMAG_LIBS.'admin_panel/');

define('THENEXTMAG_FRAMEWORK', get_template_directory().'/framework/');

define('THENEXTMAG_INC', get_template_directory().'/inc/');
define('THENEXTMAG_INC_LIBS', THENEXTMAG_INC.'libs/');
define('THENEXTMAG_BLOCKS', THENEXTMAG_INC.'blocks/');
define('THENEXTMAG_MODULES', THENEXTMAG_INC.'/modules/');

define ('THENEXTMAG_TEMPLATES', THENEXTMAG_LIBS.'templates/');
define ('THENEXTMAG_AJAX', THENEXTMAG_LIBS.'/ajax/');
define ('THENEXTMAG_HEADER_TEMPLATES', THENEXTMAG_TEMPLATES.'header/');
define ('THENEXTMAG_FOOTER_TEMPLATES', THENEXTMAG_TEMPLATES.'footer/');
define ('THENEXTMAG_SINGLE_TEMPLATES', THENEXTMAG_TEMPLATES.'single/');

/**
 * Enqueue Style and Script Files Init Theme
 */
require_once (THENEXTMAG_INC.'bk_enqueue_scripts.php');
require_once (THENEXTMAG_INC.'bk_theme_settings.php');
require_once (THENEXTMAG_LIBS.'mega_menu.php');

/**
 * Add php library file.
 */
require_once (THENEXTMAG_LIBS.'core.php');
require_once (THENEXTMAG_LIBS.'mega_menu.php');
require_once (THENEXTMAG_LIBS.'custom_css.php');
require_once (THENEXTMAG_LIBS.'translation.php');
require_once (THENEXTMAG_INC.'bk_inc_files.php');

/**
* Add post thumbnail support
*/
add_theme_support( 'post-thumbnails' );