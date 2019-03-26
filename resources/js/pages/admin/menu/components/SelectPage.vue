<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <card :is-collapsible="true">
        <template v-slot:header>
            <h4>Pages</h4>
        </template>

        <form-content-loading :formAmount="1" v-if="isNotReady"></form-content-loading>

        <div v-else>
            <div class="form-group">
                <label>All Pages</label>
                <multiselect :clear-on-select="false"
                             :close-on-select="false"
                             :internal-search="false"
                             :loading="isSearching"
                             :multiple="true"
                             :options="pages"
                             :searchable="true"
                             @search-change="searchPage"
                             deselectLabel="remove"
                             label="title"
                             selectLabel="select"
                             track-by="id"
                             v-model="selectedPages"></multiselect>
            </div>

            <button class="btn btn-primary" @click="addToMenu">Add to menu</button>
        </div>
    </card>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    import Card from '@components/Card';
    import {mapMutations} from 'vuex';
    import FormContentLoading from '@components/content_loading/FormContentLoading';

    export default {
        data: () => ({
            selectedPages: [],
            pages: [],
            isLoading: true,
            isSearching: false,
        }),
        computed: {
            isNotReady() {
                return this.isLoading || this.$store.state.menu.coreLoading;
            }
        },
        methods: {
            ...mapMutations('menu', ['ADD_MENU_ITEM']),
            searchPage(query = null) {
                this.isSearching = true;
                axios.get(`/api/page/search` + (query ? `?title=${query}` : ''))
                    .then(response => {
                        this.pages = response.data;
                    })
                    .catch(error => {
                        if (error.response.status === 404) {
                            this.pages = [];
                        }
                    })
                    .finally(() => {
                        this.isLoading = false;
                        this.isSearching = false;
                    })
            },
            addToMenu() {
                this.selectedPages.forEach((selectedPage) => {
                    let tmp = {
                        type: 'page',
                        pageId: selectedPage.id,
                        title: selectedPage.title,
                        slug: selectedPage.slug,
                        menuLabel: selectedPage.title
                    };

                    this.ADD_MENU_ITEM(tmp);
                });
                this.reset();
            },
            reset() {
                this.selectedPages = [];
            }
        },
        components: {
            Card, Multiselect, FormContentLoading
        },
        created() {
            this.searchPage();
        }
    }
</script>

<style scoped>

</style>
