<script setup>
defineProps({
  modelValue: String,
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

let showPassword = ref(false);

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
          <span class="material-symbols-outlined text-primary"> lock </span>
        </span>
      </div>

      <input
        :value="modelValue"
        @input="updateValue"
        :id="inputId"
        :type="showPassword ? 'text' : 'password'"
        class="border border-gray-300 text-sm rounded focus:outline-primary block w-full px-10 p-3.5"
        placeholder="**************"
        :disabled="disabled"
        :class="{ 'bg-gray-200': disabled }"
      />

      <div
        class="absolute z-50 cursor-pointer inset-y-0 right-0 flex items-center pr-3"
      >
        <span class="w-5 h-5" @click="showPassword = !showPassword">
          <span v-if="!showPassword">
            <span class="material-symbols-outlined"> visibility </span>
          </span>
          <span v-else>
            <span class="material-symbols-outlined"> visibility_off </span>
          </span>
        </span>
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


