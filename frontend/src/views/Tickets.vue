<template>
  <div class="min-h-screen bg-gray-100 p-6">

    <!-- 🔴 HEADER -->
    <div class="flex justify-between items-center mb-6">

      <!-- LEFT -->
      <div class="flex items-center gap-4">
        <button
          @click="router.push('/dashboard')"
          class="text-gray-500 hover:text-black transition"
        >
          ← Dashboard
        </button>

        <h1 class="text-2xl font-bold">Tickets</h1>
      </div>

      <!-- RIGHT -->
      <div class="flex items-center gap-3">

        <button
          @click="goCreate"
          class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition"
        >
          + New Ticket
        </button>

        <button
          @click="logout"
          class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition"
        >
          Logout
        </button>

      </div>

    </div>

    <!-- ⏳ LOADING -->
    <div v-if="loading" class="text-center text-gray-500">
      Loading...
    </div>

    <!-- ❌ ERROR -->
    <div v-if="error" class="text-center text-red-500">
      {{ error }}
    </div>

    <!-- 📋 LIST -->
    <div v-if="tickets.length" class="space-y-4">

      <div
        v-for="ticket in tickets"
        :key="ticket.id"
        class="bg-white p-4 rounded shadow flex justify-between items-center hover:shadow-md transition"
      >
        <div>
          <h2 class="font-bold">{{ ticket.title }}</h2>

          <p :class="statusClass(ticket.status)" class="text-sm">
            {{ ticket.status }}
          </p>
        </div>

        <button
          @click="viewTicket(ticket.id)"
          class="text-blue-500 hover:underline"
        >
          View
        </button>
      </div>

    </div>

    <!-- EMPTY -->
    <div v-else class="text-center text-gray-400">
      No tickets found
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../services/api";
import { useRouter } from "vue-router";

const router = useRouter();

const tickets = ref([]);
const loading = ref(true);
const error = ref(null);

onMounted(async () => {
  try {
    const res = await api.get("/tickets");
    tickets.value = res.data.data;
  } catch (e) {
    error.value = "Failed to load tickets";
  } finally {
    loading.value = false;
  }
});

const viewTicket = (id) => {
  router.push(`/tickets/${id}`);
};

const goCreate = () => {
  router.push("/tickets/create");
};

const logout = async () => {
  if (!confirm("Are you sure you want to logout?")) return;

  try {
    await api.post("/logout");
  } catch (e) {
    console.error(e);
  }

  localStorage.removeItem("token");
  router.push("/");
};

const statusClass = (status) => {
  switch (status) {
    case "open":
      return "text-blue-500 font-semibold";
    case "in_progress":
      return "text-yellow-500 font-semibold";
    case "resolved":
      return "text-green-500 font-semibold";
    case "closed":
      return "text-gray-500 font-semibold";
    default:
      return "text-gray-400";
  }
};
</script>