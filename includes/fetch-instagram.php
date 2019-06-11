<?php

if( !defined( 'ABSPATH' )  )
	exit();

Class Dude_Img_Userfeed_Fetch_Instagram extends Dude_Img_Userfeed {

	private static $_instance = null;

	public static function instance() {
		if( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	} // end function instance

	public static function do_fetch( $username = null ) {
    if ( empty( $username ) ) {
      $settings = get_option( 'dude-img-userfeed' );
      $username = strtolower( $settings['username'] );
    }

		if ( empty( $username ) ) {
			return false;
    }

    $count = apply_filters( 'dude_img_userfeed_insta_count', 10 );
    $count = apply_filters( "dude_img_userfeed_insta_count_{$username}", $count );

		$url = "https://www.instagram.com/{$username}/?__a=1";
   	$output = json_decode( file_get_contents( $url ) );
    $insta = $output->graphql->user->edge_owner_to_timeline_media->edges;

		if ( empty( $insta ) ) {
			return false;
    }

		$real_insta = array();
		$insta = array_slice( $insta, 0, $count );

		/**
		 *  Get only the details we really need.
		 */
		foreach ( $insta as $insta_post_key => $insta_post ) {
			$real_insta[ $insta_post_key ] = new \stdClass();
			$real_insta[ $insta_post_key ]->thumbnail_src = $insta_post->node->thumbnail_src;
			$real_insta[ $insta_post_key ]->display_url = $insta_post->node->display_url;
			$real_insta[ $insta_post_key ]->caption = $insta_post->node->edge_media_to_caption->edges{0}->node->text;
			$real_insta[ $insta_post_key ]->likes = $insta_post->node->edge_liked_by;
			$real_insta[ $insta_post_key ]->comments = $insta_post->node->edge_media_to_comment;
			$real_insta[ $insta_post_key ]->code = $insta_post->node->shortcode;
		}

		$insta = $real_insta;

		$return = set_transient( "dude_userfeed_insta_{$username}|{$count}", $insta, apply_filters( 'dude_img_userfeed_insta_transient_lifetime', 5 * MINUTE_IN_SECONDS ) );

		if ( $return ) {
			$option = get_option( 'dude-img-userfeed' );
			$option['last_fetch_insta'] = current_time( 'Y-m-d H:i:s' );
			update_option( 'dude-img-userfeed', $option );
		}

		return $insta;
	} // end function do_fetch
} // end class Dude_Img_Userfeed_Admin_Settings_Page
