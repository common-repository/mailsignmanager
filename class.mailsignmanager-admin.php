<?php
/**
 * Class pour l'interface d'administration
 *
 */



/**
 * Class which contains the Admin Panel and manage it
 *
 * Mass usage of static to haven't to load Class (create an object)
 */
class MailSignManager_admin
{

  // Local variables
  private static $page_title = "Mail Signature Manager Configuration";
  private static $menu_title = "MailSignManager";
  private static $capability = "manage_options"; // see https://codex.wordpress.org/Roles_and_Capabilities#manage_options
  private static $menu_slug = 'mailsignmanager/MailSignManager-admin-panel.php'; // the page to load
  private static $function = "";
  #private static $icon_url = ; // not yet created

  /**
  * Function init
  */
  public static function init() {


  }// End of public static function init() {

  /**
  * Function which create the Menu
  */
  public static function addMenu() {

    add_menu_page (
      self::$page_title,
      self::$menu_title,
      self::$capability,
      self::$menu_slug,
      self::$function //,
    #  $icon_url, // no icons for the moment
    #  $position // always at the bottom, not important
    );


  }//End of public static function init_Menu_Panel() {

} // End of class MailSignManager_admin


?>
