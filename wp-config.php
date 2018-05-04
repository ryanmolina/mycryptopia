<?php
//require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/vendor/autoload.php';
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();
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

define('DB_NAME', getenv('DB_NAME'));

/** MySQL database username */
define('DB_USER', getenv('DB_LIVE_USER') ? getenv('DB_LIVE_USER') : getenv('DB_LOCAL_USER'));

/** MySQL database password */
define('DB_PASSWORD', getenv('DB_LIVE_PASSWORD') ? getenv('DB_LIVE_PASSWORD') : getenv('DB_LOCAL_PASSWORD'));

/** MySQL hostname */
define('DB_HOST', getenv('DB_LIVE_HOST') ? getenv('DB_LIVE_HOST') : getenv('DB_LOCAL_HOST'));

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
define('FS_METHOD', 'direct' );
define('FS_CHMOD_DIR', 0770);
define('FS_CHMOD_FILE', 0660);

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'cW_d&KX?$%.MS`9W9exoL5)M=82R^Prm3aJj}E.j 2#g[<(#k6voldffSML+ZXUg');
define('SECURE_AUTH_KEY',  'v vBH.9H`;~?so1v`K6e]DnR9BL}b8#h,mo>?*-Pmle5]:MRWNy[pZJ&vBNf H),');
define('LOGGED_IN_KEY',    'LJIoX!?-E=AY yRbS+,0J EM]LC71{^AixI$7Acp.U~}&a@Ao3bS+O~SS_@Xqta8');
define('NONCE_KEY',        'P86DC?vt{qq?@?phI097PZ`{Em3&r~,HJvBx%hKRZ,#{2]ZhUI9^oQz`*^fX3*kV');
define('AUTH_SALT',        '8UQ{.YlRGJI@#~YG+@mngw3`i4)S5w: Vi?jocF= #oxIR94|e?LdQq4.bK}+blK');
define('SECURE_AUTH_SALT', 'Tq<EE%a;%:B0TUl+m4B}%])9~B:z~sSEHe|U?9J=GLK{|C>.ib>zKx!Rf^yz-$!{');
define('LOGGED_IN_SALT',   'doFQXc]WqG00#0oE]S9O,+FzlMObg$*I`VM|puR7DC|@9u)@IlqUhF(I#nHdr)h6');
define('NONCE_SALT',       '}164zHI|r9,+_9QuWl):|EHC+qbQv%vp8V//:NOZzIt*[pHr1^N`;Xa]Qv`;&J<v');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = getenv('DB_PREFIX');

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

define ('EMPTY_TRASH_DAYS', 1);
