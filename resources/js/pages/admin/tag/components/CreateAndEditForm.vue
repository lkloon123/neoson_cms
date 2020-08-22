<template>
  <html-modal
    :current-state="modalState"
    :is-btn-html="true"
    :show-btn="true"
    :show-footer="false"
    :title="$t(getTitle)"
    :trigger-btn-class="{btn: true, 'btn-icon': true, 'btn-sm': mode === 'edit', 'btn-info': mode === 'edit', 'btn-primary': mode === 'create', 'icon-left': mode === 'create'}"
    :trigger-btn-text="editBtnIcon"
    :trigger-btn-tooltip="$t('common.edit')"
    @hidden="hideModal"
    @shown="showModal"
  >
    <div class="form-group">
      <label for="name">{{ $t('common.name') }} <span class="text-danger">*</span></label>
      <input
        id="name"
        v-model="clonedValue.name"
        v-validate="'required'"
        type="text"
        class="form-control"
        :class="{'is-invalid': errors.first('Name')}"
        name="Name"
      >

      <div class="invalid-feedback">
        {{ errors.first('Name') }}
      </div>
    </div>

    <div class="form-group">
      <label for="slug">{{ $t('page.slug') }}</label>
      <input
        id="slug"
        v-model="clonedValue.slug"
        type="text"
        class="form-control"
      >
    </div>

    <div class="form-group mb-0 text-right">
      <button
        type="submit"
        class="btn btn-primary"
        :class="{'btn-progress': isLoading}"
        @click="validateAndSave"
      >
        {{ $t('common.save') }}
      </button>
    </div>
  </html-modal>
</template>

<script>
import HtmlModal from '@components/modal/HtmlModal';
import sluggable from 'slug';
import { cloneDeep } from 'lodash';
import axios from 'axios';

export default {
  components: {
    HtmlModal,
  },
  props: {
    value: {
      type: Object,
      default: () => ({}),
    },
    mode: {
      type: String,
      default: 'create',
    },
  },
  data: () => ({
    clonedValue: {},
    modalState: 'hide',
    isLoading: false,
  }),
  computed: {
    editBtnIcon() {
      if (this.mode === 'create') {
        return `<i class="fas fa-plus"/> ${this.$t('common.create')}`;
      }
      return '<i class="fas fa-edit fa-fw"/>';
    },
    getTitle() {
      if (this.mode === 'create') {
        return 'tag.create_tag';
      }
      return 'tag.edit_tag';
    },
  },
  watch: {
    value: {
      handler(newValue) {
        this.clonedValue = cloneDeep(newValue);
      },
      immediate: true,
    },
    'clonedValue.name': function clonedValueName(newValue) {
      this.clonedValue.slug = sluggable(newValue);
    },
  },
  methods: {
    validateAndSave() {
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          this.save();
        }
      });
    },
    async save() {
      this.isLoading = true;

      if (this.mode === 'create') {
        this.$Toast.showLoading({
          title: 'Creating...',
        });

        try {
          await axios.post('/api/tag', {
            name: this.clonedValue.name,
            slug: this.clonedValue.slug,
          });
          this.hideModal();
          this.$emit('input', this.clonedValue);
          this.$Toast.show({
            type: 'success',
            message: 'Successfully created tag',
          });
        } catch (err) {
          this.$Toast.show({
            type: 'error',
            message: err.response.data.message,
          });
        }

        this.isLoading = false;
      } else if (this.mode === 'edit') {
        this.$Toast.showLoading({
          title: 'Updating...',
        });

        try {
          await axios.put(`/api/tag/${this.clonedValue.id}`, {
            name: this.clonedValue.name,
            slug: this.clonedValue.slug,
          });
          this.$emit('input', this.clonedValue);
          this.hideModal();
          this.$Toast.show({
            type: 'success',
            message: 'Successfully updated tag',
          });
        } catch (err) {
          this.$Toast.show({
            type: 'error',
            message: err.response.data.message,
          });
        }

        this.isLoading = false;
      }
    },
    showModal() {
      this.modalState = 'show';
    },
    hideModal() {
      this.modalState = 'hide';
      this.errors.clear();
      if (this.mode === 'create') {
        this.clonedValue.name = '';
        this.clonedValue.slug = '';
      } else if (this.mode === 'edit') {
        this.clonedValue = cloneDeep(this.value);
      }
    },
  },
};
</script>

<style scoped>

</style>
