export default function (Vue) {
    Vue.Utils = {
        getRandomId() {
            return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
        },

        styleTypes() {
            return ['primary', 'secondary', 'danger', 'warning', 'info', 'success', 'light', 'dark'];
        }
    };

    Object.defineProperties(Vue.prototype, {
        $Utils: {
            get() {
                return Vue.Utils;
            }
        }
    })
}