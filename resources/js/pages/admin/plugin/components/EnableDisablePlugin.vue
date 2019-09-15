<template>
    <toggle-button :color="{checked: '#63ed7a', unchecked: '#fc544b', disabled: '#CCCCCC'}"
                   :disabled="updating"
                   :sync="true"
                   :value="!plugin.isDisabled"
                   @input="enableOrDisablePlugin($event)"
                   class="mt-2"></toggle-button>
</template>

<script>
    import {ToggleButton} from 'vue-js-toggle-button';

    export default {
        props: ['plugin'],
        data: () => ({
            updating: false
        }),
        computed: {
            description() {
                return this.plugin.desc ? this.plugin.desc : this.plugin.name;
            }
        },
        methods: {
            enableOrDisablePlugin(state) {
                this.updating = true;
                this.$Toast.showLoading({
                    title: 'Updating...'
                });

                axios.put(`/api/plugin/${this.plugin.id}`, {
                    isDisabled: !state
                }).then(response => {
                    this.$Toast.show({
                        type: 'success',
                        message: `Successfully updated plugin [${this.plugin.name}]`
                    });
                }).catch(err => {
                    this.$Toast.show({
                        type: 'error',
                        message: err.response.data.message
                    });
                }).finally(() => {
                    this.updating = false;
                })
            }
        },
        components: {
            ToggleButton
        }
    }
</script>

<style scoped>

</style>
