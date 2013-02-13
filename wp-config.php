<?php
// ===================================================
// Load database info and local development parameters
// ===================================================
require_once(dirname( __FILE__ ) . '/environment/load_environment.php');
define('DB_NAME', $_ENV["DB_NAME"]);
define('DB_USER', $_ENV["DB_USER"]);
define('DB_PASSWORD', $_ENV["DB_PASSWORD"]);
define('DB_HOST', $_ENV["DB_HOST"]);
$table_prefix  = $_ENV["TABLE_PREFIX"];
define('WP_DEBUG', $_ENV["WP_DEBUG"]);
$bool_to_int = $_ENV["WP_DEBUG"] ? 1 : 0;
ini_set( 'display_errors', $bool_to_int );
define( 'WP_DEBUG_DISPLAY', $_ENV["WP_DEBUG"] );
define( 'WP_LOCAL_DEV', $_ENV["WP_DEBUG"] );
define( 'SAVEQUERIES', $_ENV["WP_DEBUG"] );

// ========================
// Custom Content Directory
// ========================
// define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/content' );
// define( 'WP_CONTENT_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/content' );

// Alternatively these could be defined in the DB
// define('WP_SITEURL', 'http://' . $_ENV['LOCAL_DOMAIN'] . '/wp');
// define('WP_HOME', 'http://' . $_ENV['LOCAL_DOMAIN']);

// ================================================
// You almost certainly do not want to change these
// ================================================
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

// ==============================================================
// Salts, for security
// Grab these from: https://api.wordpress.org/secret-key/1.1/salt
// ==============================================================
define( 'AUTH_KEY',         'put your unique phrase here' );
define( 'SECURE_AUTH_KEY',  'put your unique phrase here' );
define( 'LOGGED_IN_KEY',    'put your unique phrase here' );
define( 'NONCE_KEY',        'put your unique phrase here' );
define( 'AUTH_SALT',        'put your unique phrase here' );
define( 'SECURE_AUTH_SALT', 'put your unique phrase here' );
define( 'LOGGED_IN_SALT',   'put your unique phrase here' );
define( 'NONCE_SALT',       'put your unique phrase here' );

// ================================
// Language
// Leave blank for American English
// ================================
define( 'WPLANG', '' );

// ===================
// Bootstrap WordPress
// ===================
if ( !defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/wp/' );
require_once( ABSPATH . 'wp-settings.php' );
