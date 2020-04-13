<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <span>
    <button
      v-if="showBtn && !isBtnHtml"
      type="button"
      :class="triggerBtnClass"
      :title="triggerBtnTooltip"
      @click="copyCurrentState = 'show'"
    >
      {{ triggerBtnText }}
    </button>

    <!-- eslint-disable vue/no-v-html -->
    <button
      v-if="showBtn && isBtnHtml"
      type="button"
      :class="triggerBtnClass"
      :title="triggerBtnTooltip"
      @click="copyCurrentState = 'show'"
      v-html="triggerBtnText"
    />
    <!-- eslint-enable vue/no-v-html -->

    <BaseModal
      :current-state="copyCurrentState"
      @hidden="handleHidden"
      @shown="$emit('shown', $event)"
    >
      <template v-slot:header>
        <h5 class="modal-title">{{ title }}</h5>
      </template>
      <span>{{ body }}</span>
      <template v-slot:footer>
        <button
          :class="cfmBtnClass"
          data-dismiss="modal"
          @click="$emit('confirm', $event)"
        >
          {{ $t(cfmBtnText) }}
        </button>
        <button
          :class="cancelBtnClass"
          data-dismiss="modal"
          @click="$emit('cancel', $event)"
        >
          {{ $t(cancelBtnText) }}
        </button>
      </template>
    </BaseModal>
  </span>
</template>

<script>
import BaseModal from './BaseModal';

export default {
  components: {
    BaseModal,
  },
  props: {
    title: {
      type: String,
      default: '',
    },
    body: {
      type: String,
      required: true,
    },
    cfmBtnClass: {
      type: Object,
      default: () => ({
        btn: true,
        'btn-primary': true,
      }),
    },
    cfmBtnText: {
      type: String,
      default: 'common.yes',
    },
    cancelBtnClass: {
      type: Object,
      default: () => ({
        btn: true,
        'btn-secondary': true,
      }),
    },
    cancelBtnText: {
      type: String,
      default: 'common.no',
    },
    // trigger button
    showBtn: {
      type: Boolean,
      default: false,
    },
    isBtnHtml: {
      type: Boolean,
      default: false,
    },
    triggerBtnText: {
      type: String,
      default: 'show',
    },
    triggerBtnClass: {
      type: Object,
      default: () => ({
        btn: true,
        'btn-primary': true,
      }),
    },
    triggerBtnTooltip: {
      type: String,
      default: null,
    },
    // inherit props from base modal
    showXOnHeader: {
      type: Boolean,
      default: true,
    },
    currentState: {
      type: String,
      default: 'hide',
      validator: (value) => ['show', 'hide'].includes(value),
    },
  },
  data: () => ({
    copyCurrentState: null,
  }),
  watch: {
    currentState(newValue) {
      this.copyCurrentState = newValue;
    },
  },
  mounted() {
    this.copyCurrentState = this.currentState;
  },
  methods: {
    handleHidden(event) {
      this.copyCurrentState = 'hide';
      this.$emit('hidden', event);
    },
  },
};
</script>

<style scoped>

</style>
