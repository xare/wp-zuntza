<?php

/**
 * @package Zuntza
 */

namespace Inc\Zuntza\Base;

 class Activate {
  public static function activate() {
    flush_rewrite_rules();

    $default = [];

    if ( !get_option('zuntza')) {
      update_option('zuntza', $default);
    }
    $upload_dir = wp_upload_dir();
    $zuntza_dir = $upload_dir['basedir'] . '/zuntza';

    if (!file_exists($zuntza_dir)) {
        wp_mkdir_p($zuntza_dir);
    }

  }
 }