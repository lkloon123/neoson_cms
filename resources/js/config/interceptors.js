import axios from 'axios';
import { values } from 'lodash';

function refreshXsrfToken() {
  return axios.get('/admin')
    .then(({ data }) => {
      const wrapper = document.createElement('div');
      wrapper.innerHTML = data;

      return wrapper.querySelector('meta[name=csrf-token]').getAttribute('content');
    })
    .then((token) => {
      axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
      document.querySelector('meta[name=csrf-token]').setAttribute('content', token);

      return token;
    });
}


axios.interceptors.response.use(null,
  (error) => {
    if (error.config && error.response) {
      if (error.response.status === 419) {
        return refreshXsrfToken()
          .then((token) => {
            error.config.headers.common['X-CSRF-TOKEN'] = token;
            return axios.request(error.config);
          });
      }

      if (error.response.status === 401) {
        // unauthenticated
        window.location = '/login';
      }

      if (error.response.status === 422) {
        // eslint-disable-next-line prefer-destructuring
        error.response.data.message = values(error.response.data.errors)[0];
        return Promise.reject(error);
      }
    }

    return Promise.reject(error);
  });
