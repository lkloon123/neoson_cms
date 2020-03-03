<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <div class="row">
    <div class="col-md-9">
      <card>
        <template v-slot:header>
          <h4>Content</h4>
        </template>
        <template v-slot:header-action>
          <button
            :class="{disabled: isLoading}"
            :disabled="isLoading"
            class="btn btn-light"
            @click="validateAndSave('Draft')"
          >
            Save Draft
          </button>
          <button
            :class="{disabled: isLoading}"
            :disabled="isLoading"
            class="btn btn-primary"
            @click="validateAndSave('Publish')"
          >
            Publish
          </button>
        </template>

        <tiny-mce-editor
          v-model="content"
          v-validate="'required'"
          name="Content"
          :is-content-loading="isLoading"
          :style="{border: contentHasErrorBorderStyle}"
        />

        <div
          class="invalid-feedback"
          :style="{display: contentHasErrorStyle}"
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
          <h4>Schedule</h4>
        </template>

        <form-content-loading
          v-if="isLoading"
          :form-amount="2"
        />
        <div v-else>
          <div class="form-group">
            <label>Publish From</label>
            <date-range-picker
              v-model="publishFromDate"
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
            <label>Publish To</label>
            <date-range-picker
              v-model="publishToDate"
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
          <h4>Config</h4>
        </template>

        <form-content-loading
          v-if="isLoading"
          :form-amount="3"
        />
        <div v-else>
          <div class="form-group">
            <label for="title">Title <span class="text-danger">*</span></label>
            <input
              id="title"
              v-model="title"
              v-validate="'required'"
              name="Title"
              class="form-control"
              :class="{'is-invalid': errors.first('Title')}"
              type="text"
              placeholder="Enter page title"
            >

            <div class="invalid-feedback">
              {{ errors.first('Title') }}
            </div>
          </div>

          <div class="form-group">
            <label for="slug">Slug/Permalink <span class="text-danger">*</span></label>
            <input
              id="slug"
              v-model="slug"
              v-validate="'required'"
              name="Slug/Permalink"
              class="form-control"
              :class="{'is-invalid': errors.first('Slug/Permalink')}"
              type="text"
              placeholder="Enter slug"
            >

            <div class="invalid-feedback">
              {{ errors.first('Slug/Permalink') }}
            </div>
          </div>

          <div class="form-group mb-2">
            <label for="description">Description</label>
            <textarea
              id="description"
              v-model="description"
              class="form-control"
              placeholder="Enter short description"
            />
          </div>
        </div>
      </card>

      <featured-image v-model="featuredImg" />
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
import FeaturedImage from './components/FeaturedImage';

export default {
  components: {
    TinyMceEditor, DateRangePicker, Card, FormContentLoading, FeaturedImage,
  },
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
    content: '',
    title: '',
    slug: '',
    description: '',
    featuredImg: '',
    publishFromDate: moment().format('YYYY-MM-DD hh:mm:ss a'),
    publishToDate: moment().add(1, 'week').format('YYYY-MM-DD hh:mm:ss a'),
    isLoading: true,
  }),
  computed: {
    contentHasErrorStyle() {
      if (this.errors && this.errors.items.length > 0) {
        return this.errors.first('Content') ? 'block' : 'none';
      }

      return 'none';
    },
    contentHasErrorBorderStyle() {
      if (this.errors && this.errors.items.length > 0) {
        return this.errors.first('Content') ? '1px solid #dc3545' : 'none';
      }

      return 'none';
    },
  },
  watch: {
    title(newValue) {
      this.slug = sluggable(newValue, { lower: true });
    },
  },
  async created() {
    if (this.mode === 'edit') {
      this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Edit Page');
      // fetch data from server
      try {
        const pageResponse = await axios.get(`/api/page/${this.$route.params.id}`);
        this.title = pageResponse.data.title;
        this.slug = pageResponse.data.slug;
        this.description = pageResponse.data.description;
        this.publishFromDate = moment(pageResponse.data.publish_from_date).format('YYYY-MM-DD hh:mm:ss a');
        this.publishToDate = moment(pageResponse.data.publish_to_date).format('YYYY-MM-DD hh:mm:ss a');
        this.content = pageResponse.data.content;
        this.featuredImg = pageResponse.data.featuredImg;
      } catch (err) {
        this.$Toast.show({
          type: 'error',
          message: err.response.data.message,
        });
      }
    } else {
      this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Create Page');
    }

    this.$store.commit('SET_PAGE_BACK_LINK', '/pages');

    this.isLoading = false;
  },
  methods: {
    validateAndSave(status) {
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          this.save(status);
        }
      });
    },
    async save(status) {
      const params = {
        status,
        content: this.content,
        title: this.title,
        slug: this.slug,
        description: this.description,
        featuredImg: this.featuredImg,
        publish_from_date: moment(this.publishFromDate, 'YYYY-MM-DD hh:mm:ss a').format('YYYY-MM-DD HH:mm:ss'),
        publish_to_date: moment(this.publishToDate, 'YYYY-MM-DD hh:mm:ss a').format('YYYY-MM-DD HH:mm:ss'),
      };

      if (this.mode === 'create') {
        this.isLoading = true;
        this.$Toast.showLoading({
          title: 'Creating...',
        });

        try {
          const createResponse = await axios.post('/api/page', params);
          this.$Toast.show({
            type: 'success',
            message: 'Successfully created page',
          });
          this.$router.push(`/pages/edit/${createResponse.data.id}`);
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
          await axios.put(`/api/page/${this.$route.params.id}`, params);
          this.$Toast.show({
            type: 'success',
            message: 'Successfully updated page',
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
    .content-field {
        padding: 20px;
    }
</style>
