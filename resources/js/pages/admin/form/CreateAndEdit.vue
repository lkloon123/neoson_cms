<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <div>
    <div class="row">
      <div class="col-md-3">
        <available-form-component />
      </div>
      <div class="col-md-6">
        <card>
          <template v-slot:header>
            <h4 class="form-inline">
              Form Preview
            </h4>
          </template>
          <template v-slot:header-action>
            <div class="form-inline">
              <div class="form-group">
                <label for="formName">Name <span class="text-danger">*</span></label>
                <input
                  id="formName"
                  v-model="name"
                  v-validate="'required'"
                  :class="{'is-invalid': errors.first('Name')}"
                  :disabled="isLoading"
                  class="form-control mx-2"
                  name="Name"
                  type="text"
                >
              </div>

              <button
                :class="{disabled: isLoading}"
                :disabled="isLoading"
                class="btn btn-primary"
                @click="validateAndSave"
              >
                Save
              </button>
            </div>
          </template>

          <form-content-loading
            v-if="isLoading"
            :form-amount="2"
          />

          <Container
            v-else
            :drop-placeholder="true"
            :get-child-payload="getChildPayload"
            drag-class="opacity-ghost"
            drag-handle-selector=".item-drag-handler"
            group-name="form"
            lock-axis="y"
            @drag-enter="itemsEntering = true"
            @drag-leave="itemsEntering = false"
            @onDrop="onDrop"
          >
            <div
              v-if="isFormItemsEmpty && !itemsEntering"
              class="empty-form-component text-center"
            >
              <i class="fas fa-arrows-alt" /> Drag component here from the left.
            </div>

            <Draggable
              v-for="(field, index) in formItems"
              :key="field.id"
            >
              <div
                :class="{selected: selectedFormItemIndex === index}"
                class="form-item-wrapper"
                @click="select(index)"
              >
                <div class="form-group">
                  <div class="item-drag-handler text-center">
                    <i class="fas fa-grip-horizontal item-drag-icon" />
                  </div>

                  <!-- display form -->
                  <example-form-field
                    :template="getHtmlElementByType(field.type)"
                    :field="field"
                  />
                </div>
              </div>
            </Draggable>
          </Container>
        </card>
      </div>
      <div class="col-md-3">
        <update-field />
      </div>
    </div>
  </div>
</template>

<script>
import Card from '@components/Card';
import { Container, Draggable } from 'vue-smooth-dnd';
import FormContentLoading from '@components/content_loading/FormContentLoading';
import { cloneDeep } from 'lodash';
import { mapGetters } from 'vuex';
import axios from 'axios';
import AvailableFormComponent from './components/AvailableFormComponent';
import UpdateField from './components/UpdateField';
import Mixin from './mixin';
import ExampleFormField from './components/ExampleFormField';

export default {
  components: {
    AvailableFormComponent, Card, Container, Draggable, UpdateField, FormContentLoading, ExampleFormField,
  },
  mixins: [Mixin],
  props: {
    mode: {
      type: String,
      default: 'create',
    },
  },
  data: () => ({
    name: '',
    itemsEntering: false,
  }),
  computed: {
    ...mapGetters('form', ['getHtmlElementByType']),
    formItems: {
      get() {
        return this.$store.state.form.formItems;
      },
      set(value) {
        this.$store.commit('form/SET_FORM_ITEMS', value);
      },
    },
    selectedFormItemIndex: {
      get() {
        return this.$store.state.form.selectedIndex;
      },
      set(value) {
        this.$store.commit('form/SET_SELECTED_FORM_ITEM_INDEX', value);
      },
    },
    isFormItemsEmpty() {
      return this.formItems.length <= 0;
    },
  },
  watch: {
    formItems() {
      this.itemsEntering = false;
    },
  },
  async created() {
    this.isLoading = true;
    this.$store.commit('form/RESET_STATE');

    if (this.mode === 'edit') {
      this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Edit Form');

      // fetch data from server
      try {
        const formResponse = await axios.get(`/api/form/${this.$route.params.id}`);
        this.name = formResponse.data.form.name;
        this.formItems = formResponse.data.data;
      } catch (err) {
        this.$Toast.show({
          type: 'error',
          message: err.response.data.message,
        });
      }
    } else {
      this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Create Form');
    }

    const formComponentResponse = await axios.get('/api/form/component');
    this.$store.commit('form/SET_FORM_COMPONENTS', formComponentResponse.data);

    this.$store.commit('SET_PAGE_BACK_LINK', '/forms');

    this.isLoading = false;
  },
  methods: {
    validateAndSave() {
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          this.save();
        }
      });
    },
    onDrop(dropResult) {
      const clonedPayload = cloneDeep(dropResult.payload);
      clonedPayload.id = this.$Utils.getRandomId();
      dropResult.payload = clonedPayload;
      this.formItems = this.applyDrag(this.formItems, dropResult);

      if (dropResult.addedIndex !== null) {
        this.selectedFormItemIndex = dropResult.addedIndex;
      }
    },
    select(index) {
      this.selectedFormItemIndex = index;
    },
    getChildPayload(index) {
      return this.formItems[index];
    },
    async save() {
      const params = {
        name: this.name,
        formItems: this.formItems,
      };

      this.isLoading = true;

      if (this.mode === 'create') {
        try {
          const createResponse = await axios.post('/api/form', params);
          this.$Toast.show({
            type: 'success',
            message: 'Successfully created form',
          });
          this.$router.push(`/forms/edit/${createResponse.data.id}`);
        } catch (err) {
          this.$Toast.show({
            type: 'error',
            message: err.response.data.message,
          });
        }
      } else if (this.mode === 'edit') {
        this.$Toast.showLoading({
          title: 'Updating...',
        });

        try {
          await axios.put(`/api/form/${this.$route.params.id}`, params);
          this.$Toast.show({
            type: 'success',
            message: 'Successfully updated form',
          });
        } catch (err) {
          this.$Toast.show({
            type: 'error',
            message: err.response.data.message,
          });
        }
      }

      this.isLoading = false;
    },
  },
};
</script>

<style lang="scss" scoped>
    .form-item-wrapper:hover {
        .form-group {
            border: 1px dashed;

            .item-drag-handler {
                visibility: visible;
            }
        }
    }

    .form-item-wrapper.selected .form-group {
        /*background-color: #f8f9fa;*/
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.12), 0 2px 4px 0 rgba(0, 0, 0, 0.08);
    }

    .form-item-wrapper {
        margin: 5px;

        .item-drag-handler {
            visibility: hidden;
            cursor: move;
        }

        .form-group {
            border-radius: 5px;
            padding: 0 10px 10px;
        }
    }

    .empty-form-component {
        padding: 45px 20px;
        line-height: 36px;
        border: 1px dashed;
        background-color: rgba(150, 150, 150, 0.1);
        border-radius: 5px;
    }

    .smooth-dnd-container {
        min-height: 130px;
    }

    .opacity-ghost {
        background-color: #f8f9fa;
    }
</style>
