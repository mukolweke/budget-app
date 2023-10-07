<script setup lang="ts">
defineProps({
  modalActive: Boolean,
  title: String,
});

defineEmits(["close-modal", "confirm-modal"]);
</script>

<template>
  <teleport to="body">
    <transition name="modal-outer">
      <div
        v-if="modalActive"
        class="absolute bottom-0 right-0 left-0 h-screen bg-black bg-opacity-30 flex justify-center px-8"
      >
        <transition name="modal-inner">
          <div
            v-if="modalActive"
            class="p-8 bg-white self-start mt-32 max-w-screen-md rounded-md"
          >
            <div class="flex items-center justify-between mb-6">
              <h2
                class="text-sm font-semibold text-onyx-lightest uppercase tracking-widest"
              >
                {{ title }}
              </h2>
              <span
                class="material-symbols-outlined cursor-pointer"
                @click="$emit('close-modal')"
              >
                close
              </span>
            </div>
            <!-- Modal Body -->
            <div class="mb-6">
              <slot />
            </div>

            <!-- Modal action -->
            <div class="flex items-center justify-end space-x-4 z-0">
              <button class="py-2 px-6 btn-alt" @click="$emit('close-modal')">
                Close
              </button>
              <button class="py-2 px-6 btn" @click="$emit('confirm-modal')">
                Save
              </button>
            </div>
          </div>
        </transition>
      </div>
    </transition>
  </teleport>
</template>

<style scoped>
.modal-outer-enter-active,
.modal-outer-leave-active {
  transition: opacity 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
}

.modal-outer-enter-from,
.modal-outer-leave-to {
  opacity: 0;
}

.modal-inner-enter-active {
  transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02) 0.15s;
}

.modal-inner-leave-active {
  transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
}

.modal-inner-enter-from {
  opacity: 0;
  transform: scale(0.8);
}

.modal-inner-leave-to {
  transform: scale(0.8);
}
</style>