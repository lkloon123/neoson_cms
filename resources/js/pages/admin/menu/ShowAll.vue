<template>
  <card>
    <template v-slot:header>
      <h4>
        {{ $t('menu.all_menus') }}&nbsp;
        <router-link
          to="/menu/create"
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
        <span v-else-if="props.column.field === 'action'">
          <span class="table-actions">
            <button
              class="btn btn-icon btn-info btn-sm"
              :title="$t('common.edit')"
              @click="gotoEdit(props.row.id)"
            >
              <i class="fas fa-edit fa-fw" />
            </button>
            <!-- delete button -->
            <confirm-modal
              :body="$t('common.confirm_delete_confirmation', {entity: $t('menu.menu'), item: props.row.name})"
              :cfm-btn-class="{btn: true, 'btn-danger': true}"
              :is-btn-html="true"
              :show-btn="true"
              :trigger-btn-class="{btn: true, 'btn-icon': true, 'btn-sm': true, 'btn-danger': true}"
              :trigger-btn-text="deleteBtnIcon"
              :trigger-btn-tooltip="$t('common.delete')"
              :title="$t('common.confirmation')"
              @confirm="deleteMenu(props.row.id, props.row.name)"
            />
            <!-- #delete button -->
          </span>
          <i class="fas fa-ellipsis-v text-muted show-action-icon" />
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

export default {
  components: {
    VueGoodTable, Card, VclTable, ConfirmModal,
  },
  mixins: [DateFormattingMixin],
  data: () => ({
    columns: [
      {
        label: 'common.name',
        field: 'name',
        width: '60%',
      },
      {
        label: 'common.created_at',
        field: 'created_at',
        width: '20%',
      },
      {
        label: 'common.last_edited',
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
  mounted() {
    this.loadMenus();
    this.$store.commit('SET_CURRENT_PAGE_TITLE', 'menu.menu');
  },
  methods: {
    async loadMenus() {
      this.resetState();

      try {
        const menusResponse = await axios.get('/api/menu');
        if (menusResponse.status === 200) {
          this.rows = menusResponse.data;
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
      this.$router.push(`/menu/edit/${id}`);
    },
    async deleteMenu(id, name) {
      this.isLoading = true;
      this.$Toast.showLoading({
        title: 'Deleting...',
      });

      try {
        await axios.delete(`/api/menu/${id}`);
        this.$Toast.show({
          type: 'success',
          message: `Successfully deleted menu [${name}]`,
        });

        this.loadMenus();
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
