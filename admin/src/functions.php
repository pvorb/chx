<?php
function translate($key) {
  global $l10n;

  echo $l10n[$key];
}

function get_all_snippet_ids() {
  global $db;

  $res = $db->query('SELECT `id` FROM `snippet` ORDER BY `id` ASC;');

  if ($res === FALSE)
    return array();

  $result = array();
  while ($row = $res->fetch_row())
    $result[] = $row[0];

  $res->free();
  return $result;
}

function get_snippet_by_id($id) {
  global $db;

  $query = "SELECT `content` FROM `snippet` WHERE `id` = '$id';";
  $res = $db->query($query);

  if ($res === FALSE)
    return '';

  $row = $res->fetch_row();
  $content = $row[0];

  $res->free();
  return $content;
}

function escape_html($html) {
  $html = str_replace('<', '&lt;', $html);
  $html = str_replace('>', '&gt;', $html);
  return $html;
}

function capitalize(&$string) {
  $string[0] = strtoupper($string[0]);
  return $string;
}
