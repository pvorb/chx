<?php
require_once 'src/includes.php';

// if this script is requested, return a 404
if (isset($_SERVER['REQUEST_URI']) &&
    $_SERVER['REQUEST_URI'] === $_SERVER['SCRIPT_NAME'])
  error(404);

// get the requested path
$requested_path = get_requested_path();

// extract the base path (without file extension)
$base_path = remove_file_extension($requested_path);

// get the corresponding template path
$tpl_path = 'tpl' . $base_path . '.tpl.php';

// when that template exists, include it (shows contents), otherwise return a
// 404
if (file_exists($tpl_path))
  include $tpl_path;
else
  error(404);
