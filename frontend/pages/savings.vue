<script setup lang="ts">
definePageMeta({
  middleware: ["auth"],
});
</script>

<template>
  <div>
    <!-- List Savings -->
    <module-listing name="saving"></module-listing>
  </div>
</template>

<style lang="scss" scoped>
</style>