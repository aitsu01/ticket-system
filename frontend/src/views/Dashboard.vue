<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Dashboard</h1>

    <div v-if="data">
      <p>Total: {{ data.total }}</p>
      <p>Open: {{ data.open }}</p>
      <p>In Progress: {{ data.in_progress }}</p>
      <p>Resolved: {{ data.resolved }}</p>
      <p>Closed: {{ data.closed }}</p>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import api from "../services/api";

const data = ref(null);

onMounted(async () => {
  const res = await api.get("/dashboard");
  data.value = res.data;
});
</script>