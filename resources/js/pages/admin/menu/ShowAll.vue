<template>
    <card>
        <template v-slot:header>
            <h4>All Menus&nbsp;
                <router-link to="/menu/create" class="btn btn-icon icon-left btn-primary">
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
                        <confirm-modal :body="`Confirm Delete Menu [${props.row.name}] ?`"
                                       :cfm-btn-class="{btn: true, 'btn-danger': true}"
                                       :is-btn-html="true"
                                       :show-btn="true"
                                       :trigger-btn-class="{btn: true, 'btn-icon': true, 'btn-sm': true, 'btn-danger': true}"
                                       :trigger-btn-text="deleteBtnIcon"
                                       trigger-btn-tooltip="Delete"
                                       @confirm="deleteMenu(props.row.id, props.row.name)"
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
                    label: 'Name',
                    field: 'name',
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
                    width: '19%'
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
            loadMenus() {
                this.resetState();
                axios.get('/api/menu')
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
                this.$router.push(`/menu/edit/${id}`);
            },
            deleteMenu(id, name) {
                this.isLoading = true;
                this.$Toast.showLoading({
                    title: 'Deleting...'
                });

                axios.delete(`/api/menu/${id}`)
                    .then(response => {
                        this.$Toast.show({
                            type: 'success',
                            message: `Successfully deleted menu [${name}]`
                        });

                        this.loadMenus();
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
            this.loadMenus();
            this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Menu');
        }
    }
</script>

<style scoped>
</style>
