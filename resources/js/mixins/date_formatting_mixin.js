import moment from 'moment';

export default {
  methods: {
    formatToAgoDate(inputDateTime) {
      return moment(inputDateTime).fromNow();
    },
  },
};
