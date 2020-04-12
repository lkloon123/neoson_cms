<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <card>
    <template v-slot:header>
      <h4>
        {{ $t('user.all_users') }}&nbsp;
        <router-link
          v-if="hasPermission('create', 'user_manage')"
          to="/settings/users/create"
          class="btn btn-icon icon-left btn-primary"
        >
          <i class="fas fa-plus" /> {{ $t('common.create') }}
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
        slot="table-column"
        slot-scope="props"
      >
        <span>
          {{ $t(props.column.label) }}
        </span>
      </template>

      <template
        slot="table-row"
        slot-scope="props"
      >
        <span v-if="props.column.field === 'updated_at' || props.column.field === 'created_at'">
          {{ formatToAgoDate(props.formattedRow[props.column.field]) }}
        </span>
        <div v-else-if="props.column.field === 'role'">
          <span v-if="isCurrentLoggedInUser(props.row.id)">{{ props.formattedRow[props.column.field] }}</span>
          <template v-else>
            <xeditable
              v-if="!props.row.isSummitingRole"
              :select-options="roleOptions"
              :value="props.formattedRow[props.column.field]"
              input-type="select"
              @input="saveRole($event, props.row)"
            />
            <div v-else>
              <a class="btn disabled btn-progress">Loading</a>
            </div>
          </template>
        </div>
        <span v-else-if="props.column.field === 'action'">
          <template v-if="hasPermission('update', 'user_manage') || hasPermission('delete', 'user_manage')">
            <span class="table-actions">
              <button
                v-if="hasPermission('update', 'user_manage')"
                class="btn btn-icon btn-info btn-sm"
                :title="$t('common.edit')"
                @click="gotoEdit(props.row.id)"
              >
                <i class="fas fa-edit fa-fw" />
              </button>
              <!-- delete button -->
              <confirm-modal
                v-if="hasPermission('delete', 'user_manage') && !isCurrentLoggedInUser(props.row.id)"
                :body="$t('common.confirm_delete_confirmation', {entity: $t('setting.users'), item: props.row.email})"
                :cfm-btn-class="{btn: true, 'btn-danger': true}"
                :is-btn-html="true"
                :show-btn="true"
                :trigger-btn-class="{btn: true, 'btn-icon': true, 'btn-sm': true, 'btn-danger': true}"
                :trigger-btn-text="deleteBtnIcon"
                :trigger-btn-tooltip="$t('common.delete')"
                :title="$t('common.confirmation')"
                @confirm="deleteUser(props.row.id, props.row.email)"
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
import Xeditable from '@components/Xeditable';
import { VclTable } from 'vue-content-loading';
import ConfirmModal from '@components/modal/ConfirmModal';
import axios from 'axios';
import DateFormattingMixin from '@mixins/date_formatting_mixin';
import PermissionMixin from '@mixins/permission_mixin';

export default {
  components: {
    VueGoodTable, Card, VclTable, ConfirmModal, Xeditable,
  },
  mixins: [PermissionMixin, DateFormattingMixin],
  data: () => ({
    columns: [
      {
        label: 'common.name',
        field: 'name',
        width: '20%',
      },
      {
        label: 'common.email',
        field: 'email',
        width: '20%',
      },
      {
        label: 'role.role',
        field: 'role',
        width: '30%',
      },
      {
        label: 'common.created_at',
        field: 'created_at',
        width: '15%',
      },
      {
        label: 'common.last_edited',
        field: 'updated_at',
        width: '15%',
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
    roleOptions: [],
  }),
  computed: {
    deleteBtnIcon() {
      return '<i class="fas fa-trash fa-fw"/>';
    },
  },
  mounted() {
    this.loadUsers();
    this.loadOptions();
    this.$store.commit('SET_CURRENT_PAGE_TITLE', 'setting.users');
    this.$store.commit('SET_PAGE_BACK_LINK', '/settings');
  },
  methods: {
    isCurrentLoggedInUser(id) {
      return this.$store.state.currentUserInfo?.id === id;
    },
    async loadUsers() {
      this.resetState();

      try {
        const loadUsersResponse = await axios.get('/api/user');
        if (loadUsersResponse.status === 200) {
          this.rows = loadUsersResponse.data;
          this.rows.map((row) => {
            row.isSummitingRole = false;
            return row;
          });
        }
      } catch (err) {
        this.$Toast.show({
          type: 'error',
          message: err.response.data.message,
        });
      }

      this.isLoading = false;
    },
    gotoEdit(id) {
      this.$router.push(`/settings/users/edit/${id}`);
    },
    async deleteUser(id, email) {
      this.isLoading = true;
      this.$Toast.showLoading({
        title: 'Deleting...',
      });

      try {
        axios.delete(`/api/user/${id}`);
        this.$Toast.show({
          type: 'success',
          message: `Successfully deleted user [${email}]`,
        });

        this.loadUsers();
      } catch (err) {
        this.$Toast.show({
          type: 'error',
          message: err.response.data.message,
        });
      }
    },
    async loadOptions() {
      const optionsResponse = await axios.options('/api/role');
      this.roleOptions = optionsResponse.data;
    },
    async saveRole(value, row) {
      if (row.role === value) {
        return;
      }

      row.isSummitingRole = true;
      this.$Toast.showLoading({
        title: 'Updating...',
      });

      try {
        await axios.put(`/api/user/${row.id}`, {
          role: value,
        });
        row.role = value;
        this.$Toast.show({
          type: 'success',
          message: 'Successfully updated user role',
        });
      } catch (err) {
        this.$Toast.show({
          type: 'error',
          message: err.response.data.message,
        });
      }

      row.isSummitingRole = false;
    },
    resetState() {
      this.isLoading = true;
      this.rows = [];
    },
  },
};
</script>

<style scoped>
    .btn-progress {
        background-image: url("/images/spinner.svg");
    }
</style>
