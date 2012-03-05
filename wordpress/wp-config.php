<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '&f9=?|yr6xgc>gNd-qyWg{FNoiH&d)~7}EHI5zm;k@ gHO~x_,H6v9xns`OSMHJZ');
define('SECURE_AUTH_KEY',  ';73YnUEF-I#Fx9Kt1Q!C8E-W2YkV%X,,dN20on,CjIY$s$dSWe31zcY16z-w*h?W');
define('LOGGED_IN_KEY',    '7_<CQn8|{GJ Y]2-a> )>w8#,3x%Nb-5MHa)zJjI^PWLZ,{_^n}SZD=j:|M;w2mD');
define('NONCE_KEY',        'Y2e2otMs/A)%grM&P4JkkK-J|5h({>`6]FqB#D6Nlaq?Z(k3S$Est+,Sxfq=@3~~');
define('AUTH_SALT',        '@U9-X1%F:QM:7zsm#tc-p5-_<s5ItT~{%6TRpf(p%v7BRWwpw~#7@/]Y{/9/Y)4U');
define('SECURE_AUTH_SALT', 'n <_$)yrazc.J1o-bGB5fPTa^exK-kfM;x(sk&F}>-;GvLmqI~c-jrIB(Xp.we1/');
define('LOGGED_IN_SALT',   'c5DgjN(7cOZd[rPfJf+;R/F*)4R8ke?{u-|!$#- t(@R7]W].@2-GOs.#p/dMY6N');
define('NONCE_SALT',       '4g~elbz>G;l{SI0Zh=T~L3|#^Rx9y BVA|)wsspV+~{J|M$ev/lTJjDjSU*YYV|e');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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
