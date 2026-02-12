<template>
  <div class="min-h-screen flex items-center justify-center p-4">
    <EnvelopeOpen
      v-if="currentStep === 'envelope'"
      @open="handleEnvelopeOpen"
    />

    <PuzzleGame v-if="currentStep === 'puzzle'" @solved="handlePuzzleSolved" />

    <FinalChoice v-if="currentStep === 'choice'" @choice-made="handleChoice" />

    <RestaurantBooking
      v-if="currentStep === 'restaurant'"
      @reservation-confirmed="handleReservation"
    />
  </div>
</template>

<script setup>
// Track current step in the flow
const currentStep = ref("envelope"); // 'envelope' | 'puzzle' | 'choice' | 'restaurant'

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

  // Only show restaurant booking if YES
  if (choice === "yes" || choice === "🧸") {
    {
      setTimeout(() => {
        currentStep.value = "restaurant";
      }, 3000); // Wait 3 seconds after confetti
    }
  }

  // Handle restaurant reservation confirmation
  const handleReservation = (reservationData) => {
    console.log("Reservation confirmed:", reservationData);
    // Could send to backend API here if needed
  };
};
</script>
