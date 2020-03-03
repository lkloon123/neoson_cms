import sluggable from 'slug';

export default {
  props: ['form', 'value'],
  computed: {
    getId() {
      return this.form.id ? this.form.id : sluggable(this.form.label, { lower: true });
    },
  },
};
