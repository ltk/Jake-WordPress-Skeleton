<?php

$wp_dir = dirname(__FILE__) .DIRECTORY_SEPARATOR.'..';

$config_file_path = dirname(__FILE__) .DIRECTORY_SEPARATOR.'config.php';


move_those_files_around( $wp_dir );
change_htaccess_permissions( $wp_dir );

require( $config_file_path );

write_to_command_line("Firing up the ole PHP script...");

run( $wp_dir, $new_database, $mysql, $wordpress_options, $wordpress_admin_user, $pages, $git_options, $domains );


function move_those_files_around( $dir ) {
    move_file( $dir.DIRECTORY_SEPARATOR.'wp', $dir );
    move_file( $dir.DIRECTORY_SEPARATOR.'content', $dir.DIRECTORY_SEPARATOR.'wp-content' );
}

function move_file( $from, $to ) {
    $errors = array();
    $ignore = array(
        '.DS_Store',
        '.',
        '..'
        );
    $files = scandir($from);

    // If there are no files, we're already done!
    if(empty($files)) return true;

    foreach($files as $file){
        if(in_array($file, $ignore)) continue;

        $from_path = $from.DIRECTORY_SEPARATOR.$file;
        $to_path = $to.DIRECTORY_SEPARATOR.$file;

        if(is_dir($from_path)) {
            mkdir($to_path);
            $move_status = move_file($from_path, $to_path);
        } else {
            $move_status = copy($from_path, $to_path);  
        }
        if(!$move_status) array_push($errors, $from_path);
    }

    if($move_status){
       if(is_dir($from)){
           rmdir($from);
       } else {
           unlink($from);
       } 
    }  
    return empty($errors) ? true : false;
}

function change_htaccess_permissions( $dir ){
    chmod($dir.DIRECTORY_SEPARATOR.'.htaccess', 0777);
}

function run( $install_path, $new_database, $mysql, $wordpress_options, $wordpress_admin_user, $pages, $git_options, $domains ) {
  // modify_wp_config( $install_path, $new_database );
  // create_env_loader( $install_path );
  create_dev_env( $install_path, $new_database, $domains );
  setup_mysql_db( $new_database, $mysql );
  install_wordpress( $install_path, $wordpress_options, $wordpress_admin_user );
  add_pages( $pages );
  // push_to_github( $git_options, $install_path );
}

function write_to_command_line( $message ) {
  fwrite(STDOUT, $message . "\n");
}

function connect_to_mysql( $host, $username, $password ) {
  $connection = mysql_connect( $host, $username, $password );

  if( $connection ) {
    write_to_command_line("Connected to MySQL.");
    return $connection;
  } else {
    write_to_command_line("Couldn't connect to MySQL. Check your configuration details.");
    return false;
  }
}

function create_mysql_database( $database_name, $connection ) {
  $query = "CREATE DATABASE `$database_name`;";
  $query_result = mysql_query( $query, $connection );
  
  if( $query_result ) {
    write_to_command_line("Database created.");
    return true;
  } else {
    write_to_command_line("Error creating database: " . mysql_error());
    return false;
  }
}

function create_mysql_user( $username, $password, $connection ) {
  $query = "CREATE USER '$username'@'localhost' IDENTIFIED BY '$password';";
  $query_result = mysql_query( $query, $connection );
  
  if( $query_result ) {
    write_to_command_line("User created.");
    return true;
  } else {
    write_to_command_line("Error creating user: " . mysql_error());
    return false;
  }
}

function grant_db_privileges_to_user( $database_name, $username, $connection ) {
  $query = "GRANT ALL ON `$database_name`.* TO '$username'@'localhost';";
  $query_result = mysql_query( $query, $connection );
  
  if( $query_result ) {
    write_to_command_line("User privileges granted.");
    return true;
  } else {
    write_to_command_line("Error granting user privileges: " . mysql_error());
    return false;
  }
}

function setup_mysql_db( $new_database, $mysql ) {
  $connection = connect_to_mysql( $mysql['host'], $mysql['username'], $mysql['password'] );
	
  if( $connection ) {
    $database_created = create_mysql_database( $new_database['name'], $connection );
    $user_created = create_mysql_user( $new_database['username'], $new_database['password'], $connection );

    if( $database_created && $user_created ) {
      grant_db_privileges_to_user( $new_database['name'], $new_database['username'], $connection );
    }

    mysql_close( $connection );
  } 

	write_to_command_line("MySQL setup complete.");
}

function curl_get_file_contents($URL) {
	$c = curl_init();
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($c, CURLOPT_URL, $URL);
	$contents = curl_exec($c);
	curl_close($c);
	if ($contents) return $contents;
	else return false;
}

function replace_keys_and_salts( $wpconfig ) {
	
	$keys = file_get_contents("https://api.wordpress.org/secret-key/1.1/salt/");
	$start = strpos($wpconfig, "define('AUTH_KEY'");
	$search = substr($wpconfig, $start, 479);
	$wpconfig = str_replace($search, $keys, $wpconfig);

	return $wpconfig;

}

function replace_default_db_info( $wpconfig, $new_database ) {
	if ( ! empty( $new_database['name'] ) ) $wpconfig = str_replace("define('DB_NAME', 'database_name_here');", "require_once('environment/load_environment.php');\ndefine('DB_NAME', \$_ENV[\"DB_NAME\"]);", $wpconfig);
	if (!empty($new_database['username'])) $wpconfig = str_replace("define('DB_USER', 'username_here');", "define('DB_USER', \$_ENV[\"DB_USER\"]);", $wpconfig);
	if (!empty($new_database['password'])) $wpconfig = str_replace("define('DB_PASSWORD', 'password_here');", "define('DB_PASSWORD', \$_ENV[\"DB_PASSWORD\"]);", $wpconfig);
	if (!empty($new_database['host'])) $wpconfig = str_replace("define('DB_HOST', 'localhost');", "define('DB_HOST', \$_ENV[\"DB_HOST\"]);", $wpconfig);
	if (!empty($new_database['prefix'])) $wpconfig = str_replace("\$table_prefix  = 'wp_';", "\$table_prefix  = '{$new_database['prefix']}';", $wpconfig);

	return $wpconfig;
}

function modify_wp_config( $wp_dir, $new_database ) {
	if ( file_exists( "$wp_dir/wp-config-sample.php" ) && !file_exists( "$wp_dir/wp-config.php" ) ) {
		$wpconfig = file_get_contents("$wp_dir/wp-config-sample.php");
		$wpconfig = replace_keys_and_salts( replace_default_db_info( $wpconfig, $new_database ) );

		$file = fopen("$wp_dir/wp-config.php", "wb");
		fwrite($file, $wpconfig);
		fclose($file);
		write_to_command_line("wp-config.php successfully configured. Woo hoo.");
	} else if( file_exists( "$wp_dir/wp-config.php" ) ) {
		write_to_command_line("You already have a wp-config.php\nWe're gonna stick with your existing configuration.");
	} else {
		write_to_command_line("We can't find your wp-config-sample.php\nAbort the mission! Abort!");
	}
}

/*
function create_env_loader( $wp_dir ) {
	if ( ! file_exists( "$wp_dir/environment/load_environment.php" ) ) {
		$file_handle = fopen( "$wp_dir/environment/load_environment.php", "wb" );
		$env_loader = '<?php
if(file_exists(__DIR__ . "/production_env.php")) {
	require_once(__DIR__ . "/production_env.php");
} elseif(file_exists(__DIR__ . "/staging_env.php")) {
	require_once(__DIR__ . "/staging_env.php");
} elseif(is_file(__DIR__ . "/development_env.php")) {
	require_once(__DIR__ . "/development_env.php");
} elseif(is_file("../../config/wordpress/production_env.php")) {
	require_once("../../config/wordpress/production_env.php");
} elseif(is_file("../../config/wordpress/staging_env.php")) {
	require_once("../../config/wordpress/staging_env.php");
} elseif(is_file("../../config/wordpress/development_env.php")) {
	require_once("../../config/wordpress/development_env.php");
} else {
	die("Sorry! We\'re busy making this site better. We\'ll be back online shortly. (No environment could be loaded.)");
}	
?>';
		fwrite($file_handle, $env_loader);
		fclose($file_handle);
		write_to_command_line("Environment loader created.");
	}
}
*/

function create_dev_env( $wp_dir, $new_database, $domains ) {
	if ( ! file_exists( "$wp_dir/environment/development_env.php" ) ) {
		$file_handle = fopen( "$wp_dir/environment/development_env.php", "wb" );
		$dev_env = '<?php
// Local DB
$_ENV["DB_USER"] = "' . $new_database['username'] . '";
$_ENV["DB_PASSWORD"] = "' . $new_database['password'] . '";
$_ENV["DB_NAME"] = "' . $new_database['name'] . '";
$_ENV["TABLE_PREFIX"] = "' . $new_database['prefix'] . '";
$_ENV["DB_HOST"] = "' . $new_database['host'] . '";
$_ENV["WP_DEBUG"] = true;
$_ENV["LOCAL_DOMAIN"] = "' .  $domains['local'] . '";
$_ENV["REMOTE_DOMAIN"] = "' .  $domains['remote'] . '";
?>';
		fwrite($file_handle, $dev_env);
		fclose($file_handle);
		write_to_command_line("Development environment created.");
	}
}
function after_wordpress_install_buffer( $buffer ) {
	$success = preg_match('/Success/', $buffer );

	if( $success === 1 ){ 
		write_to_command_line("Install Successful!");

		write_to_command_line("Upgrading WordPress database.");
		$upgraded = wp_upgrade();

		if( $upgraded ) {
			write_to_command_line("WordPress database upgraded.");
		} else {
			write_to_command_line("WordPress database NOT upgraded.");
		}

		// Delete default posts
		wp_delete_post( 1, true );
		wp_delete_post( 2, true );

		// Redirect to wp-admin
        // 
        $admin_url = home_url() . '/wp-admin/';
        exec("open $admin_url;");
	} else {
		$errors = array();
		preg_match( '/<p class="message"><strong>ERROR<\/strong>:(.*)<\/p>/', $buffer, $errors );
		write_to_command_line("WordPress installation failed with the following error:");
		write_to_command_line( trim( $errors[1] ) );
	}
}

function install_wordpress( $install_path, $wordpress_options, $wordpress_admin_user ) {
	$install_file_path = $install_path . "/wp-admin/install.php";
	$_GET['step'] = 2; // Spoofing form submission

	$_POST = array(
		'weblog_title' => $wordpress_options['title'],
		'blog_public' => $wordpress_options['allow_search_engines'],
		'admin_password' => $wordpress_admin_user['password'],
		'admin_password2' => $wordpress_admin_user['password'],
		'admin_email' => $wordpress_admin_user['email'],
		'user_name' => $wordpress_admin_user['username'],
		);
	define( 'WP_SITEURL', $wordpress_options['url'] );
	write_to_command_line("Installing WordPress...");

	ob_start( "after_wordpress_install_buffer" );
	require( $install_file_path );
	ob_end_flush();

	update_option( 'db_version', $wp_db_version );
	update_option( 'db_upgraded',  true );

}

function add_pages( $pages, $parent_post_id = null ) {
	// $errors = array();

	foreach( $pages as $page_index => $page_info ) {
		$page_id = add_page( $page_info, $parent_post_id );

		if( $page_id ) {
			if( isset($page_info['child_pages'] ) ) {
				add_pages( $page_info['child_pages'], $page_id );
			}

			page_added_message( $page_info['post_title'], $page_id );
		} else {
			page_add_error_message( $page_info['post_title'] );
		}
	}

	return empty( $errors ) ? true : $errors;
	
}
function page_added_message( $page_title, $page_id ) {
	write_to_command_line("Page titled: '$page_title' added with Post ID = $page_id");
}

function page_add_error_message( $page_title ) {
	write_to_command_line("Page titled: '$page_title' failed to be added to WordPress!");
}

function add_page( $page, $parent_post_id = null ) {
	unset( $page['child_pages'] );
	$defaults = array(
		"post_title" => "Lorem Ipsum",
		"post_content" => "[lipsum]",
		"post_type" => "page",
		"post_status" => "publish",
		"post_date" => date('Y-m-d H:i:s'),
		"post_author" => 1
	);

	$page_info = wp_parse_args( $page, $defaults );
	if( $parent_post_id )
		$page_info["post_parent"] = $parent_post_id;

	return wp_insert_post($page_info);
}
/*
function push_to_github( $git_options, $install_path ) {
	if( isset( $git_options['remote'] ) ) {
		$output = array();
		# move to the right dir first
		exec("git remote add origin {$git_options['remote']}", $output);
		exec("git push -u origin master", $output);
		# add error detection and handling
		write_to_command_line( "Repository pushed to GitHub" );
	} else {
		write_to_command_line( "Repository not pushed to GitHub: no repo defined in config file." );
	}
}
*/
?>
