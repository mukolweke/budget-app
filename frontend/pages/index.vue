<script lang="ts" setup>
import { useDateMixin } from "~/mixins/dateMixin";
import { useAuthStore } from "~/stores/useAuthStore";

definePageMeta({
  middleware: ["auth"],
});

const auth = useAuthStore();

const { months, currentMonth, timeOfDay } = useDateMixin();
</script>

<template>
  <div>
    <h1 class="font-semibold text-xl mb-4 text-onyx-lighter">
      Good {{ timeOfDay }} {{ auth.user?.name }}!
    </h1>
    <p class="text-onyx-lightest mb-8">
      Here's summary of
      <span class="capitalize">{{ months[currentMonth] }}</span> budget
    </p>

    <div class="flex items-center space-x-8 w-full">
      <div class="card w-1/3">Card</div>
      <div class="card w-1/3">Card</div>
      <div class="card w-1/3">Card</div>
    </div>
  </div>
</template>
