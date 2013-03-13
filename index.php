<?php

require_once 'src/includes.php';

if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] === $_SERVER['SCRIPT_NAME'])
  error(404);

$requested_path = get_requested_path();

// query html snippets
$snippets = get_snippets($db, $requested_path);

$base_path = remove_file_extension($requested_path);

$tpl_path = 'tpl' . $base_path . '.tpl.php';
if (file_exists($tpl_path))
  include $tpl_path;
else
  error(404);
