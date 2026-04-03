<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-6 rounded shadow w-96">

      <h2 class="text-xl font-bold mb-4">Reset Password</h2>

      <input v-model="email" type="email" class="w-full mb-2 p-2 border rounded" placeholder="Email" />

      <input v-model="password" type="password" class="w-full mb-2 p-2 border rounded" placeholder="New Password" />

      <input v-model="password_confirmation" type="password" class="w-full mb-4 p-2 border rounded" placeholder="Confirm Password" />

      <button @click="reset" class="w-full bg-green-500 text-white p-2 rounded">
        Reset Password
      </button>

      <p v-if="message" class="text-green-500 mt-3 text-sm">
        {{ message }}
      </p>

    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import api from "../services/api";

const route = useRoute();
const router = useRouter();

const email = ref("");
const password = ref("");
const password_confirmation = ref("");
const token = ref("");
const message = ref("");

onMounted(() => {
  token.value = route.query.token;
  email.value = route.query.email;
});

const reset = async () => {
  try {
    const res = await api.post("/reset-password", {
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value,
      token: token.value
    });

    message.value = res.data.message;

    setTimeout(() => {
      router.push("/");
    }, 2000);

  } catch (e) {
    message.value = "Error resetting password";
  }
};
</script>