<script setup lang="ts">
definePageMeta({
  middleware: ["auth"],
});
</script>

<template>
  <div>
    <page-header></page-header>

    <div class="pt-10">
      <!-- List Incomes -->
      <module-listing name="income"></module-listing>
    </div>
  </div>
</template>