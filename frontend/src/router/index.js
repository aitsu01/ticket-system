import { createRouter, createWebHistory } from "vue-router";

// =======================
// AUTH / PUBLIC
// =======================
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import ForgotPassword from "../views/ForgotPassword.vue";
import ResetPassword from "../views/ResetPassword.vue";
import EmailVerified from "../views/EmailVerified.vue";
import Home from "../views/Home.vue";
import OAuthSuccess from "../views/OAuthSuccess.vue";

// =======================
// ACCOUNT
// =======================
import Account from "../views/Account.vue";

// =======================
// LAYOUT
// =======================
import AppLayout from "../layouts/AppLayout.vue";

// =======================
// APP
// =======================
import Dashboard from "../views/Dashboard.vue";
import Tickets from "../views/Tickets.vue";
import CreateTicket from "../views/CreateTicket.vue";
import TicketDetail from "../views/TicketDetail.vue";

const routes = [
  // =======================
  // PUBLIC ROUTES
  // =======================
  { path: "/", component: Home },
  { path: "/login", component: Login },
  { path: "/register", component: Register },
  { path: "/forgot-password", component: ForgotPassword },
  { path: "/reset-password", component: ResetPassword },
  { path: "/email-verified", component: EmailVerified },

  // 🔥 OAUTH (DEVE ESSERE PUBLIC)
  { path: "/oauth-success", component: OAuthSuccess },

  // =======================
  // PROTECTED ROUTES
  // =======================
  {
    path: "/app", // 🔥 cambio path per evitare conflitti
    component: AppLayout,
    meta: { requiresAuth: true },
    children: [
      { path: "dashboard", component: Dashboard },
      { path: "tickets", component: Tickets },
      { path: "tickets/create", component: CreateTicket },
      { path: "tickets/:id", component: TicketDetail },
      { path: "account", component: Account },
      { path: "admin/users", component: () => import("../views/AdminUsers.vue") },
    ],
  },

  // =======================
  // FALLBACK
  // =======================
  { path: "/:pathMatch(.*)*", redirect: "/" },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// =======================
// AUTH GUARD
// =======================
router.beforeEach((to) => {
  const token = localStorage.getItem("token");

  // 🔒 PROTECTED
  if (to.meta.requiresAuth && !token) {
    return "/login";
  }

  // 🔁 GIÀ LOGGATO
  if (token && ["/login", "/register"].includes(to.path)) {
    return "/app/dashboard";
  }
});

export default router;




