<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-6 rounded shadow w-96">

      <h2 class="text-xl font-bold mb-4 text-center">
        Forgot Password
      </h2>

      <!-- SUCCESS -->
      <p v-if="message" class="text-green-500 text-sm mb-2 text-center">
        {{ message }}
      </p>

      <!-- ERROR -->
      <p v-if="error" class="text-red-500 text-sm mb-2 text-center">
        {{ error }}
      </p>

      <!-- EMAIL -->
      <input
        v-model="email"
        type="email"
        placeholder="Enter your email"
        class="w-full mb-4 p-2 border rounded"
      />

      <!-- BUTTON -->
      <button
        @click="sendReset"
        :disabled="loading"
        class="w-full bg-yellow-500 text-white p-2 rounded mb-3 disabled:opacity-50"
      >
        {{ loading ? "Sending..." : "Send Reset Link" }}
      </button>

      <!-- LINK -->
      <router-link to="/login" class="text-sm text-blue-500">
        Back to Login
      </router-link>

    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import api from "../services/api";

import { useRouter } from "vue-router";

const router = useRouter();

const email = ref("");
const message = ref("");
const error = ref("");
const loading = ref(false);

const sendReset = async () => {
  message.value = "";
  error.value = "";

  if (!email.value) {
    error.value = "Email is required";
    return;
  }

  loading.value = true;

  try {
    const res = await api.post("/forgot-password", {
      email: email.value
    });

    message.value = res.data.message;

    //  redirect dopo 2s
    setTimeout(() => {
      router.push("/login"); // oppure "/"
    }, 2000);

  } catch (e) {
    error.value = "Unable to send reset link";
  } finally {
    loading.value = false;
  }
};
</script>