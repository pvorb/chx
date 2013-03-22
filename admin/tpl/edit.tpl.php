<?php
// get all snippets
$all = get_all_snippet_ids();

$id = false;
$saved = false;
if (isset($_GET['snippet']) && $_GET['snippet'] != '') {
  $id = $_GET['snippet'];
  if (isset($_POST['content'])) {
    $snippet = $_POST['content'];
    $saved = save_snippet($id, $snippet);
  } else {
    $snippet = get_snippet_by_id($id);
  }
}
?>
<!DOCTYPE html>
<meta charset="utf-8">
<title>Edit<?php echo ($id ? ' "'.$id.'"' : ''); ?>
</title>
<link rel="stylesheet" href="res/admin.css">
<div id="container">
  <?php include 'snippets/header.tpl.php' ?>
  <form action="edit.html" method="get">
    <h1>
      <?php translate('edit') ?>
      <select id="snippet-chooser" name="snippet">
        <?php
        foreach ($all as $snippet_id) {
          echo '<option value="'.$snippet_id.'" '.($id == $snippet_id ? ' selected' : '').'>'.$snippet_id.'</option>';
        }
        ?>
      </select>
    </h1>
  </form>
  <div id="main">
    <?php if ($saved): ?>
    <div class="saved">gespeichert</div>
    <?php endif ?>
    <?php if ($id): ?>
    <div id="editor">
      <form action="edit.html?snippet=<?php echo $id ?>" method="post">
        <h2>Editor</h2>
        <textarea id="content" name="content" rows="20" cols="80"><?php
          echo escape_html($snippet)
        ?></textarea>
        <a href="markdown-guide.de.html" target="_blank">Anleitung</a> <input
          id="save" class="save" type="submit" value="Speichern" />
      </form>
    </div>
    <div id="preview">
      <h2>Vorschau</h2>
      <div id="canvas"></div>
    </div>
    <?php endif ?>
  </div>
  <?php include 'snippets/about.tpl.php' ?>
</div>
<script src="res/ender.js"></script>
<script>var confirmationMsg = 'Ungespeicherte Fortschritte gehen verloren.';</script>
<script src="res/edit.js"></script>
