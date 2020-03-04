import axios from 'axios';

export default {
  data: () => ({
    settings: [],
    formComponents: [],
    isLoading: true,
  }),
  methods: {
    buildFormItemFromSetting(setting) {
      setting.meta.value = setting.setting_value;
      return setting.meta;
    },
    formItemTemplate(formType) {
      return `<div class="form-group">${this.getHtmlElementByType(formType)}</div>`;
    },
    updateSettingValueState(newValue, index) {
      this.settings[index].setting_value = newValue;
    },
    getHtmlElementByType(formType) {
      return this.formComponents.find((formComponent) => formComponent.default_meta.type === formType)?.html_component;
    },
    async loadSetting(group) {
      this.resetState();

      const [loadSettingResponse, formComponentResponse] = await Promise.all([
        axios.get(`/api/setting/${group}`),
        axios.get('/api/form/component'),
      ]);

      this.settings = loadSettingResponse.data;
      this.formComponents = formComponentResponse.data;

      this.isLoading = false;
    },
    async save(group) {
      this.isLoading = true;

      this.$Toast.showLoading({
        title: 'Updating...',
      });

      try {
        await axios.put(`/api/setting/${group}`, { data: this.settings });
        this.$Toast.show({
          type: 'success',
          message: 'Successfully updated setting',
        });
      } catch (err) {
        this.$Toast.show({
          type: 'error',
          message: err.response.data.message,
        });
      }

      this.isLoading = false;
    },
    resetState() {
      this.settings = [];
      this.formComponents = [];
      this.isLoading = true;
    },
  },
};
