<template>
    <div class="modal fade" :id="id" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" v-if="hasHeader">
                    <slot name="header"></slot>
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                            v-if="showXOnHeader">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <slot></slot>
                </div>
                <div class="modal-footer bg-whitesmoke br" v-if="hasFooter">
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            currentState: {
                type: String,
                default: 'hide',
                validator: (value) => ['show', 'hide'].includes(value)
            },
            showXOnHeader: {
                type: Boolean,
                default: true
            }
        },
        data: () => ({
            id: null
        }),
        computed: {
            hasHeader() {
                return !!this.$slots['header'];
            },
            hasFooter() {
                return !!this.$slots['footer'];
            }
        },
        watch: {
            currentState(newValue, oldValue) {
                if (newValue !== oldValue) {
                    if (newValue === 'hide') {
                        $(`#${this.id}`).modal(newValue);
                    } else {
                        $(`#${this.id}`).appendTo('body').modal(newValue);
                    }
                }
            }
        },
        mounted() {
            let vm = this;

            $(`#${this.id}`).on('hidden.bs.modal', (event) => {
                vm.$emit('hidden', event);
            });

            $(`#${this.id}`).on('shown.bs.modal', (event) => {
                vm.$emit('shown', event);
            });
        },
        created() {
            this.id = this.$Utils.getRandomId();
        }
    }
</script>

<style scoped>

</style>
