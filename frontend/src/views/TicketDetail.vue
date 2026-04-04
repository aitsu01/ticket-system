<template>
  <div class="min-h-screen bg-gray-100 p-6">

    <!--  BACK -->
    <button @click="router.push('/tickets')" class="mb-4 text-gray-500">
      ← Back
    </button>

    <!--  LOADING -->
    <div v-if="loading" class="text-center text-gray-500">
      Loading...
    </div>

    <!--  ERROR -->
    <div v-if="error" class="text-center text-red-500">
      {{ error }}
    </div>

    <!--  CONTENT -->
    <div v-if="ticket" class="max-w-2xl mx-auto bg-white p-6 rounded shadow">

      <!--  HEADER -->
      <div class="mb-4">
        <h1 class="text-2xl font-bold">
          {{ ticket.ticket_number }} — {{ ticket.title }}
        </h1>

        <p class="text-xs text-gray-400">
          Created: {{ ticket.created_at }}
        </p>

        <p class="text-sm text-gray-400">
           {{ ticket.user?.name }}
        </p>

        <p class="text-gray-500 mt-1">
          {{ ticket.description }}
        </p>
      </div>

      <!--  STATUS + PRIORITY -->
      <div class="flex justify-between items-center mb-4">
        <span :class="statusClass(ticket.status)">
          {{ ticket.status }}
        </span>

        <span class="text-sm text-gray-400">
          Priority: {{ ticket.priority }}
        </span>
      </div>

      <!--  STATUS CHANGE -->
      <div class="mt-4">
        <label class="text-sm text-gray-500">Change Status</label>

        <div class="flex gap-2 mt-1">
          <select v-model="selectedStatus" class="border p-2 rounded">
            <option value="open">Open</option>
            <option value="in_progress">In Progress</option>
            <option value="resolved">Resolved</option>
            <option value="closed">Closed</option>
          </select>

          <button
            @click="updateStatus"
            class="bg-blue-500 text-white px-3 py-1 rounded"
          >
            Update
          </button>
        </div>
      </div>

      <!--  ASSIGN AGENT -->
      <div class="mt-4">
        <label class="block text-sm text-gray-500 mb-1">Assign Agent</label>

        <select v-model="agentId" class="border p-2 rounded w-full">
          <option disabled value="">Select agent</option>

          <option
            v-for="user in users"
            :key="user.id"
            :value="user.id"
          >
            {{ user.name }}
          </option>
        </select>

        <button
          @click="assignAgent"
          class="mt-2 bg-green-500 text-white px-4 py-2 rounded"
        >
          Assign
        </button>

        <p class="text-sm text-gray-400 mt-1">
          Assigned to: {{ ticket.agent?.name || "Unassigned" }}
        </p>
      </div>

      <!--  COMMENTS -->
      <div class="mt-6">
        <h2 class="font-bold mb-2">Comments</h2>

        <div v-if="ticket.comments.length">
          <div
            v-for="comment in ticket.comments"
            :key="comment.id"
            class="border-b py-2"
          >
            <p>{{ comment.message }}</p>

            <span class="text-xs text-gray-400">
              {{ comment.user?.name }}
            </span>
          </div>
        </div>

        <p v-else class="text-gray-400">
          No comments yet
        </p>
      </div>

      <!--  ADD COMMENT -->
      <div class="mt-4">

        <!--  BLOCCO -->
        <div v-if="['resolved','closed'].includes(ticket.status)" class="text-gray-400">
          Comments are disabled for this ticket
        </div>

        <!--  FORM -->
        <div v-else>
          <textarea
            v-model="newComment"
            placeholder="Write a comment..."
            class="w-full p-2 border rounded mb-2"
          ></textarea>

          <button
            @click="addComment"
            class="bg-blue-500 text-white px-4 py-2 rounded"
          >
            Add Comment
          </button>
        </div>

      </div>

    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../services/api";
import { useRoute, useRouter } from "vue-router";

const route = useRoute();
const router = useRouter();

const ticket = ref(null);
const loading = ref(true);
const error = ref(null);
const newComment = ref("");

const users = ref([]);
const agentId = ref("");
const selectedStatus = ref("");

//  FETCH TICKET
const fetchTicket = async () => {
  try {
    const res = await api.get(`/tickets/${route.params.id}`);
    ticket.value = res.data.data;

    selectedStatus.value = ticket.value.status;
    agentId.value = ticket.value.assigned_to || "";
  } catch (e) {
    error.value = "Failed to load ticket";
  } finally {
    loading.value = false;
  }
};

//  FETCH USERS
const fetchUsers = async () => {
  const res = await api.get("/users");
  users.value = res.data;
};

onMounted(() => {
  fetchTicket();
  fetchUsers();
});

//  ADD COMMENT
const addComment = async () => {
  if (!newComment.value) return;

  try {
    await api.post(`/tickets/${ticket.value.id}/comments`, {
      message: newComment.value,
    });

    newComment.value = "";
    fetchTicket();
  } catch (e) {
    alert("Error adding comment");
  }
};

//  UPDATE STATUS
const updateStatus = async () => {
  await api.patch(`/tickets/${ticket.value.id}/status`, {
    status: selectedStatus.value
  });

  fetchTicket();
};

//  ASSIGN AGENT
const assignAgent = async () => {
  if (!agentId.value) return;

  await api.patch(`/tickets/${ticket.value.id}/assign`, {
    assigned_to: agentId.value
  });

  fetchTicket();
};

//  STATUS COLOR
const statusClass = (status) => {
  switch (status) {
    case "open": return "text-blue-500 font-bold";
    case "in_progress": return "text-yellow-500 font-bold";
    case "resolved": return "text-green-500 font-bold";
    case "closed": return "text-gray-500 font-bold";
    default: return "text-gray-400";
  }
};
</script>