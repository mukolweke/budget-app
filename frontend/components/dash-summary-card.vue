<script setup>
import numeral from 'numeral';

//TODO convert to typescript vue
// type Summary = {
//   name: string;
//   icon: string;
//   amount: string;
// };

defineProps({
  summary: Object,
});

const formattedNumber = (amount) => {
  return numeral(amount).format('0,0.00');
};
</script>


<template>
  <div class="card w-1/3">
    <div class="flex items-start justify-between mb-2">
      <h4 class="text-gray-400 font-medium text-sm">
        Total {{ summary.name }}
      </h4>

      <div
        class="p-2 bg-primary/30 flex items-center justify-center rounded-full"
      >
        <span class="material-symbols-outlined text-primary">
          {{ summary.icon }}
        </span>
      </div>
    </div>

    <h4 class="font-medium text-onyx-lighter text-2xl">
      KES {{ formattedNumber(summary.amount) }}
    </h4>
  </div>
</template>