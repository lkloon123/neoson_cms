<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <div>
    <div class="row">
      <div class="col-md-9">
        <card>
          <template v-slot:header>
            <h4>{{ $t('page.content') }}</h4>
          </template>
          <template v-slot:header-action>
            <button
              :class="{disabled: isLoading}"
              :disabled="isLoading"
              class="btn btn-light"
              @click="validateAndSave('Draft')"
            >
              {{ $t('page.save_draft') }}
            </button>
            <button
              :class="{disabled: isLoading}"
              :disabled="isLoading"
              class="btn btn-primary"
              @click="validateAndSave('Publish')"
            >
              {{ $t('page.publish') }}
            </button>
          </template>

          <tiny-mce-editor
            v-model="formValues.content"
            v-validate="'required'"
            name="Content"
            :is-content-loading="isLoading"
            :class="showContentErrorBorder"
          />

          <div
            class="invalid-feedback"
            :class="showContentErrorFeedback"
          >
            {{ errors.first('Content') }}
          </div>
        </card>
      </div>
      <div class="col-md-3">
        <card
          :is-collapsible="true"
          class="mb-1"
        >
          <template v-slot:header>
            <h4>{{ $t('page.schedule') }}</h4>
          </template>

          <form-content-loading
            v-if="isLoading"
            :form-amount="2"
          />
          <div v-else>
            <div class="form-group">
              <label>{{ $t('page.publish_from') }}</label>
              <date-range-picker
                v-model="formValues.publish_from_date"
                v-validate="'required'"
                name="Publish From"
                :class="{'is-invalid': errors.first('Publish From')}"
                :options="publishFromDatePickerOptions"
              />

              <div class="invalid-feedback">
                {{ errors.first('Publish From') }}
              </div>
            </div>
            <div class="form-group mb-2">
              <label>{{ $t('page.publish_to') }}</label>
              <date-range-picker
                v-model="formValues.publish_to_date"
                v-validate="'required'"
                name="Publish To"
                :class="{'is-invalid': errors.first('Publish To')}"
                :options="publishToDatePickerOptions"
              />

              <div class="invalid-feedback">
                {{ errors.first('Publish To') }}
              </div>
            </div>
          </div>
        </card>

        <card
          :is-collapsible="true"
          class="mb-1"
        >
          <template v-slot:header>
            <h4>{{ $t('common.config') }}</h4>
          </template>

          <form-content-loading
            v-if="isLoading"
            :form-amount="3"
          />
          <div v-else>
            <div class="form-group">
              <label for="title">{{ $t('common.title') }} <span class="text-danger">*</span></label>
              <input
                id="title"
                v-model="formValues.title"
                v-validate="'required'"
                name="Title"
                class="form-control"
                :class="{'is-invalid': errors.first('Title')}"
                type="text"
                :placeholder="$t('page.enter_title')"
                @input="titleEdited = true"
              >

              <div class="invalid-feedback">
                {{ errors.first('Title') }}
              </div>
            </div>

            <div class="form-group">
              <label for="slug">{{ $t('page.slug') }} <span class="text-danger">*</span></label>
              <input
                id="slug"
                v-model="formValues.slug"
                v-validate="'required'"
                name="Slug/Permalink"
                class="form-control"
                :class="{'is-invalid': errors.first('Slug/Permalink')}"
                type="text"
                :placeholder="$t('page.enter_slug')"
              >

              <div class="invalid-feedback">
                {{ errors.first('Slug/Permalink') }}
              </div>
            </div>

            <div class="form-group mb-2">
              <label for="description">{{ $t('common.description') }}</label>
              <textarea
                id="description"
                v-model="formValues.description"
                class="form-control"
                :placeholder="$t('page.enter_description')"
              />
            </div>
          </div>
        </card>

        <tag v-model="formValues.tags" />

        <featured-image v-model="formValues.featuredImg" />
      </div>
    </div>
  </div>
</template>

<script>
import TinyMceEditor from '@components/TinyMceEditor';
import DateRangePicker from '@components/DateRangePicker';
import sluggable from 'slug';
import Card from '@components/Card';
import FormContentLoading from '@components/content_loading/FormContentLoading';
import axios from 'axios';
import moment from 'moment';
import DirtyFormMixin from '@mixins/dirty_form_mixin';
import Tag from './components/Tag';
import FeaturedImage from '../page/components/FeaturedImage';

const defaultValues = {
  content: '',
  title: '',
  slug: '',
  description: '',
  tags: [],
  featuredImg: '',
  publish_from_date: moment().format('YYYY-MM-DD hh:mm:ss a'),
  publish_to_date: moment().add(1, 'week').format('YYYY-MM-DD hh:mm:ss a'),
};

export default {
  components: {
    TinyMceEditor, DateRangePicker, Card, FormContentLoading, Tag, FeaturedImage,
  },
  mixins: [DirtyFormMixin],
  props: {
    mode: {
      type: String,
      default: 'create',
    },
  },
  data: () => ({
    publishFromDatePickerOptions: {
      singleDatePicker: true,
    },
    publishToDatePickerOptions: {
      singleDatePicker: true,
    },
    formValues: { ...defaultValues },
    defaultFormValues: { ...defaultValues },
    isLoading: true,
    titleEdited: false,
  }),
  computed: {
    showContentErrorFeedback() {
      if (this.errors?.items.length > 0) {
        return { 'd-block': this.errors.first('Content') };
      }

      return { 'd-none': true };
    },
    showContentErrorBorder() {
      if (this.errors?.items.length > 0) {
        return { 'border border-danger': this.errors.first('Content') };
      }

      return { 'border-0': true };
    },
  },
  watch: {
    'formValues.title': function formValuesTitle(newValue) {
      if (this.titleEdited) {
        this.formValues.slug = sluggable(newValue, { lower: true });
      }
    },
  },
  async mounted() {
    if (this.mode === 'edit') {
      this.$store.commit('SET_CURRENT_PAGE_TITLE', 'post.edit_post');

      // fetch data from server
      try {
        const { data } = await axios.get(`/api/post/${this.$route.params.id}`);
        const {
          id, author, created_at, updated_at, ...transformedData
        } = data;
        transformedData.publish_from_date = moment(transformedData.publish_from_date).format('YYYY-MM-DD hh:mm:ss a');
        transformedData.publish_to_date = moment(transformedData.publish_to_date).format('YYYY-MM-DD hh:mm:ss a');

        this.defaultFormValues = { ...transformedData };
        this.formValues = { ...transformedData };
      } catch (err) {
        this.$Toast.show({
          type: 'error',
          message: err.response.data.message,
        });
      }
    } else {
      this.$store.commit('SET_CURRENT_PAGE_TITLE', 'post.create_post');
    }

    this.$store.commit('SET_PAGE_BACK_LINK', '/posts');

    this.isLoading = false;
  },
  methods: {
    validateAndSave(status) {
      this.$validator.validateAll().then(async (valid) => {
        if (valid) {
          await this.save(status);
          this.defaultFormValues = { ...this.formValues };
          this.updateIsDirty(false);
        }
      });
    },
    async save(status) {
      const { ...transformedFormValues } = this.formValues;
      transformedFormValues.publish_from_date = moment(transformedFormValues.publish_from_date, 'YYYY-MM-DD hh:mm:ss a').format('YYYY-MM-DD HH:mm:ss');
      transformedFormValues.publish_to_date = moment(transformedFormValues.publish_to_date, 'YYYY-MM-DD hh:mm:ss a').format('YYYY-MM-DD HH:mm:ss');

      const params = { status, ...transformedFormValues };

      if (this.mode === 'create') {
        this.isLoading = true;
        this.$Toast.showLoading({
          title: 'Creating...',
        });

        try {
          const createResponse = await axios.post('/api/post', params);
          this.$Toast.show({
            type: 'success',
            message: 'Successfully created post',
          });
          this.$router.push(`/posts/edit/${createResponse.data.id}`);
        } catch (err) {
          this.$Toast.show({
            type: 'error',
            message: err.response.data.message,
          });
        }

        this.isLoading = false;
      } else if (this.mode === 'edit') {
        this.isLoading = true;
        this.$Toast.showLoading({
          title: 'Updating...',
        });

        try {
          await axios.put(`/api/post/${this.$route.params.id}`, params);
          this.$Toast.show({
            type: 'success',
            message: 'Successfully updated post',
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
  },
};
</script>

<style scoped>
</style>
