<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'cobratest');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '123456');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '9xZ~Ax+V+<3jfq*T&H.gh4w$Uz4Ymw`aoy6//:pcG}uSMLRhvp:4T1ye>>~:VT+i');
define('SECURE_AUTH_KEY',  'JGdEPd*6#wh>A[z_4Ew}u0sxo=X,9>E>OD]jfpJG4Hd sA`@H2k$1DlTXYL|KPj`');
define('LOGGED_IN_KEY',    '@Rt1AW2PczdbXm)DS@1rX&ca7IE?5aH;.*pSUdM#%eOBmC|S=-T.q8|k1}%Cvw2d');
define('NONCE_KEY',        '@4MTdC_%l-,PPfA+jK9GUW_-]z|- rP-&>m)$Jsjy6hW}(=6-[Mpb#o{1*x(.3$u');
define('AUTH_SALT',        '?(mw>F9lx|]9/ZDDs!pQsK5#s]EI&o=cS 6_sMHq|//mJ($(Yb~`#GjNI1V<dO0Q');
define('SECURE_AUTH_SALT', 'ElLm9u*0sgxlOFy~9,%[lv#)/KrLplOWxm06dR,ECzewh {&j).S,DSsPSAl.UeI');
define('LOGGED_IN_SALT',   '-&94p|+yNR:16w}HUhIs`as$>x&@QA0^uF!oB=.#p!Lo3zde!iH@Ayl:m7~|7zTk');
define('NONCE_SALT',       'D_Q@@Ex/P.&gmt?9Q}{Cf.@z`J8+3F^0(BFE3%s;FtcVx6S.^cPZ46F%P81|ju{|');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
define('FS_METHOD', 'direct');

