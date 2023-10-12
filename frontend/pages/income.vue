<script setup lang="ts">
definePageMeta({
  middleware: ["auth"],
});
</script>

<template>
  <div>
    <div class="pb-10">
      <!-- List Incomes -->
      <module-listing name="income"></module-listing>
    </div>
  </div>
</template>