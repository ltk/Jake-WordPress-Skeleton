<?php


/**
 * Creates an asset to attach to a style object.  Checks
 * if that file differs from when it was originally saved
 * in the database.
 */

class Asset extends PluginObject {

	public $url;
	public $path;
	public $hash;

	public static $hash_type = "md5";
	

	function __construct( $url, $path, $hash = null ) {
		$this->url  = $url;
		// $this->path = get_template_directory().$this->switch_ds($path);
		$this->path = substr($path, 0, 2) != 'C:' ? get_template_directory() : null;
		$this->path .= $this->switch_ds($path);
		$this->hash = ( empty($hash) ) ? $this->generate_hash() : $hash;
	}




	public function file_has_changed() {
		//	Can this be amended to just $this->hash?  Do we need to generate it here again?
		return ( $this->hash !== $this->generate_hash() && ! is_null($this->hash) ) ? true : false;
	}




	public function generate_hash() {
		if ( !empty($this->path) ) {
			// echo "<pre>" . print_r( 'path: ' . $this->path, true) . "</pre>";
			return hash_file( self::$hash_type, $this->path );
		}
	}

	private function switch_ds( $string ) {
		// return str_replace('\\', DS, str_replace('/', DS, $string));
		return preg_replace('/[\\/]/', DS,  $string);
	}
}

?>