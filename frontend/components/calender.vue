<script setup lang="ts">
import { useDateMixin } from "~/mixins/dateMixin";

const { months, currentMonth, currentYear, activeMonth, currentDateTime } =
  useDateMixin();
</script>

<template>
  <div>
    <ul class="grid grid-cols-3 grid-rows-3 gap-4">
      <li
        v-for="(month, index) in months"
        :key="month"
        class="uppercase cursor-pointer px-4 mx-auto transition-all duration-100"
        :class="{
          'text-primary font-bold': activeMonth == index,
          'font-medium text-gray-500 hover:text-primary': activeMonth != index,
        }"
        @click="activeMonth = index"
        :title="month"
      >
        {{ month }}
      </li>
    </ul>
  </div>
</template>
