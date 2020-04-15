<template>
  <div>
    <span
      v-if="!isEditing"
      class="editable"
      :title="$t('common.click_to_edit')"
      @click="show"
    >
      {{ $t(placeholder) }}
    </span>

    <div
      v-if="isEditing"
      class="form-inline"
    >
      <select
        v-if="inputType === 'select'"
        v-model="inputValue"
        class="form-control mr-1 input-field"
      >
        <option
          v-for="option in selectOptions"
          :key="option[selectOptionsUniqueKey]"
          :value="option[selectOptionsValueKey]"
        >
          {{ option[selectOptionsValueKey] }}
        </option>
      </select>

      <input
        v-if="inputType === 'text'"
        ref="textfield"
        v-model="inputValue"
        type="text"
        class="form-control mr-1 input-field"
        @keyup.enter="onEnter"
        @keyup.esc="cancel"
      >

      <div class="ml-auto mb-1">
        <button
          class="btn btn-sm btn-icon btn-success"
          @click="save"
        >
          <i class="fas fa-check fa-fw" />
        </button>
        <button
          class="btn btn-sm btn-icon btn-danger"
          @click="cancel"
        >
          <i class="fas fa-times fa-fw" />
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      type: String,
      required: true,
    },
    inputType: {
      type: String,
      default: 'text',
      validator: (value) => ['text', 'select'].indexOf(value) !== -1,
    },
    selectOptions: {
      type: Array,
      default: () => [],
    },
    selectOptionsUniqueKey: {
      type: String,
      default: 'id',
    },
    selectOptionsValueKey: {
      type: String,
      default: 'name',
    },
    submitOnEnter: {
      type: Boolean,
      default: true,
    },
  },
  data: () => ({
    isEditing: false,
    inputValue: '',
  }),
  computed: {
    placeholder() {
      if (this.value) {
        return this.value;
      }

      return 'common.click_to_edit';
    },
  },
  watch: {
    value: {
      handler(newValue) {
        this.inputValue = newValue;
      },
      immediate: true,
    },
  },
  methods: {
    save() {
      this.$emit('input', this.inputValue);
      this.hide();
    },
    onEnter() {
      if (this.submitOnEnter) {
        this.save();
      }
    },
    cancel() {
      this.hide();
    },
    show() {
      this.isEditing = true;
      this.inputValue = this.value;
      if (this.inputType === 'text') {
        this.$nextTick(() => this.$refs.textfield.focus());
      }
    },
    hide() {
      this.isEditing = false;
      this.inputValue = '';
    },
  },
};
</script>

<style scoped>
    .editable {
        border-bottom: dashed 1px #0088cc;
        color: #337ab7;
        cursor: pointer;
    }

    .input-field {
        height: 35px !important;
        flex-grow: 1;
    }

    select.input-field {
        padding: 0.375rem 0.75rem !important;
    }
</style>
