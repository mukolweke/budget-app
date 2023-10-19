<script setup lang="ts">
import { cva } from "class-variance-authority";

// Define Props
const props = defineProps<{
  intent: "info" | "success" | "warning" | "danger";
  message: string;
  title: string;
  show: boolean;
  onDismiss: Function | undefined;
}>();

// Auto close the alert after 3sec
onMounted(() => {
  watch(
    () => props.show,
    (value) => {
      if (value) {
        setTimeout(() => {
          if (props.onDismiss) {
            props.onDismiss();
          }
        }, 3000);
      }
    }
  );
});

const containerClass = computed(() => {
  return cva("flex p-4 rounded-md space-x-3", {
    variants: {
      intent: {
        info: "bg-blue-300",
        success: "bg-green-100",
        warning: "bg-orange-100",
        danger: "bg-red-100",
      },
    },
  })({
    intent: props.intent,
  });
});

const iconClass = cva("material-symbols-outlined", {
  variants: {
    intent: {
      info: "text-blue-700",
      success: "text-green-600",
      warning: "text-orange-400",
      danger: "text-red-500",
    },
  },
})({
  intent: props.intent,
});

const titleClass = computed(() => {
  return cva("font-medium", {
    variants: {
      intent: {
        info: "text-blue-900",
        success: "text-green-900",
        warning: "text-orange-900",
        danger: "text-red-900",
      },
    },
  })({
    intent: props.intent,
  });
});

const contentClass = computed(() => {
  return cva("text-sm", {
    variants: {
      intent: {
        info: "text-blue-800",
        success: "text-green-800",
        warning: "text-orange-800",
        danger: "text-red-800",
      },
    },
  })({
    intent: props.intent,
  });
});

const btnClass = computed(() => {
  return cva("flex items-center p-0.5 rounded-md -m-1", {
    variants: {
      intent: {
        info: "text-blue-900/70 hover:text-blue-900 hover:bg-blue-200 active:bg-blue-300",
        success:
          "text-green-900/70 hover:text-green-900 hover:bg-green-200 active:bg-green-300",
        warning:
          "text-orange-900/70 hover:text-orange-900 hover:bg-orange-200 active:bg-orange-300",
        danger:
          "text-red-900/70 hover:text-red-900 hover:bg-red-200 active:bg-red-300",
      },
    },
  })({
    intent: props.intent,
  });
});

const icons = ref<Record<string, string>>({
  info: "info",
  success: "check_circle",
  warning: "warning",
  danger: "dangerous",
});

const iconComponent = computed(() => icons.value[props.intent] || "");

function dismiss() {
  if (props.onDismiss) {
    props.onDismiss();
  }
}
</script>

<template>
  <transition
    enter-active-class="duration-300"
    enter-to-class="opacity-100"
    leave-active-class="duration-300"
    leave-to-class="opacity-0"
  >
    <div class="fixed bottom-[50px] right-[50px] w-[400px]">
      <div :class="containerClass" v-if="show">
        <div class="shrink-0">
          <span :class="iconClass"> {{ iconComponent }} </span>
        </div>
        <div class="flex-1 space-y-2">
          <h1 :class="titleClass">{{ title }}</h1>
          <div :class="contentClass">
            <p>{{ message }}</p>
          </div>
        </div>
        <div class="shrink-0" v-if="onDismiss">
          <button
            :title="'Close ' + intent"
            :aria-label="'Close ' + intent"
            :class="btnClass"
            @click="dismiss"
          >
            <span class="material-symbols-outlined w-6 h-6"> close </span>
          </button>
        </div>
      </div>
    </div>
  </transition>
</template>
