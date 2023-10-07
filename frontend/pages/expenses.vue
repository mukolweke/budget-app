<script setup lang="ts">
definePageMeta({
  middleware: ["auth"],
});
</script>

<template>
  <div>
    <page-header></page-header>
    
    <div class="pt-10">
      <!-- List Expenses -->
      <module-listing name="expense"></module-listing>
    </div>
  </div>
</template>

<style lang="scss" scoped>
</style>