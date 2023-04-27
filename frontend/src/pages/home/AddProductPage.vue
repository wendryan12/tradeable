<script setup>

import axios from 'axios';
import { useStore } from 'vuex';
import Navbar from '../../components/Navbar.vue';
import { reactive, ref, watchEffect } from 'vue';
import { useRouter } from 'vue-router';
import Alert from '../../components/Alert.vue';

const store = useStore();
const { state:{ auth,alert } } = useStore();

const API = axios.create({
    baseURL:`http://127.0.0.1:8000/api/product`
});

API.interceptors.request.use((request) => {
   if(auth.token) {
        request.headers.Authorization = `Bearer ${auth.token}`;
   }

   return request;
});

const router = useRouter();

const previewImage = ref(null);
const productForm = reactive({
    title:'',
    price:0,
    description:'',
    category:'',
    image:''
});

const submitHandler = async (e) => {
    e.preventDefault();

    store.commit('openHandler' , {
        message:'Redirecting...',
        variant:"bg-blue-50",
        textVariant:"text-blue-500"
    });

    const formData = new FormData();

    formData.append('title' , productForm.title );
    formData.append('price',productForm.price);
    formData.append('description' , productForm.description);
    formData.append('category' , productForm.category);
    formData.append('image' , productForm.image);
    formData.append('user_id' , auth.user.id);

    try {
        const { data } = await API.post('/create' , formData);
        if(data) {
           store.commit("closeHandler");
          return window.location.href = "/";
        }
    } catch(err) {
        return err;
    }
    
}

const imageHandler = (e) => {
  const file = e.target.files[0];
  const reader = new FileReader();
  reader.onloadend = function() {
     previewImage.value = reader.result;
     productForm.image = file;
  }
  reader.readAsDataURL(file);
}

watchEffect(() => {
    if(!auth.token) {
      router.push({
        path:"/",
        name:"root"
      });
    }
});

</script>

<template>
    <div class="w-full min-h-screen">
        <Navbar/>
        <div class="flex items-center justify-center px-14 py-10">
            <div class="w-[35vw]">
                <h2 class="text-center font-bold text-2xl">Add Product</h2>
                <Alert v-if="alert.open" />
                <div class="border border-gray-300 py-4 px-4 rounded-md mt-7">
                    <form @submit="submitHandler" class="w-full flex flex-col gap-y-2">
                        <input v-model="productForm.title" type="text" placeholder="Title" name="title" class="outline-none w-full rounded-md border border-gray-200 py-2 px-2"/>
                        <input v-model="productForm.price" type="number" placeholder="Price" name="title" class="outline-none w-full rounded-md border border-gray-200 py-2 px-2"/>
                        <input v-model="productForm.category" type="text" placeholder="Category" name="title" class="outline-none w-full rounded-md border border-gray-200 py-2 px-2"/>
                        <textarea v-model="productForm.description" type="text" placeholder="Description" name="title" class="w-full outline-none h-[120px] rounded-md border border-gray-200 py-2 px-2"></textarea>
                        <input @change="imageHandler" type="file" name="image" class="hidden" id="image"/>
                        <label for="image" class="w-full border-2 border-dashed border-gray-200 uppercase py-1 px-1 rounded-lg h-[180px] flex items-center justify-center cursor-pointer">
                            <p v-if="!previewImage" class="font-semibold text-xl text-gray-300">Image</p>
                            <img v-else class="w-full h-full rounded-lg object-cover" :src="previewImage"/>
                        </label>
                       <button type="submit" class="w-full bg-blue-500 text-white font-semibold text-sm py-2 rounded-md mt-7">Submit</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</template>