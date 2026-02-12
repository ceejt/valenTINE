<template>
  <div class="max-w-4xl w-full">
    <h2 class="text-center text-2xl font-bold text-rose-900 mb-8">
      Arrange the pieces to reveal the message! 
    </h2>

    <!-- Drop Zone -->
    <div
      class="relative bg-paper border-4 border-dashed border-rose-300 rounded-lg p-8 min-h-[300px] mb-8"
      @drop="handleDrop"
      @dragover.prevent
      @dragenter.prevent
    >
      <div
        class="flex flex-wrap gap-4 justify-center items-center min-h-[200px]"
      >
        <div
          v-for="piece in placedPieces"
          :key="piece.id"
          class="bg-paper-dark px-6 py-4 shadow-lg border-2 border-rose-200 torn-edge paper-texture"
          :style="{ transform: `rotate(${piece.rotation}deg)` }"
        >
          <span class="text-3xl font-bold text-rose-800">{{ piece.text }}</span>
        </div>
      </div>

      <!-- Success message -->
      <div
        v-if="isSolved"
        class="absolute inset-0 flex items-center justify-center bg-white/90 rounded-lg"
      >
        <div class="text-center">
          <p class="text-4xl mb-4">🎉</p>
          <p class="text-2xl font-bold text-rose-900">Puzzle Complete!</p>
        </div>
      </div>
    </div>

    <!-- Available Pieces -->
    <div class="flex flex-wrap gap-4 justify-center">
      <div
        v-for="piece in availablePieces"
        :key="piece.id"
        draggable="true"
        @dragstart="handleDragStart(piece)"
        class="bg-rose-50 px-6 py-4 shadow-md cursor-move hover:shadow-xl transition-shadow border-2 border-rose-300 torn-edge paper-texture"
        :style="{ transform: `rotate(${piece.rotation}deg)` }"
      >
        <span class="text-3xl font-bold text-rose-800">{{ piece.text }}</span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from "vue";

const emit = defineEmits(["solved"]);

// Puzzle pieces
const pieces = ref([
  { id: 1, text: "Will", rotation: -5, placed: false },
  { id: 2, text: "You", rotation: 3, placed: false },
  { id: 3, text: "Be", rotation: -2, placed: false },
  { id: 4, text: "My", rotation: 4, placed: false },
  { id: 5, text: "MVP?", rotation: -3, placed: false },
]);

// Shuffle pieces initially
const shuffleArray = (arr) => {
  const shuffled = [...arr];
  for (let i = shuffled.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [shuffled[i], shuffled[j]] = [shuffled[j], shuffled[i]];
  }
  return shuffled;
};

pieces.value = shuffleArray(pieces.value);

// Currently dragging piece
const draggedPiece = ref(null);

// Computed properties
const placedPieces = computed(() => pieces.value.filter((p) => p.placed));
const availablePieces = computed(() => pieces.value.filter((p) => !p.placed));
const isSolved = computed(() => pieces.value.every((p) => p.placed));

// Watch for puzzle completion
watch(isSolved, (solved) => {
  if (solved) {
    setTimeout(() => {
      emit("solved");
    }, 1500);
  }
});

// Drag handlers
const handleDragStart = (piece) => {
  draggedPiece.value = piece;
};

const handleDrop = () => {
  if (draggedPiece.value) {
    draggedPiece.value.placed = true;
    draggedPiece.value = null;
  }
};
</script>
