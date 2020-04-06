import Vue from 'vue';
import VueI18n from 'vue-i18n';
import axios from 'axios';

Vue.use(VueI18n);

export const i18n = new VueI18n({
  fallbackLocale: 'en_US',
});

const loadedLanguages = [];

function setI18nLanguage(lang) {
  i18n.locale = lang;
  axios.defaults.headers.common['Accept-Language'] = lang;
  document.querySelector('html').setAttribute('lang', lang);
  return lang;
}

export async function loadLanguageAsync(lang) {
  // If the language was already loaded
  if (loadedLanguages.includes(lang)) {
    return Promise.resolve(setI18nLanguage(lang));
  }

  // If the language hasn't been loaded yet
  const localeResponse = await axios.get(`/api/translation/${lang}`);
  const messages = localeResponse.data;

  i18n.setLocaleMessage(lang, messages);
  loadedLanguages.push(lang);
  return setI18nLanguage(lang);
}
