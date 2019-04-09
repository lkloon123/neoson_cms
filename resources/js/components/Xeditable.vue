<template>
    <div>
        <span class="editable" @click="show" v-if="!isEditing" title="Click to edit">{{value}}</span>

        <div v-if="isEditing" class="form-inline">
            <select class="form-control mr-1 input-field" v-if="inputType === 'select'" v-model="inputValue">
                <option v-for="option in selectOptions" :key="option.id" :value="option.name">{{option.name}}</option>
            </select>
            <input type="text" class="form-control mr-1 input-field" v-if="inputType === 'text'" v-model="inputValue"/>
            <button class="btn btn-sm btn-icon btn-success mr-1 btn-save" @click="save">
                <i class="fas fa-check fa-fw"></i>
            </button>
            <button class="btn btn-sm btn-icon btn-danger btn-cancel" @click="cancel">
                <i class="fas fa-times fa-fw"></i>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            value: {
                type: String
            },
            inputType: {
                type: String,
                default: 'text'
            },
            selectOptions: {
                type: Array,
                default: []
            }
        },
        data: () => ({
            isEditing: false,
            inputValue: ''
        }),
        watch: {
            value: {
                handler(newValue) {
                    this.inputValue = newValue;
                },
                immediate: true
            }
        },
        methods: {
            save() {
                this.$emit('input', this.inputValue);
                this.hide();
            },
            cancel() {
                this.hide();
            },
            show() {
                this.isEditing = true;
                this.inputValue = this.value;
            },
            hide() {
                this.isEditing = false;
                this.inputValue = '';
            }
        }
    }
</script>

<style scoped>
    .editable {
        border-bottom: dashed 1px #0088cc;
        color: #337ab7;
        cursor: pointer;
    }

    .input-field {
        height: 35px !important;
        width: 70%;
    }

    select.input-field {
        padding: 0.375rem 0.75rem !important;
    }
</style>
