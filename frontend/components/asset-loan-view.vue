<script setup lang="ts">
defineProps({
  label: String,
  datum: Array<{ name: string; amount: string }>,
});
</script>

<template>
  <div class="">
    <h4 class="font-semibold text-xl mb-4 mt-10 text-onyx-lighter">{{ label }} Summary</h4>

    <div class="border-t-2 p-2 border-primary">
      <table class="min-w-full leading-normal">
        <tbody>
          <tr v-for="(item, index) in datum" :key="index">
            <td class="pr-5 py-3 bg-white font-medium">
              <p class="text-onyx whitespace-no-wrap">
                {{ index + 1 }}
              </p>
            </td>
            <td class="pr-1 py-3 bg-white font-medium">
              <p class="text-onyx whitespace-no-wrap">
                {{ item.name }}
              </p>
            </td>
            <td class="pr-5 py-3 bg-white font-medium">
              <p class="text-onyx-lightest whitespace-no-wrap">
                KES {{ item.amount }}
              </p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
