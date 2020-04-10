<template>
  <card>
    <template v-slot:header>
      <h4>
        {{ $t('tag.all_tags') }}&nbsp;
        <create-and-edit-form @input="loadTags" />
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
        <span v-if="props.column.field === 'action'">
          <span class="table-actions">
            <!-- edit form button -->
            <create-and-edit-form
              :value="props.row"
              mode="edit"
              @input="save($event, props.index)"
            />
            <!-- #edit form button -->
            <!-- delete button -->
            <confirm-modal
              :body="$t('common.confirm_delete_confirmation', {entity: $t('menu.tags'), item: props.row.name})"
              :cfm-btn-class="{btn: true, 'btn-danger': true}"
              :is-btn-html="true"
              :show-btn="true"
              :trigger-btn-class="{btn: true, 'btn-icon': true, 'btn-sm': true, 'btn-danger': true}"
              :trigger-btn-text="deleteBtnIcon"
              :trigger-btn-tooltip="$t('common.delete')"
              :title="$t('common.confirmation')"
              @confirm="deleteTag(props.row.id, props.row.name)"
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
import CreateAndEditForm from './components/CreateAndEditForm';

export default {
  components: {
    VueGoodTable, Card, VclTable, ConfirmModal, CreateAndEditForm,
  },
  mixins: [DateFormattingMixin],
  data: () => ({
    columns: [
      {
        label: 'common.count',
        field: 'name',
        width: '50%',
      },
      {
        label: 'page.slug',
        field: 'slug',
        width: '35%',
      },
      {
        label: 'common.count',
        field: 'count',
        type: 'number',
        thClass: 'text-left',
        tdClass: 'text-left',
        width: '14%',
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
    this.loadTags();
    this.$store.commit('SET_CURRENT_PAGE_TITLE', 'menu.tags');
  },
  methods: {
    async loadTags() {
      this.resetState();

      try {
        const loadTagsResponse = await axios.get('/api/tag');
        if (loadTagsResponse.status === 200) {
          this.rows = loadTagsResponse.data;
        }
      } catch (err) {
        this.$Toast.show({
          type: 'error',
          message: err.response.data.message,
        });
      }

      this.isLoading = false;
    },
    save(data, index) {
      this.rows[index] = Object.assign(this.rows[index], data);
    },
    async deleteTag(id, name) {
      this.isLoading = true;
      this.$Toast.showLoading({
        title: 'Deleting...',
      });

      try {
        await axios.delete(`/api/tag/${id}`);
        this.$Toast.show({
          type: 'success',
          message: `Successfully deleted tag [${name}]`,
        });

        this.loadTags();
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
