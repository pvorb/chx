<?php
// defines some common functions for the backend

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

  $id = $db->real_escape_string($id);
  $query = "SELECT `content` FROM `snippet` WHERE `id` = '$id';";
  $res = $db->query($query);

  if ($res === FALSE)
    return '';

  $row = $res->fetch_row();
  $content = $row[0];

  $res->free();
  return $content;
}

function save_snippet($id, $content) {
  global $db;

  $id = $db->real_escape_string($id);
  $content = $db->real_escape_string($content);

  $query = "INSERT INTO `snippet` ".
      "(`id`, `content`) ".
      "VALUES ('$id', '$content') ".
      "ON DUPLICATE KEY UPDATE `content` = '$content';";
  
  return $db->query($query);
}

function escape_html($html) {
  return htmlspecialchars($html);
}

function capitalize(&$string) {
  $string[0] = strtoupper($string[0]);
  return $string;
}
