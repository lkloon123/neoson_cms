<template>
  <card>
    <template v-slot:header>
      <h4>
        {{ languageData.title }}&nbsp;
        <create-form
          v-if="hasPermission('create', 'translation')"
          @input="loadTranslation"
        />
      </h4>
    </template>

    <vue-good-table
      ref="translationTable"
      :columns="columns"
      :rows="rows"
      :search-options="{enabled: true}"
      :sort-options="{enabled: false}"
      :group-options="{
        enabled: true,
        collapsable: true
      }"
      style-class="vgt-table table-hover condensed bordered"
    >
      <template
        slot="table-column"
        slot-scope="props"
      >
        <span>
          {{ $t(props.column.label) }}
        </span>
      </template>

      <template slot="table-actions">
        <button
          class="btn btn-primary btn-sm h-100"
          @click="collapseExpand"
        >
          {{ $t(collapseExpandLabel) }}
        </button>
      </template>
      <template
        slot="table-header-row"
        slot-scope="props"
      >
        <span class="ml-3">
          {{ props.row.label }}
        </span>
      </template>

      <template
        slot="table-row"
        slot-scope="props"
      >
        <span v-if="props.column.field === 'updated_at' || props.column.field === 'created_at'">
          {{ formatToAgoDate(props.formattedRow[props.column.field]) }}
        </span>
        <template v-else-if="props.column.field === 'text'">
          <xeditable
            v-if="!props.row.isSubmmiting"
            :value="props.formattedRow[props.column.field]"
            @input="updateTranslation($event, props.row)"
          />
        </template>
        <span v-else>
          {{ props.formattedRow[props.column.field] }}
        </span>
      </template>
    </vue-good-table>
  </card>
</template>

<script>
import { VueGoodTable } from 'vue-good-table';
import axios from 'axios';
import Card from '@components/Card';
import Xeditable from '@components/Xeditable';
import DateFormattingMixin from '@mixins/date_formatting_mixin';
import PermissionMixin from '@mixins/permission_mixin';
import CreateForm from './components/CreateForm';

export default {
  components: {
    VueGoodTable, Card, Xeditable, CreateForm,
  },
  mixins: [DateFormattingMixin, PermissionMixin],
  props: {
    mode: {
      type: String,
      default: 'create',
    },
  },
  data: () => ({
    columns: [
      {
        label: 'translation.key',
        field: 'key',
        width: '20%',
      },
      {
        label: 'translation.text',
        field: 'text',
        width: '65%',
      },
      {
        label: 'common.last_edited',
        field: 'updated_at',
        width: '15%',
      },
    ],
    rows: [],
    languageData: null,
    isLoading: true,
    expanded: false,
  }),
  computed: {
    collapseExpandLabel() {
      return this.expanded ? 'common.collapse_all' : 'common.expand_all';
    },
  },
  async mounted() {
    if (this.mode === 'edit') {
      this.$store.commit('SET_CURRENT_PAGE_TITLE', 'translation.edit_translation');

      // fetch data from server
      await this.loadTranslation();
    } else {
      this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Create Translation');
    }

    this.$store.commit('SET_PAGE_BACK_LINK', '/settings/translations');
  },
  methods: {
    async loadTranslation() {
      const transformedResponse = [];
      try {
        const translationResponse = await axios.get(`/api/language/${this.$route.params.id}`);
        if (translationResponse.status === 200) {
          Object.keys(translationResponse.data.translations).forEach((group) => {
            transformedResponse.push({
              mode: 'span',
              label: group,
              html: false,
              children: translationResponse.data.translations[group],
            });
          });

          delete translationResponse.data.translations;
          this.languageData = translationResponse.data;
          this.rows = transformedResponse;
        }
      } catch (err) {
        this.$Toast.show({
          type: 'error',
          message: err.response.data.message,
        });
      }
    },
    async updateTranslation(text, row) {
      if (row.text === text) {
        return;
      }

      row.isSubmitting = true;
      this.$Toast.showLoading({
        title: 'Updating...',
      });

      try {
        await axios.put(`/api/translation/${row.id}`, {
          text,
        });
        row.text = text;
        this.$Toast.show({
          type: 'success',
          message: 'Successfully updated translation',
        });
      } catch (err) {
        this.$Toast.show({
          type: 'error',
          message: err.response.data.message,
        });
      }

      row.isSubmmiting = false;
    },
    collapseExpand() {
      if (this.expanded) {
        this.$refs.translationTable.collapseAll();
      } else {
        this.$refs.translationTable.expandAll();
      }

      this.expanded = !this.expanded;
    },
  },
};
</script>

<style scoped>
</style>
