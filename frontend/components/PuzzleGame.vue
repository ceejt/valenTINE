<template>
  <div class="max-w-4xl w-full">
    <h2 class="text-center text-2xl font-bold text-rose-900 mb-4">
      Arrange the pieces in the correct order!
    </h2>
    <p class="text-center text-sm text-rose-700 mb-6">
      Drag pieces to the box above. Click placed pieces to remove them.
    </p>

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
          @click="removePiece(piece)"
          class="bg-paper-dark px-6 py-4 shadow-lg border-2 border-rose-200 torn-edge paper-texture cursor-pointer hover:border-rose-400 transition-colors"
          :style="{ transform: `rotate(${piece.rotation}deg)` }"
          title="Click to remove"
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
const emit = defineEmits(["solved"]);

// Puzzle pieces with correct order
const pieces = ref([
  { id: 1, text: "Will", rotation: -5, placed: false, correctOrder: 0 },
  { id: 2, text: "You", rotation: 3, placed: false, correctOrder: 1 },
  { id: 3, text: "Be", rotation: -2, placed: false, correctOrder: 2 },
  { id: 4, text: "My", rotation: 4, placed: false, correctOrder: 3 },
  { id: 5, text: "MVP", rotation: -3, placed: false, correctOrder: 4 },
  { id: 6, text: "This", rotation: 2, placed: false, correctOrder: 5 },
  { id: 7, text: "Valentine's?", rotation: -4, placed: false, correctOrder: 6 },
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

// Track placed pieces in order
const placedPiecesOrder = ref([]);

// Currently dragging piece
const draggedPiece = ref(null);

// Computed properties
const placedPieces = computed(() => {
  // Return pieces in the order they were placed
  return placedPiecesOrder.value.map((id) =>
    pieces.value.find((p) => p.id === id),
  );
});

const availablePieces = computed(() => pieces.value.filter((p) => !p.placed));

const isSolved = computed(() => {
  if (placedPiecesOrder.value.length !== pieces.value.length) return false;

  // Check if pieces are in correct order
  return placedPiecesOrder.value.every((pieceId, index) => {
    const piece = pieces.value.find((p) => p.id === pieceId);
    return piece.correctOrder === index;
  });
});

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
    placedPiecesOrder.value.push(draggedPiece.value.id);
    draggedPiece.value = null;
  }
};

// Allow removing pieces (click to remove)
const removePiece = (piece) => {
  piece.placed = false;
  const index = placedPiecesOrder.value.indexOf(piece.id);
  if (index > -1) {
    placedPiecesOrder.value.splice(index, 1);
  }
};
</script>
