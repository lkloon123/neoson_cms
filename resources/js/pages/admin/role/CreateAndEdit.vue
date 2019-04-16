<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <div>
        <div class="row">
            <div class="col-md-12">
                <card>
                    <template v-slot:header>
                        <h4>Abilities</h4>
                    </template>
                    <template v-slot:header-action>
                        <div class="form-inline">
                            <div class="form-group">
                                <label for="roleName">Name <span class="text-danger">*</span></label>
                                <input :class="{'is-invalid': errors.first('Name')}"
                                       :disabled="isLoading"
                                       class="form-control mx-2"
                                       id="roleName"
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

                    <vcl-table :columns="5" v-if="isLoading"></vcl-table>

                    <vue-good-table :columns="columns"
                                    :rows="rows"
                                    :sort-options="{enabled: false}"
                                    styleClass="vgt-table table-hover condensed"
                                    v-else>
                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field === 'module'">
                                {{props.formattedRow[props.column.field]}}
                            </span>
                            <span v-else-if="props.formattedRow[props.column.field] !== ''">
                                <multiselect :allow-empty="false"
                                             :class="{allow: props.formattedRow[props.column.field].state === 0, disallow: props.formattedRow[props.column.field].state === 1, own: props.formattedRow[props.column.field].state === 2}"
                                             :options="displaySelectOption(props.index, props.column.field)"
                                             :searchable="false"
                                             :value="props.formattedRow[props.column.field]"
                                             @input="changeCheckboxState($event, props.index, props.column.field)"
                                             deselect-label=""
                                             label="label"
                                             selectLabel=""
                                             track-by="state"></multiselect>
                            </span>
                            <span v-else></span>
                        </template>
                    </vue-good-table>
                </card>
            </div>
        </div>
    </div>
</template>

<script>
    import {VueGoodTable} from 'vue-good-table';
    import Card from '@components/Card';
    import {VclTable} from 'vue-content-loading';
    import FormContentLoading from '@components/content_loading/FormContentLoading';
    import Multiselect from 'vue-multiselect'

    export default {
        props: {
            mode: {
                type: String,
                default: 'create'
            }
        },
        data: () => ({
            columns: [],
            rows: [],
            name: '',
            selectOptions: [
                {state: 0, label: 'Allow'},
                {state: 1, label: 'Disallow'},
                {state: 2, label: 'Only Own'}
            ],
            isLoading: true
        }),
        methods: {
            validateAndSave() {
                this.$validator.validateAll().then(valid => {
                    if (valid) {
                        this.save();
                    }
                });
            },
            displaySelectOption(index, field) {
                if (_.get(this.rows[index], field + '.has_own') === true) {
                    return this.selectOptions;
                }

                return [
                    {state: 0, label: 'Allow'},
                    {state: 1, label: 'Disallow'}
                ];
            },
            changeCheckboxState(checkState, index, field) {
                _.set(this.rows[index], field, checkState);
            },
            loadAbilityOptions() {
                axios.options('/api/abilities')
                    .then(response => {
                        this.columns = response.data.columns;
                        this.rows = response.data.data;

                        if (this.mode === 'edit') {
                            this.loadRole();
                        } else {
                            this.isLoading = false;
                        }
                    });
            },
            loadRole() {
                axios.get(`/api/role/${this.$route.params.id}`)
                    .then(response => {
                        this.name = response.data.name;
                        const abilities = response.data.abilities;
                        abilities.forEach(ability => {
                            for (let i = 0; i < this.rows.length; i++) {
                                if (_.snakeCase(this.rows[i].module) === ability.module) {
                                    if (ability.only_own) {
                                        this.rows[i].abilities[ability.name].state = this.selectOptions[2].state;
                                        this.rows[i].abilities[ability.name].label = this.selectOptions[2].label;
                                    } else {
                                        this.rows[i].abilities[ability.name].state = this.selectOptions[0].state;
                                        this.rows[i].abilities[ability.name].label = this.selectOptions[0].label;
                                    }
                                    break;
                                }
                            }
                        })
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            },
            save() {
                this.isLoading = true;

                if (this.mode === 'create') {
                    axios.post('/api/role', {
                        name: this.name,
                        abilities: this.rows
                    }).then(response => {
                        this.$Toast.show({
                            type: 'success',
                            message: 'Successfully created role'
                        });
                        this.$router.push(`/settings/roles/edit/${response.data.id}`);
                    }).catch(err => {
                        this.$Toast.show({
                            type: 'error',
                            message: err.response.data.message
                        });
                    }).finally(() => {
                        this.isLoading = false;
                    });
                } else if (this.mode === 'edit') {
                    this.$Toast.showLoading({
                        title: 'Updating...'
                    });

                    axios.put(`/api/role/${this.$route.params.id}`, {
                        name: this.name,
                        abilities: this.rows
                    }).then(response => {
                        this.$Toast.show({
                            type: 'success',
                            message: 'Successfully updated role'
                        })
                    }).catch(err => {
                        this.$Toast.show({
                            type: 'error',
                            message: err.response.data.message
                        });
                    }).finally(() => {
                        this.isLoading = false;
                    });
                }
            }
        },
        components: {
            Card, VueGoodTable, VclTable, FormContentLoading, Multiselect
        },
        created() {
            if (this.mode === 'edit') {
                this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Edit Role');
            } else {
                this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Create Role');
            }

            this.$store.commit('SET_PAGE_BACK_LINK', '/settings/roles');
            this.loadAbilityOptions();
        }
    }
</script>

<style>
    .multiselect.allow .multiselect__tags,
    .multiselect.allow .multiselect__tags span,
    .multiselect.allow .multiselect__tags input {
        color: #fff;
        background: #28a745;
    }

    .multiselect.disallow .multiselect__tags,
    .multiselect.disallow .multiselect__tags span,
    .multiselect.disallow .multiselect__tags input {
        color: #fff;
        background: #dc3545;
    }

    .multiselect.own .multiselect__tags,
    .multiselect.own .multiselect__tags span,
    .multiselect.own .multiselect__tags input {
        background: #ffc107;
    }
</style>
