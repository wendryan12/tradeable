import { createRouter, createWebHistory } from 'vue-router';

//homepage
import Homepage from "../pages/home/Homepage.vue";
import ProfilePage from "../pages/home/ProfilePage.vue";
import ProductRecDetail from "../pages/home/ProductRecDetail.vue";
import AddProductPage from "../pages/home/AddProductPage.vue";
import UpdateProduct from "../pages/home/UpdateProduct.vue";
import ProductDetail from '../pages/home/ProductDetail.vue';
import CartPage from "../pages/home/CartPage.vue";

//auth
import Login from "../pages/auth/Login.vue";
import Register from "../pages/auth/Register.vue";


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
     {
      path:"/",
      component:Homepage,
      name:'root'
     },
     {
      path:"/auth/login",
      component:Login,
      name:'login'
     },
     {
      path:"/auth/register",
      component:Register,
      name:'register'
     },
     {
      path:"/profile",
      component:ProfilePage,
      name:'profile'
     },
     {
      path:"/product/:id",
      component:ProductRecDetail,
      name:'product recommendation detail'
     },
     {
       path:"/product/detail/:id",
       component:ProductDetail,
       name:'product detail'
     },
     {
      path:"/product/create",
      component:AddProductPage,
      name:'add product'
     },
     {
      path:"/product/update/:id",
      component:UpdateProduct,
      name:'update product'
     },
     {
      path:"/cart",
      component:CartPage,
      name:"cart"
     }
  ]
});

export default router
