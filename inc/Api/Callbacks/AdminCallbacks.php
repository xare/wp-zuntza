<?php
/**
 * @package zuntza
 */

 namespace Inc\Zuntza\Api\Callbacks;

use Inc\Zuntza\Base\BaseController;

 class AdminCallbacks extends BaseController {

  public function adminDashboard() {
    return require_once("$this->plugin_templates_path/adminDashboard.php");
  }
  
 }