<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-6 rounded shadow w-96">

      <h2 class="text-xl font-bold mb-4 text-center">Login</h2>

      <!--  ERROR -->
      <p v-if="errorMessage" class="text-red-500 mb-3 text-sm text-center">
        {{ errorMessage }}
      </p>

      <!--  SUCCESS -->
      <p v-if="successMessage" class="text-green-500 mb-3 text-sm text-center">
        {{ successMessage }}
      </p>

      <!--  EMAIL -->
      <input
        v-model="email"
        type="email"
        placeholder="Email"
        class="w-full mb-2 p-2 border rounded"
      />

      <!--  PASSWORD -->
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

      <!--  LOGIN -->
      <button
        @click="login"
        :disabled="loading"
        class="w-full bg-blue-500 text-white p-2 rounded mb-3 disabled:opacity-50"
      >
        {{ loading ? 'Loading...' : 'Login' }}
      </button>

      <!--  RESEND -->
      <div v-if="emailNotVerified" class="mb-3 text-center">

        <p class="text-sm text-gray-600 mb-2">
          Didn't receive the verification email?
        </p>

        <button
          @click="resendVerification"
          :disabled="resendLoading || cooldown > 0"
          class="bg-yellow-500 text-white px-4 py-2 rounded disabled:opacity-50"
        >
          <span v-if="resendLoading">Sending...</span>

          <span v-else-if="cooldown > 0">
            Resend in {{ cooldown }}s
          </span>

          <span v-else>
            Resend Verification Email
          </span>
        </button>

      </div>

      <!--  LINKS -->
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

// STATE
const email = ref("");
const password = ref("");
const showPassword = ref(false);

const errorMessage = ref("");
const successMessage = ref("");

const loading = ref(false);
const resendLoading = ref(false);
const emailNotVerified = ref(false);

//  COOLDOWN
const cooldown = ref(0);
let interval = null;

const startCooldown = () => {
  cooldown.value = 30;

  interval = setInterval(() => {
    cooldown.value--;

    if (cooldown.value <= 0) {
      clearInterval(interval);
    }
  }, 1000);
};

//  LOGIN
const login = async () => {
  errorMessage.value = "";
  successMessage.value = "";
  emailNotVerified.value = false;
  loading.value = true;

  try {
    const res = await api.post("/login", {
      email: email.value,
      password: password.value,
    });

    localStorage.setItem("token", res.data.token);
    router.push("/dashboard");

  } catch (error) {

    if (
      error.response?.status === 403 ||
      error.response?.data?.message?.includes("not verified")
    ) {
      emailNotVerified.value = true;
      errorMessage.value = "Email not verified";

    } else if (error.response?.status === 401) {
      errorMessage.value = "Invalid credentials";

    } else {
      errorMessage.value = "Something went wrong";
    }

  } finally {
    loading.value = false;
  }
};

//  RESEND
const resendVerification = async () => {
  if (cooldown.value > 0) return;

  errorMessage.value = "";
  successMessage.value = "";
  resendLoading.value = true;

  try {
    await api.post("/resend-verification", {
      email: email.value
    });

    successMessage.value = "Verification email sent!";
    startCooldown();

  } catch (e) {
    errorMessage.value = "Error sending email";
  } finally {
    resendLoading.value = false;
  }
};
</script>