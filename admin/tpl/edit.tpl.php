<?php
// get all snippets
$all = get_all_snippet_ids();

$id = false;
if (isset($_GET['snippet']) && $_GET['snippet'] != '') {
  $id = $_GET['snippet'];
  $snippet = get_snippet_by_id($id);
}
?>
<!DOCTYPE html>
<meta charset="utf-8">
<title>Edit<?php echo ($id ? ' '.$id : ''); ?>
</title>
<link rel="stylesheet"
  href="res/admin.css">
<link rel="stylesheet"
  href="res/jwysiwyg.css">
<div id="container">
  <h1><?php translate('edit') ?><?php echo ($id ? ' <em>'.$id.'</em>' : ''); ?></h1>
  <form><select id="snippet-chooser">
    <?php
      foreach ($all as $snippet_id)
        echo '<option>'.$snippet_id.'</option>';
    ?>
  </select></form>
  <?php if ($id): ?>
  <div id="editor">
    <textarea class="wysiwyg" rows="30" cols="100">
      <?php echo escape_html($snippet) ?>
    </textarea>
  </div>
  <?php endif; ?>
</div>
<script src="res/jquery.js"></script>
<script src="res/jwysiwyg.js"></script>
<script>
$(function() {
  $('.wysiwyg').wysiwyg({
    controls: {
      strikeThrough: { visible: false },
      indent: { visible: false },
      outdent: { visible: false },
      underline: { visible: false },
      justifyLeft: { visible: false },
      justifyCenter: { visible: false },
      justifyRight: { visible: false },
      justifyFull: { visible: false },
      subscript: { visible: false },
      superscript: { visible: false },
      insertHorizontalRule: { visible: false },
      insertImage: { visible: false },
      insertTable: { visible: false },
      code: { visible: false }
    }
  });
});
</script>
