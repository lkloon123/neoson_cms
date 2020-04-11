import moment from 'moment';

export default {
  methods: {
    formatToAgoDate(inputDateTime) {
      return moment(inputDateTime).locale(this.$store.state.locale).fromNow();
    },
  },
};
