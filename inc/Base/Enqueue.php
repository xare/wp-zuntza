<?php

/**
 * @package zuntza
 */

 namespace Inc\Zuntza\Base;
use Inc\Zuntza\Base\BaseController;
class Enqueue extends BaseController {
  public function register(){
    add_action ( 'admin_enqueue_scripts', [$this, 'enqueue_admin']);
    add_action ( 'wp_enqueue_scripts', [$this, 'enqueue']);
  }
function enqueue() {
        //enqueue all our scripts
        wp_enqueue_style('ZuntzaStyle', $this->plugin_url . 'dist/css/zuntza.min.css');
        wp_enqueue_script('ZuntzaScript', $this->plugin_url . 'dist/js/zuntza.min.js',[]);
        wp_localize_script( 'ZuntzaScript', 'ajaxObject', ['ajaxUrl' => admin_url( 'admin-ajax.php' )]);
      }
  function enqueue_admin() {
        wp_enqueue_script('media_upload');
        wp_enqueue_media();
        // enqueue all our scripts
        wp_enqueue_style('ZuntzaAdminStyle', $this->plugin_url .'dist/css/zuntzaAdmin.min.css');
        wp_enqueue_script('ZuntzaAdminScript', $this->plugin_url .'dist/js/zuntzaAdmin.min.js');
      }
}