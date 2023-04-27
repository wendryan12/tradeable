import jwt from 'jwt-decode';

const authStore = {
    state:() => ({
        token:JSON.parse(localStorage.getItem('user')) || null,
        user:JSON.parse(localStorage.getItem('user')) ? jwt(JSON.parse(localStorage.getItem('user'))) : null,
    }),
    mutations: {
        isLogged(state ,payload) {
           state.token = payload.access_token;
           state.user = payload.access_token ? jwt(payload.access_token) : null;

           localStorage.setItem("user" , JSON.stringify(state.token));

           return state;
        },
        logoutHandler(state) {
            state.token = null;
            state.user = null;

            localStorage.setItem('user' , JSON.stringify(state.token));

            return state;
        }
    }
}

export default authStore;