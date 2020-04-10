<template>
  <div>
    <div class="form-group">
      <label for="menu-label">{{ $t('common.label') }}</label>
      <input
        id="menu-label"
        :value="getValue('menuLabel')"
        class="form-control"
        name="Label"
        type="text"
        @input="setValue('menuLabel', $event.target.value)"
      >
    </div>

    <div class="form-group">
      <span>
        {{ $t('common.url') }}: <a
          :href="`/${itemData.slug}`"
          target="_blank"
        >{{ $t(itemData.title) }}</a>
      </span>
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
