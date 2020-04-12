<template>
  <div>
    <a
      href="#"
      data-toggle="dropdown"
      class="nav-link dropdown-toggle nav-link-lg"
      style="padding-left:0!important;padding-right:0!important"
    >
      <span v-if="!isLoading">
        <img
          class="mr-1 custom-flag-icon"
          :src="flagIconUrl"
          alt="locale"
        >
      </span>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
      <a
        v-for="language in languageData"
        :key="language.id"
        href="#"
        class="dropdown-item"
        @click="changeAppLocale(language.code)"
      >
        {{ language.title }}
      </a>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { mapState, mapActions } from 'vuex';

export default {
  data: () => ({
    isLoading: true,
    languageData: [],
  }),
  computed: {
    ...mapState(['locale']),
    displayFlagIso() {
      if (this.locale && this.languageData.length) {
        return this.languageData.find((lang) => lang.code === this.locale).country_iso.toUpperCase();
      }

      return 'US';
    },
    flagIconUrl() {
      return `/images/flags/${this.displayFlagIso}.svg`;
    },
  },
  mounted() {
    this.loadLanguages();
  },
  methods: {
    ...mapActions(['loadAppLocale']),
    async loadLanguages() {
      this.isLoading = true;

      try {
        const languagesResponse = await axios.get('/api/language');
        if (languagesResponse.status === 200) {
          this.languageData = languagesResponse.data;
        }
      } catch (err) {
        this.$Toast.show({
          type: 'error',
          message: err.response.data.message,
        });
      }

      this.isLoading = false;
    },
    async changeAppLocale(languageCode) {
      await axios.put(`/api/locale/${languageCode}`);

      this.loadAppLocale();
    },
  },
};
</script>

<style>
  .custom-flag-icon {
    width: 30px;
    height: 30px;
  }
</style>
