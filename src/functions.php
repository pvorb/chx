<?php
// defines some common functions for the frontend

// define global $missing_snippets array
$missing_snippets = array();

/**
 * Sets an error code.
 * 
 * TODO improve
 *
 * @param int $code
 */
function error($code) {
  if (!headers_sent())
    header('HTTP/1.1 404 Not Found');
  exit;
}

/**
 * Checks whether a string ends with a suffix
 *
 * @param string $str
 * @param string $suffix
 * @return boolean
 */
function str_ends_with($str, $suffix) {
  return strrpos($str, $suffix) == (strlen($str) - strlen($suffix));
}

/**
 * Removes a prefix from a string.
 *
 * @param string $str
 * @param string $prefix
 * @return string
 */
function str_remove_prefix($str, $prefix) {
  if (substr($str, 0, strlen($prefix)) == $prefix)
    return substr($str, strlen($prefix), strlen($str));
  return $str;
}

// TODO strange behavior: __dir__ needed?
require_once __dir__.'/../lib/php-markdown/markdown.php';

/**
 * Turns markdown into HTML.
 *
 * @param string $md
 */
function md2html($md) {
  return Markdown($md);
}


/**
 * Gets all snippets for a given path.
 *
 * @param string $path
 * @return array snippets as an associative array (id -> content)
 */
function get_snippets($path) {
  global $db;

  $path = $db->real_escape_string($path);

  $res = $db->query(
      "SELECT `snippet`.`id`, `snippet`.`content` ".
      "FROM `snippet`, `template` ".
      "WHERE `template`.`path` = '$path' AND `snippet`.`id` = `template`.`snippet_id`;"
  );

  $result = array();
  while ($row = $res->fetch_assoc())
    $result[$row['id']] = $row['content'];

  $res->free();

  return $result;
}

/**
 * Gets the prefix of the requested path.
 *
 * @return string
 */
function get_path_prefix() {
  return dirname($_SERVER['SCRIPT_NAME']);
}

/**
 * Determines and returns the requested path.
 *
 * @return string
 */
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

/**
 * Removes the file extension from a path.
 *
 * @param string $path
 * @return string
 */
function remove_file_extension($path) {
  $dotpos = strrpos($path, '.');
  return substr($path, 0, $dotpos);
}

/**
 * Adds a snippet to $missing_snippets and inserts a reference in db table
 * 'template'.
 *
 * @param string $id
 */
function add_missing_snippet($id, $plain) {
  global $db;
  global $missing_snippets;
  global $requested_path;

  $missing_snippets[] = array($id, $plain);
  $id = $db->real_escape_string($id);
  $requested_path = $db->real_escape_string($requested_path);

  $db->query(
      "INSERT INTO `template` (`snippet_id`, `path`) ".
      "VALUES ('$id', '$requested_path');"
  );
}

/**
 * Inserts dummy text into table 'snippet' for every missing snippet.
 */
function create_missing_snippets() {
  global $db;
  global $missing_snippets;

  // do nothing if there are no missing snippets
  if (sizeof($missing_snippets) == 0)
    return;

  $len = sizeof($missing_snippets);
  for ($i = 0; $i < $len; $i++) {
    $snippet = $missing_snippets[$i];
    $id = $snippet[0];
    $plain = $snippet[1] ? '1' : '0';
    echo 'created snippet '.$id;
    $id = $db->real_escape_string($id);
    $db->query(
        "INSERT INTO `snippet` (`id`, `content`, `plain`) ".
        "VALUES ('.$id', '[...]', '$plain');"
    );
  }
}

/**
 * Prints the snippet with $id.
 *
 * @param string $id
 */
function snippet($id, $plain = false) {
  global $snippets;

  // if the snippet is available, use it
  if (isset($snippets[$id])) {
    // plain snippet, no markdown
    if ($plain)
      echo $snippets[$id];
    //
    else
      echo md2html($snippets[$id]);
  } else {
    add_missing_snippet($id, $plain);
    echo '[...]'; // show default value for a missing snippet
  }
}
