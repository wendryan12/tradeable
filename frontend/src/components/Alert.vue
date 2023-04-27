<script setup>
 
 import { useStore } from 'vuex';

 const store = useStore();
 const { state:{ alert } } = useStore();

 const variant = alert.variant ? true : false;
 const textVariant = alert.textVariant ? true : false;

 const closeHandler = () => {
    return store.commit('closeHandler');
 }
 
</script>

<template>
    <div class="w-full py-2 px-3 mb-4 flex items-center justify-between rounded-md" :class="[variant ? alert.variant : '']">
         <h4 class="font-semibold text-[15px]" :class="[textVariant ? alert.textVariant : '']">{{ alert.message }}</h4>
         <button @click="closeHandler" :class="[textVariant ? alert.textVariant : '']" class="font-bold text-md">x</button>
    </div>
</template>