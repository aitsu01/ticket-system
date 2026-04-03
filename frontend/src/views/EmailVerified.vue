<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded shadow w-96 text-center">

      <h2 class="text-2xl font-bold text-green-600 mb-4">
         Email Verified
      </h2>

      <p class="text-gray-600 mb-6">
        Your email has been successfully verified.
      </p>

      <router-link
        to="/"
        class="bg-blue-500 text-white px-4 py-2 rounded"
      >
        Go to Login
      </router-link>

    </div>
  </div>
</template>


<script setup>
import { onMounted } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

onMounted(() => {
  setTimeout(() => {
    router.push("/");
  }, 3000);
});
</script>