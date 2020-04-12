<template>
  <div class="row">
    <div class="col-md-2 col-sm-2" />
    <div class="col-md-8 col-sm-8">
      <card>
        <template v-slot:header>
          <h4>{{ $t('setting.integration_settings') }}</h4>
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

          <div class="text-right">
            <button
              v-if="hasPermission('update', 'integration_setting')"
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
    group: 'integration',
  }),
  mounted() {
    this.loadSetting(this.group);
    this.$store.commit('SET_CURRENT_PAGE_TITLE', 'setting.integration_settings');
    this.$store.commit('SET_PAGE_BACK_LINK', '/settings');
  },
};
</script>

<style scoped>

</style>
