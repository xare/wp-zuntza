<?php

/**
 * @package Zuntza
 */
namespace Inc\Zuntza\Base;

 class Deactivate {
  public static function deactivate() {
    flush_rewrite_rules();
  }
 }