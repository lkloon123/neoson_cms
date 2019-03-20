<template>
    <div>
        <div class="row">
            <div class="col-md-9">
                <card>
                    <template v-slot:header>
                        <h4>Content</h4>
                    </template>
                    <template v-slot:header-action>
                        <button class="btn btn-light" @click="validateAndSave('Draft')" :disabled="isLoading">
                            Save Draft
                        </button>
                        <button class="btn btn-primary" @click="validateAndSave('Publish')" :disabled="isLoading">
                            Publish
                        </button>
                    </template>

                    <tiny-mce-editor name="Content"
                                     v-model="content"
                                     :is-content-loading="isLoading"
                                     v-validate="'required'"
                                     :style="{border: contentHasErrorBorderStyle}"></tiny-mce-editor>

                    <div class="invalid-feedback" :style="{display: contentHasErrorStyle}">
                        {{errors.first('Content')}}
                    </div>
                </card>
            </div>
            <div class="col-md-3">
                <card :is-collapsible="true">
                    <template v-slot:header>
                        <h4>Schedule</h4>
                    </template>

                    <form-content-loading :formAmount="2" v-if="isLoading"></form-content-loading>
                    <div v-else>
                        <div class="form-group">
                            <label>Publish From</label>
                            <date-range-picker name="Publish From"
                                               :class="{'is-invalid': errors.first('Publish From')}"
                                               :options="publishFromDatePickerOptions"
                                               v-model="publishFromDate"
                                               v-validate="'required'"></date-range-picker>

                            <div class="invalid-feedback">
                                {{errors.first('Publish From')}}
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label>Publish To</label>
                            <date-range-picker name="Publish To"
                                               :class="{'is-invalid': errors.first('Publish To')}"
                                               :options="publishToDatePickerOptions"
                                               v-model="publishToDate"
                                               v-validate="'required'"></date-range-picker>

                            <div class="invalid-feedback">
                                {{errors.first('Publish To')}}
                            </div>
                        </div>
                    </div>
                </card>

                <card :is-collapsible="true">
                    <template v-slot:header>
                        <h4>Config</h4>
                    </template>

                    <form-content-loading :formAmount="3" v-if="isLoading"></form-content-loading>
                    <div v-else>
                        <div class="form-group">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input id="title"
                                   name="Title"
                                   class="form-control"
                                   :class="{'is-invalid': errors.first('Title')}"
                                   type="text"
                                   placeholder="Enter page title"
                                   v-model="title"
                                   v-validate="'required'"/>

                            <div class="invalid-feedback">
                                {{errors.first('Title')}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug/Permalink <span class="text-danger">*</span></label>
                            <input id="slug"
                                   name="Slug/Permalink"
                                   class="form-control"
                                   :class="{'is-invalid': errors.first('Slug/Permalink')}"
                                   type="text"
                                   placeholder="Enter slug"
                                   v-model="slug"
                                   v-validate="'required'"/>

                            <div class="invalid-feedback">
                                {{errors.first('Slug/Permalink')}}
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <label for="description">Description</label>
                            <textarea id="description"
                                      class="form-control"
                                      placeholder="Enter short description"
                                      v-model="description"></textarea>
                        </div>
                    </div>
                </card>
            </div>
        </div>
    </div>
</template>

<script>
    import TinyMceEditor from '@components/TinyMceEditor';
    import DateRangePicker from '@components/DateRangePicker';
    import sluggable from 'slug';
    import Card from '@components/Card';
    import FormContentLoading from '@components/content_loading/FormContentLoading';

    export default {
        props: {
            mode: {
                type: String,
                default: 'create'
            }
        },
        data: () => ({
            publishFromDatePickerOptions: {
                singleDatePicker: true,
            },
            publishToDatePickerOptions: {
                singleDatePicker: true,
            },
            content: '',
            title: '',
            slug: '',
            description: '',
            publishFromDate: moment().format('YYYY-MM-DD hh:mm:ss a'),
            publishToDate: moment().add(1, 'week').format('YYYY-MM-DD hh:mm:ss a'),
            id: null,
            isLoading: true
        }),
        watch: {
            title(newValue) {
                this.slug = sluggable(newValue, {lower: true});
            }
        },
        computed: {
            contentHasErrorStyle() {
                if (this.errors && this.errors.items.length > 0) {
                    return this.errors.first('Content') ? 'block' : 'none';
                }

                return 'none';
            },
            contentHasErrorBorderStyle() {
                if (this.errors && this.errors.items.length > 0) {
                    return this.errors.first('Content') ? '1px solid #dc3545' : 'none';
                }

                return 'none';
            }
        },
        methods: {
            validateAndSave(status) {
                this.$validator.validateAll().then(valid => {
                    if (valid) {
                        this.save(status);
                    }
                });
            },
            save(status) {
                let params = {
                    status: status,
                    content: this.content,
                    title: this.title,
                    slug: this.slug,
                    description: this.description,
                    publish_from_date: moment(this.publishFromDate, 'YYYY-MM-DD hh:mm:ss a').format('YYYY-MM-DD HH:mm:ss'),
                    publish_to_date: moment(this.publishToDate, 'YYYY-MM-DD hh:mm:ss a').format('YYYY-MM-DD HH:mm:ss')
                };

                if (this.mode === 'create') {
                    this.isLoading = true;
                    this.$Toast.showLoading({
                        title: 'Creating...'
                    });

                    axios.post('/api/page', params)
                        .then(response => {
                            this.$Toast.show({
                                type: 'success',
                                message: 'Successfully created page'
                            });
                            this.$router.push(`/pages/edit/${response.data.id}`);
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

                    axios.put(`/api/page/${this.id}`, params)
                        .then(response => {
                            this.$Toast.show({
                                type: 'success',
                                message: 'Successfully updated page'
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
            TinyMceEditor, DateRangePicker, Card, FormContentLoading
        },
        created() {
            if (this.mode === 'edit') {
                this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Edit Page');
                //fetch data from server
                axios.get(`/api/page/${this.$route.params.id}`)
                    .then(response => {
                        this.title = response.data.title;
                        this.slug = response.data.slug;
                        this.description = response.data.description;
                        this.publishFromDate = moment(response.data.publish_from_date).format('YYYY-MM-DD hh:mm:ss a');
                        this.publishToDate = moment(response.data.publish_to_date).format('YYYY-MM-DD hh:mm:ss a');
                        this.content = response.data.content;
                        this.id = response.data.id;

                        this.isLoading = false;
                    })
                    .catch(err => {
                        this.$Toast.show({
                            type: 'error',
                            message: err.response.data.message
                        });
                    });
            } else {
                this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Create Page');
                this.isLoading = false;
            }

            this.$store.commit('SET_PAGE_BACK_LINK', '/pages');
        }
    }
</script>

<style scoped>
    .content-field {
        padding: 20px;
    }
</style>
