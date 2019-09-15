<template>
    <div class="row">
        <div class="col-md-2 col-sm-2"></div>
        <div class="col-md-8 col-sm-8">
            <card>
                <template v-slot:header>
                    <h4>General Settings</h4>
                </template>

                <vcl-table v-if="isLoading"></vcl-table>

                <template v-else>
                    <template v-for="(setting, key) in settings">
                        <form-wrapper :form="forms[key]" v-model="settings[key]"></form-wrapper>
                    </template>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary btn-save" @click="save(group)">Save</button>
                    </div>
                </template>
            </card>
        </div>
    </div>
</template>

<script>
    import Card from '@components/Card';
    import Mixin from './mixin';
    import {VclTable} from 'vue-content-loading';
    import FormWrapper from "@components/forms_builder/FormWrapper";

    export default {
        mixins: [Mixin],
        data: () => ({
            group: 'general',
        }),
        components: {
            FormWrapper, Card, VclTable
        },
        created() {
            this.loadSetting(this.group);
            this.$store.commit('SET_CURRENT_PAGE_TITLE', 'General Settings');
            this.$store.commit('SET_PAGE_BACK_LINK', '/settings');
        }
    }
</script>

<style scoped>
    .btn-save {
        width: 150px
    }
</style>
