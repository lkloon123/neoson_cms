export default {
  computed: {
    isLoading: {
      get() {
        return this.$store.state.form.coreLoading;
      },
      set(value) {
        this.$store.commit('form/UPDATE_CORE_LOADING', value);
      },
    },
  },
  methods: {
    applyDrag(arr, dragResult) {
      const { removedIndex, addedIndex, payload } = dragResult;
      if (removedIndex === null && addedIndex === null) {
        return arr;
      }

      const result = [...arr];
      let itemToAdd = payload;

      if (removedIndex !== null) {
        // eslint-disable-next-line prefer-destructuring
        itemToAdd = result.splice(removedIndex, 1)[0];
      }

      if (addedIndex !== null) {
        result.splice(addedIndex, 0, itemToAdd);
      }

      return result;
    },
  },
};
