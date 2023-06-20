<?php
/*
Plugin Name: Schedule Maintenance Mode
Description: Enable Maintenance page for any specific interval time or specified by you. 
Author: Geek Code Lab
Version: 1.9
Author URI: https://geekcodelab.com/
*/

if ( ! defined( 'ABSPATH' ) ) exit;
define('SMMGK_BUILD', "1.9");
define('SMMGK_PATH', plugin_dir_path(__FILE__));
define('SMMGK_URL', plugins_url() . '/'.  basename(dirname(__FILE__)));
require_once SMMGK_PATH . 'functions.php';

function smmgk_plugin_add_settings_link( $links ) { 
	$support_link = '<a href="https://geekcodelab.com/contact/"  target="_blank" >' . __( 'Support' ) . '</a>';
	array_unshift( $links, $support_link );

	$settings_link = '<a href="'.admin_url('').'/options-general.php?page=smmgk-schedule-maintenance-mode">' . __( 'Settings' ) . '</a>';
	array_unshift( $links, $settings_link );

	return $links;	
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'smmgk_plugin_add_settings_link');

$smmgk_months=array("01"=>"Jan","02"=>"Feb","03"=>"Mar","04"=>"Apr","05"=>"May","06"=>"Jun","07"=>"Jul","08"=>"Aug","09"=>"Sep","10"=>"Oct","11"=>"Nov","12"=>"Dec");
add_action('admin_menu', 'smmgk_admin_menu_maintenance');
add_action('admin_print_scripts', 'smmgk_admin_scripts');
 add_action('admin_print_styles', 'smmgk_admin_styles');
register_activation_hook( __FILE__ , 'smmgk_schedule_maintenance_plugin_active' );

function smmgk_admin_scripts() {    
   
    if( is_admin() ) {             

	wp_enqueue_script( 'wp-color-picker');
    wp_register_script('smmgk_upload_media_script', SMMGK_URL.'/assets/js/upload_media_script.js', array('jquery','media-upload'), SMMGK_BUILD);
    wp_enqueue_script('smmgk_upload_media_script');
	wp_enqueue_media();
	}
}

function smmgk_admin_styles() {

	if( is_admin() ) {  
	$css= SMMGK_URL. "/assets/css/admin.css";               
    wp_enqueue_style( 'smmgk-main-admin-css', $css, array(), SMMGK_BUILD );
	wp_enqueue_style( 'wp-color-picker');
    // wp_enqueue_style('thickbox');
	}
}

 
//---------------------------------------------------------------//

function smmgk_schedule_maintenance_plugin_active()
{
	$options= smmgk_get_options();
	if(!isset($options['headline']))
	 {
		$options['headline']='Website is under construction';
		update_option('smmgk_schedule_maintenance',$options);
	 }

	 if(!isset($options['maintenance_content']))
	 {
		$options['maintenance_content']="We'll be back with a newly updated website shortly!";
		update_option('smmgk_schedule_maintenance',$options);
	 }
}
function smmgk_enqueue_styles_scripts_schedule_maintenance()
{

   

}

//---------------------------------------------------------------



function smmgk_admin_menu_maintenance() {

	add_options_page('Schedule Maintenance Mode', 'Schedule Maintenance Mode', 'manage_options', 'smmgk-schedule-maintenance-mode', 'smmgk_options_menu_view'  );

}
//---------------------------------------------------------------//

function smmgk_options_menu_view() {

	if (!current_user_can('manage_options'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}
      include( SMMGK_PATH . 'admin/options.php' );
}
add_action('smmgk_start_shedule_maitenance', 'smmgk_start_schedule_event');
add_action('smmgk_end_shedule_maitenance', 'smmgk_end_schedule_event');

function smmgk_start_schedule_event()
{	
	$smmgk_options= smmgk_get_options();
	$smmgk_options['maintenance_mode']=1;
	update_option('smmgk_schedule_maintenance',$smmgk_options);
	
}
function smmgk_end_schedule_event()
{	
	$smmgk_options= smmgk_get_options();
	$smmgk_options['maintenance_mode']=0;
	$smmgk_options['status']=0;
	update_option('smmgk_schedule_maintenance',$smmgk_options);
}// If u want to load a function only in the front end.
add_action( 'template_redirect', 'smmgk_front_end_maintenance');
function smmgk_front_end_maintenance() {
	if(isset($_REQUEST['smmgk_preview']))
	{
		include_once( SMMGK_PATH . 'theme/index.php' );
			 die;
	}
    if ( !is_admin() ) { 		$current_role="";		if ( is_user_logged_in() ) {
		$current_role=wp_get_current_user()->roles[0];		}
		if($current_role!="administrator")
		{
			$smmgk_options= smmgk_get_options();			if(isset($smmgk_options['maintenance_mode']) && $smmgk_options['status'])			{
				if($smmgk_options['maintenance_mode']==1 && $smmgk_options['status']==1)
				{
						include_once( SMMGK_PATH . 'theme/index.php' );
				 die;
				}			}
		}
       
    }
}
?>