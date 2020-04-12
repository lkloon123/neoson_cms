<template>
  <html-modal v-bind="getPropsForTransfer">
    {{ body }}
  </html-modal>
</template>

<script>
import { cloneDeep } from 'lodash';
import HtmlModal from './HtmlModal';

export default {
  components: {
    HtmlModal,
  },
  props: {
    title: {
      type: String,
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
  computed: {
    getPropsForTransfer() {
      const clonedProps = cloneDeep(this.$props);
      delete clonedProps.body;
      return clonedProps;
    },
  },
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
