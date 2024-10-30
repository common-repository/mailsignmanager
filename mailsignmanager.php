<?php
/**
 * @package MailSignManager
 * @version 0.81
 */
/*
Plugin Name: MailSignManager
Plugin URI:
Description: A manager of mail signature
Version: 0.81
Author: sGendrot
Author URI: https://github.com/sgendrot/
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl.html
*/
/*
MailSignManager is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

MailSignManager is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, see https://www.gnu.org/licenses/gpl.html

*/


/**
 * Les inclusions
 */
include_once (plugin_dir_path( __FILE__ ).'/MailSignManager_Global.php');


// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}



// If user is admin
if ( is_admin() ) {
  //Load admin menu
	require_once( MailSignManager_PLUGIN_DIR . 'class.mailsignmanager-admin.php' );

  // Call addMenu function of Class MailSignManager_admin
	add_action( 'admin_menu', array( 'MailSignManager_admin', 'addMenu' ) );

	// Handle AJAX Calling
	add_action( 'wp_ajax_MailSignManagerPlugin_JS_SaveAndPreview', 'MailSignManagerPlugin_Write_InfoJS');

}//fin de if ( is_admin() )


/**
 * Scripts et CSS Files
 */
add_action('admin_enqueue_scripts', 'MailSignManagerPlugin_add_my_stylesheet');
add_action('admin_enqueue_scripts', 'MailSignManagerPlugin_add_my_scriptfiles');


/**
 * Fonction d'ajout des pages de styles pour le plugin MailSignManager
 */
function MailSignManagerPlugin_add_my_stylesheet() {
	$myStyleUrl = plugins_url('MailSignManager-main.css', __FILE__);

	//MailSignManagerPlugin_log_me("myStyleUrl ".$myStyleUrl,__FILE__, 57);

	wp_register_style( 'MailSignManagerPlugin-main-css', $myStyleUrl);
	wp_enqueue_style( 'MailSignManagerPlugin-main-css');
}//fin de function MailSignManager_add_my_stylesheet()


/**
 * Fonction d'ajout des pages JS pour le plugin MailSignManager
 */
function MailSignManagerPlugin_add_my_scriptfiles() {
	$myStyleUrl = plugins_url('MailSignManager-main.js', __FILE__);
	wp_register_script( 'MailSignManagerPlugin-main-js', $myStyleUrl);
	wp_enqueue_script( 'MailSignManagerPlugin-main-js' );
	wp_localize_script('MailSignManagerPlugin-main-js', 'MailSignManagerPlugin_URL', array('pluginsUrl' => plugin_dir_url( __FILE__ )) );

	// Js for media
  wp_enqueue_media();

}//fin de function MailSignManagerPlugin_add_my_scriptfiles()




?>
