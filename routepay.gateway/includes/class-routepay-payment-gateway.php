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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'gateway' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         '|S&RtpkEuY;!w!GI! RG$J$5zQ(+hCi;OV=b7Zl+QM<I_Ju{PDU):Y4}!>S;rRob' );
define( 'SECURE_AUTH_KEY',  ';91{3.u-/Q]80X-xs8B}hp}zBhRH~7S E`7Car4F#m[Yw1pU(-l4ATx,6y@&Jnk{' );
define( 'LOGGED_IN_KEY',    '_zn)Q[ja+byEQ<_kZ ly>v1a)cgKPw[<Pk nBGi>bTW)fYcXFG~Fl7w=6.`8J[:f' );
define( 'NONCE_KEY',        '21<YFKXxJ+jNTM+<4(El:4h#l?43qv@^Jr)KOki6]3p,^Mi2}qA5(vUdObR/dmYd' );
define( 'AUTH_SALT',        'mK!Xl*KL]q^9Nw*c?<0&9~[ca3e9RFe<Z1JCNF5Pq_zvlD EWyDQA4J +e &wJT|' );
define( 'SECURE_AUTH_SALT', '1$T~i&P6:Q@1K|#]Dk~pjlpO*j#mNU#V1MQZ{eafd0JMG-5[.~sC!~d}i%a2:;AO' );
define( 'LOGGED_IN_SALT',   '01~Zu&WC_2d*[UQZ6.Z+$?Q!wfgH~Jc>xMgZ%H$7bm`pMc*.e=s+xLxYSA~S.HBq' );
define( 'NONCE_SALT',       'B]G:S^2}=g7-<Mwt-[>kfil#veq![mi>~ 79#z@ss:{&q{#;yq CNInX3H&el}##' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */

define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
