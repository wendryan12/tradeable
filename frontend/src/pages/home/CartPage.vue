<script setup>

import Navbar from '../../components/Navbar.vue';
import { watchEffect } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';

const router = useRouter();

const store = useStore();
const { state:{ auth,alert,cart } } = useStore();

const API = axios.create({
    baseURL:"http://127.0.0.1:8000/api/cart"
});

const fetchUserCart = async () => {
    const { data } = await API.get('/all?user_id='+auth.user.id);

    store.commit("getCartHandler" , data);
}

const updateQty = (type) => {
     
}

const deleteCart = async (id) => {
    const { data } = await API.delete("/delete/"+id);

    if(data) {
       fetchUserCart();
    }
}

watchEffect(() => {
    if(!auth?.token) {
      return router.push({
        path:"/"
      });
    }

    fetchUserCart();
})

</script>

<template>
    <div class="w-full min-h-screen">
      <Navbar/>
      <div class="flex justify-center items-center py-10">
        <div class="w-[60vw]   py-2 px-3 rounded-md flex flex-col gap-y-4">
            <div v-for="cart in cart.carts" class="flex justify-between items-start border-2 py-2 px-3 border-gray-200">
               <div class="flex items-center gap-x-5">
                <img :src="'http://127.0.0.1:8000/storage/product_image/'+cart.product.image" class="w-[150px] h-[150px] rounded-md"/>
                <div class="flex flex-col">
                    <h2 class="text-lg font-bold">{{ cart.product.title }}</h2>
                    <p class="text-gray-400 font-medium text-[18px] mt-1">${{ cart.product.price }}</p>
                    <div class="flex items-center gap-x-2 mt-4">
                        <button class="bg-blue-500 text-white font-bold text-md rounded-md px-2">+</button>
                        <span class="font-semibold text-sm">{{ cart.qty }}</span>
                        <button class="bg-blue-500 text-white font-bold text-md rounded-md px-2">-</button>

                    </div>
                </div>
               </div>
               <div class="flex items-center gap-x-2">
                <button @click="deleteCart(cart?.id)" class="bg-red-500 mt-3 text-white font-semibold text-sm py-2 px-3 rounded-md">Delete</button>
               </div>
            </div>
        </div>
      </div>
    </div>
</template>