<script setup>
defineProps({
  modelValue: String,
  placeholder: String,
  label: String,
  error: String,
  helpText: String,
  inputId: String || null,
  disabled: Boolean,
  typeVal: {
    type: String,
    default: 'text',
  }
})

const emit = defineEmits(['update:model-value'])

const updateValue = (event) => {
  emit('update:model-value', event.target.value)
}
</script>

<template>
  <div>
    <label :for="inputId" class="font-semibold text-xs">{{ label }} </label>
    <div class="relative">
      <div
        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
      >
        <span class="w-5 h-5">
          <!-- icon slot -->
          <span class="material-symbols-outlined text-primary"> <slot /> </span>
        </span>
      </div>
      <input
        :value="modelValue"
        @input="updateValue"
        :type="typeVal"
        :id="inputId"
        class="border border-gray-300 text-sm rounded focus:outline-primary block w-full pl-10 p-3.5"
        :placeholder="placeholder"
        :disabled="disabled"
        :class="{ 'bg-gray-200': disabled }"
      />
    </div>

    <div class="text-xs text-red-500 mt-1" v-if="error">
      {{ error[0] }}
    </div>

    <div class="text-[10px] text-gray-500 mt-1" v-if="helpText">
      {{ helpText }}
    </div>
  </div>
</template>


