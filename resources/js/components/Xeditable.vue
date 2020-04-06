<template>
  <div>
    <span
      v-if="!isEditing"
      class="editable"
      title="Click to edit"
      @click="show"
    >{{ placeholder }}</span>

    <div
      v-if="isEditing"
      class="form-inline"
    >
      <select
        v-if="inputType === 'select'"
        v-model="inputValue"
        class="form-control mr-1 input-field"
        :style="{'width': width}"
      >
        <option
          v-for="option in selectOptions"
          :key="option.id"
          :value="option.name"
        >
          {{ option.name }}
        </option>
      </select>
      <input
        v-if="inputType === 'text'"
        ref="textfield"
        v-model="inputValue"
        type="text"
        class="form-control mr-1 input-field"
        :style="{'width': width}"
        @keyup.enter="onEnter"
        @keyup.esc="cancel"
      >
      <button
        class="btn btn-sm btn-icon btn-success mr-1 btn-save"
        @click="save"
      >
        <i class="fas fa-check fa-fw" />
      </button>
      <button
        class="btn btn-sm btn-icon btn-danger btn-cancel"
        @click="cancel"
      >
        <i class="fas fa-times fa-fw" />
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      type: String,
    },
    inputType: {
      type: String,
      default: 'text',
    },
    selectOptions: {
      type: Array,
      default: () => [],
    },
    submitOnEnter: {
      type: Boolean,
      default: true,
    },
    width: {
      type: String,
      default: '70%',
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

      return 'Click to edit';
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
    }

    select.input-field {
        padding: 0.375rem 0.75rem !important;
    }
</style>
