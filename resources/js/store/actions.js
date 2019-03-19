import axios from 'axios';

const getCurrentUserInfo = ({commit}) => {
    axios.get('/api/me')
        .then((response) => {
            commit('SET_CURRENT_USER_INFO', response.data);
        })
        .catch((err) => {
            if (err.response) {
                if (err.response.status === 401) {
                    commit('SET_CURRENT_USER_INFO', null);
                    //redirect to login
                    window.location = '/login';
                }
            }
        });
};

const logout = ({commit}) => {
    axios.post('/logout')
        .then(() => {
            commit('SET_CURRENT_USER_INFO', null);
            window.location = '/';
        });
};

export {
    getCurrentUserInfo,
    logout
}
