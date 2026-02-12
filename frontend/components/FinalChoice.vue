<template>
  <div class="text-center max-w-2xl w-full">
    <!-- Message -->
    <div v-if="!choiceMade" class="mb-12">
      <h1 class="text-5xl font-bold text-rose-900 mb-4">
        Will You Be My MVP this valenTINE?
      </h1>
      <p class="text-xl text-rose-700">Choose wisely... 😊</p>
    </div>

    <!-- Buttons -->
    <div v-if="!choiceMade" class="flex gap-8 justify-center">
      <button
        @click="handleChoice('yes')"
        class="group relative bg-green-500 hover:bg-green-600 text-white font-bold text-4xl px-16 py-8 rounded-2xl shadow-2xl transform transition-all hover:scale-110 active:scale-95"
      >
        YES 💚
      </button>

      <button
        @click="handleChoice('no')"
        class="group relative bg-red-500 hover:bg-red-600 text-white font-bold text-4xl px-16 py-8 rounded-2xl shadow-2xl transform transition-all hover:scale-110 active:scale-95"
      >
        NO 🚫
      </button>
    </div>

    <!-- YES Response -->
    <div v-if="choiceMade && userChoice === 'yes'" class="animate-bounce">
      <div class="text-9xl mb-4">🐻</div>
      <h2 class="text-4xl font-bold text-green-700 mb-2">Yay! 🎉</h2>
      <p class="text-2xl text-green-600">You made the right choice! 💕</p>
    </div>

    <!-- NO Response -->
    <div v-if="choiceMade && userChoice === 'no'" class="animate-wiggle">
      <div class="text-9xl mb-4">🍅</div>
      <h2 class="text-4xl font-bold text-red-700 mb-4">Oops! Wrong answer!</h2>
      <button
        @click="resetChoice"
        class="bg-rose-500 hover:bg-rose-600 text-white font-bold text-2xl px-8 py-4 rounded-xl shadow-lg transform transition-all hover:scale-105"
      >
        Try Again? 🔄
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import confetti from "canvas-confetti";

const emit = defineEmits(["choice-made"]);

const choiceMade = ref(false);
const userChoice = ref(null);

const handleChoice = async (choice) => {
  choiceMade.value = true;
  userChoice.value = choice;

  // Trigger confetti for YES
  if (choice === "yes") {
    triggerConfetti();
  }

  // Send to backend API
  try {
    await axios.post("http://localhost:8000/api/proposal/choice", {
      choice: choice,
    });
    console.log("Choice saved to database!");
  } catch (error) {
    console.error("Failed to save choice:", error);
  }

  emit("choice-made", choice);
};

const resetChoice = () => {
  choiceMade.value = false;
  userChoice.value = null;
};

const triggerConfetti = () => {
  const duration = 3 * 1000;
  const end = Date.now() + duration;

  const colors = ["#ff69b4", "#ff1493", "#ff69b4"];

  const frame = () => {
    confetti({
      particleCount: 2,
      angle: 60,
      spread: 55,
      origin: { x: 0 },
      colors: colors,
    });
    confetti({
      particleCount: 2,
      angle: 120,
      spread: 55,
      origin: { x: 1 },
      colors: colors,
    });

    if (Date.now() < end) {
      requestAnimationFrame(frame);
    }
  };

  frame();
};
</script>
