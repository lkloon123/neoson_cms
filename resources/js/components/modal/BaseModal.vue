<template>
  <div
    :id="id"
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
  >
    <div
      class="modal-dialog"
      :class="{'modal-sm': size === 'small', 'modal-lg': size === 'large', 'modal-xl': size === 'extra_large'}"
      role="document"
    >
      <div class="modal-content">
        <div
          v-if="hasHeader"
          class="modal-header"
        >
          <slot name="header" />
          <button
            v-if="showXOnHeader"
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <slot />
        </div>
        <div
          v-if="hasFooter"
          class="modal-footer bg-whitesmoke br"
        >
          <slot name="footer" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    currentState: {
      type: String,
      default: 'hide',
      validator: (value) => ['show', 'hide'].includes(value),
    },
    showXOnHeader: {
      type: Boolean,
      default: true,
    },
    size: {
      type: String,
      default: 'default',
    },
  },
  data: () => ({
    id: null,
  }),
  computed: {
    hasHeader() {
      return !!this.$slots.header;
    },
    hasFooter() {
      return !!this.$slots.footer;
    },
  },
  watch: {
    currentState(newValue, oldValue) {
      if (newValue !== oldValue) {
        if (newValue === 'hide') {
          $(`#${this.id}`).modal(newValue);
        } else {
          $(`#${this.id}`).appendTo('body').modal(newValue);
        }
      }
    },
  },
  mounted() {
    const vm = this;
    this.id = this.$Utils.getRandomId();

    $(`#${this.id}`).on('hidden.bs.modal', (event) => {
      vm.$emit('hidden', event);
    });

    $(`#${this.id}`).on('shown.bs.modal', (event) => {
      vm.$emit('shown', event);
    });
  },
};
</script>

<style scoped>

</style>
