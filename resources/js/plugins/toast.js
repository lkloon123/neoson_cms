import iziToast from 'izitoast';

export default function (Vue) {
  Vue.Toast = {
    show({
      title = '', message = '', type = 'info', timeout = 4 * 1000, showClose = true, showProgressBar = true,
    }) {
      iziToast.destroy();

      return iziToast[type]({
        title,
        message,
        timeout,
        close: showClose,
        position: 'bottomLeft',
        displayMode: 2,
        pauseOnHover: false,
        progressBar: showProgressBar,
        animateInside: false,
        transitionOut: 'fadeOutUp',
      });
    },
    showLoading({
      title = '', message = '', type = 'info', timeout = false, showClose = false, showProgressBar = false,
    }) {
      return this.show({
        title,
        message,
        type,
        timeout,
        showClose,
        showProgressBar,
      });
    },
  };

  Object.defineProperties(Vue.prototype, {
    $Toast: {
      get() {
        return Vue.Toast;
      },
    },
  });
}
