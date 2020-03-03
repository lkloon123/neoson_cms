/**
 * Credit: https://amystechnotes.com/2015/05/06/tinymce-add-character-count/
 * This is a slightly modified version to work with more recent TinyMCE version, fix some code styling and don't trim
 * trailing and leading whitespaces from count.
 */

import '@css/tinymce_charactercount_plugin.css';

// eslint-disable-next-line no-undef,func-names
tinymce.PluginManager.add('charactercount', function (editor) {
  const self = this;

  function update() {
    editor.theme.panel.find('#charactercount').text(['Characters: {0}', self.getCount()]);
  }

  editor.on('init', () => {
    const statusbar = editor.theme.panel && editor.theme.panel.find('#statusbar')[0];

    if (statusbar) {
      window.setTimeout(() => {
        statusbar.insert({
          type: 'label',
          name: 'charactercount',
          text: ['Characters: {0}', self.getCount()],
          classes: 'charactercount',
          disabled: editor.settings.readonly,
        }, 0);

        editor.on('setcontent beforeaddundo keyup', update);
      }, 0);
    }
  });

  function decodeHtml(html) {
    const txt = document.createElement('textarea');
    txt.innerHTML = html;
    return txt.value;
  }

  self.getCount = () => {
    const tx = editor.getContent({ format: 'raw' });
    const decoded = decodeHtml(tx);
    const decodedStripped = decoded.replace(/(<([^>]+)>)/ig, '');
    return decodedStripped.length;
  };
});
