<template>
  <div class="max-w-xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">Account Settings</h1>

    <!-- ERROR -->
    <p v-if="errorMessage" class="text-red-500 text-sm mb-3">
      {{ errorMessage }}
    </p>

    <!-- USER INFO -->
    <div class="bg-white p-4 rounded shadow mb-6">
      <p class="text-sm text-gray-500">Name</p>
      <p class="font-bold">{{ user?.name }}</p>

      <p class="text-sm text-gray-500 mt-2">Email</p>
      <p>{{ user?.email }}</p>
    </div>

    <!-- CHANGE PASSWORD -->
    <div class="bg-white p-4 rounded shadow mb-6">
      <h2 class="font-bold mb-3">Change Password</h2>

      <!-- CURRENT -->
      <div class="relative mb-2">
        <input
          v-model="currentPassword"
          :type="showCurrent ? 'text' : 'password'"
          placeholder="Current password"
          class="w-full p-2 border rounded"
        />
        <button type="button" @click="showCurrent = !showCurrent"
          class="absolute right-2 top-2 text-sm text-gray-500">
          {{ showCurrent ? 'hide' : 'show' }}
        </button>
      </div>

      <!-- NEW -->
      <div class="relative mb-2">
        <input
          v-model="newPassword"
          :type="showNew ? 'text' : 'password'"
          placeholder="New password"
          class="w-full p-2 border rounded"
        />
        <button type="button" @click="showNew = !showNew"
          class="absolute right-2 top-2 text-sm text-gray-500">
          {{ showNew ? 'hide' : 'show' }}
        </button>
      </div>

      <!-- CONFIRM -->
      <div class="relative mb-3">
        <input
          v-model="confirmPassword"
          :type="showConfirm ? 'text' : 'password'"
          placeholder="Confirm password"
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

      <!-- REQUIREMENTS -->
      <div class="mt-2 text-xs space-y-1">
        <p :class="checkClass(newPassword.length >= 8)">✔ At least 8 characters</p>
        <p :class="checkClass(/[A-Z]/.test(newPassword))">✔ One uppercase letter</p>
        <p :class="checkClass(/[a-z]/.test(newPassword))">✔ One lowercase letter</p>
        <p :class="checkClass(/\d/.test(newPassword))">✔ One number</p>
        <p :class="checkClass(/[\W_]/.test(newPassword))">✔ One special character</p>
      </div>

      <!-- BUTTON -->
      <button
        @click="changePassword"
        :disabled="!isPasswordValid()"
        :class="[
          'mt-3 px-4 py-2 rounded',
          isPasswordValid()
            ? 'bg-blue-500 text-white'
            : 'bg-gray-300 text-gray-500 cursor-not-allowed'
        ]"
      >
        Update Password
      </button>

      <!-- SUCCESS -->
      <p v-if="passwordMessage" class="text-green-500 mt-2 text-sm">
        {{ passwordMessage }}
      </p>
    </div>

    <!-- CHANGE EMAIL -->
    <div class="bg-white p-4 rounded shadow">
      <h2 class="font-bold mb-3">Change Email</h2>

      <input
        v-model="newEmail"
        type="email"
        placeholder="New email"
        class="w-full mb-2 p-2 border rounded"
      />

      <button
        @click="changeEmail"
        class="bg-green-500 text-white px-4 py-2 rounded"
      >
        Update Email
      </button>

      <p v-if="emailMessage" class="text-green-500 mt-2 text-sm">
        {{ emailMessage }}
      </p>
    </div>

  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import api from "../services/api";

const user = ref(null);

const currentPassword = ref("");
const newPassword = ref("");
const confirmPassword = ref("");
const newEmail = ref("");

const showCurrent = ref(false);
const showNew = ref(false);
const showConfirm = ref(false);

const passwordMessage = ref("");
const emailMessage = ref("");
const errorMessage = ref("");

// FETCH USER
const fetchUser = async () => {
  const res = await api.get("/me");
  user.value = res.data;
};

onMounted(fetchUser);

// CHECK STYLE
const checkClass = (condition) =>
  condition ? "text-green-500" : "text-gray-400";

// PASSWORD SCORE
const passwordScore = computed(() => {
  let score = 0;
  const pwd = newPassword.value;

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

// VALIDATION
const isPasswordValid = () => {
  return (
    newPassword.value.length >= 8 &&
    /[A-Z]/.test(newPassword.value) &&
    /[a-z]/.test(newPassword.value) &&
    /\d/.test(newPassword.value) &&
    /[\W_]/.test(newPassword.value)
  );
};

// CHANGE PASSWORD
const changePassword = async () => {
  errorMessage.value = "";

  if (newPassword.value !== confirmPassword.value) {
    errorMessage.value = "Passwords do not match";
    return;
  }

  try {
    await api.patch("/user/password", {
      current_password: currentPassword.value,
      password: newPassword.value,
      password_confirmation: confirmPassword.value
    });

    passwordMessage.value = "Password updated successfully";

    setTimeout(() => {
      window.location.reload();
    }, 1500);

  } catch (e) {
    errorMessage.value = "Error updating password";
  }
};

// CHANGE EMAIL
const changeEmail = async () => {
  errorMessage.value = "";
  emailMessage.value = "";

  try {
    await api.patch("/user/email", {
      email: newEmail.value
    });

    emailMessage.value = "Email updated. Please verify your new email.";
    newEmail.value = "";

  } catch (e) {
    if (e.response?.data?.errors?.email) {
      errorMessage.value = "Email already taken";
    } else {
      errorMessage.value = "Error updating email";
    }
  }
};
</script>