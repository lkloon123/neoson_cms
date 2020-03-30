import { mapMutations, mapState } from 'vuex';
import { cloneDeep } from 'lodash';

export default {
  props: {
    mode: {
      type: String,
      default: 'add',
    },
    itemData: {
      type: Object,
    },
  },
  computed: {
    ...mapState('menu', {
      isLoading: (state) => state.coreLoading,
    }),
  },
  methods: {
    ...mapMutations('menu', ['ADD_MENU_ITEM']),
    getValue(key) {
      if (this.mode === 'add') {
        return this[key];
      }
      return this.itemData[key];
    },
    setValue(key, value) {
      if (this.mode === 'add') {
        this[key] = value;
      } else {
        this.$store.commit('menu/UPDATE_MENU_ITEM_KEY', { id: this.itemData.id, key, value });
      }
    },
    addToMenu() {
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          this.ADD_MENU_ITEM(this.$data);
          this.reset();
        }
      });
    },
    removeMenu() {
      const cloned = cloneDeep(this.itemData);
      this.$store.commit('menu/REMOVE_MENU_ITEM', cloned);
    },
  },
};
