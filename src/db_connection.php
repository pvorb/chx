<?php
// gets a database-connection

$db = new mysqli(CONF_DB_HOST, CONF_DB_USER, CONF_DB_PWD, CONF_DB_NAME);

if ($db->connect_errno) {
  echo 'Failed to connect to MySQL: (' . $db->connect_errno . ') ' . $db->connect_error;
  
  // TODO probably send a warning e-mail to the server admin
}

