<template>
  <html-modal
    :current-state="modalState"
    :is-btn-html="true"
    :show-btn="true"
    :show-footer="false"
    :title="$t('translation.create_translation')"
    :trigger-btn-class="{btn: true, 'btn-icon': true, 'btn-primary': true, 'icon-left': true}"
    :trigger-btn-text="editBtnIcon"
    :trigger-btn-tooltip="$t('common.edit')"
    @hidden="hideModal"
    @shown="showModal"
  >
    <div class="form-group">
      <label for="group">{{ $t('translation.group') }} <span class="text-danger">*</span></label>
      <input
        id="group"
        v-model="formValues.group"
        v-validate="'required'"
        type="text"
        class="form-control"
        :class="{'is-invalid': errors.first('Group')}"
        name="Group"
      >

      <div class="invalid-feedback">
        {{ errors.first('Group') }}
      </div>
    </div>

    <div class="form-group">
      <label for="key">{{ $t('translation.key') }} <span class="text-danger">*</span></label>
      <input
        id="key"
        v-model="formValues.key"
        v-validate="'required'"
        type="text"
        class="form-control"
        :class="{'is-invalid': errors.first('Key')}"
        name="Key"
      >

      <div class="invalid-feedback">
        {{ errors.first('Key') }}
      </div>
    </div>

    <div class="form-group">
      <label for="text">{{ $t('translation.text') }}</label>
      <input
        id="text"
        v-model="formValues.text"
        type="text"
        class="form-control"
        name="Text"
      >
      <small class="form-text text-muted">{{ $t('translation.create_translation_description') }}</small>
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
import axios from 'axios';

export default {
  components: {
    HtmlModal,
  },
  data: () => ({
    modalState: 'hide',
    isLoading: false,
    formValues: {
      group: '',
      key: '',
      text: '',
    },
  }),
  computed: {
    editBtnIcon() {
      return `<i class="fas fa-plus"/> ${this.$t('common.create')}`;
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

      this.$Toast.showLoading({
        title: 'Creating...',
      });

      try {
        await axios.post('/api/translation', { ...this.formValues });
        this.hideModal();
        this.$emit('input', this.clonedValue);
        this.$Toast.show({
          type: 'success',
          message: 'Successfully created translation',
        });
      } catch (err) {
        this.$Toast.show({
          type: 'error',
          message: err.response.data.message,
        });
      }

      this.isLoading = false;
    },
    showModal() {
      this.modalState = 'show';
    },
    hideModal() {
      this.modalState = 'hide';
      this.errors.clear();
      this.formValues.key = '';
      this.formValues.text = '';
    },
  },
};
</script>

<style scoped>

</style>
