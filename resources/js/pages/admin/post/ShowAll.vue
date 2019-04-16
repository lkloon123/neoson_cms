<template>
    <card>
        <template v-slot:header>
            <h4>All Posts&nbsp;
                <router-link to="/posts/create" class="btn btn-icon icon-left btn-primary">
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
                <span v-if="props.column.field === 'updated_at'">
                    {{formatToAgoDate(props.formattedRow[props.column.field])}}
                </span>
                <span v-else-if="props.column.field === 'action'">
                    <span class="table-actions">
                        <button class="btn btn-icon btn-info btn-sm" @click="gotoEdit(props.row.id)" title="Edit">
                            <i class="fas fa-edit fa-fw"></i>
                        </button>
                        <!-- delete button -->
                        <confirm-modal :body="`Confirm Delete Post [${props.row.title}] ?`"
                                       :cfm-btn-class="{btn: true, 'btn-danger': true}"
                                       :is-btn-html="true"
                                       :show-btn="true"
                                       :trigger-btn-class="{btn: true, 'btn-icon': true, 'btn-sm': true, 'btn-danger': true}"
                                       :trigger-btn-text="deleteBtnIcon"
                                       trigger-btn-tooltip="Delete"
                                       @confirm="deletePost(props.row.id, props.row.title)"
                                       title="Confirmation">
                        </confirm-modal>
                        <!-- #delete button -->
                    </span>
                    <i class="fas fa-ellipsis-v text-muted show-action-icon"></i>
                </span>
                <span v-else-if="props.column.field === 'status'">
                    <span class="badge badge-success" v-if="props.formattedRow[props.column.field] === 'Publish'">{{props.formattedRow[props.column.field]}}</span>
                    <span class="badge badge-warning" v-else>{{props.formattedRow[props.column.field]}}</span>
                </span>
                <span v-else-if="!props.formattedRow[props.column.field]">
                    &mdash;
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
                    width: '32%'
                },
                {
                    label: 'Author',
                    field: 'author.name',
                    width: '20%'
                },
                {
                    label: 'Tags',
                    field: (row) => row.tags.map(tag => tag.name).join(', '),
                    width: '20%'
                },
                {
                    label: 'Status',
                    field: 'status',
                    width: '10%'
                },
                {
                    label: 'Last edited',
                    field: 'updated_at',
                    width: '17%'
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
            loadPosts() {
                this.resetState();
                axios.get('/api/post')
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
                this.$router.push(`/posts/edit/${id}`);
            },
            deletePost(id, title) {
                this.isLoading = true;
                this.$Toast.showLoading({
                    title: 'Deleting...'
                });

                axios.delete(`/api/post/${id}`)
                    .then(response => {
                        this.$Toast.show({
                            type: 'success',
                            message: `Successfully deleted post [${title}]`
                        });

                        this.loadPosts();
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
            this.loadPosts();
            this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Posts');
        }
    }
</script>

<style scoped>
</style>
