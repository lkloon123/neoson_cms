<template>
  <card>
    <template v-slot:header>
      <h4>
        Plugins&nbsp;
        <router-link
          to="/plugins/installer"
          class="btn btn-icon icon-left btn-primary"
        >
          <i class="fas fa-plus" /> Install
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
      style-class="vgt-table table-hover condensed"
    >
      <template
        slot="table-row"
        slot-scope="props"
      >
        <span v-if="props.column.field === 'action'">
          <span class="table-actions">
            <!-- delete button -->
            <confirm-modal
              :body="`Confirm Delete Plugin [${props.row.name}] ?`"
              :cfm-btn-class="{btn: true, 'btn-danger': true}"
              :is-btn-html="true"
              :show-btn="true"
              :trigger-btn-class="{btn: true, 'btn-icon': true, 'btn-sm': true, 'btn-danger': true}"
              :trigger-btn-text="deleteBtnIcon"
              trigger-btn-tooltip="Delete"
              title="Confirmation"
              @confirm="deletePlugin(props.row.id, props.row.name)"
            />
            <!-- #delete button -->
          </span>
          <i class="fas fa-ellipsis-v text-muted show-action-icon" />
        </span>
        <span v-else-if="props.column.field === 'enabled_disabled_state'">
          <enable-disable-plugin
            :plugin="props.row"
            @updated="updatePluginState($event, props.index)"
          />
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
import EnableDisablePlugin from './components/EnableDisablePlugin';

export default {
  components: {
    EnableDisablePlugin, VueGoodTable, Card, VclTable, ConfirmModal,
  },
  data: () => ({
    columns: [
      {
        label: 'Name',
        field: 'name',
        width: '25%',
      },
      {
        label: 'Version',
        field: 'ver',
        width: '10%',
      },
      {
        label: 'Author',
        field: 'author',
        width: '10%',
      },
      {
        label: 'Description',
        field: 'desc',
        width: '44%',
      },
      {
        label: 'Enabled',
        field: 'enabled_disabled_state',
        width: '10%',
      },
      {
        label: '',
        field: 'action',
        tdClass: 'text-center show-action',
        width: '1%',
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
    this.loadPlugins();
    this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Plugins');
  },
  methods: {
    updatePluginState(newPluginState, index) {
      this.$set(this.rows, index, newPluginState);
    },
    async loadPlugins() {
      try {
        const pluginsResponse = await axios.get('/api/plugin');
        if (pluginsResponse.status === 200) {
          this.rows = pluginsResponse.data;
        }
      } catch (err) {
        this.$Toast.show({
          type: 'error',
          message: err.response.data.message,
        });
      }

      this.isLoading = false;
    },
    async deletePlugin(id, name) {
      this.isLoading = true;
      this.$Toast.showLoading({
        title: 'Deleting...',
      });

      try {
        await axios.delete(`/api/plugin/${id}`);
        this.$Toast.show({
          type: 'success',
          message: `Successfully deleted plugin [${name}]`,
        });

        this.loadPlugins();
      } catch (err) {
        this.$Toast.show({
          type: 'error',
          message: err.response.data.message,
        });
      }

      this.isLoading = false;
    },
  },
};
</script>

<style scoped>

</style>
