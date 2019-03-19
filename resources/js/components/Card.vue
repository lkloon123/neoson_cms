<template>
    <div class="card" :class="styleClass">
        <div class="card-header" v-if="hasHeader">
            <slot name="header"></slot>
            <!-- header action -->
            <div class="card-header-action" v-if="hasHeaderAction || isCollapsible">
                <slot name="header-action"></slot>
                <button :data-collapse="collapsibleId"
                        class="btn btn-icon btn-light"
                        v-if="isCollapsible"
                        v-html="collapsibleIcon"
                        @click="collapsibleClick">
                </button>
            </div>
            <!-- #header action -->
        </div>

        <!-- body -->
        <div class="collapse show" :id="collapsibleId" v-if="isCollapsible">
            <div class="card-body">
                <slot></slot>
            </div>
        </div>
        <div class="card-body" v-else>
            <slot></slot>
        </div>
        <!-- #body -->

        <div class="card-footer" v-if="hasFooter">
            <slot name="footer"></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            isCollapsible: {
                type: Boolean,
                default: false
            },
            isHoverable: {
                type: Boolean,
                default: true
            },
            styleType: {
                type: String,
                default: 'light',
                validator: (value) => Vue.prototype.$Utils.styleTypes().includes(value)
            }
        },
        data: () => ({
            collapsibleId: null,
            collapsibleIcon: '<i class="fas fa-minus"></i>'
        }),
        methods: {
            collapsibleClick() {
                let target = $(`#${this.collapsibleId}`);

                target.collapse('toggle');
                target.on('shown.bs.collapse', () => this.collapsibleIcon = '<i class="fas fa-minus"></i>');
                target.on('hidden.bs.collapse', () => this.collapsibleIcon = '<i class="fas fa-plus"></i>');
            }
        },
        computed: {
            styleClass() {
                return {
                    'card-primary': this.styleType === 'primary',
                    'card-secondary': this.styleType === 'secondary',
                    'card-success': this.styleType === 'success',
                    'card-danger': this.styleType === 'danger',
                    'card-warning': this.styleType === 'warning',
                    'card-info': this.styleType === 'info',
                    'card-light': this.styleType === 'light',
                    'card-dark': this.styleType === 'dark',
                    'hoverable': this.isHoverable
                }
            },
            hasHeader() {
                return !!this.$slots['header'];
            },
            hasHeaderAction() {
                return !!this.$slots['header-action'];
            },
            hasFooter() {
                return !!this.$slots['footer'];
            }
        },
        created() {
            if (this.isCollapsible) {
                this.collapsibleId = this.$Utils.getRandomId();
            }
        }
    }
</script>

<style scoped>
    .hoverable {
        transition: all .25s linear;
    }

    .hoverable:hover {
        box-shadow: 0 8px 17px 0 rgba(0, 0, 0, .2), 0 6px 20px 0 rgba(0, 0, 0, .19);
    }
</style>
