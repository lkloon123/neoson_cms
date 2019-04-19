<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <div>
        <card :is-collapsible="true" class="mb-1">
            <template v-slot:header>
                <h4>Featured Image</h4>
            </template>

            <img :src="selectedImg"
                 @click="showImg"
                 class="feature-img-placeholder mb-3"
                 v-if="hasSelectedImg">

            <LightBox :images="[{src: selectedImg}]"
                      :show-light-box="false"
                      :show-thumbs="false"
                      ref="lightbox"></LightBox>

            <div :class="{'d-flex': hasSelectedImg, 'justify-content-between': hasSelectedImg}">
                <button class="btn btn-danger btn-icon icon-left" v-if="hasSelectedImg" @click="removeImg">
                    <i class="fas fa-trash"></i>Remove
                </button>
                <html-modal :current-state="modalState"
                            :is-btn-html="true"
                            :show-btn="true"
                            :show-footer="false"
                            :trigger-btn-callback="openFileManager"
                            :trigger-btn-class="{btn: true, 'btn-light': true, 'btn-block': !hasSelectedImg, 'btn-icon': hasSelectedImg, 'icon-left': hasSelectedImg}"
                            :trigger-btn-text="triggerBtnTxt"
                            @hidden="modalState = 'hide'"
                            @shown="modalState = 'show'"
                            size="extra_large">
                    <div style="height: 500px;">
                        <file-manager></file-manager>
                    </div>
                </html-modal>
            </div>
        </card>
    </div>
</template>

<script>
    import Card from '@components/Card';
    import HtmlModal from '@components/modal/HtmlModal';
    import LightBox from 'vue-image-lightbox';

    export default {
        props: ['value'],
        data: () => ({
            modalState: 'hide',
            selectedImg: ''
        }),
        computed: {
            triggerBtnTxt() {
                return this.selectedImg ? '<i class="fas fa-exchange-alt"></i>Replace' : 'Select';
            },
            hasSelectedImg() {
                return this.selectedImg && this.selectedImg !== '' && this.selectedImg !== undefined && this.selectedImg !== null;
            }
        },
        watch: {
            value: {
                handler(newValue) {
                    this.selectedImg = newValue;
                },
                immediate: true
            },
            selectedImg(newValue) {
                if (newValue && !this.isImage(newValue)) {
                    this.$Toast.show({
                        type: 'error',
                        message: 'Invalid Image, supported type: jpeg, jpg, gif, png'
                    });
                    this.selectedImg = '';
                }
                this.$emit('input', this.selectedImg);
            }
        },
        methods: {
            openFileManager() {
                this.$store.dispatch('fm/refreshAll');
                this.$store.commit('fm/setFileCallBack', (fileUrl) => {
                    this.selectedImg = fileUrl;
                    this.modalState = 'hide';
                });
            },
            removeImg() {
                this.selectedImg = '';
            },
            isImage(url) {
                return (url.match(/\.(jpeg|jpg|gif|png)$/) != null);
            },
            showImg() {
                this.$refs.lightbox.showImage(0);
            }
        },
        components: {
            Card, HtmlModal, LightBox
        }
    }
</script>

<style scoped>
    @import "~vue-image-lightbox/dist/vue-image-lightbox.min.css";

    .feature-img-placeholder {
        max-width: 100%;
        cursor: zoom-in;
    }
</style>
