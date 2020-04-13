<template>
  <toggle-button
    :color="{checked: '#63ed7a', unchecked: '#fc544b', disabled: plugin.isDisabled ? '#fc544b' : '#63ed7a'}"
    :disabled="disabled || updating"
    :sync="true"
    :value="!plugin.isDisabled"
    class="mt-2"
    @input="enableOrDisablePlugin($event)"
  />
</template>

<script>
import { ToggleButton } from 'vue-js-toggle-button';
import axios from 'axios';
import { cloneDeep } from 'lodash';

export default {
  components: {
    ToggleButton,
  },
  props: {
    plugin: {
      type: Object,
      required: true,
    },
    disabled: {
      type: Boolean,
      required: true,
    },
  },
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
          message: `Successfully ${!state ? 'disabled' : 'enabled'} plugin [${this.plugin.name}]`,
        });

        const clonedPlugin = cloneDeep(this.plugin);
        clonedPlugin.isDisabled = !state;
        this.$emit('updated', clonedPlugin);
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
