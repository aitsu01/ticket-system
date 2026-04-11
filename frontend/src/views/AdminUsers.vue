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

          <!-- ROLE -->
          <span class="text-xs bg-gray-200 px-2 py-1 rounded">
            {{ u.role }}
          </span>

          <!-- STATUS -->
          <span
            class="text-xs px-2 py-1 rounded ml-2"
            :class="u.is_active ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800'"
          >
            {{ u.is_active ? 'Active' : 'Disabled' }}
          </span>
        </div>

        <div class="flex gap-2 items-center">

          <!-- ROLE SELECT -->
          <select v-model="u.role" class="border p-1 rounded">
            <option value="user">User</option>
            <option value="agent">Agent</option>
            <option value="admin">Admin</option>
          </select>

          <button
            @click="updateRole(u)"
            class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded"
          >
            Save
          </button>

          <!-- ACTIVE -->
          <button
            @click="toggleActive(u)"
            :disabled="u.id === currentUser.id"
            class="px-2 py-1 rounded text-white"
            :class="[
              u.id === currentUser.id
                ? 'bg-gray-400 cursor-not-allowed'
                : 'bg-yellow-500 hover:bg-yellow-600'
            ]"
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
const currentUser = ref(null);

//  FETCH USERS
const fetchUsers = async () => {
  try {
    const res = await api.get("/users");
    users.value = res.data;
  } catch (e) {
    alert("Error loading users");
  } finally {
    loading.value = false;
  }
};

//  FETCH CURRENT USER
const fetchCurrentUser = async () => {
  const res = await api.get("/me");
  currentUser.value = res.data;
};

onMounted(() => {
  fetchUsers();
  fetchCurrentUser();
});

// ========================
// UPDATE ROLE
// ========================
const updateRole = async (user) => {
  try {
    await api.patch(`/users/${user.id}/role`, {
      role: user.role
    });

    alert("Role updated");

  } catch (e) {
    alert(e.response?.data?.message || "Error updating role");
  }
};

// ========================
// TOGGLE ACTIVE
// ========================
const toggleActive = async (user) => {
  try {
    const res = await api.patch(`/users/${user.id}/toggle-active`);

    //  aggiorna stato dal backend (più sicuro)
    user.is_active = res.data.is_active;

  } catch (e) {
    alert(e.response?.data?.message || "Error updating user");
  }
};
</script>