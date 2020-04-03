<template>
  <div class="container mt-5">
    <div class="page-error">
      <div class="page-inner">
        <h1>404</h1>
        <div class="page-description">
          The page you were looking for could not be found.
        </div>

        <div class="mt-3">
          <router-link
            id="btnBack"
            to="/dashboard"
            class="btn btn-info btn-lg btn-round"
          >
            Back to Home
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  created() {
    this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Not Found');
  },
};
</script>
