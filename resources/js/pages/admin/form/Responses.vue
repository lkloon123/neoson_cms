<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <card>
    <template v-slot:header>
      <h4>{{ $t('form.form_responses') }}</h4>
    </template>

    <vcl-table
      v-if="isLoading"
      :columns="5"
    />

    <vue-good-table
      v-else
      :columns="columns"
      :line-numbers="true"
      :pagination-options="{enabled: true}"
      :rows="rows"
      :search-options="{enabled: true}"
      style-class="vgt-table table-hover condensed"
    >
      <template
        slot="table-column"
        slot-scope="props"
      >
        <span>
          {{ $t(props.column.label) }}
        </span>
      </template>

      <template v-slot:table-actions>
        <button
          class="btn btn-icon btn-sm btn-secondary btn-refresh"
          @click="loadFormResponse"
        >
          <i class="fas fa-sync" />
        </button>
      </template>
    </vue-good-table>
  </card>
</template>

<script>
import { VueGoodTable } from 'vue-good-table';
import Card from '@components/Card';
import { VclTable } from 'vue-content-loading';
import axios from 'axios';

export default {
  components: {
    VueGoodTable, Card, VclTable,
  },
  data: () => ({
    columns: [],
    rows: [],
    formName: '',
    isLoading: true,
  }),
  mounted() {
    this.loadFormResponse();
    this.$store.commit('SET_CURRENT_PAGE_TITLE', 'form.form_responses');
    this.$store.commit('SET_PAGE_BACK_LINK', '/forms');
  },
  methods: {
    async loadFormResponse() {
      this.resetState();

      try {
        const formResponse = await axios.get(`/api/form/response/${this.$route.params.id}`);
        this.columns = formResponse.data.columns;
        this.rows = formResponse.data.data;
        this.formName = formResponse.data.form_name;
      } catch (err) {
        this.$Toast.show({
          type: 'error',
          message: err.response.data.message,
        });
      }

      this.isLoading = false;
    },
    resetState() {
      this.isLoading = true;
      this.rows = [];
    },
  },
};
</script>

<style scoped>
  .btn-refresh {
    margin-top: 2px;
  }
</style>
