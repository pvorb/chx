<?php

function error($code) {
  if (!headers_sent())
    header('HTTP/1.1 404 Not Found');
  exit;
}

function str_ends_with($haystack, $needle) {
  return strrpos($haystack, $needle) == (strlen($haystack) - strlen($needle));
}

function str_remove_prefix($str, $prefix) {
  if (substr($str, 0, strlen($prefix)) == $prefix)
    return substr($str, strlen($prefix), strlen($str));
  return $str;
}

function get_snippets($path) {
  global $db;

  $res = $db->query('SELECT `snippet`.`id`, `snippet`.`content` '
      .'FROM `snippet`, `template` '
      .'WHERE `template`.`path` = \''.$path.'\' AND `snippet`.`id` = `template`.`snippet_id`;');

  $result = array();
  while ($row = $res->fetch_assoc())
    $result[$row['id']] = $row['content'];

  $res->free();

  return $result;
}

function get_path_prefix() {
  return dirname($_SERVER['SCRIPT_NAME']);
}

function get_requested_path() {
  $prefix = get_path_prefix();
  $requested_path = '';

  // if REQUEST_URI is not given, assume '/index.html'
  if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] !== $prefix . '/')
    $requested_path = str_remove_prefix($_SERVER['REQUEST_URI'], $prefix);
  else
    $requested_path = '/index.html';

  // for directory requests, append 'index.html'
  if (strrpos($requested_path, '.html') === FALSE)
    $requested_path .= 'index.html';

  return $requested_path;
}

function remove_file_extension($path) {
  $dotpos = strrpos($path, '.');
  return substr($path, 0, $dotpos);
}

function s($id) {
  global $snippets;
  echo $snippets[$id];
}
