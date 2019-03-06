<template>
    <div>
        <basic-card>
            <template v-slot:header>
                <h2>Pages &nbsp;
                    <button class="btn btn-success waves-effect">
                        <i class="material-icons">add</i><span>ADD</span>
                    </button>
                </h2>
            </template>
            <template v-slot:body>
                <vue-good-table :columns="columns"
                                :rows="rows"
                                :search-options="{enabled: true}"
                                :selectOptions="{enabled: true}"
                                styleClass="vgt-table bordered table-hover"></vue-good-table>
            </template>
        </basic-card>
    </div>
</template>

<script>
    import BasicCard from '../../components/BasicCard';
    import {VueGoodTable} from 'vue-good-table';

    export default {
        data: () => ({
            columns: [
                {
                    label: 'Title',
                    field: 'title'
                },
                {
                    label: 'Author',
                    field: 'author'
                },
                {
                    label: 'Date',
                    field: 'date',
                    type: 'date',
                    dateInputFormat: 'DD-MM-YYYY HH:mm:ss',
                    dateOutputFormat: 'DD-MM-YYYY HH:mm',
                    tdClass: 'text-left',
                    width: '250px'
                }
            ],
            rows: [
                {id: 1, title: "John", author: 20, date: '01-05-2018 18:24:59'},
            ]
        }),
        components: {
            BasicCard, VueGoodTable
        }
    }
</script>

<style scoped>
    @import '~vue-good-table/dist/vue-good-table.min.css';
    @import './../../../sass/vue_good_table_fix.scss';
</style>
