<template>
    <div>
        <box-content-loading v-if="isLoading || isContentLoading"></box-content-loading>

        <div :class="{'should-hide': isLoading || isContentLoading}">
            <tiny-mce :init="tinymceInit"
                      :value="value"
                      @input="$emit('input', $event)"
                      :plugins="tinymcePlugin"
                      :toolbar="tinymceToolbar"
                      @onInit="isLoading = false"></tiny-mce>
        </div>
    </div>
</template>

<script>
    import 'tinymce';
    import 'tinymce/themes/silver/theme';
    import 'tinymce/plugins/help/plugin';
    import 'tinymce/plugins/link/plugin';
    import 'tinymce/plugins/code/plugin';
    import 'tinymce/plugins/nonbreaking/plugin';
    import 'tinymce/plugins/lists/plugin';
    import 'tinymce/plugins/advlist/plugin';
    import 'tinymce/plugins/image/plugin';
    import 'tinymce/plugins/media/plugin';
    import 'tinymce/plugins/autoresize/plugin';
    import TinyMce from '@tinymce/tinymce-vue';

    import BoxContentLoading from '@components/content_loading/BoxContentLoading'

    export default {
        props: {
            isContentLoading: {
                type: Boolean,
                default: false
            },
            value: {
                type: String
            }
        },
        data: () => ({
            tinymceInit: {
                skin_url: '/css/tinymce/skins/ui/oxide',
                content_css: '/css/tinymce/skins/content/default/content.min.css',
                menubar: false,
                statusbar: false,
                nonbreaking_force_tab: true,
                image_advtab: true,
                autoresize_bottom_margin: 10,
                min_height: 350
            },
            tinymcePlugin: 'help link code nonbreaking lists advlist image media autoresize',
            tinymceToolbar: 'undo redo | formatselect fontsizeselect | bold italic strikethrough forecolor | link image media | alignleft aligncenter alignright alignjustify | bullist numlist | removeformat | code help',
            isLoading: true
        }),
        components: {
            TinyMce, BoxContentLoading
        }
    }
</script>

<style scoped>

</style>
