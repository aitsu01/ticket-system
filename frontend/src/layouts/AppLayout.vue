<template>
  <div class="min-h-screen bg-gray-100">

    <!-- 🔝 NAVBAR -->
    <div class="bg-white shadow px-6 py-4 flex justify-between items-center">

      <!-- LEFT -->
      <div class="flex items-center gap-6">
        <h1 class="font-bold text-lg">Ticket System</h1>

        <router-link to="/app/dashboard" class="text-gray-600 hover:text-black">
          Dashboard
        </router-link>

        <router-link to="/app/tickets" class="text-gray-600 hover:text-black">
          Tickets
        </router-link>

        <!-- ADMIN ONLY -->
        <router-link
          v-if="user?.role === 'admin'"
          to="/app/admin/users"
          class="text-gray-600 hover:text-black"
        >
          Users
        </router-link>
      </div>

      <!-- RIGHT -->
      <div class="flex items-center gap-4">

        <!-- USER NAME -->
        <span class="text-sm text-gray-500">
          {{ user?.name }}
        </span>

        <!-- ACCOUNT -->
        <router-link
          to="/app/account"
          class="text-gray-600 hover:text-black"
        >
          Account
        </router-link>

        <!-- LOGOUT -->
        <button
          @click="logout"
          class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded"
        >
          Logout
        </button>

      </div>

    </div>

    <!-- 📄 CONTENT -->
    <div class="p-6">
      <router-view />
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../services/api";
import { useRouter } from "vue-router";

const router = useRouter();
const user = ref(null);

// 👤 FETCH USER
const fetchUser = async () => {
  try {
    const res = await api.get("/me");
    user.value = res.data;
  } catch (e) {
    // 🔒 token non valido → logout
    localStorage.removeItem("token");
    router.push("/login");
  }
};

onMounted(fetchUser);

// 🚪 LOGOUT
const logout = async () => {
  try {
    await api.post("/logout");
  } catch (e) {
    // anche se fallisce, logout client
  }

  localStorage.removeItem("token");

  // 🔥 redirect corretto
  router.push("/login");
};
</script>