<template>
  <div class="text-center max-w-2xl w-full">
    <!-- Message -->
    <div v-if="!choiceMade" class="mb-12">
      <h1 class="text-5xl font-bold text-rose-900 mb-4">
        To my Tine babyyy, will you be my valenTINE? 🥹💐
      </h1>
      <p class="text-xl text-rose-700">
        don't choose tomato pls it doesn't work!!!!
      </p>
    </div>

    <!-- Emoji Input -->
    <div v-if="!choiceMade" class="mb-12">
      <div
        class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-2xl max-w-md mx-auto"
      >
        <label class="block text-lg font-semibold text-rose-900 mb-4">
          Type your answer:
        </label>
        <input
          v-model="emojiInput"
          @input="handleEmojiInput"
          type="text"
          placeholder="🧸 or 🍅"
          class="w-full text-6xl text-center py-6 px-4 rounded-xl border-4 border-rose-300 focus:border-rose-500 focus:outline-none focus:ring-4 focus:ring-rose-200 transition-all"
          maxlength="2"
        />
        <p class="mt-4 text-sm text-rose-600">🧸 = Yes | 🍅 = No</p>
      </div>
    </div>

    <!-- YES Response -->
    <div v-if="choiceMade && userChoice === 'yes'" class="animate-bounce">
      <div class="text-9xl mb-4">🧸</div>
      <h2 class="text-4xl font-bold text-green-700 mb-2">Yeyyy!</h2>
      <p class="text-2xl text-green-600">
        I give you hugs and kisses naaaa!!!!
      </p>
    </div>

    <!-- NO Response -->
    <div v-if="choiceMade && userChoice === 'no'" class="animate-wiggle">
      <div class="text-9xl mb-4">🍅</div>
      <h2 class="text-4xl font-bold text-red-700 mb-4">Babyyy NOOOO!</h2>
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
const emit = defineEmits(["choice-made"]);
const config = useRuntimeConfig();

const choiceMade = ref(false);
const userChoice = ref(null);
const emojiInput = ref("");

const handleEmojiInput = () => {
  const input = emojiInput.value.trim();

  // Check for teddy bear emoji (yes)
  if (input === "🧸") {
    handleChoice("yes");
  }
  // Check for tomato emoji (no)
  else if (input === "🍅") {
    handleChoice("no");
  }
};

const handleChoice = async (choice) => {
  choiceMade.value = true;
  userChoice.value = choice;

  // Trigger confetti for YES
  if (choice === "yes") {
    triggerConfetti();
  }

  // Send to backend API
  try {
    await $fetch(`${config.public.apiUrl}/api/proposal/choice`, {
      method: "POST",
      body: { choice },
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
  emojiInput.value = "";
};

const triggerConfetti = () => {
  // Only run on client side
  if (process.client) {
    import("canvas-confetti").then((confetti) => {
      const duration = 3 * 1000;
      const end = Date.now() + duration;
      const colors = ["#ff69b4", "#ff1493", "#ff69b4"];

      const frame = () => {
        confetti.default({
          particleCount: 2,
          angle: 60,
          spread: 55,
          origin: { x: 0 },
          colors: colors,
        });
        confetti.default({
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
    });
  }
};
</script>
