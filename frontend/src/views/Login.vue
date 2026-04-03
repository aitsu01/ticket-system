<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-6 rounded shadow w-96">

      <h2 class="text-xl font-bold mb-4 text-center">Login</h2>

      <!-- 🔴 Error message -->
      <p v-if="errorMessage" class="text-red-500 mb-3 text-sm text-center">
        {{ errorMessage }}
      </p>

      <!-- 📧 Email -->
      <input
        v-model="email"
        type="email"
        placeholder="Email"
        class="w-full mb-2 p-2 border rounded"
      />

      <!-- 🔐 Password -->
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

      <!-- 🔵 Login -->
      <button
        @click="login"
        :disabled="loading"
        class="w-full bg-blue-500 text-white p-2 rounded mb-3 disabled:opacity-50"
      >
        {{ loading ? 'Loading...' : 'Login' }}
      </button>

      <!-- 🟡 Resend verification -->
      <button
        v-if="errorMessage.includes('Email not verified')"
        @click="resendVerification"
        class="w-full bg-yellow-500 text-white p-2 rounded mb-3"
      >
        Resend Verification Email
      </button>

      <!-- 🔗 Links -->
      <div class="flex justify-between text-sm">
        <router-link to="/register" class="text-blue-500">
          Register
        </router-link>

        <router-link to="/forgot-password" class="text-gray-500">
          Forgot Password?
        </router-link>
      </div>

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

const errorMessage = ref("");
const loading = ref(false);

const login = async () => {
  errorMessage.value = "";
  loading.value = true;

  try {
    const res = await api.post("/login", {
      email: email.value,
      password: password.value,
    });

    localStorage.setItem("token", res.data.token);
    router.push("/dashboard");

  } catch (error) {

    if (error.response?.status === 403) {
      errorMessage.value = "Email not verified. Check your inbox.";

      //  salva token anche se non verificato
      if (error.response.data.token) {
        localStorage.setItem("token", error.response.data.token);
      }

    } else if (error.response?.status === 401) {
      errorMessage.value = "Invalid credentials";
    } else {
      errorMessage.value = "Something went wrong";
    }

  } finally {
    loading.value = false;
  }
};

const resendVerification = async () => {
  try {
    await api.post("/email/verification-notification");
    alert("Verification email sent!");
  } catch (e) {
    alert("Error sending email");
  }
};
</script>