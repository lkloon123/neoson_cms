<template>
  <div>
    <div class="form-group">
      <label for="menu-label">Label</label>
      <input
        id="menu-label"
        v-model="menuLabel"
        class="form-control"
        name="Label"
        type="text"
      >
    </div>

    <div class="form-group">
      <label for="url">Url</label>
      <input
        id="url"
        v-model="url"
        class="form-control"
        name="Url"
        type="text"
        placeholder="http://"
      >
    </div>

    <button
      class="btn btn-danger btn-icon icon-left"
      @click="removeMenu"
    >
      <i class="fas fa-trash" /> Remove
    </button>
  </div>
</template>

<script>
import { cloneDeep } from 'lodash';

export default {
  props: {
    itemData: {
      type: Object,
    },
  },
  computed: {
    menuLabel: {
      get() {
        return this.itemData.menuLabel;
      },
      set(value) {
        const cloned = cloneDeep(this.itemData);
        cloned.menuLabel = value;
        this.$store.commit('menu/UPDATE_MENU_ITEM', cloned);
      },
    },
    url: {
      get() {
        return this.itemData.url;
      },
      set(value) {
        const cloned = cloneDeep(this.itemData);
        cloned.url = value;
        this.$store.commit('menu/UPDATE_MENU_ITEM', cloned);
      },
    },
  },
  methods: {
    removeMenu() {
      const cloned = cloneDeep(this.itemData);
      this.$store.commit('menu/REMOVE_MENU_ITEM', cloned);
    },
  },
};
</script>

<style scoped>
    #url {
        font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    }
</style>
