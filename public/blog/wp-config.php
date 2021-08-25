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
define('DB_NAME', 'hhrblog');

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
define('AUTH_KEY',         'X`c+8z]V{7{H`/;J3Q[{lmsRd8{>d@o+XL`a/IQH|P%ie/=GRd6r~~eTV9*Qg30(');
define('SECURE_AUTH_KEY',  ';)sF3y}D1mH*.Xh<o^rT[IqThDyjG[hCxbY}TV!x`h{Z{rO-4=>{tl X1j>?kbgI');
define('LOGGED_IN_KEY',    'YCg-Rs_#0ra~FObn)F=^ct)E4Hph(47^~oY[Tb|`YpIOd&$}e`?*Y;}Z 76P>5{5');
define('NONCE_KEY',        '7bmB|~gqSiN0}5uuvHB`.dJC^v,c<v}mAuj C *!<9TS&;hl~~bmn0ffZ+B|mW:|');
define('AUTH_SALT',        '(W{3~4RS502XDL93y%sO@H+~RJp6<w7OA$:df{<6y!akTLcRP`~9s|pR/Ol8cch#');
define('SECURE_AUTH_SALT', '1}KV,eJ-huq4Jg(g0>VxJ#&?IG4gW3i:AhIdWrbQC$9DIwKhdds*&qz;0(XHI./n');
define('LOGGED_IN_SALT',   'XO+L~#}!fS{CZ#yllp/LV{wQ[@@F()exL?=g|pQ+/<`WFNZWIPvL<d8SA^nj2Tv4');
define('NONCE_SALT',       'j&x KX3o[.mH_ G.Iy)uvk{*na^Atd?)&O%ne7SuwxO2_CPW?8Re|T+v#_yuq9j|');

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
