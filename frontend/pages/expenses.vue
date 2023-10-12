<script setup lang="ts">
definePageMeta({
  middleware: ["auth"],
});
</script>

<template>
  <div>
    <!-- List Expenses -->
    <module-listing name="expense"></module-listing>
  </div>
</template>

<style lang="scss" scoped>
</style>