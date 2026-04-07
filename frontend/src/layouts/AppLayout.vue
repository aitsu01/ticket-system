<template>
  <div class="min-h-screen bg-gray-100">

    <!--  NAVBAR -->
    <div class="bg-white shadow px-6 py-4 flex justify-between items-center">

      <!-- LEFT -->
      <div class="flex items-center gap-6">
        <h1 class="font-bold text-lg">Ticket System</h1>

        <router-link to="/dashboard" class="text-gray-600 hover:text-black">
          Dashboard
        </router-link>

        <router-link to="/tickets" class="text-gray-600 hover:text-black">
          Tickets
        </router-link>

        <!--  SOLO ADMIN -->
  <router-link
    v-if="user?.role === 'admin'"
    to="/admin/users"
  >
    Users
  </router-link>


      </div>

      <!-- RIGHT -->
      <div class="flex items-center gap-4">

        <span class="text-sm text-gray-500">
          {{ user?.name }}
        </span>

        <router-link to="/account" class="text-gray-600 hover:text-black">
  Account
</router-link>

        <button
          @click="logout"
          class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded"
        >
          Logout
        </button>

      </div>

    </div>

    <!--  CONTENT -->
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

//  FETCH USER
const fetchUser = async () => {
  try {
    const res = await api.get("/me");
    user.value = res.data;
  } catch (e) {
    localStorage.removeItem("token");
    router.push("/login");
  }
};

onMounted(fetchUser);

//  LOGOUT
const logout = async () => {
  try {
    await api.post("/logout");
  } catch (e) {}

  localStorage.removeItem("token");
  router.push("/login");
};
</script>