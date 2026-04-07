<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-6 rounded shadow w-96">

      <h2 class="text-xl font-bold mb-4 text-center">Reset Password</h2>

      <!-- SUCCESS -->
      <p v-if="message" class="text-green-500 text-sm mb-2 text-center">
        {{ message }}
      </p>

      <!-- ERROR -->
      <p v-if="error" class="text-red-500 text-sm mb-2 text-center">
        {{ error }}
      </p>

      <!-- EMAIL -->
      <input v-model="email" type="email" placeholder="Email"
        class="w-full mb-2 p-2 border rounded" />

      <!-- PASSWORD -->
      <div class="relative mb-2">
        <input
          v-model="password"
          :type="showPassword ? 'text' : 'password'"
          placeholder="New Password"
          class="w-full p-2 border rounded"
        />
        <button type="button" @click="showPassword = !showPassword"
          class="absolute right-2 top-2 text-sm text-gray-500">
          {{ showPassword ? 'hide' : 'show' }}
        </button>
      </div>

      <!-- CONFIRM -->
      <div class="relative mb-3">
        <input
          v-model="passwordConfirm"
          :type="showConfirm ? 'text' : 'password'"
          placeholder="Confirm Password"
          class="w-full p-2 border rounded"
        />
        <button type="button" @click="showConfirm = !showConfirm"
          class="absolute right-2 top-2 text-sm text-gray-500">
          {{ showConfirm ? 'hide' : 'show' }}
        </button>
      </div>

      <!-- STRENGTH -->
      <div class="mt-1">
        <div class="w-full h-2 bg-gray-200 rounded">
          <div
            class="h-2 rounded transition-all"
            :class="strengthColor"
            :style="{ width: strengthWidth }"
          ></div>
        </div>

        <p class="text-xs mt-1" :class="strengthTextColor">
          {{ strengthLabel }}
        </p>
      </div>

      <!-- BUTTON -->
      <button
        @click="resetPassword"
        class="w-full mt-3 bg-blue-500 text-white p-2 rounded"
      >
        Reset Password
      </button>

    </div>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { useRoute, useRouter } from "vue-router";
import api from "../services/api";

const route = useRoute();
const router = useRouter();

const email = ref("");
const password = ref("");
const passwordConfirm = ref("");

const showPassword = ref(false);
const showConfirm = ref(false);

const message = ref("");
const error = ref("");

// SCORE
const passwordScore = computed(() => {
  let score = 0;
  const pwd = password.value;

  if (!pwd) return 0;

  if (pwd.length >= 8) score++;
  if (/[A-Z]/.test(pwd)) score++;
  if (/[a-z]/.test(pwd)) score++;
  if (/\d/.test(pwd)) score++;
  if (/[\W_]/.test(pwd)) score++;

  return score;
});

const strengthWidth = computed(() => (passwordScore.value / 5) * 100 + "%");

const strengthLabel = computed(() => {
  return ["", "Very Weak", "Weak", "Medium", "Strong", "Very Strong"][passwordScore.value];
});

const strengthColor = computed(() => {
  return ["", "bg-red-500", "bg-orange-400", "bg-yellow-400", "bg-green-400", "bg-green-600"][passwordScore.value];
});

const strengthTextColor = computed(() => {
  return ["", "text-red-500", "text-orange-500", "text-yellow-600", "text-green-500", "text-green-700"][passwordScore.value];
});

// RESET
const resetPassword = async () => {
  error.value = "";
  message.value = "";

  if (password.value !== passwordConfirm.value) {
    error.value = "Passwords do not match";
    return;
  }

  try {
    await api.post("/reset-password", {
      token: route.query.token,
      email: email.value,
      password: password.value,
      password_confirmation: passwordConfirm.value
    });

    message.value = "Password reset successful";

    setTimeout(() => {
      router.push("/login");
    }, 2000);

  } catch (e) {
    error.value = "Invalid token or email";
  }
};
</script>