<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <div class="row">
    <div class="col-3" />
    <div class="col-6">
      <card>
        <template v-slot:header>
          <h4>{{ $t('plugin.upload_plugin') }}</h4>
        </template>

        <div class="upload-component">
          <div class="upload">
            <div v-if="files.length">
              <div
                v-for="file in files"
                :key="file.id"
              >
                <div class="form-group">
                  <div class="input-group d-flex flex-row">
                    <div class="input-group-prepend">
                      <label
                        for="file"
                        class="btn btn-primary pt-2"
                      >{{ $t('plugin.browse') }}</label>
                    </div>
                    <input
                      class="form-control mr-1"
                      type="text"
                      readonly="readonly"
                      :value="file.name"
                    >
                    <button
                      :disabled="file.progress >= 100 || ($refs.upload && $refs.upload.active)"
                      class="btn btn-success"
                      type="button"
                      @click.prevent="$refs.upload.active = true"
                    >
                      {{ $t(installBtnText) }}
                    </button>
                  </div>
                </div>

                <!--                                <span v-if="file.error">{{file.error}}</span>-->
                <!--                                <span v-else-if="file.success">success</span>-->
                <!--                                <span v-else-if="file.active">active</span>-->
                <!--                                <span v-else></span>-->

                <div class="d-flex justify-content-between">
                  <span>{{ (file.progress / 100 * file.size) | formatSize }}/{{ file.size | formatSize }}</span>
                  <span>{{ file.speed | formatSize }}/s</span>
                </div>

                <div class="progress">
                  <div
                    class="progress-bar progress-bar-striped progress-bar-animated"
                    :style="{width : file.progress + '%'}"
                  >
                    {{ file.progress }}%
                  </div>
                </div>
              </div>
            </div>
            <template v-else>
              <div class="text-center p-5">
                <h4>{{ $t('plugin.drop_file_anyway_upload') }}<br>{{ $t('common.or') }}</h4>
                <label
                  for="file"
                  class="btn btn-lg btn-primary ml-2"
                >{{ $t('plugin.select_file') }}</label>
              </div>
            </template>

            <div
              v-show="$refs.upload && $refs.upload.dropActive"
              class="drop-active"
            >
              <h3>{{ $t('drop_file_to_upload') }}</h3>
            </div>

            <vue-upload-component
              ref="upload"
              v-model="files"
              :drop="true"
              :headers="headers"
              extensions="zip"
              post-action="/api/plugin"
              @input-file="inputFile"
            />
          </div>
        </div>
      </card>
    </div>
  </div>
</template>

<script>
import Card from '@components/Card';
import VueUploadComponent from 'vue-upload-component';

export default {
  components: {
    VueUploadComponent, Card,
  },
  data: () => ({
    files: [],
  }),
  computed: {
    installBtnText() {
      if (this.files[0].progress >= 100) {
        return 'plugin.installing';
      }

      if (this.$refs.upload && this.$refs.upload.active) {
        return 'plugin.uploading';
      }

      return 'plugin.install';
    },
    headers() {
      return {
        Accept: 'application/json, text/plain, */*',
        'X-CSRF-TOKEN': (() => {
          const token = document.head.querySelector('meta[name="csrf-token"]');
          if (token) {
            return token.content;
          }

          return null;
        })(),
      };
    },
  },
  mounted() {
    this.$store.commit('SET_PAGE_BACK_LINK', '/plugins');
    this.$store.commit('SET_CURRENT_PAGE_TITLE', 'plugin.install_plugin');
  },
  methods: {
    inputFile(newFile, oldFile) {
      if (newFile && oldFile && !newFile.active && oldFile.active) {
        if (newFile.xhr) {
          if (newFile.xhr.status === 200) {
            this.$Toast.show({
              type: 'success',
              message: 'Successfully installed plugin',
            });
            this.$router.push('/plugins');
          } else {
            this.$Toast.show({
              type: 'error',
              message: newFile.response.message,
            });
            this.files = [];
          }
        }
      }
    },
  },
};
</script>

<style scoped>
    .upload-component label.btn {
        margin-bottom: 0;
        cursor: pointer;
    }

    .upload-component .btn:disabled {
        cursor: not-allowed;
    }

    .upload-component .drop-active {
        top: 0;
        bottom: 0;
        right: 0;
        left: 0;
        position: fixed;
        z-index: 9999;
        opacity: .6;
        text-align: center;
        background: #000;
    }

    .upload-component .drop-active h3 {
        margin: -.5em 0 0;
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        font-size: 40px;
        color: #fff;
        padding: 0;
    }
</style>
