<template>
  <div>
    <div class="form-group">
      <label>{{ $t('menu.available_languages') }} :</label>
      <div>
        <span
          v-for="(language,index) in itemData.languageIds"
          :key="index"
          class="badge badge-info mr-1"
        >
          {{ language.title }}
        </span>
      </div>
    </div>

    <button
      class="btn btn-danger btn-icon icon-left"
      @click="removeMenu"
    >
      <i class="fas fa-trash" /> {{ $t('common.remove') }}
    </button>
  </div>
</template>

<script>
import Mixin from '../mixin';

export default {
  mixins: [Mixin],
};
</script>

<style scoped>

</style>
