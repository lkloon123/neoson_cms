export default {
    data: () => ({
        settings: [],
        isLoading: true
    }),
    methods: {
        loadSetting(group) {
            this.resetState();
            axios.get(`/api/setting/${group}`)
                .then(response => {
                    this.settings = response.data;
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        save(group) {
            this.isLoading = true;

            this.$Toast.showLoading({
                title: 'Updating...'
            });

            axios.put(`/api/setting/${group}`, {data: this.settings})
                .then(response => {
                    this.$Toast.show({
                        type: 'success',
                        message: 'Successfully updated setting'
                    });
                })
                .catch(err => {
                    this.$Toast.show({
                        type: 'error',
                        message: err.response.data.message
                    });
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        resetState() {
            this.settings = [];
            this.isLoading = true;
        }
    },
};
