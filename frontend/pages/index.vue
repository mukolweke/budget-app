<script lang="ts" setup>
import { useAuthStore } from "~/stores/useAuthStore";

definePageMeta({
  middleware: ["auth"],
});

const auth = useAuthStore();

let currentTime = new Date();

const timeOfDay = computed(() => {
  const currentHour = currentTime.getHours();
  if (currentHour >= 6 && currentHour < 12) {
    return "Morning";
  } else if (currentHour >= 12 && currentHour < 17) {
    return "Afternoon";
  } else {
    return "Evening";
  }
});

</script>

<template>
  <div>
    <h1 class="font-semibold text-xl mb-4">Good {{ timeOfDay }} {{ auth.user?.name }}!</h1>
    <p>Here's summary of this months budget</p>
  </div>
</template>

<style scoped></style>
