
const alertStore = {
    state:() => ({
        open:false,
        message:"",
        variant:"",
        textVariant:""
    }),
    actions:{},
    mutations:{
        openHandler(state, payload) {
           state.open = true;
           state.message = payload.message;
           state.variant = payload.variant;
           state.textVariant = payload.textVariant;

           return state;
        },
        closeHandler(state) {
        
           state.open = false;
           state.message = '';
           state.variant = '';
           state.textVariant = "";

           return state;
        }
    }
}

export default alertStore