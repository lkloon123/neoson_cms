<template>
  <div class="row">
    <div class="col-md-2 col-sm-2" />
    <div class="col-md-8 col-sm-8">
      <card>
        <template v-slot:header>
          <h4>{{ $t('setting.general_settings') }}</h4>
        </template>

        <vcl-table v-if="isLoading" />

        <template v-else>
          <template v-for="(setting, index) in settings">
            <form-item-wrapper
              :key="index"
              :template="formItemTemplate(setting.meta.type)"
              :form-item="buildFormItemFromSetting(setting, group)"
              @value-changed="updateSettingValueState($event, index)"
            />
          </template>

          <div
            v-if="hasPermission('update', 'general_setting')"
            class="text-right"
          >
            <button
              type="submit"
              class="btn btn-primary btn-save"
              @click="save(group)"
            >
              {{ $t('common.save') }}
            </button>
          </div>
        </template>
      </card>
    </div>
  </div>
</template>

<script>
import Card from '@components/Card';
import { VclTable } from 'vue-content-loading';
import FormItemWrapper from '@components/FormItemWrapper';
import Mixin from './mixin';

export default {
  components: {
    FormItemWrapper, Card, VclTable,
  },
  mixins: [Mixin],
  data: () => ({
    group: 'general',
  }),
  created() {
    this.loadSetting(this.group);
    this.$store.commit('SET_CURRENT_PAGE_TITLE', 'setting.general_settings');
    this.$store.commit('SET_PAGE_BACK_LINK', '/settings');
  },
};
</script>

<style scoped>
    .btn-save {
        width: 150px
    }
</style>
