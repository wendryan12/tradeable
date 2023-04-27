
<script setup>
  
  import { reactive, watchEffect } from 'vue';
  import { RouterLink,useRouter } from 'vue-router';
  import { useStore } from 'vuex';
  import axios from 'axios';
  import store from '../../store';
  import Alert from '../../components/Alert.vue';

  const router = useRouter();

  const API = axios.create({
    baseURL:`http://127.0.0.1:8000/api/auth`
  });

  const { state: { auth,alert } } = useStore();

  const loginForm = reactive({
    email:"",
    password:""
  });

  const loginFormError = reactive({
     emailError:"",
     passwordError:""
  });

  const submitHandler = async (e) => {
    e.preventDefault();

    if(loginForm.email === "") {
      loginFormError.emailError = true;
    }

    if(loginForm.password === "") {
       return loginFormError.passwordError = true;
    }

    store.commit("openHandler", {
      message:"Redirecting...",
      variant:"bg-blue-50",
      textVariant:'text-blue-500'
    });

    try {
      const { data } = await API.post('/login', loginForm);

      if(data) {
        store.commit('isLogged',data);
      }
 
    } catch(err) {
       const { response:{ data } } = err;

       return store.commit("openHandler" , {
        message:data.message,
        variant:"bg-red-50",
        textVariant:'text-red-500'
       });
    }
  }

  watchEffect(() => {
    if(auth.token) {
       return router.push({
          path:"/"
       });
    }
  });


</script>


<template>
  <div class="w-full min-h-screen flex items-center bg-blue-500 justify-center">
    <div class="w-[30vw] bg-white border-t-4 border-blue-400 py-5 px-5 shadow-lg">
      <Alert v-if="alert.open" />
        <h2 class="text-center font-semibold text-2xl">Login Account</h2>
        <form @submit="submitHandler" class="w-full mt-7 flex flex-col gap-y-2">
            <input :class="[loginFormError.emailError ? 'border-red-400' : 'border-gray-200']" v-model="loginForm.email" type="email" name="email" placeholder="Your email" class="w-full py-2 outline-none  px-3 rounded-sm border-2 "/>
            <span  v-if="loginFormError.emailError" class="block text-red-500 font-semibold text-sm mb-1">{{ "Please fill password field" }}</span>
            <input :class="[loginFormError.passwordError  ? 'border-red-400' : 'border-gray-200']" v-model="loginForm.password" :autocomplete="false" type="password" name="password" placeholder="Your password" class="w-full py-2 outline-none  px-3 rounded-sm border-2"/>
            <span  v-if="loginFormError.passwordError" class="block text-red-500 font-semibold text-sm mb-1">{{ "Please fill password field" }}</span>
            <p class="text-sm text-gray-400 mt-2 font-medium">Don't have account? <RouterLink to="/auth/register"><span class="text-blue-500">Register</span></RouterLink></p>
            <button class="w-full bg-blue-500 text-md font-semibold capitalize py-2 text-white mt-4 rounded-md">Login</button>
        </form>
    </div>
  </div>
</template>
