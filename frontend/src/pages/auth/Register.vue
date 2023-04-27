<script setup>
  import { reactive, watchEffect } from 'vue';
  import { RouterLink } from 'vue-router';
  import axios from 'axios';
  import {useStore}from"vuex";

    const API = axios.create({
    baseURL:`http://127.0.0.1:8000/api/auth`
  });

  const store = useStore();


  const registerForm = reactive({
    email:"",
    password:"",
    name:"",
    confirm:""
  });

  const registerFormError = reactive({
     emailError:false,
     passwordError:false,
     nameError:false,
     confirmError:false 
  });

  const submitHandler = async (e) => {
    e.preventDefault();

    if(registerForm.email === "") {
      registerFormError.emailError = true;
    }

    if(registerForm.name === "") {
      registerFormError.nameError = true;
    }

    if(registerForm.password === "") {
      registerFormError.passwordError = true;
    }

    if(registerForm.confirm === "") {
       return registerFormError.confirmError = true;
    }

    
    try {
      const { data } = await API.post('/register', registerForm);

      if(data) {
        return window.location.href = '/auth/login';
      }
 
    } catch(err) {
      

       return store.commit("openHandler" , {
        message:"Error",
        variant:"bg-red-50",
        textVariant:'text-red-500'
       });
    }

  }
</script>

<template>
     <div class="w-full min-h-screen flex items-center bg-blue-500 justify-center">
    <div class="w-[30vw] bg-white border-t-4 border-blue-400 py-5 px-5 shadow-lg">
        <h2 class="text-center font-semibold text-2xl">Create Account</h2>
        <form @submit="submitHandler" class="w-full mt-7 flex flex-col gap-y-2">
            <input :class="[registerFormError.nameError ? 'border-red-400' : 'border-gray-200']" v-model="registerForm.name" type="text" name="name" placeholder="Your username" class="w-full py-2 outline-none  px-3 rounded-sm border-2 border-gray-200"/>
            <span  v-if="registerFormError.nameError" class="block text-red-500 font-semibold text-sm mb-1">{{ "Please fill name field" }}</span>

            <input :class="[registerFormError.emailError ? 'border-red-400' : 'border-gray-200']" v-model="registerForm.email" type="email" name="email" placeholder="Your email" class="w-full py-2 outline-none  px-3 rounded-sm border-2 border-gray-200"/>
            <span  v-if="registerFormError.emailError" class="block text-red-500 font-semibold text-sm mb-1">{{ "Please fill email field" }}</span>

            <input :class="[registerFormError.passwordError ? 'border-red-400' : 'border-gray-200']" v-model="registerForm.password" type="password" name="password" placeholder="Your password" class="w-full py-2 outline-none  px-3 rounded-sm border-2 border-gray-200"/>
            <span  v-if="registerFormError.passwordError" class="block text-red-500 font-semibold text-sm mb-1">{{ "Please fill password field" }}</span>

            <input :class="[registerFormError.confirmError ? 'border-red-400' : 'border-gray-200']" v-model="registerForm.confirm" type="password" name="confirm" placeholder="Confirm password" class="w-full py-2 outline-none  px-3 rounded-sm border-2 border-gray-200"/>
            <span  v-if="registerFormError.confirmError" class="block text-red-500 font-semibold text-sm mb-1">{{ "Please field confirm field" }}</span>

            <p class="text-sm text-gray-400 mt-2 font-medium">Already have account? <RouterLink to="/auth/login"><span class="text-blue-500">Login</span></RouterLink></p>

            <button class="w-full bg-blue-500 text-md font-semibold capitalize py-2 text-white mt-4 rounded-md">Register</button>
        </form>
    </div>
  </div>
</template>