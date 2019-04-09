<template>
    <card>
        <template v-slot:header>
            <h4>All Roles&nbsp;
                <router-link to="/settings/roles/create" class="btn btn-icon icon-left btn-primary">
                    <i class="fas fa-plus"></i>Create
                </router-link>
            </h4>
        </template>

        <vcl-table :columns="5" v-if="isLoading"></vcl-table>

        <vue-good-table :columns="columns"
                        :rows="rows"
                        :search-options="{enabled: true}"
                        :selectOptions="{enabled: true, selectOnCheckboxOnly: true}"
                        :pagination-options="{enabled: true}"
                        styleClass="vgt-table table-hover condensed"
                        v-else>
            <template slot="table-row" slot-scope="props">
                <span v-if="props.column.field === 'updated_at' || props.column.field === 'created_at'">
                    {{formatToAgoDate(props.formattedRow[props.column.field])}}
                </span>
                <span v-else-if="props.column.field === 'action'">
                    <span class="table-actions">
                        <button class="btn btn-icon btn-info btn-sm" @click="gotoEdit(props.row.id)" title="Edit">
                            <i class="fas fa-edit fa-fw"></i>
                        </button>
                        <!-- delete button -->
                        <confirm-modal :body="`Confirm Delete Role [${props.row.name}] ?`"
                                       :cfm-btn-class="{btn: true, 'btn-danger': true}"
                                       :is-btn-html="true"
                                       :show-btn="true"
                                       :trigger-btn-class="{btn: true, 'btn-icon': true, 'btn-sm': true, 'btn-danger': true}"
                                       :trigger-btn-text="deleteBtnIcon"
                                       trigger-btn-tooltip="Delete"
                                       @confirm="deleteRole(props.row.id, props.row.name)"
                                       title="Confirmation">
                        </confirm-modal>
                        <!-- #delete button -->
                    </span>
                    <i class="fas fa-ellipsis-v text-muted show-action-icon"></i>
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

    export default {
        data: () => ({
            columns: [
                {
                    label: 'Title',
                    field: 'title',
                    width: '60%'
                },
                {
                    label: 'Created At',
                    field: 'created_at',
                    width: '20%'
                },
                {
                    label: 'Last edited',
                    field: 'updated_at',
                    width: '20%'
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
            loadRoles() {
                this.resetState();
                axios.get('/api/role')
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
            formatToAgoDate(inputDateTime) {
                return moment(inputDateTime).fromNow();
            },
            gotoEdit(id) {
                this.$router.push(`/settings/roles/edit/${id}`);
            },
            deleteRole(id, title) {
                this.isLoading = true;
                this.$Toast.showLoading({
                    title: 'Deleting...'
                });

                axios.delete(`/api/role/${id}`)
                    .then(response => {
                        this.$Toast.show({
                            type: 'success',
                            message: `Successfully deleted role [${title}]`
                        });

                        this.loadRoles();
                    })
                    .catch(err => {
                        this.isLoading = false;
                        this.$Toast.show({
                            type: 'error',
                            message: err.response.data.message
                        });
                    });
            },
            resetState() {
                this.isLoading = true;
                this.rows = [];
            }
        },
        components: {
            VueGoodTable, Card, VclTable, ConfirmModal
        },
        created() {
            this.loadRoles();
            this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Roles');
            this.$store.commit('SET_PAGE_BACK_LINK', '/settings');
        }
    }
</script>

<style scoped>
    @import '~vue-good-table/dist/vue-good-table.css';
    @import '~@css/vue_good_table_fix.scss';
</style>
