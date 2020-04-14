import { isEqual } from 'lodash';

export default {
  data: () => ({
    isDirty: false,
  }),
  beforeMount() {
    window.addEventListener('beforeunload', this.onBeforeUnload);
  },
  beforeDestroy() {
    window.removeEventListener('beforeunload', this.onBeforeUnload);
  },
  watch: {
    // automatic watch formValues for dirty value if exist
    formValues: {
      handler(newValues) {
        if (this.defaultFormValues) {
          this.isDirty = !isEqual(this.defaultFormValues, newValues);
        }
      },
      deep: true,
    },
  },
  methods: {
    updateIsDirty(isDirty) {
      this.isDirty = isDirty;
    },
    onBeforeUnload(e) {
      if (this.isDirty) {
        e.preventDefault();
        // Chrome requires returnValue to be set
        e.returnValue = '';
      }
    },
  },
  beforeRouteLeave(to, from, next) {
    // eslint-disable-next-line no-alert
    if (!this.isDirty || window.confirm(
      'This page is asking you to confirm that you want to leave - data you have entered may not be saved.',
    )) {
      next();
    } else {
      next(false);
    }
  },
};
