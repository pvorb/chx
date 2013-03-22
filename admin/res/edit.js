var marked = require('marked');

$.domReady(function() {
  var choose = $('#choose');
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

  function contentChanged() {
    hasChanged = true;
    choose.attr('onclick', 'return confirm(\'' + confirmationMsg + '\')');

    // FIXME prevent accidentally leaving the page and losing changes
    window.onbeforeunload = function goodbye(e) {
      if (!e) e = window.event;
      e.cancelBubble = true;
      e.returnValue = confirmationMsg;

      if (e.stopPropagation) {
        e.stopPropagation();
        e.preventDefault();
      }
    };
    
    save.removeAttr('disabled');
    var saved = $('.saved');
    if (saved) {
      saved.fadeOut(1000, function() {
        console.log('done')
      });
    }
  }
});
