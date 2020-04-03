<template>
  <card>
    <template v-slot:header>
      <h4>
        All Roles&nbsp;
        <router-link
          v-if="hasPermission('create', 'acl_setting')"
          to="/settings/roles/create"
          class="btn btn-icon icon-left btn-primary"
        >
          <i class="fas fa-plus" />Create
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
        <span v-if="props.column.field === 'updated_at' || props.column.field === 'created_at'">
          {{ formatToAgoDate(props.formattedRow[props.column.field]) }}
        </span>
        <span v-else-if="props.column.field === 'action'">
          <template v-if="hasPermission('update', 'acl_setting') || hasPermission('delete', 'acl_setting')">
            <span class="table-actions">
              <button
                v-if="hasPermission('update', 'acl_setting')"
                class="btn btn-icon btn-info btn-sm"
                title="Edit"
                @click="gotoEdit(props.row.id)"
              >
                <i class="fas fa-edit fa-fw" />
              </button>
              <!-- delete button -->
              <confirm-modal
                v-if="hasPermission('delete', 'acl_setting')"
                :body="`Confirm Delete Role [${props.row.name}] ?`"
                :cfm-btn-class="{btn: true, 'btn-danger': true}"
                :is-btn-html="true"
                :show-btn="true"
                :trigger-btn-class="{btn: true, 'btn-icon': true, 'btn-sm': true, 'btn-danger': true}"
                :trigger-btn-text="deleteBtnIcon"
                trigger-btn-tooltip="Delete"
                title="Confirmation"
                @confirm="deleteRole(props.row.id, props.row.name)"
              />
              <!-- #delete button -->
            </span>
            <i class="fas fa-ellipsis-v text-muted show-action-icon" />
          </template>
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
        width: '40%',
      },
      {
        label: 'Users',
        field: 'users_count',
        width: '20%',
      },
      {
        label: 'Created At',
        field: 'created_at',
        width: '20%',
      },
      {
        label: 'Last edited',
        field: 'updated_at',
        width: '19%',
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
    this.loadRoles();
    this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Roles');
    this.$store.commit('SET_PAGE_BACK_LINK', '/settings');
  },
  methods: {
    async loadRoles() {
      this.resetState();

      try {
        const loadRoleResponse = await axios.get('/api/role');
        if (loadRoleResponse.status === 200) {
          this.rows = loadRoleResponse.data;
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
      this.$router.push(`/settings/roles/edit/${id}`);
    },
    async deleteRole(id, title) {
      this.isLoading = true;
      this.$Toast.showLoading({
        title: 'Deleting...',
      });

      try {
        axios.delete(`/api/role/${id}`);
        this.$Toast.show({
          type: 'success',
          message: `Successfully deleted role [${title}]`,
        });

        this.loadRoles();
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
