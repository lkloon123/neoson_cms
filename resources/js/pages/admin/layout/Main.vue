<template>
  <div class="main-wrapper main-wrapper-1">
    <div class="navbar-bg" />
    <top-nav />
    <left-nav />

    <div class="main-content">
      <section class="section">
        <div class="section-header">
          <div
            v-if="pageBackLink !== null"
            class="section-header-back"
          >
            <router-link
              :to="pageBackLink"
              class="btn btn-icon"
            >
              <i class="fas fa-arrow-left" />
            </router-link>
          </div>
          <h1>{{ currentPageTitle }}</h1>

          <div class="section-header-breadcrumb">
            <div
              v-for="(breadcrumb, index) in breadcrumbList"
              :key="index"
              class="breadcrumb-item"
            >
              <router-link
                v-if="breadcrumb.link"
                :to="breadcrumb.link"
              >
                {{ breadcrumb.name }}
              </router-link>
              <span v-else>{{ breadcrumb.name }}</span>
            </div>
          </div>
        </div>

        <div class="section-body">
          <router-view />
        </div>
      </section>
    </div>

    <main-footer />
  </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
import TopNav from './TopNav';
import LeftNav from './LeftNav';
import MainFooter from './Footer';


export default {
  components: {
    MainFooter,
    LeftNav,
    TopNav,
  },
  data: () => ({
    breadcrumbList: [],
  }),
  computed: {
    ...mapState(['currentPageTitle', 'pageBackLink']),
  },
  watch: {
    $route() {
      this.updateBreadcrumbList();
    },
  },
  mounted() {
    // eslint-disable-next-line global-require
    require('@stisla/scripts');
    this.updateBreadcrumbList();
  },
  created() {
    this.getCurrentUserInfo();
  },
  methods: {
    ...mapActions(['getCurrentUserInfo']),
    updateBreadcrumbList() {
      this.breadcrumbList = this.$route.meta.breadcrumb;
    },
  },
};
</script>

<style scoped>

</style>
