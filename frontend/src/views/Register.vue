<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-6 rounded shadow w-96">
      <h2 class="text-xl font-bold mb-4">Register</h2>

      <input v-model="name" placeholder="Name" class="w-full mb-2 p-2 border rounded" />
      <input v-model="email" type="email" placeholder="Email" class="w-full mb-2 p-2 border rounded" />
      <input v-model="password" type="password" placeholder="Password" class="w-full mb-4 p-2 border rounded" />

      <button @click="register" class="w-full bg-green-500 text-white p-2 rounded mb-3">
        Register
      </button>

      <router-link to="/" class="text-sm text-blue-500">
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

const name = ref("");
const email = ref("");
const password = ref("");

const register = async () => {
  try {
    await api.post("/register", {
      name: name.value,
      email: email.value,
      password: password.value,
    });

    router.push("/");
  } catch (e) {
    alert("Register failed");
  }
};
</script>