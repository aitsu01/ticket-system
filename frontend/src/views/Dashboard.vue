<template>
  <div class="min-h-screen bg-gray-100 p-6">

    <!--  HEADER -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Dashboard</h1>

      <!-- ➡️ NAV -->
      <button
        @click="$router.push('/app/tickets')"
        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition"
      >
        Go to Tickets
      </button>
    </div>

    <!--  Loading -->
    <div v-if="loading" class="text-center text-gray-500">
      Loading...
    </div>

    <!--  Error -->
    <div v-if="error" class="text-center text-red-500">
      {{ error }}
    </div>

    <!--  STATS -->
    <div v-if="data" class="grid grid-cols-2 md:grid-cols-5 gap-4">

      <!-- TOTAL -->
      <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-500">Total</p>
        <p class="text-xl font-bold">{{ data.total }}</p>
      </div>

      <!-- OPEN -->
      <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-500">Open</p>
        <p class="text-xl font-bold text-blue-500">{{ data.open }}</p>
      </div>

      <!-- IN PROGRESS -->
      <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-500">In Progress</p>
        <p class="text-xl font-bold text-yellow-500">{{ data.in_progress }}</p>
      </div>

      <!-- RESOLVED -->
      <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-500">Resolved</p>
        <p class="text-xl font-bold text-green-500">{{ data.resolved }}</p>
      </div>

      <!--  CLOSED -->
      <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-500">Closed</p>
        <p class="text-xl font-bold text-gray-500">{{ data.closed }}</p>
      </div>

      <!--  AGENTS -->
      <div class="bg-white p-4 rounded shadow col-span-2 md:col-span-5">
        <p class="text-gray-500 mb-2 font-semibold">Tickets by Agent</p>

        <div
          v-for="agent in data.by_agent"
          :key="agent.agent"
          class="flex justify-between border-b py-1"
        >
          <span>{{ agent.agent }}</span>
          <span class="font-bold">{{ agent.count }}</span>
        </div>
      </div>

    </div>

  </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import api from "../services/api";

const data = ref(null);
const loading = ref(true);
const error = ref(null);

onMounted(async () => {
  try {
    const res = await api.get("/dashboard");
    data.value = res.data;
  } catch (e) {
    error.value = "Failed to load dashboard";
  } finally {
    loading.value = false;
  }
});
</script>