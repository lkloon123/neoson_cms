<template>
  <toggle-button
    :color="{checked: '#63ed7a', unchecked: '#fc544b', disabled: '#CCCCCC'}"
    :disabled="updating"
    :sync="true"
    :value="!plugin.isDisabled"
    class="mt-2"
    @input="enableOrDisablePlugin($event)"
  />
</template>

<script>
import { ToggleButton } from 'vue-js-toggle-button';
import axios from 'axios';

export default {
  components: {
    ToggleButton,
  },
  props: ['plugin'],
  data: () => ({
    updating: false,
  }),
  computed: {
    description() {
      return this.plugin.desc ? this.plugin.desc : this.plugin.name;
    },
  },
  methods: {
    async enableOrDisablePlugin(state) {
      this.updating = true;
      this.$Toast.showLoading({
        title: 'Updating...',
      });

      try {
        await axios.put(`/api/plugin/${this.plugin.id}`, {
          isDisabled: !state,
        });
        this.$Toast.show({
          type: 'success',
          message: `Successfully updated plugin [${this.plugin.name}]`,
        });
      } catch (err) {
        this.$Toast.show({
          type: 'error',
          message: err.response.data.message,
        });
      }

      this.updating = false;
    },
  },
};
</script>

<style scoped>

</style>
