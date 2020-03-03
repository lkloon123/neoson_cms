import axios from 'axios';

const getCurrentUserInfo = async ({ commit }) => {
  try {
    const currentUserInfo = await axios.get('/api/me');
    commit('SET_CURRENT_USER_INFO', currentUserInfo.data);
  } catch (err) {
    if (err.response) {
      if (err.response.status === 401) {
        commit('SET_CURRENT_USER_INFO', null);
        // redirect to login
        window.location = '/login';
      }
    }
  }
};

const getRbac = async ({ commit }) => {
  try {
    const rbacResponse = await axios.get('/api/rbac');
    commit('SET_CURRENT_USER_ROLE', rbacResponse.data.role);
    commit('SET_CURRENT_USER_PERMISSION', rbacResponse.data.permissions);
  } catch (err) {
    if (err.response) {
      if (err.response.status === 401) {
        commit('SET_CURRENT_USER_INFO', null);
        // redirect to login
        window.location = '/login';
      }
    }
  }
};

const logout = async ({ commit }) => {
  await axios.post('/logout');
  commit('SET_CURRENT_USER_INFO', null);
  window.location = '/';
};

export {
  getCurrentUserInfo,
  getRbac,
  logout,
};
