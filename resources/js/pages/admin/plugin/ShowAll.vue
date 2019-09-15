<template>
    <card>
        <template v-slot:header>
            <h4>Plugins&nbsp;
                <router-link to="/plugins/installer" class="btn btn-icon icon-left btn-primary">
                    <i class="fas fa-plus"></i>Install
                </router-link>
            </h4>
        </template>

        <vcl-table :columns="5" v-if="isLoading"></vcl-table>

        <vue-good-table :columns="columns"
                        :rows="rows"
                        :search-options="{enabled: true}"
                        :selectOptions="{enabled: true, selectOnCheckboxOnly: true}"
                        styleClass="vgt-table table-hover condensed"
                        v-else>
            <template slot="table-row" slot-scope="props">
                <span v-if="props.column.field === 'action'">
                    <span class="table-actions">
                        <!-- delete button -->
                        <confirm-modal :body="`Confirm Delete Plugin [${props.row.name}] ?`"
                                       :cfm-btn-class="{btn: true, 'btn-danger': true}"
                                       :is-btn-html="true"
                                       :show-btn="true"
                                       :trigger-btn-class="{btn: true, 'btn-icon': true, 'btn-sm': true, 'btn-danger': true}"
                                       :trigger-btn-text="deleteBtnIcon"
                                       trigger-btn-tooltip="Delete"
                                       @confirm="deletePlugin(props.row.id, props.row.name)"
                                       title="Confirmation">
                        </confirm-modal>
                        <!-- #delete button -->
                    </span>
                    <i class="fas fa-ellipsis-v text-muted show-action-icon"></i>
                </span>
                <span v-else-if="props.column.field === 'enabled_disabled_state'">
                    <enable-disable-plugin :plugin="props.row"></enable-disable-plugin>
                </span>
                <span v-else>
                    {{props.formattedRow[props.column.field]}}
                </span>
            </template>
        </vue-good-table>
    </card>
</template>

<script>
    import {VueGoodTable} from 'vue-good-table';
    import Card from '@components/Card';
    import {VclTable} from 'vue-content-loading';
    import ConfirmModal from '@components/modal/ConfirmModal';
    import EnableDisablePlugin from './components/EnableDisablePlugin';
    import {ToggleButton} from 'vue-js-toggle-button';

    export default {
        data: () => ({
            columns: [
                {
                    label: 'Name',
                    field: 'name',
                    width: '25%'
                },
                {
                    label: 'Version',
                    field: 'ver',
                    width: '10%'
                },
                {
                    label: 'Author',
                    field: 'author',
                    width: '10%'
                },
                {
                    label: 'Description',
                    field: 'desc',
                    width: '44%'
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
                    width: '1%'
                }
            ],
            rows: [],
            isLoading: true
        }),
        computed: {
            deleteBtnIcon() {
                return '<i class="fas fa-trash fa-fw"></i>';
            }
        },
        methods: {
            loadPlugins() {
                axios.get('/api/plugin')
                    .then(response => {
                        if (response.status === 200) {
                            this.rows = response.data;
                        }
                        //nothing to assign for 204
                    })
                    .catch(err => {
                        this.$Toast.show({
                            type: 'error',
                            message: err.response.data.message
                        });
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            },
            deletePlugin(id, name) {
                this.isLoading = true;
                this.$Toast.showLoading({
                    title: 'Deleting...'
                });

                axios.delete(`/api/plugin/${id}`)
                    .then(response => {
                        this.$Toast.show({
                            type: 'success',
                            message: `Successfully deleted plugin [${name}]`
                        });

                        this.loadPlugins();
                    })
                    .catch(err => {
                        this.isLoading = false;
                        this.$Toast.show({
                            type: 'error',
                            message: err.response.data.message
                        });
                    });
            },
        },
        components: {
            EnableDisablePlugin, VueGoodTable, Card, VclTable, ConfirmModal, ToggleButton
        },
        created() {
            this.loadPlugins();
            this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Plugins');
        }
    }
</script>

<style scoped>

</style>
