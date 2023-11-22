<script setup lang="ts">
import { useDateStore } from "~/stores/useDateStore";

const date = useDateStore();
</script>

<template>
  <div>
    <ul class="grid grid-cols-3 grid-rows-3 gap-4">
      <li
        v-for="(month, index) in date.months"
        :key="month"
        class="uppercase cursor-pointer px-4 mx-auto transition-all duration-100"
        :class="{
          'text-primary font-bold': date.selectedMonthIndex == index,
          'font-medium text-gray-500 hover:text-primary':
            date.selectedMonthIndex != index,
        }"
        @click="date.updateCurrentMonth(index)"
        :title="month"
      >
        {{ month }}
      </li>
    </ul>
  </div>
</template>
