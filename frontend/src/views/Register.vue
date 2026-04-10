<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-6 rounded shadow w-96">

      <h2 class="text-xl font-bold mb-4">Register</h2>

      <!-- SUCCESS -->
      <div v-if="successMessage" class="bg-green-100 text-green-700 p-2 rounded mb-3 text-sm">
        {{ successMessage }}
      </div>

      <!-- ERROR -->
      <div v-if="errorMessage" class="bg-red-100 text-red-700 p-2 rounded mb-3 text-sm">
        {{ errorMessage }}
      </div>

      <!-- NAME -->
      <input v-model="name" placeholder="Name" class="w-full mb-2 p-2 border rounded" />

      <!-- EMAIL -->
      <input v-model="email" type="email" placeholder="Email" class="w-full mb-2 p-2 border rounded" />

      <!-- PASSWORD -->
      <div class="relative mb-2">
        
        <input
  v-model="password"
  :type="showPassword ? 'text' : 'password'"
  placeholder="Password"
  class="w-full p-2 border rounded"
  @focus="showRequirements = true"
  @blur="handleBlur"
/>
        <button type="button" @click="showPassword = !showPassword"
          class="absolute right-2 top-2 text-sm text-gray-500">
          {{ showPassword ? 'hide' : 'show' }}
        </button>
      </div>

      <!-- CONFIRM PASSWORD -->
      <div class="relative mb-3">
        <input
          v-model="passwordConfirm"
          :type="showPasswordConfirm ? 'text' : 'password'"
          placeholder="Confirm Password"
          class="w-full p-2 border rounded"
        />
        <button type="button" @click="showPasswordConfirm = !showPasswordConfirm"
          class="absolute right-2 top-2 text-sm text-gray-500">
          {{ showPasswordConfirm ? 'hide' : 'show' }}
        </button>
      </div>

      <!--  PASSWORD STRENGTH -->
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

      <!-- REQUIREMENTS -->
      
      <div v-if="showRequirements" class="mt-2 text-xs space-y-1 transition-all">

        <p :class="checkClass(password.length >= 8)">✔ At least 8 characters</p>
        <p :class="checkClass(/[A-Z]/.test(password))">✔ One uppercase letter</p>
        <p :class="checkClass(/[a-z]/.test(password))">✔ One lowercase letter</p>
        <p :class="checkClass(/\d/.test(password))">✔ One number</p>
        <p :class="checkClass(/[\W_]/.test(password))">✔ One special character</p>
      </div>

      <!-- BUTTON -->
      <button
        @click="register"
        :disabled="!isPasswordValid()"
        :class="[
          'w-full p-2 rounded mb-3 mt-3 transition',
          isPasswordValid()
            ? 'bg-green-500 hover:bg-green-600 text-white'
            : 'bg-gray-300 text-gray-500 cursor-not-allowed'
        ]"
      >
        Register
      </button>

      <!-- DIVIDER -->
<div class="flex items-center my-4">
  <div class="flex-1 h-px bg-gray-300"></div>
  <span class="px-2 text-sm text-gray-500">or</span>
  <div class="flex-1 h-px bg-gray-300"></div>
</div>

<!-- GOOGLE REGISTER -->
<button
  @click="loginWithGoogle"
  class="w-full flex items-center justify-center gap-3 border border-gray-200 bg-white hover:shadow-md px-4 py-2 rounded-lg transition"
>
  <svg class="w-5 h-5" viewBox="0 0 48 48">
    <path fill="#EA4335" d="M24 9.5c3.54 0 6.73 1.22 9.24 3.6l6.9-6.9C35.64 2.7 30.2 0 24 0 14.64 0 6.64 5.4 2.88 13.32l8.04 6.24C12.6 13.32 17.88 9.5 24 9.5z"/>
    <path fill="#4285F4" d="M46.5 24.5c0-1.64-.14-2.86-.44-4.14H24v7.84h12.74c-.26 1.9-1.66 4.76-4.74 6.7l7.34 5.7C43.9 36.44 46.5 30.94 46.5 24.5z"/>
    <path fill="#FBBC05" d="M10.92 28.56a14.8 14.8 0 010-9.12l-8.04-6.24A23.96 23.96 0 000 24c0 3.84.92 7.46 2.88 10.8l8.04-6.24z"/>
    <path fill="#34A853" d="M24 48c6.2 0 11.4-2.04 15.2-5.54l-7.34-5.7c-1.96 1.36-4.54 2.3-7.86 2.3-6.12 0-11.4-3.82-13.08-9.06l-8.04 6.24C6.64 42.6 14.64 48 24 48z"/>
  </svg>

  <span class="text-sm font-medium text-gray-700">
    Sign up with Google
  </span>
</button>

      <!-- LINK -->
      <router-link to="/" class="text-sm text-blue-500">
        Back to Login
      </router-link>

    </div>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import api from "../services/api";
import { useRouter } from "vue-router";

const router = useRouter();
const handleBlur = () => {
  if (!password.value) {
    showRequirements.value = false;
  }
};

// STATE
const name = ref("");
const email = ref("");
const password = ref("");
const passwordConfirm = ref("");

const showPassword = ref(false);
const showPasswordConfirm = ref(false);

const errorMessage = ref("");
const successMessage = ref("");

const showRequirements = ref(false);

//Register with Google
const loginWithGoogle = () => {
  window.location.href = "http://127.0.0.1:8000/api/v1/auth/google/redirect";
};

// CHECK CLASS
const checkClass = (condition) => {
  return condition ? "text-green-500" : "text-gray-400";
};

// PASSWORD SCORE
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

// UI
const strengthWidth = computed(() => (passwordScore.value / 5) * 100 + "%");

const strengthLabel = computed(() => {
  switch (passwordScore.value) {
    case 1: return "Very Weak";
    case 2: return "Weak";
    case 3: return "Medium";
    case 4: return "Strong";
    case 5: return "Very Strong";
    default: return "";
  }
});

const strengthColor = computed(() => {
  switch (passwordScore.value) {
    case 1: return "bg-red-500";
    case 2: return "bg-orange-400";
    case 3: return "bg-yellow-400";
    case 4: return "bg-green-400";
    case 5: return "bg-green-600";
    default: return "bg-gray-300";
  }
});

const strengthTextColor = computed(() => {
  switch (passwordScore.value) {
    case 1: return "text-red-500";
    case 2: return "text-orange-500";
    case 3: return "text-yellow-600";
    case 4: return "text-green-500";
    case 5: return "text-green-700";
    default: return "text-gray-400";
  }
});

// STRICT VALIDATION
const isPasswordValid = () => {
  return (
    password.value.length >= 8 &&
    /[A-Z]/.test(password.value) &&
    /[a-z]/.test(password.value) &&
    /\d/.test(password.value) &&
    /[\W_]/.test(password.value)
  );
};

// REGISTER
const register = async () => {
  errorMessage.value = "";
  successMessage.value = "";

  if (password.value !== passwordConfirm.value) {
    errorMessage.value = "Passwords do not match";
    return;
  }

  if (!isPasswordValid()) {
    errorMessage.value = "Password does not meet requirements";
    return;
  }

  try {
    await api.post("/register", {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: passwordConfirm.value,
    });

    successMessage.value =
      "Registration successful! Please check your email to verify your account.";

    name.value = "";
    email.value = "";
    password.value = "";
    passwordConfirm.value = "";

    setTimeout(() => router.push("/"), 2000);

  } catch (e) {
    if (e.response?.data?.errors) {
      const errors = e.response.data.errors;

      if (errors.email) errorMessage.value = "Email already exists";
      else if (errors.password) errorMessage.value = errors.password[0];
      else errorMessage.value = "Validation error";

    } else {
      errorMessage.value = "Register failed";
    }
  }
};
</script>