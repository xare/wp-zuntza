<?php
    /*
    Plugin Name: Zuntza a plugin to discover fiber optic availability in the BasqueCountry for WP
    Description: Zuntza plugin for WordPress
    Version: 1.0
    Author: xare
    */

defined( 'ABSPATH' ) or die ( 'Acceso prohibido');

// Require once the Composer Autoload
if( file_exists( dirname( __FILE__).'/vendor/autoload.php' ) ){
  require_once dirname( __FILE__).'/vendor/autoload.php';
}

/**
 * The code that runs during plugin Activation
 *
 * @return void
 */
function activate_zuntza(){
  Inc\Zuntza\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_zuntza');

/**
 * The code that runs during plugin Deactivation
 *
 * @return void
 */
function deactivate_zuntza(){
  Inc\Zuntza\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_zuntza');

if(class_exists( 'Inc\\Zuntza\\Init' )) {
  Inc\Zuntza\Init::register_services();
}