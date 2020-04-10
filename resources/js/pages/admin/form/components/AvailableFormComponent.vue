<template>
  <card>
    <template v-slot:header>
      <h4>{{ $t('form.form_component') }}</h4>
    </template>

    <list-content-loading v-if="isLoading" />

    <Container
      v-else
      group-name="form"
      behaviour="copy"
      :get-child-payload="getChildPayload"
    >
      <Draggable
        v-for="formComponent in formComponents"
        :key="formComponent.id"
        class="row text-center mb-3"
      >
        <div class="col-12 item-drag">
          <div class="alert alert-light mb-0">
            {{ formComponent.default_meta.componentLabel }}
          </div>
        </div>
      </Draggable>
    </Container>
  </card>
</template>

<script>
import Card from '@components/Card';
import { Container, Draggable } from 'vue-smooth-dnd';
import ListContentLoading from '@components/content_loading/ListContentLoading';
import { mapState } from 'vuex';
import { cloneDeep } from 'lodash';
import Mixin from '../mixin';

export default {
  components: {
    Card, Container, Draggable, ListContentLoading,
  },
  mixins: [Mixin],
  computed: {
    ...mapState('form', ['formComponents']),
  },
  methods: {
    getChildPayload(index) {
      const cloned = cloneDeep(this.formComponents[index].default_meta);
      cloned.htmlComponent = this.formComponents[index].html_component;
      return cloned;
    },
  },
};
</script>

<style scoped>
    .item-drag {
        cursor: move;
    }
</style>
