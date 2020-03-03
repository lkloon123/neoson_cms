import axios from 'axios';

export default {
  data: () => ({
    settings: [],
    forms: [],
    isLoading: true,
  }),
  methods: {
    async loadSetting(group) {
      this.resetState();
      const loadSettingResponse = await axios.get(`/api/setting/${group}`);
      this.settings = loadSettingResponse.data.settings;
      this.forms = loadSettingResponse.data.forms;

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
      this.isLoading = true;
    },
  },
};
