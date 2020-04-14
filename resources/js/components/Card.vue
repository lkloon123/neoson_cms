<template>
  <div
    class="card"
    :class="styleClass"
  >
    <div
      v-if="hasHeader"
      class="card-header"
    >
      <slot name="header" />
      <!-- header action -->
      <div
        v-if="hasHeaderAction || isCollapsible"
        class="card-header-action"
      >
        <slot name="header-action" />
        <!-- eslint-disable vue/no-v-html -->
        <button
          v-if="isCollapsible"
          :data-collapse="collapsibleId"
          class="btn btn-icon btn-light"
          @click="collapsibleClick"
          v-html="collapsibleIcon"
        />
        <!-- eslint-enable vue/no-v-html -->
      </div>
      <!-- #header action -->
    </div>

    <!-- collapsible -->
    <div
      v-if="isCollapsible"
      :id="collapsibleId"
      class="collapse"
      :class="{show: !defaultCollapse}"
    >
      <div class="card-body">
        <slot />
      </div>

      <div
        v-if="hasFooter"
        class="card-footer"
      >
        <slot name="footer" />
      </div>
    </div>
    <!-- #collapsible -->

    <div v-else>
      <div class="card-body">
        <slot />
      </div>

      <div
        v-if="hasFooter"
        class="card-footer"
      >
        <slot name="footer" />
      </div>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';

export default {
  props: {
    isCollapsible: {
      type: Boolean,
      default: false,
    },
    defaultCollapse: {
      type: Boolean,
      default: false,
    },
    isHoverable: {
      type: Boolean,
      default: true,
    },
    styleType: {
      type: String,
      default: 'light',
      validator: (value) => Vue.prototype.$Utils.styleTypes().includes(value),
    },
  },
  data: () => ({
    collapsibleId: null,
    collapsibleIcon: '<i class="fas fa-minus"/>',
  }),
  computed: {
    styleClass() {
      return {
        'card-primary': this.styleType === 'primary',
        'card-secondary': this.styleType === 'secondary',
        'card-success': this.styleType === 'success',
        'card-danger': this.styleType === 'danger',
        'card-warning': this.styleType === 'warning',
        'card-info': this.styleType === 'info',
        'card-light': this.styleType === 'light',
        'card-dark': this.styleType === 'dark',
        hoverable: this.isHoverable,
      };
    },
    hasHeader() {
      return !!this.$slots.header;
    },
    hasHeaderAction() {
      return !!this.$slots['header-action'];
    },
    hasFooter() {
      return !!this.$slots.footer;
    },
  },
  beforeMount() {
    if (this.isCollapsible) {
      this.collapsibleId = this.$Utils.getRandomId();

      if (this.defaultCollapse) {
        this.collapsibleIcon = '<i class="fas fa-plus"/>';
      }
    }
  },
  methods: {
    collapsibleClick() {
      const target = $(`#${this.collapsibleId}`);

      target.collapse('toggle');
      target.on('shown.bs.collapse', () => { this.collapsibleIcon = '<i class="fas fa-minus"/>'; });
      target.on('hidden.bs.collapse', () => { this.collapsibleIcon = '<i class="fas fa-plus"/>'; });
    },
  },
};
</script>

<style scoped>
    .hoverable {
        transition: all .25s linear;
    }

    .hoverable:hover {
        box-shadow: 0 8px 17px 0 rgba(0, 0, 0, .2), 0 6px 20px 0 rgba(0, 0, 0, .19);
    }
</style>
