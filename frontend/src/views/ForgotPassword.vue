<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-6 rounded shadow w-96">

      <h2 class="text-xl font-bold mb-4">Reset Password</h2>

      <input
        v-model="email"
        type="email"
        placeholder="Email"
        class="w-full mb-4 p-2 border rounded"
      />

      <button
        @click="send"
        class="w-full bg-yellow-500 text-white p-2 rounded mb-3"
      >
        Send Reset Link
      </button>

      <p v-if="message" class="text-green-500 text-sm mb-2">
        {{ message }}
      </p>

      <router-link to="/" class="text-sm text-blue-500">
        Back to Login
      </router-link>

    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import api from "../services/api";

const email = ref("");
const message = ref("");

const send = async () => {
  try {
    const res = await api.post("/forgot-password", {
      email: email.value
    });

    message.value = res.data.message;

  } catch (e) {
    message.value = "Error sending email";
  }
};
</script>