<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'alertcalm_wp' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '*Uatj0AbCW&*}2jHvFy>%3|Tk4C,C]?[E`vthx[;A4C2n%iqLo]R^_9,N[<O-O#3' );
define( 'SECURE_AUTH_KEY',  'f<:@zR%HaD>z?Oc-X.=Ry=Lh<7y`QEM|`7Q~eE70[}jPzGTf}<HitJABwyt[u^Li' );
define( 'LOGGED_IN_KEY',    'i7M4=Xb!,}E9<,:bm0hwFyP|sH(?*K5{/Z3{rXj*IMuaSV @Wy<:JI3-P+xfGY)9' );
define( 'NONCE_KEY',        'Vlwx3jjcm|52-U/*P[#GUQ5U4):edlbc 88@ww2&i.Xrx?%a,2DsiG)~1P+ieQVV' );
define( 'AUTH_SALT',        '@AxEb^xz#:+<{xr|FZg-E%FW+q_KuP!F12P{AB@b9 =s?f,K=V#)54rzS4iYl@+@' );
define( 'SECURE_AUTH_SALT', 'EX<ZZ]OYw7UI>?g7ji~%r_teusIZ8Go>=N4}{}^Zr)1`{}z*EI*82H;nv=J/_xN<' );
define( 'LOGGED_IN_SALT',   'D} Aat_vhi_,H07G[Oppiv8h05l2A*?nznH.x{IIbm_9z_z)dgMM~P$ho(^dM,6d' );
define( 'NONCE_SALT',       'Ye>/feD}>rI::d+bROPgZ$,wDT1/1E[5o3m6)dhp`~7e-gsXTLOV{iYS}2f&I,e#' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', true );
define('WP_DEBUG_LOG', true);  // Guarda los errores en el archivo de log
define('WP_DEBUG_DISPLAY', false); 

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';