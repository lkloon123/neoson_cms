<template>
  <input
    :id="id"
    class="form-control"
    type="text"
    :value="value"
    :disabled="disabled"
    readonly
  >
</template>

<script>
import moment from 'moment';

export default {
  props: {
    options: {
      type: Object,
      required: true,
    },
    value: {
      type: String,
      required: true,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },
  data: () => ({
    copyOption: {
      minDate: '1970-01-01 12:00:00 am',
      maxDate: '2038-01-18 11:59:59 pm',
      showDropdowns: true,
      ranges: {
        Today: [moment().startOf('day'), moment().endOf('day')],
        Tomorrow: [moment().add(1, 'day').startOf('day'), moment().add(1, 'day').endOf('day')],
      },
      locale: {
        format: 'YYYY-MM-DD hh:mm:ss a',
      },
      timePicker: true,
      cancelButtonClasses: 'btn-light',
    },
    selectedDateTime: null,
    dateRangePickerIns: null,
    id: null,
  }),
  watch: {
    selectedDateTime(newValue) {
      this.$emit('input', newValue);
    },
  },
  beforeMount() {
    this.id = this.$Utils.getRandomId();
    this.copyOption = Object.assign(this.copyOption, this.options);
    this.selectedDateTime = this.value;
  },
  mounted() {
    this.dateRangePickerIns = $(`#${this.id}`);
    this.makeDateTimePicker();
    this.bindEvents();
  },
  methods: {
    makeDateTimePicker() {
      this.dateRangePickerIns.daterangepicker(this.copyOption);
    },
    bindEvents() {
      const vm = this;
      if (this.options.singleDatePicker && this.options.singleDatePicker === true) {
        this.dateRangePickerIns.on('apply.daterangepicker', (event, picker) => {
          vm.selectedDateTime = picker.startDate.format('YYYY-MM-DD hh:mm:ss a');
        });
        this.dateRangePickerIns.on('hide.daterangepicker', (event, picker) => {
          vm.selectedDateTime = picker.startDate.format('YYYY-MM-DD hh:mm:ss a');
        });
      } else {
        this.dateRangePickerIns.on('apply.daterangepicker', (event, picker) => {
          vm.selectedDateTime = `${picker.startDate.format('YYYY-MM-DD hh:mm:ss a')} - ${picker.endDate.format('YYYY-MM-DD hh:mm:ss a')}`;
        });
        this.dateRangePickerIns.on('hide.daterangepicker', (event, picker) => {
          vm.selectedDateTime = `${picker.startDate.format('YYYY-MM-DD hh:mm:ss a')} - ${picker.endDate.format('YYYY-MM-DD hh:mm:ss a')}`;
        });
      }
    },
  },
};
</script>

<style scoped>

</style>
