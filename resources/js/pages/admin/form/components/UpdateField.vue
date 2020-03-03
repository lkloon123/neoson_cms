<template>
  <card>
    <template v-slot:header>
      <h4>Form Properties</h4>
    </template>

    <div v-if="!clonedSelectedItem">
      <div class="alert alert-info">
        <div class="alert-body">
          Please click a component in form preview to change its properties
        </div>
      </div>
    </div>

    <template v-else>
      <div class="form-group">
        <label for="label">Label</label>
        <input
          id="label"
          v-model="formLabel"
          type="text"
          class="form-control"
        >
      </div>

      <div
        v-if="isValidatorPresent('required')"
        class="form-group"
      >
        <toggle-button
          :width="40"
          :value="validators.required"
          :sync="true"
          @input="(value) => setValidator('required', value)"
        />
        Is Required?
      </div>

      <div class="d-flex justify-content-between">
        <button
          class="btn btn-danger btn-icon icon-left"
          @click="removeField"
        >
          <i class="fas fa-trash" /> Remove
        </button>

        <button
          class="btn btn-light btn-icon icon-left"
          @click="duplicateField"
        >
          <i class="fas fa-clone" /> Duplicate
        </button>
      </div>
    </template>
  </card>
</template>

<script>
import Card from '@components/Card';
import { mapState } from 'vuex';
import { ToggleButton } from 'vue-js-toggle-button';
import { cloneDeep } from 'lodash';

export default {
  components: {
    Card, ToggleButton,
  },
  computed: {
    ...mapState('form', ['selectedIndex']),
    clonedSelectedItem() {
      if (this.selectedIndex !== null) {
        return this.$store.state.form.formItems[this.selectedIndex];
      }
      return null;
    },
    validators() {
      return this.clonedSelectedItem?.validators;
    },
    formLabel: {
      get() {
        return this.clonedSelectedItem?.label;
      },
      set(value) {
        const cloned = cloneDeep(this.clonedSelectedItem);
        cloned.label = value;
        this.$store.commit('form/UPDATE_FORM_ITEM', cloned);
      },
    },
  },
  methods: {
    isValidatorPresent(key) {
      return this.validators && this.validators[key] !== undefined;
    },
    setValidator(validatorKey, value) {
      const cloned = cloneDeep(this.clonedSelectedItem);
      cloned.validators[validatorKey] = value;
      this.$store.commit('form/UPDATE_FORM_ITEM', cloned);
    },
    removeField() {
      this.$store.commit('form/REMOVE_FORM_ITEM');
    },
    duplicateField() {
      this.$store.commit('form/ADD_FORM_ITEM', this.clonedSelectedItem);
    },
  },
};
</script>

<style>
</style>
