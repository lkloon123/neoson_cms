<template>
  <div>
    <div class="form-group">
      <label for="menu-label">Label</label>
      <input
        id="menu-label"
        :value="getValue('menuLabel')"
        class="form-control"
        name="Label"
        type="text"
        @input="setValue('menuLabel', $event.target.value)"
      >
    </div>

    <div class="form-group">
      <label for="url">Url</label>
      <input
        id="url"
        v-validate="{required: true, url:{require_host: false}}"
        :value="getValue('url')"
        class="form-control"
        :class="{'is-invalid': errors.first('Url')}"
        name="Url"
        placeholder="http://"
        type="text"
        @input="setValue('url', $event.target.value)"
      >

      <div class="invalid-feedback">
        {{ errors.first('Url') }}
      </div>
    </div>

    <button
      class="btn btn-primary"
      @click="addToMenu"
    >
      Add to menu
    </button>
  </div>
</template>

<script>
import Mixin from './mixin';

export default {
  mixins: [Mixin],
  data: () => ({
    type: 'custom_link',
    menuLabel: '',
    url: '',
  }),
  methods: {
    reset() {
      this.menuLabel = '';
      this.url = '';
    },
  },
};
</script>

<style scoped>
    #url {
        font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    }
</style>
