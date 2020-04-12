<template>
  <card>
    <template v-slot:header>
      <h4>{{ $t('translation.languages') }}</h4>
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
          <span class="table-actions">
            <button
              class="btn btn-icon btn-info btn-sm"
              :title="$t('common.edit')"
              @click="gotoEdit(props.row.id)"
            >
              <i class="fas fa-edit fa-fw" />
            </button>
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
import Card from '@components/Card';
import { VueGoodTable } from 'vue-good-table';
import { VclTable } from 'vue-content-loading';
import axios from 'axios';
import DateFormattingMixin from '@mixins/date_formatting_mixin';

export default {
  components: {
    VueGoodTable, Card, VclTable,
  },
  mixins: [DateFormattingMixin],
  data: () => ({
    columns: [
      {
        label: 'common.title',
        field: 'title',
        width: '32%',
      },
      {
        label: 'translation.code',
        field: 'code',
        width: '30%',
      },
      {
        label: 'translation.translated',
        field: 'count',
        width: '20%',
      },
      {
        label: 'common.last_edited',
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
  mounted() {
    this.loadLanguages();
    this.$store.commit('SET_CURRENT_PAGE_TITLE', 'setting.translation');
    this.$store.commit('SET_PAGE_BACK_LINK', '/settings');
  },
  methods: {
    async loadLanguages() {
      this.resetState();

      try {
        const languagesResponse = await axios.get('/api/language');
        if (languagesResponse.status === 200) {
          this.rows = languagesResponse.data;
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
      this.$router.push(`/settings/translations/edit/${id}`);
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
