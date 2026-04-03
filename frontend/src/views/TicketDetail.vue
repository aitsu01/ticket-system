<template>
  <div class="min-h-screen bg-gray-100 p-6">

    <!-- BACK -->
    <button @click="router.push('/tickets')" class="mb-4 text-gray-500">
      ← Back
    </button>

    <!-- LOADING -->
    <div v-if="loading" class="text-center text-gray-500">
      Loading...
    </div>

    <!-- ERROR -->
    <div v-if="error" class="text-center text-red-500">
      {{ error }}
    </div>

    <!-- CONTENT -->
    <div v-if="ticket" class="max-w-2xl mx-auto bg-white p-6 rounded shadow">

      <!-- HEADER -->


      <div class="mb-4">
  <h1 class="text-2xl font-bold">
  {{ ticket.ticket_number }} — {{ ticket.title }}
</h1>

<p class="text-xs text-gray-400">
  Created: {{ ticket.created_at }}
</p>

  <!--  CREATOR -->
  <p class="text-sm text-gray-400">
    Created by: {{ ticket.user.name }}
  </p>

  <p class="text-gray-500 mt-1">
    {{ ticket.description }}
  </p>
</div>



      <!-- STATUS -->
      <div class="flex justify-between mb-4">
        <span :class="statusClass(ticket.status)">
          {{ ticket.status }}
        </span>

        <span class="text-sm text-gray-400">
          Priority: {{ ticket.priority }}
        </span>
      </div>

      <!-- COMMENTS -->
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

            <span class="text-xs text-gray-400">
  {{ comment.user.name }}
</span>
              

            </span>
          </div>
        </div>

        <p v-else class="text-gray-400">
          No comments yet
        </p>
      </div>

      <!-- ADD COMMENT -->
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

const fetchTicket = async () => {
  try {
    const res = await api.get(`/tickets/${route.params.id}`);
    ticket.value = res.data.data;
  } catch (e) {
    error.value = "Failed to load ticket";
  } finally {
    loading.value = false;
  }
};

onMounted(fetchTicket);

const addComment = async () => {
  if (!newComment.value) return;

  try {
    await api.post(`/tickets/${ticket.value.id}/comments`, {
      message: newComment.value,
    });

    newComment.value = "";
    fetchTicket(); // 🔄 refresh
  } catch (e) {
    alert("Error adding comment");
  }
};

const statusClass = (status) => {
  switch (status) {
    case "open": return "text-blue-500 font-bold";
    case "in_progress": return "text-yellow-500 font-bold";
    case "resolved": return "text-green-500 font-bold";
    case "closed": return "text-gray-500 font-bold";
  }
};
</script>