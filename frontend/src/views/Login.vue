<template>

<input v-model="email" type="email" />
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-6 rounded shadow w-96">
      <h2 class="text-xl font-bold mb-4">Login</h2>

      <input v-model="email" placeholder="Email" class="w-full mb-2 p-2 border rounded" />
      <div class="relative mb-4">
  <input
    v-model="password"
    :type="showPassword ? 'text' : 'password'"
    placeholder="Password"
    class="w-full p-2 border rounded"
  />

  <button
    type="button"
    @click="showPassword = !showPassword"
    class="absolute right-2 top-2 text-sm text-gray-500"
  >
    {{ showPassword ? 'hide' : 'show' }}
  </button>
</div>

      <button @click="login" class="w-full bg-blue-500 text-white p-2 rounded">
        Login
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import api from "../services/api";
import { useRouter } from "vue-router";

const router = useRouter();

const email = ref("");
const password = ref("");
const showPassword = ref(false);

const login = async () => {
  try {
    const res = await api.post("/login", {
      email: email.value,
      password: password.value,
    });

    localStorage.setItem("token", res.data.token);

    router.push("/dashboard"); //  redirect corretto

  } catch (error) {
    alert("Login failed");
    console.error(error);
  }
};
</script>