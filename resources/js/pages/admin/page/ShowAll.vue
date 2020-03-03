<template>
  <card>
    <template v-slot:header>
      <h4>
        All Pages&nbsp;
        <router-link
          to="/pages/create"
          class="btn btn-icon icon-left btn-primary"
        >
          <i class="fas fa-plus" /> Create
        </router-link>
      </h4>
    </template>

    <vcl-table
      v-if="isLoading"
      :columns="5"
    />

    <vue-good-table
      v-else
      :columns="columns"
      :rows="rows"
      :search-options="{enabled: true}"
      :select-options="{enabled: true, selectOnCheckboxOnly: true}"
      :pagination-options="{enabled: true}"
      style-class="vgt-table table-hover condensed"
    >
      <template
        slot="table-row"
        slot-scope="props"
      >
        <span v-if="props.column.field === 'updated_at'">
          {{ formatToAgoDate(props.formattedRow[props.column.field]) }}
        </span>
        <span v-else-if="props.column.field === 'action'">
          <span class="table-actions">
            <button
              class="btn btn-icon btn-info btn-sm"
              title="Edit"
              @click="gotoEdit(props.row.id)"
            >
              <i class="fas fa-edit fa-fw" />
            </button>
            <!-- delete button -->
            <confirm-modal
              :body="`Confirm Delete Page [${props.row.title}] ?`"
              :cfm-btn-class="{btn: true, 'btn-danger': true}"
              :is-btn-html="true"
              :show-btn="true"
              :trigger-btn-class="{btn: true, 'btn-icon': true, 'btn-sm': true, 'btn-danger': true}"
              :trigger-btn-text="deleteBtnIcon"
              trigger-btn-tooltip="Delete"
              title="Confirmation"
              @confirm="deletePage(props.row.id, props.row.title)"
            />
            <!-- #delete button -->
          </span>
          <i class="fas fa-ellipsis-v text-muted show-action-icon" />
        </span>
        <span v-else-if="props.column.field === 'status'">
          <span
            v-if="props.formattedRow[props.column.field] === 'Publish'"
            class="badge badge-success"
          >{{ props.formattedRow[props.column.field] }}</span>
          <span
            v-else
            class="badge badge-warning"
          >{{ props.formattedRow[props.column.field] }}</span>
        </span>
        <span v-else>
          {{ props.formattedRow[props.column.field] }}
        </span>
      </template>
    </vue-good-table>
  </card>
</template>

<script>
import { VueGoodTable } from 'vue-good-table';
import Card from '@components/Card';
import { VclTable } from 'vue-content-loading';
import ConfirmModal from '@components/modal/ConfirmModal';
import axios from 'axios';
import moment from 'moment';

export default {
  components: {
    VueGoodTable, Card, VclTable, ConfirmModal,
  },
  data: () => ({
    columns: [
      {
        label: 'Title',
        field: 'title',
        width: '40%',
      },
      {
        label: 'Author',
        field: 'author.name',
        width: '20%',
      },
      {
        label: 'Status',
        field: 'status',
        width: '19%',
      },
      {
        label: 'Last edited',
        field: 'updated_at',
        width: '20%',
      },
      {
        label: '',
        field: 'action',
        tdClass: 'text-center show-action',
        width: '1%',
      },
    ],
    rows: [],
    isLoading: true,
  }),
  computed: {
    deleteBtnIcon() {
      return '<i class="fas fa-trash fa-fw"/>';
    },
  },
  created() {
    this.loadPages();
    this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Pages');
  },
  methods: {
    async loadPages() {
      this.resetState();

      try {
        const pagesResponse = await axios.get('/api/page');
        if (pagesResponse.status === 200) {
          this.rows = pagesResponse.data;
        }
      } catch (err) {
        this.$Toast.show({
          type: 'error',
          message: err.response.data.message,
        });
      }

      this.isLoading = false;
    },
    formatToAgoDate(inputDateTime) {
      return moment(inputDateTime).fromNow();
    },
    gotoEdit(id) {
      this.$router.push(`/pages/edit/${id}`);
    },
    async deletePage(id, title) {
      this.isLoading = true;
      this.$Toast.showLoading({
        title: 'Deleting...',
      });

      try {
        await axios.delete(`/api/page/${id}`);
        this.$Toast.show({
          type: 'success',
          message: `Successfully deleted page [${title}]`,
        });

        this.loadPages();
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
</style>
