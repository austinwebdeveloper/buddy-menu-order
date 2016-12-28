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
define('DB_NAME', 'buddy');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         ' 93Wj9+H8RykCLOY-fu8s+`kzLSIV.pi_gdqBxmG*dUU9NI$=1bphjeWqzns)ngN');
define('SECURE_AUTH_KEY',  'on9Tw?(|nXXtFM]F@,j}B*, o;sx*<Dn.}EDK.xVQx`K+6=jTVgD6%:g_X,U}$$0');
define('LOGGED_IN_KEY',    'D:),Ln JwY;(wm,K.N.q74GReG<$a?1:.QDSu}DXltt}LSk92C!P}hx%UkSA y9o');
define('NONCE_KEY',        '657cVTp^O-AK{&2[!8P pQ`<yF`!Th8-{]g4>IIHSj@{SBE.kdd2V{O)ku`^%QXY');
define('AUTH_SALT',        '(XGEeF*Bj!3bW#UxAW9b+_h1&3U`|5E#A@;tgi%tqpd[w@($cHGdIy:/ABp,HTS4');
define('SECURE_AUTH_SALT', 'VbF(BYh^E>{ER$JLTI(;w;[?BEno~PoL9P<Y]fN>o%8C/5x&@u-l@wr`^uSkPiue');
define('LOGGED_IN_SALT',   '}3L!Ci(;l??Z!cUxPiz&5`K*AMPMBP=NrLwdeYiJ[LK$Y`oabf7;GS|:Jo6Lv>Zi');
define('NONCE_SALT',       '2m$6w9_7]Q5A jT7d2o}1@{%&w{<w7+Uh~69J9-+3-!bYf;jI1=@q>pJzCo<zmGv');

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
