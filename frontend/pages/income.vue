<script setup lang="ts">
definePageMeta({
  middleware: ["auth"],
});
</script>

<template>
  <div>
    <page-header></page-header>

    <div class="pt-10">
      <!-- Create Action -->
      <!-- <div>
        <button class="btn px-5 font-bold" @click="toggleModal">Create</button>
      </div>

       -->

      <!-- List Incomes -->
      <module-listing name="income"></module-listing>
    </div>
  </div>
</template>