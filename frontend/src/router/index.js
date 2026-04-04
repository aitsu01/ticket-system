import { createRouter, createWebHistory } from "vue-router";

//  AUTH PAGES
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import ForgotPassword from "../views/ForgotPassword.vue";
import ResetPassword from "../views/ResetPassword.vue";
import EmailVerified from "../views/EmailVerified.vue";
import Home from "../views/Home.vue";



//  LAYOUT
import AppLayout from "../layouts/AppLayout.vue";

//  APP PAGES
import Dashboard from "../views/Dashboard.vue";
import Tickets from "../views/Tickets.vue";
import CreateTicket from "../views/CreateTicket.vue";
import TicketDetail from "../views/TicketDetail.vue";

const routes = [
  { path: "/", component: Home },
  //  PUBLIC
  { path: "/login", component: Login },
  { path: "/register", component: Register },
  { path: "/forgot-password", component: ForgotPassword },
  { path: "/reset-password", component: ResetPassword },
  { path: "/email-verified", component: EmailVerified },

  //  PROTECTED (CON LAYOUT)
  {
    path: "/",
    component: AppLayout,
    meta: { requiresAuth: true },
    children: [
      { path: "dashboard", component: Dashboard },
      { path: "tickets", component: Tickets },
      { path: "tickets/create", component: CreateTicket },
      { path: "tickets/:id", component: TicketDetail },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

//  AUTH GUARD
router.beforeEach((to) => {
  const token = localStorage.getItem("token");

  if (to.meta.requiresAuth && !token) {
    return "/";
  }
});

export default router;