<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">Audit Logs</h1>

    <!--  FILTERS -->
    <div class="flex gap-2 mb-4 flex-wrap">

      <input
        v-model="search"
        placeholder="Search user ID"
        class="border p-2 rounded"
      />

      <select v-model="actionFilter" class="border p-2 rounded">
        <option value="">All Actions</option>
        <option value="login">Login</option>
        <option value="logout">Logout</option>
        <option value="login_failed">Login Failed</option>
        <option value="register">Register</option>
        <option value="ticket_created">ticket created</option>

      </select>

    </div>

    <!--  LOADING -->
    <div v-if="loading" class="text-gray-500">Loading...</div>

    <!--  TABLE -->
    <table v-else class="w-full bg-white rounded shadow">
      <thead class="bg-gray-100 text-left text-sm">
        <tr>
          <th class="p-3">Action</th>
          <th class="p-3">User</th>
          <th class="p-3">Method</th>
          <th class="p-3">IP</th>
          <th class="p-3">Date</th>
        </tr>
      </thead>

      <tbody>
        <tr
          v-for="log in filteredLogs"
          :key="log.id"
          class="border-t hover:bg-gray-50"
        >
          <!-- ACTION -->
          <td class="p-3">
            <span :class="actionBadge(log.action)">
              {{ log.action }}
            </span>
          </td>

          <!-- USER -->
          <td class="p-3">
  <div v-if="log.user">
    <p class="font-semibold text-sm">
      {{ log.user.name }}
    </p>
    <p class="text-xs text-gray-400">
      {{ log.user.email }}
    </p>
  </div>

  <div v-else class="text-gray-400 text-sm">
    Guest
  </div>
</td>

          <!-- METHOD -->
          <td class="p-3">
            <span
              v-if="log.meta?.method"
              :class="methodBadge(log.meta.method)"
            >
              {{ log.meta.method }}
            </span>
          </td>

          <!-- IP -->
          <td class="p-3 text-sm text-gray-500">
            {{ log.ip }}
          </td>

          <!-- DATE -->
          <td class="p-3 text-sm text-gray-500">
            {{ formatDate(log.created_at) }}
          </td>
        </tr>
      </tbody>
    </table>

    <!-- EMPTY -->
    <div v-if="!filteredLogs.length" class="text-center text-gray-400 mt-4">
      No logs found
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import api from "../services/api";

const logs = ref([]);
const loading = ref(true);

const search = ref("");
const actionFilter = ref("");

// FETCH
const fetchLogs = async () => {
  try {
    const res = await api.get("/audit-logs");
    logs.value = res.data;
  } catch (e) {
    console.error("Error loading logs");
  } finally {
    loading.value = false;
  }
};

onMounted(fetchLogs);

// FILTER
const filteredLogs = computed(() => {
  return logs.value.filter(log => {

    const matchUser = search.value
      ? String(log.user_id).includes(search.value)
      : true;

    const matchAction = actionFilter.value
      ? log.action === actionFilter.value
      : true;

    return matchUser && matchAction;
  });
});

//  BADGE ACTION
const actionBadge = (action) => {
  switch (action) {
    case "login":
      return "bg-green-100 text-green-700 px-2 py-1 rounded text-xs";
    case "logout":
      return "bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs";
    case "login_failed":
      return "bg-red-100 text-red-700 px-2 py-1 rounded text-xs";
    case "register":
      return "bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs";
    default:
      return "bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs";
  }
};

//  BADGE METHOD
const methodBadge = (method) => {
  return method === "google"
    ? "bg-red-100 text-red-600 px-2 py-1 rounded text-xs"
    : "bg-blue-100 text-blue-600 px-2 py-1 rounded text-xs";
};

//  FORMAT DATE
const formatDate = (date) => {
  return new Date(date).toLocaleString();
};
</script>