<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpressdb' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'selVa_kiasas11' );

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
define( 'AUTH_KEY',         'oaljN>-r]ku,*Fs6PrEfRhhj$k|8Q{N@CYf!F~kc;]&tAD,ZJkTbJ,vgt-)MN33b' );
define( 'SECURE_AUTH_KEY',  'hVJ-;3X;Oith8mr%F4X .E3_5Z;c`jic(>o9[zZ+1n5S^t1W`sQt_B?b|R>W?#&a' );
define( 'LOGGED_IN_KEY',    't7Bt? pttVUko<E:GAq%LgbB@Bd.04^IR<P_Er>$=@6*`M,RF0G#nJ1RD!E?Ebq>' );
define( 'NONCE_KEY',        'V9VU Q:=XMkYd+@Y2twyqL/isF`%+ReDpD&)TVAVYLA[!4SS!OaAixV:&l.U]7 l' );
define( 'AUTH_SALT',        'zf5d$E.>0J6tk_o%cZxA-7:}I[dey#kGz1`fx%Nh{JM/} f|3+EMWL.:`_.wJjBu' );
define( 'SECURE_AUTH_SALT', '(8VyMo=;{e9gSc8c`fiZ~,4%vv!;~-ttm2<,7Fqp$@ 50RN&D)2B5[I^O=2bw{;^' );
define( 'LOGGED_IN_SALT',   'NjQRjF/%an <)zPinSZzN26UVJ@ZZ0bUrgVriWS$Y*<og(d4p<Xw5w+o@6L;g3AP' );
define( 'NONCE_SALT',       '|HH7Ljz`&*VzTMQIMxYs(mB0s^c5](J;u{7XaN4.O_M>lQkmF]Cni9^z1}_Pn=:T' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
