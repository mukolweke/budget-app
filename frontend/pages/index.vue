<script lang="ts" setup>
import { useAuthStore } from "~/stores/useAuthStore";

definePageMeta({
  middleware: ["auth"],
});

const auth = useAuthStore();
</script>

<template>
  <div>
    Page: Index Page

    {{ auth.user }}
  </div>
</template>

<style scoped></style>
