<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <card :is-collapsible="true" class="mb-1">
        <template v-slot:header>
            <h4>Custom Link</h4>
        </template>

        <form-content-loading :formAmount="2" v-if="isLoading"></form-content-loading>

        <div v-else>
            <div class="form-group">
                <label for="menu-label">Label</label>
                <input class="form-control"
                       id="menu-label"
                       name="Label"
                       type="text"
                       v-model="menuLabel"/>
            </div>

            <div class="form-group">
                <label for="url">Url</label>
                <input class="form-control"
                       :class="{'is-invalid': errors.first('Url')}"
                       id="url"
                       name="Url"
                       placeholder="http://"
                       type="text"
                       v-model="url"
                       v-validate="{required: true, url:{require_host: false}}"/>

                <div class="invalid-feedback">
                    {{errors.first('Url')}}
                </div>
            </div>

            <button class="btn btn-primary" @click="addToMenu">Add to menu</button>
        </div>
    </card>
</template>

<script>
    import Card from '@components/Card';
    import {mapMutations} from 'vuex';
    import FormContentLoading from '@components/content_loading/FormContentLoading';

    export default {
        data: () => ({
            type: 'custom_link',
            menuLabel: '',
            url: '',
        }),
        computed: {
            isLoading() {
                return this.$store.state.menu.coreLoading;
            }
        },
        methods: {
            ...mapMutations('menu', ['ADD_MENU_ITEM']),
            addToMenu() {
                this.$validator.validateAll().then(valid => {
                    if (valid) {
                        this.ADD_MENU_ITEM(this.$data);
                        this.reset();
                    }
                });
            },
            reset() {
                this.menuLabel = '';
                this.url = '';
            }
        },
        components: {
            Card, FormContentLoading
        }
    }
</script>

<style scoped>
    #url {
        font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    }
</style>
