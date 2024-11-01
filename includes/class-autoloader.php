<?php

namespace Stellenanzeigen;

if (!defined('ABSPATH')) exit;

/**
 * Autoloader class
 * Injects the correct Classes and functions into the Code
 */
class Autoloader
{

  public function register()
  {
    spl_autoload_register(function ($class) {
      $prefix   = __NAMESPACE__ . '\\';
      $base_dir = STELLENANZEIGENE_PATH;

      $len = strlen($prefix);

      if (strncmp($prefix, $class, $len) !== 0) return;

      $relative_file_path = str_replace('\\', '/', substr($class, $len));
      $path_as_array = explode('/', $relative_file_path);
      $file = end($path_as_array);
      $directoryPath = strtolower(implode("/", array_slice(explode('/', $relative_file_path), 0, -1)));
      $file_snake_case = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $file));
      $file_path = $base_dir . $file . '.php';
      $class_file_path = $base_dir . $directoryPath . '/' . 'class-' . $file_snake_case . '.php';


      if (file_exists($class_file_path)) require $class_file_path;
      if (file_exists($file_path)) require $file_path;
    });
  }
}
