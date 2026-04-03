<template>
  <div class="flex h-screen bg-gray-100">

    <!--  SIDEBAR -->
    <div class="w-64 bg-white shadow-md p-4">

      <h2 class="text-xl font-bold mb-6">Ticket System</h2>

      <nav class="flex flex-col gap-3">

        <button
          @click="$router.push('/dashboard')"
          class="text-left hover:text-blue-500"
        >
           Dashboard
        </button>

        <button
          @click="$router.push('/tickets')"
          class="text-left hover:text-blue-500"
        >
           Tickets
        </button>

      </nav>

    </div>

    <!--  MAIN -->
    <div class="flex-1 flex flex-col">

      <!--  NAVBAR -->
      <div class="bg-white shadow p-4 flex justify-between items-center">

        <h1 class="font-bold">Helpdesk</h1>

        <button
          @click="logout"
          class="bg-red-500 text-white px-3 py-1 rounded"
        >
          Logout
        </button>

      </div>

      <!--  CONTENT -->
      <div class="flex-1 overflow-y-auto p-6">
        <router-view />
      </div>

    </div>

  </div>
</template>

<script setup>
import api from "../services/api";
import { useRouter } from "vue-router";

const router = useRouter();

const logout = async () => {
  await api.post("/logout");
  localStorage.removeItem("token");
  router.push("/");
};
</script>