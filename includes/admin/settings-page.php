<?php

if( !defined( 'ABSPATH' )  )
	exit();

Class Dude_Img_Userfeed_Admin_Settings_Page extends Dude_Img_Userfeed {

	private static $_instance = null;

	public function __construct() {
		$this->setup_settings_page();
	} // end function __construct

	public static function instance() {
		if( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	} // end function instance

	private function setup_settings_page() {
		$sap = sap_initialize_library(
      array(
        'version'	=> '2.0',
        'lib_url'	=> plugin_dir_path( dirname( __FILE__ ) ).'/lib/simple-admin-pages/',
      )
    );

    $sap->add_page(
      'options',
      array(
        'id'            => 'dude-img-userfeed',
        'title'         => __( 'Image username feed', 'dude-img-userfeed' ),
        'menu_title'    => __( 'Image username feed', 'dude-img-userfeed' ),
        'capability'    => 'manage_options'
      )
    );

    $sap->add_section(
      'dude-img-userfeed',
      array(
        'id'            => 'dude-img-userfeed-settings',
        'description'   => __( 'Images are stored to transient in favor of caching and reducing page load time. Cache time is five minutes<br />and after that new images are fetched from Instagram when images are needed again.', 'dude-img-userfeed' ),
    	)
    );

    $sap->add_setting(
      'dude-img-userfeed',
      'dude-img-userfeed-settings',
      'text',
      array(
        'id'            => 'username',
        'title'         => __( 'Username', 'dude-img-userfeed' ),
        'description'   => __( 'You can also set this dynamically from the functions.', 'dude-img-userfeed' ),
      )
    );

		$sap->add_setting(
      'dude-img-userfeed',
      'dude-img-userfeed-settings',
      'text',
      array(
        'id'            => 'last_fetch_insta',
        'title'         => __( 'Last fetch was made', 'dude-img-userfeed' ),
      )
    );

    $sap = apply_filters( 'dude_img_userfeed_setup_settings_page', $sap );

    $sap->add_admin_menus();
	} // end function setup_settings_page()
} // end class Dude_Img_Userfeed_Admin_Settings_Page
