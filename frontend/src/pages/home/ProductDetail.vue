<script setup>
 
 import NavbarVue from '../../components/Navbar.vue';
 import axios from 'axios';
import { ref, watchEffect } from 'vue';
 import { useStore } from 'vuex';
 import { useRouter,useRoute,RouterLink } from 'vue-router';
 
 const API = axios.create({
    baseURL:`http://127.0.0.1:8000/api`
  });

 const router = useRouter();
 const route = useRoute();
 const { state:{ auth,alert } } = useStore();
 const productDetail = ref(null);

 const fetchProduct = async () => {
    try {
        const { data } = await axios.get(`http://127.0.0.1:8000/api/product/${route.params.id}`);
        productDetail.value = data;

        return productDetail;

    } catch(err) {
        return err;
    }
 }

 const addToCartHandler = async (productId) => {
    const { data } = await API.post("/cart/create"  , {
        product_id:productId,
        user_id:auth?.user?.id ,
        qty:1
    });

    if(data) {
       return router.push({
        path:"/cart"
       });
    }
 }

 const formatNominal = (value) => {
      return new Intl.NumberFormat('en-US', {
        currency:'USD',
        style:'currency'
      }).format(value);
   }


 watchEffect(() => {
    fetchProduct();
 });

</script>

<template>
 <div class="w-full min-h-screen">
    <NavbarVue/>
    <div class="py-10 px-14 flex justify-center items-center" v-if="productDetail != null">
        <div class="w-[85%] py-10 mx-auto flex items-start gap-x-10">
          <div class="w-[45%] bg-gray-100 rounded-md flex items-center justify-center py-5 px-5">
            <img :src="'http://127.0.0.1:8000/storage/product_image/' + productDetail.image" :alt="productDetail.title" class="w-full object-cover h-[320px]"/>
          </div>
          <div class="flex-1 mt-2">
            <h2 class="text-2xl font-bold">{{ productDetail.title }}</h2>
            <h5 class="mt-2 text-gray-500 font-medium text-md">Price : {{ formatNominal(productDetail.price) }}</h5>
            <h5 class="mt-2 text-gray-500 font-medium text-sm">Published at : {{ new Date().toDateString() }}</h5>
            <p class="text-sm text-gray-400 leading-6 mt-7">Desc : {{ productDetail.description }}</p>
           <div class="flex items-center gap-x-2  mt-7">
            <RouterLink to="/">
                <button class="bg-gray-600 text-white rounded-md py-[5px] px-5 font-semibold">Back</button>
            </RouterLink>
            <button @click="addToCartHandler(productDetail.id)" v-if="auth?.user?.id && auth?.user?.id !== productDetail.user.id" class="bg-blue-500 text-white rounded-md py-[5px] px-5 font-semibold">Add to cart</button>
            <RouterLink v-else-if="auth?.user?.id && auth?.user?.id == productDetail?.user?.id" to="/profile">
              <button  class="bg-blue-500 text-white rounded-md py-[5px] px-5 font-semibold">Manage Product</button>
            </RouterLink>
           </div>
          </div>
        </div>
    </div>
 </div>
</template>