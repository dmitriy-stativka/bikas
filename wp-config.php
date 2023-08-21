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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'bikasnew' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'asr=n[KzrKx>A!D>55>*E+=cdY`SBR1{}a=j>q])=mid,+M:]&`45yJa>Jo[vdVO' );
define( 'SECURE_AUTH_KEY',  'L.~v-S)3D2l;Fy!qJ]NaAC[4bPbH k{l):&Ys0vI?BtMsE5}nX1xK@.=eH0N2N)r' );
define( 'LOGGED_IN_KEY',    '#!]OWLrbD*6xYa]`X{#aT-xjlxHIJ0sD &V7 ,i@Fqzq}~#^u64 je;3Ig(i/SR!' );
define( 'NONCE_KEY',        ' pOPS~CYqB2~7PjcqHpamb3s>Gs-TyAFhY.v`=B-L;yW-Xr4QO<@d,%/=A[6Ke%w' );
define( 'AUTH_SALT',        'X>B@ WAFOR.jP.6gVBLkNCbQy-*JF>p2mdY)#_L@7y ^VHkTF/m2Dvx6XEPPb{V{' );
define( 'SECURE_AUTH_SALT', 'BRtSOnQmh8n_zmi$AHqR8-|;MeB`/Gc|)t/=cp}G7tL-q|~S%i3TQl9=jXF[INeb' );
define( 'LOGGED_IN_SALT',   '>-vV6Pq07EF&wAlZ0_uT!;GFy)vN8`k&{hVH.pZfI:pya}/GY@A24&/NCJne~hzf' );
define( 'NONCE_SALT',       'r@Qj?,}w,XU:^<*9qv0Y-LSqN)91[v+fmV|@X`[$@TLx9S#s.$7HK~4a(TKd@U@]' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
