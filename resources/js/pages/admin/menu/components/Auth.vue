<template>
  <div>
    <div class="form-group">
      <label for="guest-label">{{ $t('menu.guest_label') }}</label>
      <input
        id="guest-label"
        :value="getValue('guestLabel')"
        class="form-control"
        name="Label"
        type="text"
        :placeholder="$t('common.login')"
        @input="setValue('guestLabel', $event.target.value)"
      >
    </div>

    <div class="form-group">
      <label for="logged-in-label">{{ $t('menu.logged_in_label') }}</label>
      <input
        id="logged-in-label"
        :value="getValue('menuLabel')"
        class="form-control"
        name="Label"
        type="text"
        :placeholder="$t('common.my_account')"
        @input="setValue('menuLabel', $event.target.value)"
      >
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
    type: 'auth',
    guestLabel: '',
    menuLabel: '',
    componentLabel: 'menu.auth',
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
