export default {
  methods: {
    translate(word) {
      if (word.includes('.')) {
        return this.$t(word);
      }

      return word;
    },
  },
};
