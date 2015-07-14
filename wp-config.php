<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'oto');

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
define('AUTH_KEY',         'T>>1Ocg870$YYcj#h[+z8Jo+2%#XyoBXY2Q,a,N&>cPqF-Sg|{@|FW#5zaDW&Qr&');
define('SECURE_AUTH_KEY',  'L4,f*an2aml]({M%0<H}Uz,)9vt0U#ypzQod*]_nAX2dokgFMa~0F;S0^Y%~86$O');
define('LOGGED_IN_KEY',    'ubq8w**&9FVBvJ5/Fkj%N3no9ewh{VW?do@Sv4f#o)v2$vXo9;J&.k7Awi|GxG+y');
define('NONCE_KEY',        ')}L/4zED;@k_6%8r=7>=j%keR*<76HV4e,R96(!gq1OT`hGc(a&a*{2VdVze1/V ');
define('AUTH_SALT',        'Q*;7=V57z>:j&j^cRC _Br:(+q`h6{S wyAxBW _j(j<5+:v_WApEE@bfApOfn3T');
define('SECURE_AUTH_SALT', 'q0|&t(yOodO|->0u|)T.;+&ZhL3Z:z}-sZa/^v_f?e@u *0][QWE..f~cad~4+?H');
define('LOGGED_IN_SALT',   'jf|S+^Wl8zFU,a8b9FBw7L!?;vc_1QJ:!<Y0SD*Vh({)w~AS9om%/>VnGiCas `~');
define('NONCE_SALT',       ')$j-d.KvcOK+Lo@d:uq3fA%5t$Qr]CuiF@+$-+z+$o!4P&[;:gn^p%&vu0VGY4`i');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
