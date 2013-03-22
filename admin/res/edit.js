var marked = require('marked');

$.domReady(function() {
  var chooser = $('#snippet-chooser');
  var canvas = $('#canvas');
  var content = $('#content');
  var hasChanged = false;
  var save = $('#save');

  save.attr('disabled', 'disabled');

  showPreview(); // init preview
  content.on('keyup', function() {
    if (!hasChanged)
      contentChanged();
    showPreview();
  });

  function showPreview() {
    canvas.html(marked(content.val(), {
      breaks : true
    }));
  }

  function get(warn) {
    var redirect = true;
    if (warn === true) {
      redirect = confirm(confirmationMsg);
    }
    if (redirect) {
      window.location.href = 'edit.html?snippet=' + chooser[0].value;
    }
  }

  chooser.on('change select', get);

  function contentChanged() {
    hasChanged = true;
    chooser.off('change select');
    chooser.on('change select', function() {
      get(true);
    });

    save.removeAttr('disabled');
    var saved = $('.saved');
    if (saved) {
      saved.fadeOut(1000, function() {
        console.log('done')
      });
    }
  }
});
