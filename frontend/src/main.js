import { createApp } from 'vue';
import App from './App.vue';
import store from './store';
import router from './router';

import * as FaIcons from "oh-vue-icons/icons/fa";
import { OhVueIcon, addIcons } from "oh-vue-icons";

import './assets/main.css'

const Fa = Object.values({ ...FaIcons });
const app = createApp(App);

addIcons(...Fa);

app.component("v-icon", OhVueIcon);
app
.use(store)
.use(router);

app.mount('#app')
