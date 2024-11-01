<?php 
/*
Plugin Name: TrueROAS
Plugin URI: https://www.trueroas.io/
Description: There is a new way to track your ads.
Gain an extreme advantage by leveraging true data.
Version: 3.1
Author: TrueROAS
Author URI: https://trueroas.io
Text Domain: trueroas
Icon: assets/icon.svg
*/

// If this file is called directly, abort. //
if ( ! defined( 'WPINC' ) ) {die;} // end if

function trueroas_activation_redirect( $plugin ) {
    if( $plugin == plugin_basename( __FILE__ ) ) {
        exit( wp_redirect( admin_url( 'admin.php?page=trueroas' ) ) );
    }
}
add_action( 'activated_plugin', 'trueroas_activation_redirect' );

// Let's Initialize Everything
if ( file_exists( plugin_dir_path( __FILE__ ) . 'core-init.php' ) ) {
require_once( plugin_dir_path( __FILE__ ) . 'core-init.php' );
}