<template>
  <card>
    <template v-slot:header>
      <h4>Translations</h4>
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
      <template slot="table-actions">
        <button
          class="btn btn-primary btn-sm h-100"
          @click="collapseExpand"
        >
          {{ collapseExpandLabel }}
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
        <div v-else-if="props.column.field === 'text'">
          <xeditable
            v-if="!props.row.isSubmmiting"
            :value="props.formattedRow[props.column.field]"
            width="90%"
            @input="updateTranslation($event, props.row)"
          />
        </div>
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

export default {
  components: {
    VueGoodTable, Card, Xeditable,
  },
  mixins: [DateFormattingMixin],
  props: {
    mode: {
      type: String,
      default: 'create',
    },
  },
  data: () => ({
    columns: [
      {
        label: 'Key',
        field: 'key',
        width: '20%',
      },
      {
        label: 'Text',
        field: 'text',
        width: '65%',
      },
      {
        label: 'Last edited',
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
      return this.expanded ? 'Collapse All' : 'Expand All';
    },
  },
  async created() {
    if (this.mode === 'edit') {
      this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Edit Translation');

      // fetch data from server
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
    } else {
      this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Create Translation');
    }

    this.$store.commit('SET_PAGE_BACK_LINK', '/settings/translations');
  },
  methods: {
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
