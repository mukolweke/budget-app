<script setup lang="ts">
definePageMeta({
  middleware: ["auth"],
});
</script>

<template>
  <div>
    <div class="pt-10">
      <!-- List Savings -->
      <module-listing name="saving"></module-listing>
    </div>
  </div>
</template>

<style lang="scss" scoped>
</style>