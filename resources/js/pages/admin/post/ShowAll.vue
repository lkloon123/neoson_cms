<template>
  <card>
    <template v-slot:header>
      <h4>
        All Posts&nbsp;
        <router-link
          v-if="hasPermission('create', 'post')"
          to="/posts/create"
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
          <template v-if="hasPermission('update', 'post') || hasPermission('delete', 'post')">
            <span class="table-actions">
              <button
                v-if="hasPermission('update', 'post')"
                class="btn btn-icon btn-info btn-sm"
                title="Edit"
                @click="gotoEdit(props.row.id)"
              >
                <i class="fas fa-edit fa-fw" />
              </button>
              <!-- delete button -->
              <confirm-modal
                v-if="hasPermission('delete', 'post')"
                :body="`Confirm Delete Post [${props.row.title}] ?`"
                :cfm-btn-class="{btn: true, 'btn-danger': true}"
                :is-btn-html="true"
                :show-btn="true"
                :trigger-btn-class="{btn: true, 'btn-icon': true, 'btn-sm': true, 'btn-danger': true}"
                :trigger-btn-text="deleteBtnIcon"
                trigger-btn-tooltip="Delete"
                title="Confirmation"
                @confirm="deletePost(props.row.id, props.row.title)"
              />
              <!-- #delete button -->
            </span>
            <i class="fas fa-ellipsis-v text-muted show-action-icon" />
          </template>
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
        <span v-else-if="!props.formattedRow[props.column.field]">
          &mdash;
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
import PermissionMixin from '@mixins/permission_mixin';

export default {
  components: {
    VueGoodTable, Card, VclTable, ConfirmModal,
  },
  mixins: [PermissionMixin],
  data: () => ({
    columns: [
      {
        label: 'Title',
        field: 'title',
        width: '32%',
      },
      {
        label: 'Author',
        field: 'author.name',
        width: '20%',
      },
      {
        label: 'Tags',
        field: (row) => row.tags.map((tag) => tag.name).join(', '),
        width: '20%',
      },
      {
        label: 'Status',
        field: 'status',
        width: '10%',
      },
      {
        label: 'Last edited',
        field: 'updated_at',
        width: '17%',
      },
      {
        label: '',
        field: 'action',
        tdClass: 'text-center show-action',
        width: '1%',
        sortable: false,
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
    this.loadPosts();
    this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Posts');
  },
  methods: {
    async loadPosts() {
      this.resetState();

      try {
        const postsResponse = await axios.get('/api/post');
        if (postsResponse.status === 200) {
          this.rows = postsResponse.data;
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
      this.$router.push(`/posts/edit/${id}`);
    },
    async deletePost(id, title) {
      this.isLoading = true;
      this.$Toast.showLoading({
        title: 'Deleting...',
      });

      try {
        await axios.delete(`/api/post/${id}`);
        this.$Toast.show({
          type: 'success',
          message: `Successfully deleted post [${title}]`,
        });

        this.loadPosts();
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
