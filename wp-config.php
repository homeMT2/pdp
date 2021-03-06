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
define('DB_NAME', 'i3940098_wp4');

/** MySQL database username */
define('DB_USER', 'i3940098_wp1');

/** MySQL database password */
define('DB_PASSWORD', 'W(]8*q~imZn3l*eOGu]87@[4');

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
define('AUTH_KEY',         '3rfsEtVoCm5rxNEXbNsQH6laqDuklgPwKmAeflxVTRO9oZBwl74MSPHwEfHwM9zJ');
define('SECURE_AUTH_KEY',  'g1552RiL9ijWWZi4xQ4BkloYONn4eerCZU3yRqNijea9T9px0X0Yl1n81d8W91fn');
define('LOGGED_IN_KEY',    'c7MfYuJSiDWZl3fnL8J318o0bLKqGAG6kMZ4YBm6wsLDC2cbVVfep2Q07W2plFeD');
define('NONCE_KEY',        'HHHnK3tAmt3TWOghf1e9DBPhzweHAyzTJisNK3vr4DvCTj1OjEAnw7ahDsZ2gDmJ');
define('AUTH_SALT',        'TDJa5pRlwqSfB352MDkl2TbSgLEqnl92qJhG7t8R9atvRQgYsvA1J9UwR9Q5Y7F8');
define('SECURE_AUTH_SALT', '6BHXXadzeB5yCs3m272LPbliKTrowMGw1wZxrb1PQr2Oe2167T1mrXyIHNzgTxQc');
define('LOGGED_IN_SALT',   'HTcS3MaM1Jp7XxapPGNY7xIc3LxByQHNz4T9f4P3jpMvHErH1kldzHzDemQFvVsq');
define('NONCE_SALT',       'S4Jo0C8IbkxCoK2peCjQlZfjeNRTM34iIhaDmQaWc6TgEmUC6etDYsMeLm7iJzHa');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed upstream.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


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
