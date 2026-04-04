<template>
  <div class="min-h-screen bg-gray-100 p-6">

    <!--  HEADER -->
    <div class="flex justify-between items-center mb-6">

      <div class="flex items-center gap-4">
        <button
          @click="router.push('/dashboard')"
          class="text-gray-500 hover:text-black transition"
        >
          ← Dashboard
        </button>

        <h1 class="text-2xl font-bold">Tickets</h1>
      </div>

      <button
        @click="goCreate"
        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition"
      >
        + New Ticket
      </button>

    </div>

    <!--  SEARCH -->
    <div class="mb-4">

      <input
  v-model="search"
  placeholder="Search by title, description or #ticket"
  class="w-full p-2 border rounded"
/>



    </div>

    <!--  FILTERS -->
    <div class="flex gap-2 mb-4 flex-wrap">

      <select v-model="statusFilter" class="border p-2 rounded">
        <option value="">All Status</option>
        <option value="open">Open</option>
        <option value="in_progress">In Progress</option>
        <option value="resolved">Resolved</option>
        <option value="closed">Closed</option>
      </select>

      <button
        @click="toggleMyTickets"
        :class="myTickets ? 'bg-blue-500 text-white' : 'bg-gray-200'"
        class="px-3 py-2 rounded"
      >
        My Tickets
      </button>

      <button
        @click="toggleAssigned"
        :class="assignedToMe ? 'bg-green-500 text-white' : 'bg-gray-200'"
        class="px-3 py-2 rounded"
      >
        Assigned to Me
      </button>

      <!-- RESET -->
      <button
        @click="resetFilters"
        class="bg-red-400 text-white px-3 py-2 rounded"
      >
        Reset
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
    <div v-if="filteredTickets.length" class="space-y-4">

      <div
        v-for="ticket in tickets"
        :key="ticket.id"
        class="bg-white p-4 rounded shadow hover:shadow-md transition flex justify-between items-center"
      >
        <div>

          <h2 class="font-bold">
            {{ ticket.ticket_number }} — {{ ticket.title }}
          </h2>

          <p class="text-xs text-gray-400">
            Created: {{ ticket.created_at }} •  {{ ticket.user?.name || 'N/A' }}
          </p>

          <p :class="statusClass(ticket.status)" class="text-sm mt-1">
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
      No tickets match your filters
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import api from "../services/api";
import { useRouter } from "vue-router";

import { watch } from "vue";



const router = useRouter();

const tickets = ref([]);
const loading = ref(true);
const error = ref(null);

const search = ref("");
const statusFilter = ref("");
const myTickets = ref(false);
const assignedToMe = ref(false);
const currentUser = ref(null);

//  FETCH USER
const fetchUser = async () => {
  const res = await api.get("/me");
  currentUser.value = res.data;
};

//  FETCH TICKETS
const fetchTickets = async () => {
  loading.value = true;

  try {
    const res = await api.get("/tickets", {
      params: {
        search: search.value,
        status: statusFilter.value,
        my_tickets: myTickets.value ? 1 : 0,
        assigned_to_me: assignedToMe.value ? 1 : 0,
      }
    });

    tickets.value = res.data.data;

  } catch (e) {
    error.value = "Failed to load tickets";
  } finally {
    loading.value = false;
  }
};

onMounted(async () => {
  await fetchUser();
  await fetchTickets();
});

//  TOGGLES
const toggleMyTickets = () => {
  myTickets.value = !myTickets.value;
};

const toggleAssigned = () => {
  assignedToMe.value = !assignedToMe.value;
};

//  RESET
const resetFilters = () => {
  search.value = "";
  statusFilter.value = "";
  myTickets.value = false;
  assignedToMe.value = false;
};

//  FILTER LOGIC (COMBINATA)
const filteredTickets = computed(() => {
  let result = tickets.value;

  //  SEARCH
  if (search.value) {
    result = result.filter(ticket =>
      ticket.title.toLowerCase().includes(search.value.toLowerCase())
    );
  }

  //  STATUS
  if (statusFilter.value) {
    result = result.filter(ticket =>
      ticket.status === statusFilter.value
    );
  }

  //  MY TICKETS
  if (myTickets.value && currentUser.value) {
    result = result.filter(ticket =>
      ticket.user?.id === currentUser.value.id
    );
  }

  //  ASSIGNED
  if (assignedToMe.value && currentUser.value) {
    result = result.filter(ticket =>
      ticket.agent?.id === currentUser.value.id
    );
  }

  return result;
});

//  STATUS COLOR
const statusClass = (status) => {
  switch (status) {
    case "open": return "text-blue-500 font-semibold";
    case "in_progress": return "text-yellow-500 font-semibold";
    case "resolved": return "text-green-500 font-semibold";
    case "closed": return "text-gray-500 font-semibold";
    default: return "text-gray-400";
  }
};

//  NAV
const viewTicket = (id) => {
  router.push(`/tickets/${id}`);
};

const goCreate = () => {
  router.push("/tickets/create");
};

watch(
  [search, statusFilter, myTickets, assignedToMe],
  () => {
    fetchTickets();
  }
);
</script>