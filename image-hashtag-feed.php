<?php
/**
 *
 * Plugin Name:       Image user feed
 * Plugin URI:        https://github.com/digitoimistodude/image-username-feed
 * Description:       Get Instagram user feeds by bypassing the API.
 * Version:           1.0.0
 * Author:            Digitoimisto Dude Oy, Timi Wahalahti
 * Author URI:        https://www.dude.fi
 * GitHub Plugin URI: digitoimistodude/image-username-feed
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if( !defined( 'ABSPATH' )  )
	exit();


Class Dude_Img_Userfeed {

  private static $_instance = null;
  protected $plugin_path;

  public function __construct() {
    $this->plugin_path = plugin_dir_path( __FILE__ );

    add_action( 'init', array( $this, 'load_depencies' ) );
		add_action( 'init', array( 'Dude_Img_Userfeed_Admin_Settings_Page', 'instance' ) );
		add_action( 'init', array( 'Dude_Img_Userfeed_Fetch_Instagram', 'instance' ) );
  } // end function __construct

  public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'dude-img-userfeed' ) );
	} // end function __clone

  public function __wakeup() {
    _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'dude-img-userfeed' ) );
  } // end function __wakeup

  public static function instance() {
    if( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }

    return self::$_instance;
  } // end function instance

  public function load_depencies() {
    require_once( $this->plugin_path.'/libraries/simple-admin-pages/simple-admin-pages.php' );
		require_once( $this->plugin_path.'/includes/admin/settings-page.php' );
		require_once( $this->plugin_path.'/includes/fetch-instagram.php' );
		require_once( $this->plugin_path.'/includes/get-from-cache.php' );
  } // end function load_depencies
} // end class Dude_Img_Userfeed

$plugin = new Dude_Img_Userfeed();

if( !function_exists( 'get_the_dude_img_userfeed_raw' ) ) {
	function get_the_dude_img_userfeed_raw( $username = null ) {
		return Dude_Img_Userfeed_Get_From_Cache::get_raw( $username );
	} // end function dude_img_userfeed_get_raw
}

if( !function_exists( 'get_the_dude_img_userfeed_thumbnails' ) ) {
	function get_the_dude_img_userfeed_thumbnails( $username = null ) {
		return Dude_Img_Userfeed_Get_From_Cache::get_thumbnails( $username );
	} // end function dude_img_userfeed_thumbnails
}

if( !function_exists( 'the_dude_img_userfeed_thumbnails' ) ) {
	function the_dude_img_userfeed_thumbnails( $username = null ) {
		echo Dude_Img_Userfeed_Get_From_Cache::get_thumbnails( $username );
	} // end function dude_img_userfeed_thumbnails
}
