export default function (Vue) {
  Vue.Utils = {
    getRandomId() {
      return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
    },

    styleTypes() {
      return ['primary', 'secondary', 'danger', 'warning', 'info', 'success', 'light', 'dark'];
    },

    findId(arr, id) {
      let output = {};
      for (let i = 0; i < arr.length; i += 1) {
        if (arr[i].id === id) {
          output.current = arr[i];
          output.parent = arr;
          break;
        } else if (arr[i].children && arr[i].children.length > 0) {
          output = this.findId(arr[i].children, id);
          if (output.current) {
            break;
          }
        }
      }
      return output;
    },
  };

  Object.defineProperties(Vue.prototype, {
    $Utils: {
      get() {
        return Vue.Utils;
      },
    },
  });
}
