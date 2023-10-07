<script setup lang="ts">
definePageMeta({
  middleware: ["auth"],
});
</script>

<template>
  <div>
    <page-header></page-header>

    <div class="pt-10">
      <!-- List Savings -->
      <module-listing name="saving"></module-listing>
    </div>
  </div>
</template>

<style lang="scss" scoped>
</style>