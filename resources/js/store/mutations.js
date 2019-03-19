const SET_CURRENT_PAGE_TITLE = (state, payload) => state.currentPageTitle = payload;
const SET_PAGE_BACK_LINK = (state, payload) => state.pageBackLink = payload;
const SET_CURRENT_USER_INFO = (state, payload) => state.currentUserInfo = payload;

export {
    SET_CURRENT_PAGE_TITLE,
    SET_PAGE_BACK_LINK,
    SET_CURRENT_USER_INFO
}
