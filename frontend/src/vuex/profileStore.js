
const profileStore = {
    state:() => ({
        name:"",
        email:"",
        profile:"",
        id:""
    }),
    mutations:{
        getProfileData(state, payload) {
            state = payload;
            
            return state;
        }
    },
    actions:{
        getProfile(context) {}
    }
}

export default profileStore;