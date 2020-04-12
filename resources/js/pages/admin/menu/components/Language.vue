<template>
  <div>
    <div class="form-group">
      <label>{{ $t('translation.all_languages') }}</label>
      <multiselect
        v-model="selectedLanguages"
        :clear-on-select="false"
        :internal-search="false"
        :loading="isSearching"
        :multiple="true"
        :options="languages"
        :searchable="true"
        :deselect-label="$t('common.remove')"
        label="title"
        :placeholder="$t('translation.select_language')"
        :select-label="$t('common.select')"
        track-by="id"
        @search-change="searchLanguage"
      />
    </div>

    <button
      class="btn btn-primary"
      @click="addToMenu"
    >
      {{ $t('menu.add_to_menu') }}
    </button>
  </div>
</template>

<script>
import axios from 'axios';
import Multiselect from 'vue-multiselect';
import { mapMutations } from 'vuex';

export default {
  components: {
    Multiselect,
  },
  data: () => ({
    selectedLanguages: [],
    languages: [],
    isLoading: true,
    isSearching: false,
  }),
  mounted() {
    this.searchLanguage();
  },
  methods: {
    ...mapMutations('menu', ['ADD_MENU_ITEM']),
    async searchLanguage(query = null) {
      this.isSearching = true;

      try {
        const searchLanguageResponse = await axios.get(`/api/language/search${query ? `?title=${query}` : ''}`);
        this.languages = searchLanguageResponse.data;
      } catch (err) {
        if (err.response.status === 404) {
          this.languages = [];
        }
      }

      this.isLoading = false;
      this.isSearching = false;
    },
    addToMenu() {
      if (this.selectedLanguages.length) {
        this.ADD_MENU_ITEM({
          type: 'language',
          languageIds: this.selectedLanguages.map(({ id, title }) => ({ id, title })),
          componentLabel: 'translation.languages',
        });
      }
      this.reset();
    },
    reset() {
      this.selectedLanguages = [];
    },
  },
};
</script>

<style scoped>

</style>
