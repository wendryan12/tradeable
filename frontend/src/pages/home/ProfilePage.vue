<script setup>
  
  import { reactive, ref, watchEffect } from 'vue';
  import { useStore } from 'vuex';
  import axios from 'axios';
  import notFound from '../../assets/illustration/404.svg';
  import Navbar from '../../components/Navbar.vue';
  import { useRouter } from 'vue-router';
  
  const { state:{ auth } } = useStore();

  const store = useStore();
  const router = useRouter();

  const openModalProfile = ref(false);
  const profileData = reactive({
     name:"",
     email:"",
     bio:"",
     profile:"",
     description:""
  });

  const userProducts = ref([]);

  const API = axios.create({
    baseURL:`http://127.0.0.1:8000/api/profile`
  })

  const fetchProfileUser = async () => {
    const { data } = await API.get(`/${auth.user.id}`);
    profileData.name = data.name;
    profileData.email = data.email;
    profileData.bio = data.bio;
    profileData.profile = data.profile;

    userProducts.value = data.products;

    return profileData;
  }

  const formatNominal = (value) => {
      return new Intl.NumberFormat('en-US', {
        currency:'USD',
        style:'currency'
      }).format(value);
   }

   const deleteProduct = async (id) => {
       const { data } = await axios.delete(`http://127.0.0.1:8000/api/product/delete/${id}`);
       if(data) {
          return fetchProfileUser();
       }

       return null;
   }

   const updateProfileHandler = async (e) => {
      e.preventDefault();

      store.commit("openHandler" , {
        message:'updating...',
        variant:'bg-blue-50',
        textVariant:'text-blue-500'
      })  ;

      const { data } = await API.put(`/update/${auth.user.id}`, profileData);
      if(data) {
          fetchProfileUser();
          openModalProfile.value = false;
        store.commit("closeHandler" , {
        message:'updating...',
        variant:'bg-blue-50',
        textVariant:'text-blue-500'
      })  ;
      }
   }

   const openModalHandler = () => {
    openModalProfile.value = true;
   }

  watchEffect(() => {
    if(!auth.token) {
      return router.push({
        path:"/",
        name:"root"
      });
    }
    
    fetchProfileUser();
  });

</script>

<template>
    <div class="w-full min-h-screen">
      <Navbar/>
        <div class="w-full px-14 pt-10 pb-4 flex items-center justify-center border-b border-gray-300">
            <div class="flex items-start  w-full gap-x-7">
               <img :src="profileData.profile" v-if="profileData.profile" class="w-[150px] h-[150px]"/>
               <div v-else class="w-[140px] h-[140px] bg-blue-500 rounded-full flex text-white items-center justify-center font-bold text-5xl uppercase">
                 {{ profileData?.name?.charAt(0) }}
               </div>
               <div class="flex-1 mt-3">
                <div class="flex items-center">
                  <h2 class="text-2xl font-bold mr-7">{{ profileData.name }}</h2>
                  <button @click="openModalHandler"><v-icon name="fa-regular-edit" class="cursor-pointer" scale="1.2" fill="#aaaa"/></button>
                </div>
                
                <p class="text-gray-500 text-md font-medium mt-1">{{ profileData.email }}</p>
                <p class="text-gray-500 text-md font-normal mt-3">{{ profileData.bio ? profileData.bio : "No bio added" }}</p>

               </div>
            </div>
        </div>
        <div class="px-14 py-7">
           <div v-if="userProducts.length == 0" class="flex justify-center flex-col items-center">
            <img :src="notFound" alt="not found" class="w-[250px] h-[200px]"/>
                 <h2 class="text-center text-gray-400 mt-5 font-semibold">Belum ada barang nih disini!</h2>
          </div>
          <div v-else class="grid grid-cols-5 gap-3">
            <div v-for="product in userProducts" class="rounded-md overflow-hidden bg-white shadow-lg shadow-gray-300">
              <img :src="'http://127.0.0.1:8000/storage/product_image/' + product.image" class="w-full h-[260px]"/>
              <div class="py-3 px-3">
                <h4 class="text-md font-semibold">{{ product.title }}</h4>
                <p class="text-[15px] font-medium text-gray-400 mt-1">{{ formatNominal(product.price) }}</p>
                <div class="flex items-center gap-x-2 mt-3">
                 <RouterLink :to="'/product/update/' + product.id">
                  <button> <v-icon name="fa-regular-edit" scale="1.15" class="text-blue-400"/></button>
                 </RouterLink>
                 <button @click="deleteProduct(product.id)"> <v-icon name="fa-regular-trash-alt" scale="1.15" class="text-red-400"/></button>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    <div style="background-color:rgba(10,10,10,0.5)" v-if="openModalProfile" class="w-full min-h-screen fixed top-0 left-0 flex items-center justify-center">
    <div class="w-[30vw] bg-white rounded-md py-4 px-4">
        <h2 class="text-center font-semibold text-xl">Update Profile</h2>
        <form @submit="updateProfileHandler" class="mt-6 flex flex-col gap-y-2">
            <input type="text" name="name" placeholder="Your name" v-model="profileData.name" class="w-full py-2 px-2 rounded-md border-2 border-gray-200" />
            <input type="email" name="email" placeholder="Your email" v-model="profileData.email" class="w-full py-2 px-2 rounded-md border-2 border-gray-200" />
            <textarea type="text" name="bio" v-model="profileData.bio" placeholder="Your bio" class="w-full py-2 px-2 rounded-md border-2 border-gray-200"></textarea>
            <button type="submit"  class="bg-blue-500 text-sm font-semibold py-2 w-full mt-5 text-white">Submit</button>
        </form>
    </div>
</div>
</template>