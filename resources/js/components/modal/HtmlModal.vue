<template>
    <span>
        <button type="button"
                :class="triggerBtnClass"
                @click="triggerBtnClicked"
                v-if="showBtn && !isBtnHtml"
                :title="triggerBtnTooltip">
            {{triggerBtnText}}
        </button>

        <button type="button"
                :class="triggerBtnClass"
                @click="triggerBtnClicked"
                v-if="showBtn && isBtnHtml"
                v-html="triggerBtnText"
                :title="triggerBtnTooltip">
        </button>

        <BaseModal :current-state="copyCurrentState" @hidden="handleHidden" @shown="$emit('shown', $event)" :size="size">
            <template v-slot:header>
                <h5 class="modal-title">{{title}}</h5>
            </template>
            <slot></slot>
            <template v-slot:footer v-if="showFooter">
                <button :class="cfmBtnClass" data-dismiss="modal" @click="$emit('confirm', $event)">
                    {{cfmBtnText}}
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
                default: 'ok'
            },
            showFooter: {
                type: Boolean,
                default: true
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
            triggerBtnTooltip: {
                type: String,
                default: null
            },
            triggerBtnCallback: {
                type: Function,
                default: null
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
            size: {
                type: String,
                default: 'default'
            }
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
            },
            triggerBtnClicked() {
                if(this.triggerBtnCallback !== null){
                    this.triggerBtnCallback();
                }
                this.copyCurrentState = 'show';
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
