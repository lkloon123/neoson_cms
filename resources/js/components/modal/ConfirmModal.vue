<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <span>
        <button type="button"
                :class="triggerBtnClass"
                @click="copyCurrentState = 'show'"
                v-if="showBtn && !isBtnHtml">
            {{triggerBtnText}}
        </button>

        <button type="button"
                :class="triggerBtnClass"
                @click="copyCurrentState = 'show'"
                v-if="showBtn && isBtnHtml"
                v-html="triggerBtnText">
        </button>

        <BaseModal :current-state="copyCurrentState" @hidden="handleHidden" @shown="$emit('shown', $event)">
            <template v-slot:header>
                <h5 class="modal-title">{{title}}</h5>
            </template>
            <span>{{body}}</span>
            <template v-slot:footer>
                <button :class="cfmBtnClass" data-dismiss="modal" @click="$emit('confirm', $event)">
                    {{cfmBtnText}}
                </button>
                <button :class="cancelBtnClass" data-dismiss="modal" @click="$emit('cancel', $event)">
                    {{cancelBtnText}}
                </button>
            </template>
        </BaseModal>
    </span>
</template>

<script>
    import BaseModal from './BaseModal';

    export default {
        props: {
            title: {
                type: String
            },
            body: {
                type: String,
                required: true
            },
            cfmBtnClass: {
                type: Object,
                default: () => {
                    return {
                        btn: true,
                        'btn-primary': true
                    }
                }
            },
            cfmBtnText: {
                type: String,
                default: 'yes'
            },
            cancelBtnClass: {
                type: Object,
                default: () => {
                    return {
                        btn: true,
                        'btn-secondary': true
                    }
                }
            },
            cancelBtnText: {
                type: String,
                default: 'no'
            },
            //trigger button
            showBtn: {
                type: Boolean,
                default: false
            },
            isBtnHtml: {
                type: Boolean,
                default: false
            },
            triggerBtnText: {
                type: String,
                default: 'show'
            },
            triggerBtnClass: {
                type: Object,
                default: () => {
                    return {
                        btn: true,
                        'btn-primary': true
                    }
                }
            },
            //inherit props from base modal
            showXOnHeader: {
                type: Boolean,
                default: true
            },
            currentState: {
                type: String,
                default: 'hide',
                validator: (value) => ['show', 'hide'].includes(value)
            },
        },
        watch: {
            currentState(newValue) {
                this.copyCurrentState = newValue;
            },
        },
        data: () => ({
            copyCurrentState: null
        }),
        methods: {
            handleHidden(event) {
                this.copyCurrentState = 'hide';
                this.$emit('hidden', event)
            }
        },
        components: {
            BaseModal
        },
        created() {
            this.copyCurrentState = this.currentState;
        }
    }
</script>

<style scoped>

</style>
