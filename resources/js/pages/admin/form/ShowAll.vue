<template>
  <card>
    <template v-slot:header>
      <h4>
        All Forms&nbsp;
        <router-link
          v-if="hasPermission('create', 'form')"
          to="/forms/create"
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
        <span v-if="props.column.field === 'updated_at' || props.column.field === 'created_at'">
          {{ formatToAgoDate(props.formattedRow[props.column.field]) }}
        </span>
        <span v-else-if="props.column.field === 'responses'">
          <router-link
            v-if="props.row.responses > 0"
            :to="`/forms/responses/${props.row.id}`"
            class="badge badge-info"
          >
            {{ props.formattedRow[props.column.field] }}
          </router-link>
          <span
            v-else
            class="badge badge-info"
          >
            {{ props.formattedRow[props.column.field] }}
          </span>
        </span>
        <span v-else-if="props.column.field === 'action'">
          <template v-if="hasPermission('update', 'form') || hasPermission('delete', 'form')">
            <span class="table-actions">
              <button
                v-if="hasPermission('update', 'form')"
                class="btn btn-icon btn-info btn-sm"
                title="Edit"
                @click="gotoEdit(props.row.id)"
              >
                <i class="fas fa-edit fa-fw" />
              </button>
              <!-- delete button -->
              <confirm-modal
                v-if="hasPermission('delete', 'form')"
                :body="`Confirm Delete Form [${props.row.name}] ?`"
                :cfm-btn-class="{btn: true, 'btn-danger': true}"
                :is-btn-html="true"
                :show-btn="true"
                :trigger-btn-class="{btn: true, 'btn-icon': true, 'btn-sm': true, 'btn-danger': true}"
                :trigger-btn-text="deleteBtnIcon"
                trigger-btn-tooltip="Delete"
                title="Confirmation"
                @confirm="deleteForm(props.row.id, props.row.name)"
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
import DateFormattingMixin from '@mixins/date_formatting_mixin';
import PermissionMixin from '@mixins/permission_mixin';

export default {
  components: {
    VueGoodTable, Card, VclTable, ConfirmModal,
  },
  mixins: [PermissionMixin, DateFormattingMixin],
  data: () => ({
    columns: [
      {
        label: 'Name',
        field: 'name',
        width: '40%',
      },
      {
        label: 'Responses',
        field: 'responses',
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
    this.loadForms();
    this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Forms');
  },
  methods: {
    async loadForms() {
      this.resetState();

      try {
        const formResponse = await axios.get('/api/form');
        if (formResponse.status === 200) {
          this.rows = formResponse.data;
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
      this.$router.push(`/forms/edit/${id}`);
    },
    async deleteForm(id, name) {
      this.isLoading = true;
      this.$Toast.showLoading({
        title: 'Deleting...',
      });

      try {
        await axios.delete(`/api/form/${id}`);
        this.$Toast.show({
          type: 'success',
          message: `Successfully deleted form [${name}]`,
        });

        this.loadForms();
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
    .badge-info[href]:focus, .badge-info[href]:hover {
        background-color: #0da8ee !important;
    }
</style>
