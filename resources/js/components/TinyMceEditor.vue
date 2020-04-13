<template>
  <div style="padding-right: 2px">
    <box-content-loading v-if="isLoading || isContentLoading" />

    <div :class="{'should-hide': isLoading || isContentLoading}">
      <tiny-mce
        :init="tinymceInit"
        :value="value"
        :plugins="tinymcePlugin"
        :toolbar="tinymceToolbar"
        @input="$emit('input', $event)"
        @onInit="isLoading = false"
      />
    </div>
  </div>
</template>

<script>
import 'tinymce';
import 'tinymce/themes/modern/theme';
import 'tinymce/plugins/help/plugin';
import 'tinymce/plugins/link/plugin';
import 'tinymce/plugins/code/plugin';
import 'tinymce/plugins/nonbreaking/plugin';
import 'tinymce/plugins/lists/plugin';
import 'tinymce/plugins/advlist/plugin';
import 'tinymce/plugins/image/plugin';
import 'tinymce/plugins/media/plugin';
import '../plugins/tinymce-charactercount';
import TinyMce from '@tinymce/tinymce-vue';

import BoxContentLoading from '@components/content_loading/BoxContentLoading';

export default {
  components: {
    TinyMce, BoxContentLoading,
  },
  props: {
    isContentLoading: {
      type: Boolean,
      default: false,
    },
    value: {
      type: String,
      required: true,
    },
  },
  data: () => ({
    tinymceInit: {
      skin_url: '/css/tinymce/skins/lightgray',
      content_css: '/css/tinymce/skins/lightgray/content.min.css',
      relative_urls: false,
      remove_script_host: false,
      menubar: false,
      branding: false,
      nonbreaking_force_tab: true,
      image_advtab: true,
      theme_advanced_resizing: true,
      min_height: 350,
      file_browser_callback_types: 'image, media',
      file_browser_callback(fieldName, fileUrl, type, win) {
        // eslint-disable-next-line no-undef
        tinyMCE.activeEditor.windowManager.open({
          file: '/file-manager/tinymce',
          title: 'File Manager',
          width: window.innerWidth * 0.8,
          height: window.innerHeight * 0.8,
          resizable: 'yes',
          close_previous: 'no',
        },
        {
          setUrl: (url) => { win.document.getElementById(fieldName).value = url; },
        });
      },
    },
    tinymcePlugin: 'help link code nonbreaking lists advlist image media charactercount',
    tinymceToolbar: 'undo redo | formatselect fontsizeselect | bold italic strikethrough forecolor | link image media | alignleft aligncenter alignright alignjustify | bullist numlist | removeformat | code',
    isLoading: true,
  }),
};
</script>

<style scoped>

</style>
