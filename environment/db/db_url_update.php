<?php
require_once( dirname( __FILE__ ) . '/../load_environment.php');

$new_url = $_ENV["REMOTE_DOMAIN"];
$old_url = $_ENV["LOCAL_DOMAIN"];
$old_sql_file = dirname( __FILE__ ) . DIRECTORY_SEPERATOR . 'db_dump.sql';
$new_sql_file = dirname( __FILE__ ) . DIRECTORY_SEPERATOR . 'db_dump_remote.sql';


$url_diff = strlen($new_url) - strlen($old_url); 
$regex_old_url = str_replace('.', '\.', $old_url);
$data = file_get_contents( $old_sql_file );
$normal_count = 0;
$serialized_array_count = 0;

echo "Modifying SQL file... \n";
echo "Replacing $old_url with $new_url \n";

function replace_string_length( $matches ){
    global $url_diff;
    echo "Replacing: s:" . $matches[1] . ":\n";
    echo "With: " . "s:" . (intval($matches[1]) + $url_diff) . ":\n";
    return str_replace("s:" . $matches[1] . ":", "s:" . (intval($matches[1]) + $url_diff) . ":", $matches[0]);
}

$data = preg_replace_callback( '/s:([\d]+):\\\"[^"]*http:\/\/' . $regex_old_url . '[^"]*\\\"/', "replace_string_length", $data, -1, $serialized_array_count );
echo $serialized_array_count . " replacements made in serialized arrays.\n";


$data = preg_replace( '/http:\/\/' . $regex_old_url . '/', 'http://' . $new_url, $data, -1, $normal_count );
echo $normal_count . " normal replacements made.\n";

echo "Writing modified SQL to disk.\n";
$write_status = file_put_contents( $new_sql_file, $data );

if( $write_status !== false ) {
    echo "SQL file successfully modified.\n";
} else {
    echo "SQL file modification failed.\n";
}