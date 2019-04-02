<template>
    <card>
        <template v-slot:header>
            <h4>Form Properties</h4>
        </template>

        <div v-if="!clonedSelectedItem">
            <div class="alert alert-info">
                <div class="alert-body">
                    Please click a component in form preview to change its properties
                </div>
            </div>
        </div>

        <template v-else>
            <div class="form-group">
                <label for="label">Label</label>
                <input type="text" class="form-control" id="label" v-model="formLabel"/>
            </div>

            <div class="form-group" v-if="isKeyPresent('isRequired')">
                <toggle-button :width="40" v-model="formIsRequired" :sync="true"></toggle-button>
                Is Required?
            </div>

            <div class="d-flex justify-content-between">
                <button class="btn btn-danger btn-icon icon-left" @click="removeField">
                    <i class="fas fa-trash"></i> Remove
                </button>

                <button class="btn btn-light btn-icon icon-left" @click="duplicateField">
                    <i class="fas fa-clone"></i> Duplicate
                </button>
            </div>
        </template>
    </card>
</template>

<script>
    import Card from '@components/Card';
    import {mapState} from 'vuex';
    import {ToggleButton} from 'vue-js-toggle-button';

    export default {
        computed: {
            ...mapState('form', ['selectedIndex']),
            clonedSelectedItem() {
                if (this.selectedIndex !== null) {
                    const item = this.$store.state.form.formItems[this.selectedIndex];
                    if (item) {
                        return item;
                    }
                }
                return null;
            },
            formLabel: {
                get() {
                    if (this.clonedSelectedItem !== null) {
                        return this.clonedSelectedItem.label;
                    }
                },
                set(value) {
                    let cloned = Object.assign({}, this.clonedSelectedItem);
                    cloned.label = value;
                    this.$store.commit('form/UPDATE_FORM_ITEM', cloned);
                }
            },
            formIsRequired: {
                get() {
                    if (this.clonedSelectedItem !== null) {
                        return this.clonedSelectedItem.isRequired;
                    }
                },
                set(value) {
                    let cloned = Object.assign({}, this.clonedSelectedItem);
                    cloned.isRequired = value;
                    this.$store.commit('form/UPDATE_FORM_ITEM', cloned);
                }
            }
        },
        methods: {
            isKeyPresent(key) {
                return this.clonedSelectedItem[key] !== undefined;
            },
            removeField() {
                this.$store.commit('form/REMOVE_FORM_ITEM');
            },
            duplicateField() {
                this.$store.commit('form/ADD_FORM_ITEM', this.clonedSelectedItem);
            }
        },
        components: {
            Card, ToggleButton
        }
    }
</script>

<style>
</style>
