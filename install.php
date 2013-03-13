<title>chx Installation</title>
<style>
html {
  font-family: sans-serif;
  width: 520px;
}

th {
  text-align: left;
}
</style>
<h1>chx Installation</h1>
<?php

$step = 1;
if (isset($_GET['step']))
  $step = $_GET['step'];

if (file_exists('./src/conf.php') && $step == 1 && !(isset($_GET['force']) && $_GET['force'] == true)):
?>
<p>chx seems to be already intsalled. Are you sure you want to replace the
  existing installation? (May cause loss of data.)</p>
<form method="get" action="/install.php">
  <input type="submit" value="YES" /> <input type="hidden" name="step" value="1" />
  <input type="hidden" name="force" value="true" />
</form>
<?php
die;
endif;

// show steps
switch ($step) {
  case 1:
    ?>
<h2>Step 1: Database connection information</h2>
<form method="POST" action="/install.php?step=2">
  <table>
    <tr>
      <th><label for="db_user">User name</label></th>
      <td><input type="text" id="db_user" name="db_user" value="root" /></td>
    </tr>
    <tr>
      <th><label for="db_pwd">Password</label></th>
      <td><input type="password" id="db_pwd" name="db_pwd" /></td>
    </tr>
    <tr>
      <th><label for="db_host">Host name</label></th>
      <td><input type="text" id="db_host" name="db_host" value="localhost" /></td>
    </tr>
    <tr>
      <th><label for="db_name">Database name</label></th>
      <td><input type="text" id="db_name" name="db_name" value="chx" /></td>
    </tr>
    <tr>
      <th><label for="db_prefix">Database table prefix</label></th>
      <td><input type="text" id="db_prefix" name="db_prefix" value="chx_" /></td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" value="Submit" /></td>
    </tr>
  </table>
</form>
<?php
break;
case 2:
  if (sizeof($_POST) == 0)
    die('<p>Bad request!</p>');

  $db_host = $_POST['db_host'];
  $db_user = $_POST['db_user'];
  $db_pwd = $_POST['db_pwd'];
  $db_name = $_POST['db_name'];
  $db_prefix = $_POST['db_prefix'];

  $conf = "<?php\n";
  $conf .= "define('CONF_DB_HOST',   '$db_host');\n";
  $conf .= "define('CONF_DB_USER',   '$db_user');\n";
  $conf .= "define('CONF_DB_PWD',    '$db_pwd');\n";
  $conf .= "define('CONF_DB_NAME',   '$db_name');\n";
  $conf .= "define('CONF_DB_PREFIX', '$db_prefix');\n";

  file_put_contents('./src/conf.php', $conf);
  ?>
<p><code>src/conf.php</code> written</p>
<h2>Step 2: Create administration user</h2>
<?php
break;
}
