<script setup>
    
   import { watchEffect } from 'vue';
   import { reactive } from 'vue';
   import Navbar from '../../components/Navbar.vue';
   import notFound from '../../assets/illustration/404.svg';
   import { useStore } from 'vuex';
   import axios from 'axios';

   const productReactive = reactive({
       products:[],
       userProducts:[]
   });

   const fetchRecommendationProduct = async () => {
      try {
        const response = await fetch('https://fakestoreapi.com/products')
        const responseJson = await response.json();
  
        productReactive.products = responseJson;
        
      } catch(err) {
        return err;
      }
   }


   const fetchAllProduct = async () => {
     try {

        const { data } = await axios.get(`http://127.0.0.1:8000/api/product/all`);
        productReactive.userProducts = data;

        console.log(data);

     } catch(err) {
        return err;
     }
   }

   const formatNominal = (value) => {
      return new Intl.NumberFormat('en-US', {
        currency:'USD',
        style:'currency'
      }).format(value);
   }

   watchEffect(() => {
       fetchRecommendationProduct();
       fetchAllProduct();
   });

</script>

<template>
    <div class="w-full min-h-screen bg-gray-50">
        <Navbar/>
        <div class="mt-7 px-14">
            <h2 class="text-xl font-bold mb-3">Rekomendasi Barang</h2>
            <div class="grid grid-cols-5 py-10 gap-3">
                <div v-for="product in productReactive.products" class="bg-white shadow-md"> 
                    <RouterLink :to="'/product/' + product.id">
                 <div class="flex items-center justify-center">
                    <img :src="product.image" class="w-[150px] h-[180px]" />
                 </div>
                 <div class="py-4 px-3">
                    <h5 class="font-semibold text-[14px]">{{ product.title.length > 30 ? product.title.substring(0,20) : product.title }}</h5>
                    <p class="text-sm text-gray-400 mt-1">{{ formatNominal(product.price) }}</p>
                    <p class="text-sm font-medium mt-1 text-blue-400">Rate : {{ product.rating.rate }}</p>

                 </div>
                </RouterLink>
                </div>
            </div>
        </div>
        <div class="mt-2 px-14">
            <h2 class="text-xl font-bold mb-3">Barang dari user</h2>
            <div class="py-10 flex items-center justify-center flex-col" v-if="productReactive.userProducts.length === 0">
                 <img :src="notFound" alt="not found" class="w-[250px] h-[200px]"/>
                 <h2 class="text-center text-gray-400 mt-5 font-semibold">Belum ada barang nih disini!</h2>
            </div>
            <div v-else class="py-10 grid grid-cols-5 gap-3">
                <div v-for="product in productReactive.userProducts" class="w-full bg-white shadow-md shadow-gray-300 rounded-md overflow-hidden">
                  <RouterLink :to="'/product/detail/' + product.id ">
                    <img :src="'http://127.0.0.1:8000/storage/product_image/' + product.image" class="w-full h-[260px]"/>
                     <div class="py-3 px-2">
                        <h4 class="text-md font-semibold">{{ product.title }}</h4>
                        <p class="text-[15px] font-medium text-gray-400 mt-1">{{ formatNominal(product.price) }}</p>
                        <p class="text-sm text-gray-400 mt-1">By : {{ product.user.name }}</p>

                     </div>
                  </RouterLink>
                </div>
            </div>
        </div>
    </div>
</template>
