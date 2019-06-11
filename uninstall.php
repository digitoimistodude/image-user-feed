<?php

// If uninstall not called from WordPress, then exit.
if( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit;

delete_transient( 'dude_img_userfeed_insta' );
