<template>
  <div class="min-h-screen flex items-center justify-center p-4">
    <!-- Envelope Component -->
    <EnvelopeOpen
      v-if="currentStep === 'envelope'"
      @open="handleEnvelopeOpen"
    />

    <!-- Puzzle Game Component -->
    <PuzzleGame v-if="currentStep === 'puzzle'" @solved="handlePuzzleSolved" />

    <!-- Final Choice Component -->
    <FinalChoice v-if="currentStep === 'choice'" @choice-made="handleChoice" />
  </div>
</template>

<script setup>
import { ref } from "vue";
import EnvelopeOpen from "~/components/EnvelopeOpen.vue";
import PuzzleGame from "~/components/PuzzleGame.vue";
import FinalChoice from "~/components/FinalChoice.vue";

// Track current step in the flow
const currentStep = ref("envelope"); // 'envelope' | 'puzzle' | 'choice'

// Handle envelope opening animation complete
const handleEnvelopeOpen = () => {
  currentStep.value = "puzzle";
};

// Handle puzzle completion
const handlePuzzleSolved = () => {
  currentStep.value = "choice";
};

// Handle final choice (yes/no)
const handleChoice = (choice) => {
  console.log("User chose:", choice);
};
</script>
