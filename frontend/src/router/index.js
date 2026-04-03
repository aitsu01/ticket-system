import { createRouter, createWebHistory } from "vue-router";
import Login from "../views/Login.vue";
import Dashboard from "../views/Dashboard.vue";
import Register from "../views/Register.vue";
import ForgotPassword from "../views/ForgotPassword.vue";
import EmailVerified from "../views/EmailVerified.vue";
import ResetPassword from "../views/ResetPassword.vue";




const routes = [
  { path: "/", component: Login },
  { path: "/register", component: Register },
  { path: "/forgot-password", component: ForgotPassword },

  {
    path: "/dashboard",
    component: Dashboard,
    meta: { requiresAuth: true },
  },
  { path: "/email-verified", 
    component: EmailVerified },

  { path: "/reset-password", 
    component: ResetPassword },


];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to) => {
  const token = localStorage.getItem("token");

  if (to.meta.requiresAuth && !token) {
    return "/";
  }
});

export default router;