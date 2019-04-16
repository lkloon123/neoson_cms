<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <div>
        <div class="row">
            <div class="col-md-9">
                <card>
                    <template v-slot:header>
                        <h4 class="form-inline">
                            Menu Structure
                        </h4>
                    </template>
                    <template v-slot:header-action>
                        <div class="form-inline">
                            <div class="form-group">
                                <label for="menuName">Name <span class="text-danger">*</span></label>
                                <input :class="{'is-invalid': errors.first('Name')}"
                                       :disabled="isMenuItemsEmpty && isLoading"
                                       class="form-control mx-2"
                                       id="menuName"
                                       name="Name"
                                       type="text"
                                       v-model="name"
                                       v-validate="'required'"/>
                            </div>

                            <button :class="{disabled: isMenuItemsEmpty && isLoading}"
                                    :disabled="isMenuItemsEmpty && isLoading"
                                    @click="validateAndSave"
                                    class="btn btn-primary">
                                Save
                            </button>
                        </div>
                    </template>

                    <vcl-list v-if="isLoading"></vcl-list>

                    <vue-nestable v-model="menuItems" v-else>
                        <template v-slot:placeholder>
                            Get started by add menu on right side
                            <i class="fas fa-hand-point-right" style="font-size: 1.2rem"></i>
                        </template>
                        <template slot-scope="{item, index, isChild}">
                            <vue-nestable-handle :item="item">
                                <div class="alert alert-light mb-0 p-2 pl-3 pr-3 menu-item-component">
                                <span class="menu-item-label">
                                    <b v-if="item.menuLabel">{{ item.menuLabel }}</b>
                                    <span v-else>(no label)</span>
                                    <em class="text-muted" v-if="isChild"> &nbsp;sub menu</em>
                                </span>
                                    <span class="menu-item-control">
                                        <span class="text-muted">{{formatMenuType(item.type)}}</span>
                                        <a class="btn btn-light btn-icon btn-sm" @click.prevent="openMenu(item)">
                                            <i class="fas fa-caret-down"></i>
                                        </a>
                                    </span>
                                </div>
                            </vue-nestable-handle>

                            <!-- menu options -->
                            <collapse-transition>
                                <div class="menu-item-component collapse"
                                     :class="{show: item.showMenuOption}"
                                     v-if="item.type === 'custom_link' && item.showMenuOption">
                                    <div class="card card-body mb-0 card-option">
                                        <update-link :item-data="item"></update-link>
                                    </div>
                                </div>
                            </collapse-transition>

                            <collapse-transition>
                                <div class="menu-item-component collapse"
                                     :class="{show: item.showMenuOption}"
                                     v-if="item.type === 'page' && item.showMenuOption">
                                    <div class="card card-body mb-0 card-option">
                                        <update-page :item-data="item"></update-page>
                                    </div>
                                </div>
                            </collapse-transition>
                            <!-- #menu options -->
                        </template>
                    </vue-nestable>
                </card>
            </div>
            <div class="col-md-3">
                <select-page></select-page>
                <custom-link></custom-link>
            </div>
        </div>
    </div>
</template>

<script>
    import Card from '@components/Card';
    import CustomLink from './components/CustomLink';
    import SelectPage from './components/SelectPage';
    import UpdateLink from './components/form/UpdateLink';
    import UpdatePage from './components/form/UpdatePage';
    import {VueNestable, VueNestableHandle} from 'vue-nestable';
    import {CollapseTransition} from 'vue2-transitions';
    import {VclList} from 'vue-content-loading';

    export default {
        props: {
            mode: {
                type: String,
                default: 'create'
            }
        },
        data: () => ({
            name: ''
        }),
        computed: {
            menuItems: {
                get() {
                    return this.$store.state.menu.menuItems;
                },
                set(value) {
                    this.$store.commit('menu/SET_MENU_ITEMS', value);
                }
            },
            isLoading: {
                get() {
                    return this.$store.state.menu.coreLoading;
                },
                set(value) {
                    this.$store.commit('menu/UPDATE_CORE_LOADING', value);
                }
            },
            isMenuItemsEmpty() {
                return this.menuItems.length <= 0;
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
            formatMenuType(type) {
                return _.startCase(_.camelCase(type));
            },
            openMenu(searchItem) {
                let cloned = Object.assign({}, searchItem);

                cloned.showMenuOption = !cloned.showMenuOption;
                this.$store.commit('menu/UPDATE_MENU_ITEM', cloned);
            },
            save() {
                let params = {
                    name: this.name,
                    menuItems: this.menuItems
                };

                if (this.mode === 'create') {
                    this.isLoading = true;
                    axios.post('/api/menu', params)
                        .then(response => {
                            this.$Toast.show({
                                type: 'success',
                                message: 'Successfully created menu'
                            });
                            this.$router.push(`/menu/edit/${response.data.id}`);
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
                    this.isLoading = true;
                    this.$Toast.showLoading({
                        title: 'Updating...'
                    });

                    axios.put(`/api/menu/${this.$route.params.id}`, params)
                        .then(response => {
                            this.$Toast.show({
                                type: 'success',
                                message: 'Successfully updated menu'
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
            Card,
            CustomLink,
            SelectPage,
            UpdateLink,
            UpdatePage,
            VueNestable,
            VueNestableHandle,
            CollapseTransition,
            VclList
        },
        created() {
            this.$store.commit('menu/RESET_STATE');

            if (this.mode === 'edit') {
                this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Edit Menu');
                //fetch data from server
                axios.get(`/api/menu/${this.$route.params.id}`)
                    .then(response => {
                        this.name = response.data.menu.name;
                        this.menuItems = response.data.data;

                        this.isLoading = false;
                    })
                    .catch(err => {
                        this.$Toast.show({
                            type: 'error',
                            message: err.response.data.message
                        });
                    });
            } else {
                this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Create Menu');
                this.isLoading = false;
            }

            this.$store.commit('SET_PAGE_BACK_LINK', '/menu');
        }
    }
</script>

<style scoped>
    @import '~@css/nestable.css';

    .menu-item-label {
        display: block;
        margin-right: 10em;
    }

    .menu-item-control {
        position: absolute;
        right: 1rem;
        top: 0.5rem;
    }

    .menu-item-control .btn {
        cursor: pointer;
    }

    .card-option {
        border: 1px solid rgba(0, 0, 0, 0.125);
        padding: 0.5rem 1rem 1rem;
        background-color: #e3eaef;
    }

    .menu-item-component {
        width: 25rem;
    }

    .card .card-header .form-control {
        border-radius: 0.25rem;
        padding: 10px;
    }
</style>
