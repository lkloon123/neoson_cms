<template>
  <collapse-transition>
    <div
      v-if="item.showMenuOption"
      class="menu-item-component collapse"
      :class="{show: item.showMenuOption}"
    >
      <div class="card card-body mb-0 card-option">
        <custom-link
          v-if="item.type === 'custom_link'"
          mode="update"
          :item-data="item"
        />
        <update-page
          v-else-if="item.type === 'page'"
          mode="update"
          :item-data="item"
        />
        <auth
          v-else-if="item.type === 'auth'"
          mode="update"
          :item-data="item"
        />
      </div>
    </div>
  </collapse-transition>
</template>

<script>
import { CollapseTransition } from 'vue2-transitions';
import CustomLink from '../CustomLink';
import UpdatePage from './UpdatePage';
import Auth from '../Auth';

export default {
  components: {
    CustomLink,
    CollapseTransition,
    UpdatePage,
    Auth,
  },
  props: {
    item: {
      type: Object,
      required: true,
    },
  },
};
</script>

<style scoped>
  .card-option {
    border: 1px solid rgba(0, 0, 0, 0.125);
    padding: 0.5rem 1rem 1rem;
    background-color: #e3eaef;
  }
</style>
