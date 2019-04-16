<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <card>
        <template v-slot:header>
            <h4>All Users&nbsp;
                <router-link to="/setting/users/create" class="btn btn-icon icon-left btn-primary">
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
                <div v-else-if="props.column.field === 'role'">
                    <span v-if="isCurrentLoggedInUser(props.row.id)">{{props.formattedRow[props.column.field]}}</span>
                    <template v-else>
                        <xeditable :select-options="roleOptions"
                                   :value="props.formattedRow[props.column.field]"
                                   @input="saveRole($event, props.row)"
                                   input-type="select"
                                   v-if="!props.row.isSummitingRole"></xeditable>
                        <div v-else><a class="btn disabled btn-progress">Loading</a></div>
                    </template>
                </div>
                <span v-else-if="props.column.field === 'action'">
                    <template v-if="!isCurrentLoggedInUser(props.row.id)">
                        <span class="table-actions">
                            <button class="btn btn-icon btn-info btn-sm" @click="gotoEdit(props.row.id)" title="Edit">
                                <i class="fas fa-edit fa-fw"></i>
                            </button>
                            <!-- delete button -->
                            <confirm-modal :body="`Confirm Delete User [${props.row.email}] ?`"
                                           :cfm-btn-class="{btn: true, 'btn-danger': true}"
                                           :is-btn-html="true"
                                           :show-btn="true"
                                           :trigger-btn-class="{btn: true, 'btn-icon': true, 'btn-sm': true, 'btn-danger': true}"
                                           :trigger-btn-text="deleteBtnIcon"
                                           trigger-btn-tooltip="Delete"
                                           @confirm="deleteUser(props.row.id, props.row.email)"
                                           title="Confirmation">
                            </confirm-modal>
                            <!-- #delete button -->
                        </span>
                        <i class="fas fa-ellipsis-v text-muted show-action-icon"></i>
                    </template>
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
    import Xeditable from '@components/Xeditable';
    import {VclTable} from 'vue-content-loading';
    import ConfirmModal from '@components/modal/ConfirmModal';

    export default {
        data: () => ({
            columns: [
                {
                    label: 'Name',
                    field: 'name',
                    width: '20%'
                },
                {
                    label: 'Email',
                    field: 'email',
                    width: '20%'
                },
                {
                    label: 'Role',
                    field: 'role',
                    width: '30%'
                },
                {
                    label: 'Created At',
                    field: 'created_at',
                    width: '15%'
                },
                {
                    label: 'Last edited',
                    field: 'updated_at',
                    width: '15%'
                },
                {
                    label: '',
                    field: 'action',
                    tdClass: 'text-center show-action',
                    width: '1%'
                }
            ],
            rows: [],
            isLoading: true,
            roleOptions: [],
        }),
        computed: {
            deleteBtnIcon() {
                return '<i class="fas fa-trash fa-fw"></i>';
            }
        },
        methods: {
            isCurrentLoggedInUser(id) {
                return this.$store.state.currentUserInfo ? this.$store.state.currentUserInfo.id === id : false;
            },
            loadUsers() {
                this.resetState();
                axios.get('/api/user')
                    .then(response => {
                        if (response.status === 200) {
                            this.rows = response.data;
                            this.rows.map(row => row.isSummitingRole = false);
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
                this.$router.push(`/settings/users/edit/${id}`);
            },
            deleteUser(id, email) {
                this.isLoading = true;
                this.$Toast.showLoading({
                    title: 'Deleting...'
                });

                axios.delete(`/api/user/${id}`)
                    .then(response => {
                        this.$Toast.show({
                            type: 'success',
                            message: `Successfully deleted user [${email}]`
                        });

                        this.loadUsers();
                    })
                    .catch(err => {
                        this.$Toast.show({
                            type: 'error',
                            message: err.response.data.message
                        });
                    });
            },
            loadOptions() {
                axios.options('/api/role')
                    .then(response => {
                        this.roleOptions = response.data;
                    });
            },
            saveRole(value, row) {
                if (row.role === value) {
                    return;
                }

                row.isSummitingRole = true;
                this.$Toast.showLoading({
                    title: 'Updating...'
                });
                axios.put(`/api/user/${row.id}`, {
                    role: value
                }).then(response => {
                    row.role = value;
                    this.$Toast.show({
                        type: 'success',
                        message: `Successfully updated user role`
                    });
                }).catch(err => {
                    this.$Toast.show({
                        type: 'error',
                        message: err.response.data.message
                    });
                }).finally(() => {
                    row.isSummitingRole = false;
                });
            },
            resetState() {
                this.isLoading = true;
                this.rows = [];
            }
        },
        components: {
            VueGoodTable, Card, VclTable, ConfirmModal, Xeditable
        },
        created() {
            this.loadUsers();
            this.loadOptions();
            this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Users');
            this.$store.commit('SET_PAGE_BACK_LINK', '/settings');
        }
    }
</script>

<style scoped>
    .btn-progress {
        background-image: url("/images/spinner.svg");
    }
</style>
