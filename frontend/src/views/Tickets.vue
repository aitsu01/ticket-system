<template>
  <div class="min-h-screen bg-gray-100 p-6">

    <!--  HEADER -->
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

      <!--  SEARCH -->
<div class="mb-4">
  <input
    v-model="search"
    placeholder="Search tickets..."
    class="w-full p-2 border rounded"
  />
</div>

      <!-- RIGHT -->
      <button
        @click="goCreate"
        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition"
      >
        + New Ticket
      </button>

    </div>

    <!--  LOADING -->
    <div v-if="loading" class="text-center text-gray-500">
      Loading...
    </div>

    <!--  ERROR -->
    <div v-if="error" class="text-center text-red-500">
      {{ error }}
    </div>

    <!--  LIST -->
    <div v-if="tickets.length" class="space-y-4">

      <div
        v-for="ticket in filteredTickets"
        :key="ticket.id"
        class="bg-white p-4 rounded shadow hover:shadow-md transition flex justify-between items-center"
      >
        <div>

          <!-- TITLE -->
          <h2 class="font-bold">
            {{ ticket.ticket_number }} — {{ ticket.title }}
          </h2>

          <!-- META -->
          <p class="text-xs text-gray-400">
            Created: {{ ticket.created_at }} •  {{ ticket.user?.name || 'N/A' }}
          </p>

          <!-- STATUS -->
          <p :class="statusClass(ticket.status)" class="text-sm mt-1">
            {{ ticket.status }}
          </p>

        </div>

        <!-- ACTION -->
        <button
          @click="viewTicket(ticket.id)"
          class="text-blue-500 hover:underline"
        >
          View
        </button>
      </div>

    </div>

    <!-- EMPTY -->


    <div v-if="!filteredTickets.length" class="text-center text-gray-400">
  No tickets match your search
</div>

  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../services/api";
import { useRouter } from "vue-router";
import { computed } from "vue";

const search = ref("");
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

const filteredTickets = computed(() => {
  if (!search.value) return tickets.value;

  return tickets.value.filter(ticket =>
    ticket.title.toLowerCase().includes(search.value.toLowerCase())
  );
});




</script>