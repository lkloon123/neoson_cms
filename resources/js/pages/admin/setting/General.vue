<template>
  <div class="row">
    <div class="col-md-2 col-sm-2" />
    <div class="col-md-8 col-sm-8">
      <card>
        <template v-slot:header>
          <h4>General Settings</h4>
        </template>

        <vcl-table v-if="isLoading" />

        <template v-else>
          <template v-for="(setting, key) in settings">
            <form-wrapper
              :key="key"
              v-model="settings[key]"
              :form="forms[key]"
            />
          </template>

          <div class="text-right">
            <button
              type="submit"
              class="btn btn-primary btn-save"
              @click="save(group)"
            >
              Save
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
import FormWrapper from '@components/forms_builder/FormWrapper';
import Mixin from './mixin';

export default {
  components: {
    FormWrapper, Card, VclTable,
  },
  mixins: [Mixin],
  data: () => ({
    group: 'general',
  }),
  created() {
    this.loadSetting(this.group);
    this.$store.commit('SET_CURRENT_PAGE_TITLE', 'General Settings');
    this.$store.commit('SET_PAGE_BACK_LINK', '/settings');
  },
};
</script>

<style scoped>
    .btn-save {
        width: 150px
    }
</style>
