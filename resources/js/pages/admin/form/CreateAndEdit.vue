<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <div>
        <div class="row">
            <div class="col-md-3">
                <available-form-component></available-form-component>
            </div>
            <div class="col-md-6">
                <card>
                    <template v-slot:header>
                        <h4 class="form-inline">
                            Form Preview
                        </h4>
                    </template>
                    <template v-slot:header-action>
                        <div class="form-inline">
                            <div class="form-group">
                                <label for="formName">Name <span class="text-danger">*</span></label>
                                <input :class="{'is-invalid': errors.first('Name')}"
                                       :disabled="isLoading"
                                       class="form-control mx-2"
                                       id="formName"
                                       name="Name"
                                       type="text"
                                       v-model="name"
                                       v-validate="'required'"/>
                            </div>

                            <button :class="{disabled: isLoading}"
                                    :disabled="isLoading"
                                    @click="validateAndSave"
                                    class="btn btn-primary">
                                Save
                            </button>
                        </div>
                    </template>

                    <form-content-loading :formAmount="2" v-if="isLoading"></form-content-loading>

                    <Container :drop-placeholder="true"
                               :get-child-payload="getChildPayload"
                               @drag-enter="itemsEntering = true"
                               @drag-leave="itemsEntering = false"
                               @onDrop="onDrop"
                               drag-class="opacity-ghost"
                               drag-handle-selector=".item-drag-handler"
                               group-name="form"
                               lock-axis="y"
                               v-else>

                        <div v-if="isFormItemsEmpty && !itemsEntering" class="empty-form-component text-center">
                            <i class="fas fa-arrows-alt"></i> Drag component here from the left.
                        </div>

                        <Draggable v-for="(field, index) in formItems" :key="field.id">
                            <div :class="{selected: selectedFormItemIndex === index}"
                                 @click="select(index)"
                                 class="form-item-wrapper">
                                <div class="form-group">
                                    <div class="item-drag-handler text-center">
                                        <i class="fas fa-grip-horizontal item-drag-icon"></i>
                                    </div>

                                    <!-- display form types -->
                                    <div v-if="field.type === 'text'">
                                        <label>
                                            {{field.label}}
                                            <span v-if="field.isRequired" class="text-danger ml-1">*</span>
                                        </label>
                                        <input class="form-control" type="text" readonly/>
                                    </div>
                                    <div v-else-if="field.type === 'text_area'">
                                        <label>
                                            {{field.label}}
                                            <span v-if="field.isRequired" class="text-danger ml-1">*</span>
                                        </label>
                                        <textarea class="form-control" readonly></textarea>
                                    </div>
                                    <div v-else-if="field.type === 'submit_button'">
                                        <button type="submit" class="btn btn-primary">{{field.label}}</button>
                                    </div>
                                    <!-- #form types -->
                                </div>
                            </div>
                        </Draggable>
                    </Container>
                </card>
            </div>
            <div class="col-md-3">
                <update-field></update-field>
            </div>
        </div>
    </div>
</template>

<script>
    import Card from '@components/Card';
    import AvailableFormComponent from './components/AvailableFormComponent';
    import UpdateField from './components/UpdateField';
    import {Container, Draggable} from 'vue-smooth-dnd';
    import Mixin from './mixin';
    import FormContentLoading from '@components/content_loading/FormContentLoading';

    export default {
        mixins: [Mixin],
        props: {
            mode: {
                type: String,
                default: 'create'
            }
        },
        data: () => ({
            name: '',
            itemsEntering: false
        }),
        computed: {
            formItems: {
                get() {
                    return this.$store.state.form.formItems;
                },
                set(value) {
                    this.$store.commit('form/SET_FORM_ITEMS', value);
                }
            },
            selectedFormItemIndex: {
                get() {
                    return this.$store.state.form.selectedIndex;
                },
                set(value) {
                    this.$store.commit('form/SET_SELECTED_FORM_ITEM_INDEX', value);
                }
            },
            isFormItemsEmpty() {
                return this.formItems.length <= 0;
            }
        },
        watch: {
            formItems() {
                this.itemsEntering = false;
            }
        },
        methods: {
            validateAndSave() {
                this.$validator.validateAll().then(valid => {
                    if (valid) {
                        this.save();
                    }
                });
            },
            onDrop(dropResult) {
                let clonedPayload = Object.assign({}, dropResult.payload);
                clonedPayload.id = this.$Utils.getRandomId();
                dropResult.payload = clonedPayload;
                this.formItems = this.applyDrag(this.formItems, dropResult);

                if (dropResult.addedIndex !== null) {
                    this.selectedFormItemIndex = dropResult.addedIndex;
                }
            },
            select(index) {
                this.selectedFormItemIndex = index;
            },
            getChildPayload(index) {
                return this.formItems[index];
            },
            save() {
                let params = {
                    name: this.name,
                    formItems: this.formItems
                };

                this.isLoading = true;

                if (this.mode === 'create') {
                    axios.post('/api/form', params)
                        .then(response => {
                            this.$Toast.show({
                                type: 'success',
                                message: 'Successfully created form'
                            });
                            this.$router.push(`/forms/edit/${response.data.id}`);
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
                } else if (this.mode === 'edit') {
                    this.$Toast.showLoading({
                        title: 'Updating...'
                    });

                    axios.put(`/api/form/${this.$route.params.id}`, params)
                        .then(response => {
                            this.$Toast.show({
                                type: 'success',
                                message: 'Successfully updated form'
                            });
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
                }
            }
        },
        components: {
            AvailableFormComponent, Card, Container, Draggable, UpdateField, FormContentLoading
        },
        created() {
            this.$store.commit('form/RESET_STATE');

            if (this.mode === 'edit') {
                this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Edit Form');
                //fetch data from server
                axios.get(`/api/form/${this.$route.params.id}`)
                    .then(response => {
                        this.name = response.data.form.name;
                        this.formItems = response.data.data;

                        this.isLoading = false;
                    })
                    .catch(err => {
                        this.$Toast.show({
                            type: 'error',
                            message: err.response.data.message
                        });
                    });
            } else {
                this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Create Form');
                this.isLoading = false;
            }

            this.$store.commit('SET_PAGE_BACK_LINK', '/forms');
        }
    }
</script>

<style lang="scss" scoped>
    .form-item-wrapper:hover {
        .form-group {
            border: 1px dashed;

            .item-drag-handler {
                visibility: visible;
            }
        }
    }

    .form-item-wrapper.selected .form-group {
        /*background-color: #f8f9fa;*/
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.12), 0 2px 4px 0 rgba(0, 0, 0, 0.08);
    }

    .form-item-wrapper {
        margin: 5px;

        .item-drag-handler {
            visibility: hidden;
            cursor: move;
        }

        .form-group {
            border-radius: 5px;
            padding: 0 10px 10px;
        }
    }

    .empty-form-component {
        padding: 45px 20px;
        line-height: 36px;
        border: 1px dashed;
        background-color: rgba(150, 150, 150, 0.1);
        border-radius: 5px;
    }

    .smooth-dnd-container {
        min-height: 130px;
    }

    .opacity-ghost {
        background-color: #f8f9fa;
    }
</style>
