<template>
    <card :is-collapsible="true" class="mb-1">
        <template v-slot:header>
            <h4>Tags</h4>
        </template>

        <form-content-loading :form-amount="1" v-if="isLoading"></form-content-loading>

        <multiselect :loading="isSearching"
                     :multiple="true"
                     :options="tags"
                     :searchable="true"
                     :taggable="true"
                     @search-change="searchTag"
                     @tag="addTag"
                     deselectLabel="remove"
                     label="name"
                     placeholder="Search or add a tag"
                     selectLabel="select"
                     tag-placeholder="Add this as new tag"
                     track-by="id"
                     v-model="selectedTags"
                     v-else></multiselect>
    </card>
</template>

<script>
    import Card from '@components/Card';
    import Multiselect from 'vue-multiselect';
    import FormContentLoading from '@components/content_loading/FormContentLoading';

    export default {
        props: ['value'],
        data: () => ({
            selectedTags: [],
            tags: [],
            generatedNewTag: [],
            isLoading: true,
            isSearching: false,
        }),
        watch: {
            value: {
                handler(newValue) {
                    this.selectedTags = newValue;
                },
                immediate: true
            },
            selectedTags(newValue) {
                this.$emit('input', newValue);
            }
        },
        methods: {
            addTag(newTag) {
                const tag = {
                    name: newTag,
                    id: this.$Utils.getRandomId()
                };
                // this.generatedNewTag.push(tag);
                this.tags.push(tag);
                this.selectedTags.push(tag);
            },
            searchTag(query = null) {
                this.isSearching = true;
                axios.get(`/api/tag/search` + (query ? `?name=${query}` : ''))
                    .then(response => {
                        this.tags = response.data;
                        // this.tags.push(...this.generatedNewTag);
                    })
                    .catch(error => {
                        if (error.response.status === 404) {
                            this.tags = [];
                        }
                    })
                    .finally(() => {
                        this.isLoading = false;
                        this.isSearching = false;
                    })
            },
        },
        components: {
            Card, Multiselect, FormContentLoading
        },
        created() {
            this.searchTag();
        }
    }
</script>

<style scoped>

</style>
