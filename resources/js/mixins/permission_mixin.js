import { mapGetters } from 'vuex';

export default {
  methods: {
    ...mapGetters(['hasPermission', 'isA']),
  },
};
