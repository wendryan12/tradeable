import { createStore } from 'vuex';

import alertStore from './vuex/alertStore';
import authStore from "./vuex/authStore";
import cartStore from './vuex/cartStore';

const store = createStore({
    modules:{
        auth:authStore,
        alert:alertStore,
        cart:cartStore 
    }
});

export default store;
