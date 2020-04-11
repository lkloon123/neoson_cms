<template>
  <div>
    <div class="form-group">
      <label for="menu-label">{{ $t('common.label') }}</label>
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
      <label for="url">{{ $t('common.url') }}</label>
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
      v-if="mode === 'add'"
      class="btn btn-primary"
      @click="addToMenu"
    >
      {{ $t('menu.add_to_menu') }}
    </button>

    <button
      v-if="mode === 'update'"
      class="btn btn-danger btn-icon icon-left"
      @click="removeMenu"
    >
      <i class="fas fa-trash" /> {{ $t('common.remove') }}
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
    componentLabel: 'menu.custom_link',
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
