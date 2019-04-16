<template>
    <card>
        <template v-slot:header>
            <h4>All Tags&nbsp;
                <create-and-edit-form @input="loadTags"></create-and-edit-form>
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
                <span v-if="props.column.field === 'action'">
                    <span class="table-actions">
                        <!-- edit form button -->
                            <create-and-edit-form :value="props.row"
                                                  mode="edit"
                                                  @input="save($event, props.index)"></create-and-edit-form>
                        <!-- #edit form button -->
                        <!-- delete button -->
                        <confirm-modal :body="`Confirm Delete Tag [${props.row.name}] ?`"
                                       :cfm-btn-class="{btn: true, 'btn-danger': true}"
                                       :is-btn-html="true"
                                       :show-btn="true"
                                       :trigger-btn-class="{btn: true, 'btn-icon': true, 'btn-sm': true, 'btn-danger': true}"
                                       :trigger-btn-text="deleteBtnIcon"
                                       trigger-btn-tooltip="Delete"
                                       @confirm="deleteTag(props.row.id, props.row.name)"
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
    import CreateAndEditForm from './components/CreateAndEditForm';

    export default {
        data: () => ({
            columns: [
                {
                    label: 'Name',
                    field: 'name',
                    width: '50%'
                },
                {
                    label: 'Slug',
                    field: 'slug',
                    width: '35%'
                },
                {
                    label: 'Count',
                    field: 'count',
                    type: 'number',
                    thClass: 'text-left',
                    tdClass: 'text-left',
                    width: '14%'
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
        }),
        computed: {
            deleteBtnIcon() {
                return '<i class="fas fa-trash fa-fw"></i>';
            }
        },
        methods: {
            loadTags() {
                this.resetState();
                axios.get('/api/tag')
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
            save(data, index) {
                this.rows[index] = Object.assign(this.rows[index], data);
            },
            deleteTag(id, name) {
                this.isLoading = true;
                this.$Toast.showLoading({
                    title: 'Deleting...'
                });

                axios.delete(`/api/tag/${id}`)
                    .then(response => {
                        this.$Toast.show({
                            type: 'success',
                            message: `Successfully deleted tag [${name}]`
                        });

                        this.loadTags();
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
            VueGoodTable, Card, VclTable, ConfirmModal, CreateAndEditForm
        },
        created() {
            this.loadTags();
            this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Tags');
        }
    }
</script>

<style scoped>
</style>
