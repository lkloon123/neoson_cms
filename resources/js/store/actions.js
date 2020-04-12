import axios from 'axios';
import Vue from 'vue';
import i18n from '../i18n';

const getCurrentUserInfo = async ({ commit }) => {
  try {
    const currentUserInfo = await axios.get('/api/me');
    commit('SET_CURRENT_USER_INFO', currentUserInfo.data);
  } catch (err) {
    if (err.response?.status === 401) {
      commit('SET_CURRENT_USER_INFO', null);
      // redirect to login
      window.location = '/login';
    }
  }
};

const getRbac = async ({ commit }) => {
  try {
    const rbacResponse = await axios.get('/api/rbac');
    commit('SET_CURRENT_USER_ROLE', rbacResponse.data.role);
    commit('SET_CURRENT_USER_PERMISSION', rbacResponse.data.permissions);
  } catch (err) {
    if (err.response?.status === 401) {
      commit('SET_CURRENT_USER_INFO', null);
      // redirect to login
      window.location = '/login';
    }
  }
};

const logout = async ({ commit }) => {
  await axios.post('/logout');
  commit('SET_CURRENT_USER_INFO', null);
  window.location = '/';
};

const loadAppLocale = async ({ dispatch, commit, state }) => {
  let languageCode = 'en';
  if (Vue.$cookies.isKey('locale')) {
    languageCode = Vue.$cookies.get('locale');
  }

  if (languageCode === state.locale) {
    return;
  }

  if (!state.loadedLanguages.includes(languageCode)) {
    await dispatch('loadLanguageAsync', languageCode);
  }
  i18n.locale = languageCode;
  axios.defaults.headers.common['Accept-Language'] = languageCode;
  document.querySelector('html').setAttribute('lang', languageCode);

  commit('SET_LOCALE', languageCode);
  commit('fm/settings/manualSettings', { lang: languageCode });
};

const loadLanguageAsync = async ({ commit, state }, language) => {
  const localeResponse = await axios.get(`/api/translation/${language}`);
  const messages = localeResponse.data;

  i18n.setLocaleMessage(language, messages);
  commit('SET_LOADED_LANGUAGES', [language, ...state.loadedLanguages]);
};

export default {
  getCurrentUserInfo,
  getRbac,
  logout,
  loadAppLocale,
  loadLanguageAsync,
};
