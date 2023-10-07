<script setup>
defineProps({
  modelValue: String,
  placeholder: String,
  label: String,
  error: String,
  helpText: String,
  inputId: String || null,
  disabled: Boolean,
})

let showDropdown = ref(false);

const emit = defineEmits(['update:model-value'])

const updateValue = (month) => {
  showDropdown.value = !showDropdown.value;
  emit('update:model-value', month)
}

const months = [
  "january",
  "february",
  "march",
  "april",
  "may",
  "june",
  "july",
  "august",
  "september",
  "october",
  "november",
  "december",
];

</script>

<template>
  <div>
    <label :for="inputId" class="font-semibold text-xs capitalize"
      >{{ label }}
    </label>
    <div class="relative">
      <div
        class="absolute top-1/2 bottom-1/2 left-0 flex items-center pl-3 pointer-events-none"
      >
        <span class="w-5 h-5">
          <!-- icon slot -->
          <span class="material-symbols-outlined text-primary">
            calendar_month
          </span>
        </span>
      </div>

      <div
        :class="{ 'text-gray-300': !modelValue, 'bg-gray-200': disabled }"
        class="border cursor-pointer capitalize border-gray-300 text-sm rounded focus:outline-primary block w-full pl-10 p-3"
        @click="showDropdown = !showDropdown"
      >
        {{ modelValue ? modelValue : placeholder }}
      </div>

      <div
        v-if="showDropdown"
        class="absolute top-full w-full shadow-md rounded-b border border-t-0 border-gray-300 p-3 z-50 bg-white"
      >
        <div class="grid grid-cols-4">
          <div
            v-for="month in months"
            :key="month"
            class="p-3 cursor-pointer border capitalize border-gray-100 text-center text-sm"
            @click="updateValue(month)"
          >
            {{ month }}
          </div>
        </div>
      </div>
    </div>

    <div class="text-xs text-red-500 mt-1" v-if="error">
      {{ error[0] }}
    </div>

    <div class="text-[10px] text-gray-500 mt-1" v-if="helpText">
      {{ helpText }}
    </div>
  </div>
</template>

