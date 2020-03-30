<template>
  <div>
    <div class="form-group">
      <label>All Pages</label>
      <multiselect
        v-model="selectedPages"
        :clear-on-select="false"
        :close-on-select="false"
        :internal-search="false"
        :loading="isSearching"
        :multiple="true"
        :options="pages"
        :searchable="true"
        deselect-label="remove"
        label="title"
        select-label="select"
        track-by="id"
        @search-change="searchPage"
      />
    </div>

    <button
      class="btn btn-primary"
      @click="addToMenu"
    >
      Add to menu
    </button>
  </div>
</template>

<script>
import Multiselect from 'vue-multiselect';
import { mapMutations } from 'vuex';
import axios from 'axios';

export default {
  components: {
    Multiselect,
  },
  data: () => ({
    selectedPages: [],
    pages: [],
    isLoading: true,
    isSearching: false,
  }),
  computed: {
    isNotReady() {
      return this.isLoading || this.$store.state.menu.coreLoading;
    },
  },
  created() {
    this.searchPage();
  },
  methods: {
    ...mapMutations('menu', ['ADD_MENU_ITEM']),
    async searchPage(query = null) {
      this.isSearching = true;

      try {
        const searchPageResponse = await axios.get(`/api/page/search${query ? `?title=${query}` : ''}`);
        this.pages = searchPageResponse.data;
      } catch (err) {
        if (err.response.status === 404) {
          this.pages = [];
        }
      }

      this.isLoading = false;
      this.isSearching = false;
    },
    addToMenu() {
      this.selectedPages.forEach((selectedPage) => {
        const tmp = {
          type: 'page',
          pageId: selectedPage.id,
          title: selectedPage.title,
          slug: selectedPage.slug,
          menuLabel: selectedPage.title,
        };

        this.ADD_MENU_ITEM(tmp);
      });
      this.reset();
    },
    reset() {
      this.selectedPages = [];
    },
  },
};
</script>

<style scoped>

</style>
