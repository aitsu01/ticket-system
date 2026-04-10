<template>
  <div class="flex items-center justify-center min-h-screen">
    <p class="text-lg">Logging you in...</p>
  </div>
</template>

<script setup>
import { useRoute, useRouter } from "vue-router";
import { onMounted } from "vue";

const route = useRoute();
const router = useRouter();

onMounted(() => {
  const token = route.query.token;

  console.log("TOKEN:", token); //  DEBUG

  if (token) {
    localStorage.setItem("token", token);

    //  redirect FORZATO
    
    window.location.href = "/app/dashboard";
  } else {
    window.location.href = "/login";
  }
});
</script>