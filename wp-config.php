<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
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
define('DB_NAME', 'ouwehaven');

/** MySQL database username */
define('DB_USER', 'ouwehaven');

/** MySQL database password */
define('DB_PASSWORD', '8UcYeurzZ2qDLDYsFzaFNbY6');

/** MySQL hostname */
define('DB_HOST', 'clowting.me');

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
define('AUTH_KEY',         'It_9$m`,vt> gG&=xo/;-&t8)]hdN#OHxb<79W [iY[)zagB?BTp*$1gN-(4s|)*');
define('SECURE_AUTH_KEY',  '~4@U3vY4b|kyI;%zg.-!PjC(p-<zI+_,5RpSW:zAOXE!+v!`ia):XRm.5IrN%}1C');
define('LOGGED_IN_KEY',    'Fp_+X)zq|0|%Df,LT#?k_X|/0cbNv8J<QF%$ VhE-?P|`ecyzTO:cGG0cm;sU-z6');
define('NONCE_KEY',        'U,KJieY1dE-&0(v+D)7eCL[7c>B_~fbFB*OUcJ~Xlg^9W,JFGT*t+>+1Kju>2@#r');
define('AUTH_SALT',        ':cvJ|{%lWee#?Y{~<++GOd|77`*yC2?A(VCK5*e=l4]?CPcwtL )va0$zsk]61N%');
define('SECURE_AUTH_SALT', 'Yp#:a+]02|fyMk YEuMC{^|+*R%!|hSd-R|ZMdh9n~KP[J-x%|2?TKu9)ZW;v7.P');
define('LOGGED_IN_SALT',   'P~kT@{)iW71owlY.w@o_TMtn]mu.9{Zq.YnXw,P-+k6=&(taWNxjGXy e54B*#Fm');
define('NONCE_SALT',       '~-ZJj>kuvsXb9+ttT_=8|5|6H.V1QXf:UD[xkmU6v-~}CJ]<xV++!dz(]])l%?]6');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'oh_';

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
