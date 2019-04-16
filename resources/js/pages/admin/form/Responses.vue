<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <card>
        <template v-slot:header>
            <h4>{{formName}} responses</h4>
        </template>

        <vcl-table :columns="5" v-if="isLoading"></vcl-table>

        <vue-good-table :columns="columns"
                        :line-numbers="true"
                        :pagination-options="{enabled: true}"
                        :rows="rows"
                        :search-options="{enabled: true}"
                        styleClass="vgt-table table-hover condensed"
                        v-else>
            <template v-slot:table-actions>
                <button class="btn btn-icon btn-sm btn-secondary btn-refresh" @click="loadFormResponse">
                    <i class="fas fa-sync"></i>
                </button>
            </template>
        </vue-good-table>
    </card>
</template>

<script>
    import {VueGoodTable} from 'vue-good-table';
    import Card from '@components/Card';
    import {VclTable} from 'vue-content-loading';

    export default {
        data: () => ({
            columns: [],
            rows: [],
            formName: '',
            isLoading: true
        }),
        methods: {
            loadFormResponse() {
                this.resetState();
                axios.get(`/api/form/response/${this.$route.params.id}`)
                    .then(response => {
                        this.columns = response.data.columns;
                        this.rows = response.data.data;
                        this.formName = response.data.form_name;
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
            resetState() {
                this.isLoading = true;
                this.rows = [];
            }
        },
        components: {
            VueGoodTable, Card, VclTable
        },
        created() {
            this.loadFormResponse();
            this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Form Responses');
            this.$store.commit('SET_PAGE_BACK_LINK', '/forms');
        }
    }
</script>

<style scoped>
    .btn-refresh {
        margin-top: 2px;
    }
</style>
