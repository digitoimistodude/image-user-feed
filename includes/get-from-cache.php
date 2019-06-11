<?php

if( !defined( 'ABSPATH' )  )
	exit();

Class Dude_Img_Userfeed_Get_From_Cache extends Dude_Img_Userfeed {

	private static $_instance = null;

	public static function instance() {
		if( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	} // end function instance

	public static function get_raw( $username = null ) {
    if ( empty( $username ) ) {
      $settings = get_option( 'dude-img-userfeed' );
      $username = strtolower( $settings['username'] );
    }

    $count = apply_filters( 'dude_img_userfeed_insta_count', 10 );
    $count = apply_filters( "dude_img_userfeed_insta_count_{$username}", $count );

		$insta = get_transient( "dude_userfeed_insta_{$username}|{$count}" );

	  if ( ! $insta ) {
	    $insta = Dude_Img_Userfeed_Fetch_Instagram::do_fetch( $username );
	  }

		return $insta;
	} // end function get_raw

	public static function get_thumbnails( $username = null ) {
		$images = self::get_raw( $username );

		ob_start();

		foreach ( $images as $image ) {
			echo "<img src='$image->thumbnail_src' alt='$image->caption' />";
    }

		return ob_get_clean();
	} // end function get_thumbnails
} // end class Dude_Img_Userfeed_Get_From_Cache
