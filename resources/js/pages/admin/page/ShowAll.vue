<template>
  <card>
    <template v-slot:header>
      <h4>
        {{ $t('page.all_pages') }}&nbsp;
        <router-link
          v-if="hasPermission('create', 'page')"
          to="/pages/create"
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
        <span v-if="props.column.field === 'updated_at'">
          {{ formatToAgoDate(props.formattedRow[props.column.field]) }}
        </span>
        <span v-else-if="props.column.field === 'action'">
          <template v-if="hasPermission('update', 'page') || hasPermission('delete', 'page')">
            <span class="table-actions">
              <button
                v-if="hasPermission('update', 'page')"
                class="btn btn-icon btn-info btn-sm"
                :title="$t('common.edit')"
                @click="gotoEdit(props.row.id)"
              >
                <i class="fas fa-edit fa-fw" />
              </button>
              <!-- delete button -->
              <confirm-modal
                v-if="hasPermission('delete', 'page')"
                :body="$t('common.confirm_delete_confirmation', {entity: $t('menu.pages'), item: props.row.title})"
                :cfm-btn-class="{btn: true, 'btn-danger': true}"
                :is-btn-html="true"
                :show-btn="true"
                :trigger-btn-class="{btn: true, 'btn-icon': true, 'btn-sm': true, 'btn-danger': true}"
                :trigger-btn-text="deleteBtnIcon"
                :trigger-btn-tooltip="$t('common.delete')"
                :title="$t('common.confirmation')"
                @confirm="deletePage(props.row.id, props.row.title)"
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
        <span v-else>
          {{ $t(props.formattedRow[props.column.field]) }}
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
        label: 'common.title',
        field: 'title',
        width: '40%',
      },
      {
        label: 'page.author',
        field: 'author.name',
        width: '20%',
      },
      {
        label: 'common.status',
        field: 'status',
        width: '19%',
      },
      {
        label: 'common.last_edited',
        field: 'updated_at',
        width: '20%',
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
  mounted() {
    this.loadPages();
    this.$store.commit('SET_CURRENT_PAGE_TITLE', 'menu.pages');
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
