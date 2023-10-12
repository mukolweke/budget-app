<script setup lang="ts">
definePageMeta({
  middleware: ["auth"],
});
</script>

<template>
  <div>
    <!-- List Incomes -->
    <module-listing name="income"></module-listing>
  </div>
</template>