<title>Login | chx</title>
<link rel="stylesheet" href="/res/admin.css" />
<form>
  <fieldset>
    <legend>
      <?php translate('login') ?>
    </legend>
    <table>
      <tr>
        <td><label for="login_user"><?php translate('username') ?></label></td>
        <td><input id="login_user" name="login_user" type="text" /></td>
      </tr>
      <tr>
        <td><label for="login_pwd"><?php translate('password') ?></label></td>
        <td><input id="login_pwd" name="login_pwd" type="password" /></td>
      </tr>
      <tr>
        <td></td>
        <td><input type="submit" value="<?php translate('login_submit') ?>" /></td>
      </tr>
    </table>
  </fieldset>
</form>
<?php
