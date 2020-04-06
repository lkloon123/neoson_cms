const SET_CURRENT_PAGE_TITLE = (state, payload) => { state.currentPageTitle = payload; };
const SET_PAGE_BACK_LINK = (state, payload) => { state.pageBackLink = payload; };
const SET_CURRENT_USER_INFO = (state, payload) => { state.currentUserInfo = payload; };
const SET_CURRENT_USER_ROLE = (state, payload) => { state.currentUserRole = payload; };
const SET_CURRENT_USER_PERMISSION = (state, payload) => { state.currentUserPermission = payload; };
const UPDATE_LOADER = (state, payload) => { state.showLoader = payload; };
const SET_LOCALE = (state, payload) => { state.locale = payload; };

export {
  SET_CURRENT_PAGE_TITLE,
  SET_PAGE_BACK_LINK,
  SET_CURRENT_USER_INFO,
  SET_CURRENT_USER_ROLE,
  SET_CURRENT_USER_PERMISSION,
  UPDATE_LOADER,
  SET_LOCALE,
};
