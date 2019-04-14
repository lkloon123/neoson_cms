<template>
    <html-modal :current-state="modalState"
                :is-btn-html="true"
                :show-btn="true"
                :show-footer="false"
                :title="getTitle"
                :trigger-btn-class="{btn: true, 'btn-icon': true, 'btn-sm': mode === 'edit', 'btn-info':  mode === 'edit', 'btn-primary': mode === 'create', 'icon-left': mode === 'create'}"
                :trigger-btn-text="editBtnIcon"
                @hidden="hideModal"
                @shown="showModal"
                trigger-btn-tooltip="Edit">

        <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input type="text"
                   class="form-control"
                   :class="{'is-invalid': errors.first('Name')}"
                   name="Name"
                   id="name"
                   v-model="clonedValue.name"
                   v-validate="'required'"/>

            <div class="invalid-feedback">
                {{errors.first('Name')}}
            </div>
        </div>

        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" class="form-control" id="slug" v-model="clonedValue.slug"/>
        </div>

        <div class="form-group mb-0 text-right">
            <button type="submit" class="btn btn-primary" :class="{'btn-progress': isLoading}" @click="validateAndSave">
                Save
            </button>
        </div>

    </html-modal>
</template>

<script>
    import HtmlModal from '@components/modal/HtmlModal';
    import sluggable from 'slug';

    export default {
        props: {
            value: {
                type: Object,
                default: () => ({})
            },
            mode: {
                type: String,
                default: 'create'
            }
        },
        data: () => ({
            clonedValue: {},
            modalState: 'hide',
            isLoading: false
        }),
        watch: {
            value: {
                handler(newValue) {
                    this.clonedValue = Object.assign({}, newValue);
                },
                immediate: true
            },
            'clonedValue.name'(newValue) {
                this.clonedValue.slug = sluggable(newValue, {lower: true});
            }
        },
        computed: {
            editBtnIcon() {
                if (this.mode === 'create') {
                    return '<i class="fas fa-plus"></i>Create';
                }
                return '<i class="fas fa-edit fa-fw"></i>';
            },
            getTitle() {
                if (this.mode === 'create') {
                    return 'Create Tag';
                }
                return 'Edit Tag';
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
            save() {
                this.isLoading = true;

                if (this.mode === 'create') {
                    this.$Toast.showLoading({
                        title: 'Creating...'
                    });

                    axios.post('/api/tag', {
                        name: this.clonedValue.name,
                        slug: this.clonedValue.slug
                    }).then(response => {
                        this.hideModal();
                        this.$emit('input', this.clonedValue);
                        this.$Toast.show({
                            type: 'success',
                            message: 'Successfully created tag'
                        });
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

                    axios.put(`/api/tag/${this.clonedValue.id}`, {
                        name: this.clonedValue.name,
                        slug: this.clonedValue.slug
                    }).then(response => {
                        this.$emit('input', this.clonedValue);
                        this.hideModal();
                        this.$Toast.show({
                            type: 'success',
                            message: 'Successfully updated tag'
                        });
                    }).catch(err => {
                        console.log(err);
                        this.$Toast.show({
                            type: 'error',
                            message: err.response.data.message
                        });
                    }).finally(() => {
                        this.isLoading = false;
                    });
                }
            },
            showModal() {
                this.modalState = 'show';
            },
            hideModal() {
                this.modalState = 'hide';
                this.errors.clear();
                if (this.mode === 'create') {
                    this.clonedValue.name = '';
                    this.clonedValue.slug = '';
                } else if (this.mode === 'edit') {
                    this.clonedValue = Object.assign({}, this.value);
                }
            }
        },
        components: {
            HtmlModal
        }
    }
</script>

<style scoped>

</style>
