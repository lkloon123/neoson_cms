<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <div class="row">
    <div class="col-md-9">
      <card>
        <template v-slot:header>
          <h4 class="form-inline">
            {{ $t('menu.menu_structure') }}
          </h4>
        </template>
        <template v-slot:header-action>
          <div class="form-inline">
            <div class="form-group">
              <label for="menuName">{{ $t('common.name') }} <span class="text-danger">*</span></label>
              <input
                id="menuName"
                v-model="name"
                v-validate="'required'"
                :class="{'is-invalid': errors.first('Name')}"
                :disabled="isMenuItemsEmpty && isLoading"
                class="form-control mx-2"
                name="Name"
                type="text"
              >
            </div>

            <button
              :class="{disabled: isMenuItemsEmpty && isLoading}"
              :disabled="isMenuItemsEmpty && isLoading"
              class="btn btn-primary"
              @click="validateAndSave"
            >
              {{ $t('common.save') }}
            </button>
          </div>
        </template>

        <vcl-list v-if="isLoading" />

        <vue-nestable
          v-else
          v-model="menuItems"
        >
          <template v-slot:placeholder>
            Get started by add menu on right side
            <i
              class="fas fa-hand-point-right"
              style="font-size: 1.2rem"
            />
          </template>
          <template slot-scope="{item, index, isChild}">
            <vue-nestable-handle :item="item">
              <div class="alert alert-light mb-0 p-2 pl-3 pr-3 menu-item-component">
                <span class="menu-item-label">
                  <b v-if="item.menuLabel">{{ translate(item.menuLabel) }}</b>
                  <span v-else>({{ $t('menu.no_label') }})</span>
                  <em
                    v-if="isChild"
                    class="text-muted"
                  > &nbsp;{{ $t('menu.sub_menu') }}</em>
                </span>
                <span class="menu-item-control">
                  <span class="text-muted">{{ $t(item.componentLabel) }}</span>
                  <a
                    class="btn btn-light btn-icon btn-sm"
                    @click.prevent="openMenu(item)"
                  >
                    <i class="fas fa-caret-down" />
                  </a>
                </span>
              </div>
            </vue-nestable-handle>

            <!-- menu options -->
            <update-wrapper :item="item" />
            <!-- #menu options -->
          </template>
        </vue-nestable>
      </card>
    </div>
    <div class="col-md-3">
      <available-item-wrapper :title="$t('menu.pages')">
        <select-page />
      </available-item-wrapper>

      <available-item-wrapper :title="$t('menu.custom_link')">
        <custom-link />
      </available-item-wrapper>

      <available-item-wrapper :title="$t('menu.auth')">
        <auth />
      </available-item-wrapper>

      <available-item-wrapper :title="$t('menu.language')">
        <language />
      </available-item-wrapper>
    </div>
  </div>
</template>

<script>
import Card from '@components/Card';
import { VueNestable, VueNestableHandle } from 'vue-nestable';
import { VclList } from 'vue-content-loading';
import { cloneDeep } from 'lodash';
import TranslationMixin from '@mixins/translation_mixin';
import axios from 'axios';
import AvailableItemWrapper from './components/AvailableItemWrapper';
import CustomLink from './components/CustomLink';
import SelectPage from './components/SelectPage';
import Auth from './components/Auth';
import UpdateWrapper from './components/form/UpdateWrapper';
import Language from './components/Language';

export default {
  components: {
    Language,
    AvailableItemWrapper,
    Card,
    CustomLink,
    SelectPage,
    Auth,
    UpdateWrapper,
    VueNestable,
    VueNestableHandle,
    VclList,
  },
  mixins: [TranslationMixin],
  props: {
    mode: {
      type: String,
      default: 'create',
    },
  },
  data: () => ({
    name: '',
  }),
  computed: {
    menuItems: {
      get() {
        return this.$store.state.menu.menuItems;
      },
      set(value) {
        this.$store.commit('menu/SET_MENU_ITEMS', value);
      },
    },
    isLoading: {
      get() {
        return this.$store.state.menu.coreLoading;
      },
      set(value) {
        this.$store.commit('menu/UPDATE_CORE_LOADING', value);
      },
    },
    isMenuItemsEmpty() {
      return this.menuItems.length <= 0;
    },
  },
  async mounted() {
    this.$store.commit('menu/RESET_STATE');

    if (this.mode === 'edit') {
      this.$store.commit('SET_CURRENT_PAGE_TITLE', 'menu.edit_menu');

      // fetch data from server
      try {
        const menuResponse = await axios.get(`/api/menu/${this.$route.params.id}`);
        this.name = menuResponse.data.menu.name;
        this.menuItems = menuResponse.data.data;
      } catch (err) {
        this.$Toast.show({
          type: 'error',
          message: err.response.data.message,
        });
      }
    } else {
      this.$store.commit('SET_CURRENT_PAGE_TITLE', 'menu.create_menu');
    }

    this.$store.commit('SET_PAGE_BACK_LINK', '/menu');

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
    openMenu(searchItem) {
      const cloned = cloneDeep(searchItem);

      cloned.showMenuOption = !cloned.showMenuOption;
      this.$store.commit('menu/UPDATE_MENU_ITEM', cloned);
    },
    async save() {
      const params = {
        name: this.name,
        menuItems: this.menuItems,
      };

      if (this.mode === 'create') {
        this.isLoading = true;

        try {
          await axios.post('/api/menu', params);
          this.$Toast.show({
            type: 'success',
            message: 'Successfully created menu',
          });
        } catch (err) {
          this.$Toast.show({
            type: 'error',
            message: err.response.data.message,
          });
        }

        this.isLoading = false;
      } else if (this.mode === 'edit') {
        this.isLoading = true;
        this.$Toast.showLoading({
          title: 'Updating...',
        });

        try {
          await axios.put(`/api/menu/${this.$route.params.id}`, params);
          this.$Toast.show({
            type: 'success',
            message: 'Successfully updated menu',
          });
        } catch (err) {
          this.$Toast.show({
            type: 'error',
            message: err.response.data.message,
          });
        }

        this.isLoading = false;
      }
    },
  },
};
</script>

<style scoped>
    @import '~@css/nestable.css';

    .menu-item-label {
        display: block;
        margin-right: 10em;
    }

    .menu-item-control {
        position: absolute;
        right: 1rem;
        top: 0.5rem;
    }

    .menu-item-control .btn {
        cursor: pointer;
    }

    .menu-item-component {
        width: 25rem;
    }

    .card .card-header .form-control {
        border-radius: 0.25rem;
        padding: 10px;
    }
</style>
