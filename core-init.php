<?php 
/*
*
*	***** True ROAS *****
*
*	This file initializes all TRUEROAS Core components
*	
*/
// If this file is called directly, abort. //
if ( ! defined( 'WPINC' ) ) {die;} // end if
// Define Our Constants
define('TRUEROAS_CORE_INC',dirname( __FILE__ ).'/assets/inc/');
define('TRUEROAS_CORE_IMG',plugins_url( 'assets/img/', __FILE__ ));
define('TRUEROAS_CORE_CSS',plugins_url( 'assets/css/', __FILE__ ));
define('TRUEROAS_CORE_JS',plugins_url( 'assets/js/', __FILE__ ));
/*
*
*  Register CSS
*
*/
//function trueroas_register_core_css(){
//	wp_enqueue_style('trueroas-core', TRUEROAS_CORE_CSS . 'trueroas-core.css',null,time(),'all');
//};
//add_action( 'wp_enqueue_scripts', 'trueroas_register_core_css' );    
/*
*
*  Register JS/Jquery Ready
*
*/
function trueroas_register_core_js(){
// Register Core Plugin JS	
wp_enqueue_script('trueroas-core', TRUEROAS_CORE_JS . 'trueroas-core.js','jquery',time(),true);
wp_localize_script( 'trueroas-core', 'TrueRoas',
		array(
			'pixelID' => sanitize_text_field(str_replace('www.', '', $_SERVER['HTTP_HOST'])), 
			// 'pixelID' =>sanitize_text_field($_SERVER['HTTP_HOST']),
		)
	);
};
add_action( 'wp_enqueue_scripts', 'trueroas_register_core_js' );    
/*
*
*  Includes
*
*/ 
// Load the Functions
require_once TRUEROAS_CORE_INC . 'trueroas-admin.php';
require_once TRUEROAS_CORE_INC . 'trueroas-core-functions.php';
   