<script setup>

  import { RouterLink,useRouter } from 'vue-router';
  import { useStore } from 'vuex';
  import { watchEffect } from 'vue';

  const { state:{ auth } } = useStore();
  const store = useStore();

  const router = useRouter();

  const logoutHandler = () => {
    store.commit('logoutHandler');
  }


</script>

<template>
    <nav class="w-full flex justify-between items-center py-5 px-14">
    <div class="flex items-center gap-x-14">
        <RouterLink to="/">
         <span class="cursor-pointer flex items-center gap-x-2 text-blue-500 text-xl">
            <v-icon scale="1.8" animation="float" name="fa-shopping-basket"></v-icon>
            <p class="font-bold">Shopping</p>
         </span>
       </RouterLink>
       <ul class="flex mt-1 items-center gap-x-5">
        <li>
            <RouterLink to="/">
                <span class="text-blue-500 font-medium text-[15px]">Semua</span>
            </RouterLink>
        </li>
        <li>
            <RouterLink to="/">
                <span class="font-medium text-[15px]">Orang Sekitar</span>
            </RouterLink>
        </li>
        <li>
            <RouterLink to="/">
                <span class="font-medium text-[15px]">Tukar Tambah</span>
            </RouterLink>
        </li>
        <li>
            <RouterLink to="/">
                <span class="font-medium text-[15px]">Barter</span>
            </RouterLink>
        </li>
       </ul>
    </div>

    <div v-if="auth.token === null" class="flex items-center gap-x-2">
      <RouterLink to="/auth/login">  <button class="bg-blue-500 border-2 uppercase border-blue-500 text-white text-[13px] font-bold py-[6px] px-5 rounded-md">Sign In</button></RouterLink>
      <RouterLink to="/auth/register"> <button class="border-2 uppercase border-blue-500 text-blue-500 text-[13px] font-bold py-[6px] px-5 rounded-md">Sign Up</button></RouterLink>
    </div>
    <div v-else class="flex items-center gap-x-4">
    <RouterLink to="/">
        <span class="relative text-blue-500 cursor-pointer">
            <v-icon name="fa-shopping-cart" scale="1.15"/>
        </span>
    </RouterLink>
    <RouterLink to="/profile">
        <span class="relative text-blue-500 cursor-pointer">
            <v-icon name="fa-user" scale="1.15"/>
        </span>
    </RouterLink>
    <RouterLink to="/product/create">
        <button class="text-blue-500 border-2 ml-3 border-blue-500 py-2 px-5 rounded-md font-semibold">Tambahkan barangmu</button>
    </RouterLink>
    <button @click="logoutHandler" class="bg-blue-500 text-white py-2 px-5 border-2 border-blue-500 rounded-md font-semibold ">Logout</button>
    </div>
    </nav>
</template>