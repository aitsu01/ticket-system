<template>
  <div class="min-h-screen bg-gray-100 p-6">

    <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">

      <h1 class="text-2xl font-bold mb-4">Create Ticket</h1>

      <!-- ERROR -->
      <p v-if="error" class="text-red-500 mb-3">
        {{ error }}
      </p>

      <!-- TITLE -->
      <input
        v-model="title"
        placeholder="Title"
        class="w-full mb-3 p-2 border rounded"
      />

      <!-- DESCRIPTION -->
      <textarea
        v-model="description"
        placeholder="Description"
        class="w-full mb-3 p-2 border rounded"
      ></textarea>

      <!-- PRIORITY -->
      <select v-model="priority" class="w-full mb-4 p-2 border rounded">
        <option value="low">Low</option>
        <option value="medium">Medium</option>
        <option value="high">High</option>
      </select>

      <!-- BUTTON -->
      <button
        @click="create"
        :disabled="loading"
        class="w-full bg-blue-500 text-white p-2 rounded"
      >
        {{ loading ? "Creating..." : "Create Ticket" }}
      </button>

      <!-- BACK -->
      <button
        @click="router.push('/tickets')"
        class="w-full mt-2 text-gray-500"
      >
        Back
      </button>

    </div>

  </div>
</template>

<script setup>
import { ref } from "vue";
import api from "../services/api";
import { useRouter } from "vue-router";

const router = useRouter();

const title = ref("");
const description = ref("");
const priority = ref("medium");

const loading = ref(false);
const error = ref("");

const create = async () => {
  error.value = "";

  if (!title.value || !description.value) {
    error.value = "Title and description are required";
    return;
  }

  loading.value = true;

  try {
    await api.post("/tickets", {
      title: title.value,
      description: description.value,
      priority: priority.value,
    });

    router.push("/app/tickets"); //  redirect dopo creazione

  } catch (e) {
    error.value = "Failed to create ticket";
  } finally {
    loading.value = false;
  }
};
</script>