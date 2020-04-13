<template>
  <card
    :is-collapsible="true"
    class="mb-1"
  >
    <template v-slot:header>
      <h4>{{ $t('menu.tags') }}</h4>
    </template>

    <form-content-loading
      v-if="isLoading"
      :form-amount="1"
    />

    <multiselect
      v-else
      v-model="selectedTags"
      :loading="isSearching"
      :multiple="true"
      :options="tags"
      :searchable="true"
      :taggable="true"
      :deselect-label="$t('common.remove')"
      label="name"
      :placeholder="$t('tag.search_add_tag')"
      :select-label="$t('common.select')"
      :tag-placeholder="$t('tag.add_as_new_tag')"
      track-by="id"
      @search-change="searchTag"
      @tag="addTag"
    />
  </card>
</template>

<script>
import Card from '@components/Card';
import Multiselect from 'vue-multiselect';
import FormContentLoading from '@components/content_loading/FormContentLoading';
import axios from 'axios';

export default {
  components: {
    Card, Multiselect, FormContentLoading,
  },
  props: {
    value: {
      type: Array,
      required: true,
    },
  },
  data: () => ({
    selectedTags: [],
    tags: [],
    generatedNewTag: [],
    isLoading: true,
    isSearching: false,
  }),
  watch: {
    value: {
      handler(newValue) {
        this.selectedTags = newValue;
      },
      immediate: true,
    },
    selectedTags(newValue) {
      this.$emit('input', newValue);
    },
  },
  mounted() {
    this.searchTag();
  },
  methods: {
    addTag(newTag) {
      const tag = {
        name: newTag,
        id: this.$Utils.getRandomId(),
      };
      // this.generatedNewTag.push(tag);
      this.tags.push(tag);
      this.selectedTags.push(tag);
    },
    async searchTag(query = null) {
      this.isSearching = true;

      try {
        const searchTagResponse = await axios.get(`/api/tag/search${query ? `?name=${query}` : ''}`);
        this.tags = searchTagResponse.data;
      } catch (err) {
        if (err.response.status === 404) {
          this.tags = [];
        }
      }

      this.isLoading = false;
      this.isSearching = false;
    },
  },
};
</script>

<style scoped>

</style>
