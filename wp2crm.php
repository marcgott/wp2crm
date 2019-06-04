<?php
/*
  Plugin Name: Business Brokers CRM Integration for WordPress
  Plugin URI: http://businessbrokerscrm.com
  Description: integration plugin for the BusinessBrokersCRM platform
  Version: 1.0
  Author: BusinessBrokersCRM
  Author URI: http://businessbrokerscrm.com
  Text Domain: wp2crm
*/

global $wp_query,$wp2crm_option,$pagetitle;
include_once ("_auth.php");
include_once ("functions-wp2crm_wp.php");
include_once ("functions-wp2crm_shortcode.php");
include_once ("functions-wp2crm_search.php");
include_once ("functions-wp2crm_api.php");
include_once ("class.plugintemplates.php");
include_once ("options-wp2crm.php");

show_admin_bar(false);
$wp2crm_option = get_option( 'wp2crm_settings' );

function wp2crm_load_textdomain() {
	load_plugin_textdomain( 'wp2crm', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' ); 
}
add_action( 'plugins_loaded', 'wp2crm_load_textdomain' );

function wp2crm_set_wp_title(){
global $pagetitle;
apply_filters( 'pre_get_document_title', "title". $pagetitle );
}
//add_action('init','wp2crm_set_wp_title');
//add_filter( 'pre_get_document_title', "title". $pagetitle );

/*
Enqueues Plugin Scripts and Styles
*/
function wp2crm_enqueue_scripts(){
	wp_enqueue_script('my_script',plugin_dir_url(__FILE__)."js/lib.js", array('jquery'), '1.0.0');
	wp_enqueue_script('web-tracker',get_bloginfo('url').'/crm/webTracker.php');
	wp_enqueue_style('wp2crm',plugin_dir_url(__FILE__)."css/style.css");
	wp_enqueue_style('font-awesome',plugin_dir_url(__FILE__)."css/font-awesome/css/font-awesome.css");
	wp_enqueue_style('wp2crmwp',plugin_dir_url(__FILE__)."css/wp_properties.css");
 	wp_register_script( 'jquery-form', '/wp-includes/js/jquery/jquery.form.js', array('jquery') );
	wp_enqueue_style('wp2crmtheme',plugin_dir_url(__FILE__)."css/style-themecolors.css");
}
add_action( 'wp_enqueue_scripts', 'wp2crm_enqueue_scripts' );

function wp2crm_set_listing_meta(){
	global $wp_query,$listing,$listingtags;

	$is_listing = get_query_var('listing');
	if($is_listing){
		$html = '<meta name="Keywords" content="'.join(',',$listingtags).'" />'.'<meta name="Description" content="'.$listing->description.'" />';
		$title = $listing->c_name_generic_c;
     }
}
?>
