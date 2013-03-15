<?php
require_once '../conf.php';

// 
function is_logged_in() {
  return false;
}

// check for session id and then for cookie session
if (!$_SESSION['session_id']) {

}

// if not logged in,
