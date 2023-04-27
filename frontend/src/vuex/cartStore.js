const cartStore = {
   state:() => ({
    carts:[],
    loading:false
   }),
   mutations:{
     getCartHandler(state ,payload){
        state.carts = payload;

        return state;
     }
   },
   actions:{}
}

export default cartStore;