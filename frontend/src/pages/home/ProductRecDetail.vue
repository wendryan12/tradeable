<script setup>
   
  import { useRoute } from 'vue-router';
  import Navbar from '../../components/Navbar.vue';
  import { ref, watchEffect } from 'vue';
  import axios from 'axios';

  const route = useRoute();

  const productDetail = ref(null);

  const fetchDetailProduct = async () => {
     const { data } = await axios.get(`https://fakestoreapi.com/products/${route.params.id}`);

     if(data) {
        productDetail.value = data;
     }
  }

  watchEffect(() => {
    fetchDetailProduct();
  });

</script>

<template>
    <div class="w-full min-h-screen">
        <Navbar/>
        <div class="w-[75%] py-10 mx-auto flex items-start gap-x-10">
          <div class="w-[45%] bg-gray-100 rounded-md flex items-center justify-center py-5 px-5">
            <img :src="productDetail?.image" :alt="productDetail?.title" class="h-[250px]"/>
          </div>
          <div class="flex-1 mt-2">
            <h2 class="text-xl font-bold">{{ productDetail?.title }}</h2>
            <h5 class="mt-2 text-gray-500 font-medium text-md">Price : {{ productDetail?.price }}</h5>
            <h5 class="mt-2 text-gray-500 font-medium text-sm">Published at : {{ new Date().toDateString() }}</h5>
            <p class="text-sm text-gray-400 leading-6 mt-3">Desc : {{ productDetail?.description }}</p>
            <RouterLink to="/">
                <button class="bg-gray-600 text-white rounded-md py-[5px] mt-7 px-5 font-semibold">Back</button>
            </RouterLink>
          </div>
        </div>
    </div>
</template>