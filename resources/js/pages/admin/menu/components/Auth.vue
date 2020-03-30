<template>
  <div>
    <div class="form-group">
      <label for="guest-label">Guest Label</label>
      <input
        id="guest-label"
        :value="getValue('guestLabel')"
        class="form-control"
        name="Label"
        type="text"
        @input="setValue('guestLabel', $event.target.value)"
      >
    </div>

    <div class="form-group">
      <label for="logged-in-label">Logged In Label</label>
      <input
        id="logged-in-label"
        :value="getValue('menuLabel')"
        class="form-control"
        name="Label"
        type="text"
        @input="setValue('menuLabel', $event.target.value)"
      >
    </div>

    <button
      v-if="mode === 'add'"
      class="btn btn-primary"
      @click="addToMenu"
    >
      Add to menu
    </button>

    <button
      v-if="mode === 'update'"
      class="btn btn-danger btn-icon icon-left"
      @click="removeMenu"
    >
      <i class="fas fa-trash" /> Remove
    </button>
  </div>
</template>

<script>
import Mixin from './mixin';

export default {
  mixins: [Mixin],
  data: () => ({
    type: 'auth',
    guestLabel: 'Login',
    menuLabel: 'My Account',
  }),
  methods: {
    reset() {
      this.guestLabel = 'Login';
      this.menuLabel = 'My Account';
    },
  },
};
</script>

<style scoped>

</style>
