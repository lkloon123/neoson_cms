<template>
  <span>
    <button
      v-if="showBtn && !isBtnHtml"
      type="button"
      :class="triggerBtnClass"
      :title="triggerBtnTooltip"
      @click="triggerBtnClicked"
    >
      {{ triggerBtnText }}
    </button>

    <button
      v-if="showBtn && isBtnHtml"
      type="button"
      :class="triggerBtnClass"
      :title="triggerBtnTooltip"
      @click="triggerBtnClicked"
      v-html="triggerBtnText"
    />

    <BaseModal
      :current-state="copyCurrentState"
      :size="size"
      @hidden="handleHidden"
      @shown="$emit('shown', $event)"
    >
      <template v-slot:header>
        <h5 class="modal-title">{{ title }}</h5>
      </template>
      <slot />
      <template
        v-if="showFooter"
        v-slot:footer
      >
        <button
          :class="cfmBtnClass"
          data-dismiss="modal"
          @click="$emit('confirm', $event)"
        >
          {{ cfmBtnText }}
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
      default: 'ok',
    },
    showFooter: {
      type: Boolean,
      default: true,
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
    triggerBtnCallback: {
      type: Function,
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
    size: {
      type: String,
      default: 'default',
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
  created() {
    this.copyCurrentState = this.currentState;
  },
  methods: {
    handleHidden(event) {
      this.copyCurrentState = 'hide';
      this.$emit('hidden', event);
    },
    triggerBtnClicked() {
      if (this.triggerBtnCallback !== null) {
        this.triggerBtnCallback();
      }
      this.copyCurrentState = 'show';
    },
  },
};
</script>

<style scoped>

</style>
