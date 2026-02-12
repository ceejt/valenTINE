<template>
  <Transition name="envelope">
    <div
      v-if="!isOpened"
      @click="openEnvelope"
      class="cursor-pointer relative w-80 h-56 animate-float"
    >
      <!-- Envelope Body -->
      <div
        class="absolute inset-0 bg-rose-100 rounded-lg shadow-paper-deep border-2 border-rose-200"
      >
      </div>

      <!-- Flap -->
      <div
        class="absolute top-0 left-0 right-0 h-28 bg-rose-200 origin-top transition-transform duration-1000"
        :class="{ 'rotate-x-180': isAnimating }"
        style="
          transform-style: preserve-3d;
          clip-path: polygon(0 0, 50% 100%, 100% 0);
        "
      ></div>

      <!-- Click hint -->
      <div
        class="absolute -bottom-12 left-1/2 -translate-x-1/2 text-rose-600 text-sm animate-pulse"
      >
        Click to open!
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref } from "vue";

const emit = defineEmits(["open"]);
const isOpened = ref(false);
const isAnimating = ref(false);

const openEnvelope = () => {
  isAnimating.value = true;

  // Wait for animation to complete
  setTimeout(() => {
    isOpened.value = true;
    emit("open");
  }, 1000);
};
</script>

<style scoped>
.envelope-enter-active,
.envelope-leave-active {
  transition: opacity 0.5s ease;
}

.envelope-enter-from,
.envelope-leave-to {
  opacity: 0;
}

/* 3D rotation effect */
.rotate-x-180 {
  transform: rotateX(-180deg);
}
</style>
