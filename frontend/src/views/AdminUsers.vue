
<template>
  <div class="max-w-4xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">User Management</h1>

    <div v-if="loading" class="text-gray-500">Loading...</div>

    <div v-if="users.length" class="space-y-3">

      <div
        v-for="u in users"
        :key="u.id"
        class="bg-white p-4 rounded shadow flex justify-between items-center"
      >
        <div>
          <p class="font-bold">{{ u.name }}</p>
          <p class="text-sm text-gray-500">{{ u.email }}</p>

          <span class="text-xs bg-gray-200 px-2 py-1 rounded">
            {{ u.role }}
          </span>

          <span
            class="text-xs px-2 py-1 rounded ml-2"
            :class="u.is_active ? 'bg-green-200' : 'bg-red-200'"
          >
            {{ u.is_active ? 'Active' : 'Disabled' }}
          </span>
        </div>

        <div class="flex gap-2">

          <!-- ROLE -->
          <select v-model="u.role" class="border p-1 rounded">
            <option value="user">User</option>
            <option value="agent">Agent</option>
            <option value="admin">Admin</option>
          </select>

          <button
            @click="updateRole(u)"
            class="bg-blue-500 text-white px-2 py-1 rounded"
          >
            Save
          </button>

          <!-- ACTIVE -->
          <button
            @click="toggleActive(u)"
            class="bg-yellow-500 text-white px-2 py-1 rounded"
          >
            {{ u.is_active ? "Disable" : "Enable" }}
          </button>

        </div>
      </div>

    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../services/api";

const users = ref([]);
const loading = ref(true);

const fetchUsers = async () => {
  const res = await api.get("/users");
  users.value = res.data;
  loading.value = false;
};

onMounted(fetchUsers);

//  update role
const updateRole = async (user) => {
  await api.patch(`/users/${user.id}/role`, {
    role: user.role
  });

  alert("Role updated");
};

//  toggle active
const toggleActive = async (user) => {
  await api.patch(`/users/${user.id}/toggle-active`);

  user.is_active = !user.is_active;
};
</script>