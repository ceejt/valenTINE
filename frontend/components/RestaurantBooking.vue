<template>
  <div class="text-center max-w-3xl w-full">
    <!-- Initial Booking Screen -->
    <div v-if="!showSignature && !isConfirmed" class="space-y-8">
      <h1 class="text-5xl font-bold text-rose-900 mb-4">Date night!</h1>
      <p class="text-2xl text-rose-700 mb-8">
        Book a reservation at your favorite restaurant!
      </p>

      <!-- Fake Restaurant Selection -->
      <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-8 shadow-2xl">
        <label class="block text-lg font-semibold text-rose-900 mb-4">
          Choose a restaurant:
        </label>

        <!-- The "Choice" Buttons (All lead to Pat & Pat) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
          <button
            v-for="restaurant in fakeRestaurants"
            :key="restaurant.id"
            @click="selectRestaurant(restaurant)"
            class="p-6 border-3 border-rose-300 rounded-xl hover:border-rose-500 hover:bg-rose-50 transition-all transform hover:scale-105 active:scale-95"
          >
            <img
              :src="restaurant.image"
              :alt="restaurant.name"
              class="w-24 h-24 object-cover rounded-full mx-auto mb-2 border-2 border-rose-300"
            />
            <div class="font-bold text-lg text-rose-900">
              {{ restaurant.name }}
            </div>
            <div class="text-sm text-rose-600">{{ restaurant.tagline }}</div>
          </button>
        </div>
        <div
          v-if="infoMessage"
          class="mb-4 text-lg text-rose-700 font-semibold animate-pulse"
        >
          {{ infoMessage }}
        </div>

        <!-- Selected Restaurant Display -->
        <div
          v-if="selectedRestaurant"
          class="mt-8 p-6 bg-gradient-to-r from-rose-100 to-pink-100 rounded-xl border-2 border-rose-400 animate-bounce"
        >
          <p class="text-2xl font-bold text-rose-900 mb-2">
            Perfect choice, babyy koooo!
          </p>
          <p class="text-xl text-rose-800">
            {{ selectedRestaurant.name }}
          </p>
          <p class="text-sm text-rose-600 mt-2">
            {{ selectedRestaurant.address }}
          </p>

          <button
            @click="proceedToSignature"
            class="mt-6 bg-rose-500 hover:bg-rose-600 text-white font-bold text-xl px-12 py-4 rounded-xl shadow-lg transform transition-all hover:scale-105"
          >
            Proceed to Confirmation!
          </button>
        </div>
      </div>
    </div>

    <!-- Signature Screen -->
    <div v-if="showSignature && !isConfirmed" class="space-y-6">
      <h2 class="text-4xl font-bold text-rose-900 mb-4">
        Sign to Confirm Your Reservation!
      </h2>

      <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-8 shadow-2xl">
        <div class="mb-6">
          <p class="text-xl text-rose-800 font-semibold mb-2">
            Pat & Pat Restaurant
          </p>
          <p class="text-sm text-rose-600">
            Capitol Greenstreet, Capitol Hills Dr, Pansol<br />
            Quezon City, 1119 Metro Manila
          </p>
          <p class="text-lg text-rose-700 mt-4">
            Date: <span class="font-bold">This Valentine's Day</span>
          </p>
          <p class="text-lg text-rose-700">
            Time:
            <span class="font-bold">4:00 PM (perfect for sunset!)</span>
          </p>
        </div>

        <!-- Signature Pad -->
        <div class="mb-6">
          <label class="block text-lg font-semibold text-rose-900 mb-4">
            Sign your name to confirm:
          </label>
          <canvas
            ref="signatureCanvas"
            @mousedown="startDrawing"
            @mousemove="draw"
            @mouseup="stopDrawing"
            @mouseleave="stopDrawing"
            @touchstart="startDrawing"
            @touchmove="draw"
            @touchend="stopDrawing"
            class="w-full h-48 border-4 border-rose-300 rounded-xl bg-white cursor-crosshair touch-none"
          ></canvas>

          <div class="flex gap-4 mt-4 justify-center">
            <button
              @click="clearSignature"
              class="bg-gray-400 hover:bg-gray-500 text-white font-semibold px-6 py-2 rounded-lg"
            >
              Clear
            </button>
            <button
              @click="confirmReservation"
              :disabled="!hasSignature"
              :class="[
                'font-bold px-8 py-3 rounded-xl shadow-lg transition-all',
                hasSignature
                  ? 'bg-green-500 hover:bg-green-600 text-white transform hover:scale-105'
                  : 'bg-gray-300 text-gray-500 cursor-not-allowed',
              ]"
            >
              Confirm Reservation!
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Confirmation Success -->
    <div v-if="isConfirmed" class="space-y-6 animate-bounce">
      <div class="text-9xl mb-4">🎊</div>
      <h2 class="text-5xl font-bold text-green-700 mb-4">
        Reservation Confirmed!
      </h2>
      <div
        class="bg-white/90 backdrop-blur-sm rounded-2xl p-8 shadow-2xl max-w-md mx-auto"
      >
        <p class="text-2xl text-rose-800 font-semibold mb-4">
          See you at Pat & Pat!
        </p>
        <p class="text-lg text-rose-700">It's going to be a special night!</p>
        <p class="text-sm text-rose-600 mt-4">
          To more Valentine's together, babyyy!
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed, nextTick } from "vue";

const emit = defineEmits(["reservation-confirmed"]);

const fakeRestaurants = ref([
  {
    id: 1,
    name: "Wildflour QC",
    image: new URL("../assets/restaurants/wildflour.jpg", import.meta.url).href,
    tagline: "Elegant dining experience (FULLY-BOOKED!)",
    actualRestaurant: "Pat & Pat",
  },
  {
    id: 2,
    name: "Caffe Allor Ristorante",
    image: new URL("../assets/restaurants/allor.jpg", import.meta.url).href,
    tagline: "Unique, aesthethic, IG-worthy. (FULLY-BOOKED!)",
    actualRestaurant: "Pat & Pat",
  },
  {
    id: 3,
    name: "Sable",
    image: new URL("../assets/restaurants/sable.jpg", import.meta.url).href,
    tagline: "2-storey, unique cafe (Minimal dining options)",
    actualRestaurant: "Pat & Pat",
  },
  {
    id: 4,
    name: "Pat & Pat",
    image: new URL("../assets/restaurants/patpat.jpg", import.meta.url).href,
    tagline: "Tagaytay-like experience in QC!",
    actualRestaurant: "Pat & Pat",
  },
]);

const selectedRestaurant = ref(null);
const infoMessage = ref("");
const showSignature = ref(false);
const isConfirmed = ref(false);

// Signature pad
const signatureCanvas = ref(null);
const isDrawing = ref(false);
const hasSignature = ref(false);
let ctx = null;

onMounted(() => {
  if (signatureCanvas.value) {
    ctx = signatureCanvas.value.getContext("2d");
    const canvas = signatureCanvas.value;
    canvas.width = canvas.offsetWidth;
    canvas.height = canvas.offsetHeight;
    ctx.strokeStyle = "#000000";
    ctx.lineWidth = 2;
    ctx.lineCap = "round";
  }
});

const selectRestaurant = (restaurant) => {
  infoMessage.value = "";
  if (restaurant.name === "Pat & Pat") {
    selectedRestaurant.value = {
      name: "Pat & Pat Restaurant",
      address:
        "Capitol Greenstreet, Capitol Hills Dr, Pansol, Quezon City, 1119 Metro Manila",
      image: new URL("../assets/restaurants/patpat.jpg", import.meta.url).href,
    };
  } else if (restaurant.name === "Sable") {
    infoMessage.value =
      "Sable is a great place for coffee and snacks, but not ideal for dinner/date nights. Still, a solid choice for a cozy cafe!";
    selectedRestaurant.value = null;
  } else {
    infoMessage.value = `${restaurant.name} is fully-booked for Valentine's! Please choose another restaurant.`;
    selectedRestaurant.value = null;
  }
};

const proceedToSignature = async () => {
  showSignature.value = true;

  await nextTick();
  if (signatureCanvas.value) {
    ctx = signatureCanvas.value.getContext("2d");
    const canvas = signatureCanvas.value;

    canvas.width = canvas.offsetWidth;
    canvas.height = canvas.offsetHeight;

    ctx.strokeStyle = "#000000";
    ctx.lineWidth = 3;
    ctx.lineCap = "round";
    ctx.lineJoin = "round";
  }
};

// Signature drawing functions
const getCoordinates = (e) => {
  const canvas = signatureCanvas.value;
  const rect = canvas.getBoundingClientRect();

  if (e.touches) {
    return {
      x: e.touches[0].clientX - rect.left,
      y: e.touches[0].clientY - rect.top,
    };
  }
  return {
    x: e.clientX - rect.left,
    y: e.clientY - rect.top,
  };
};

const startDrawing = (e) => {
  e.preventDefault();
  isDrawing.value = true;
  const coords = getCoordinates(e);
  ctx.beginPath();
  ctx.moveTo(coords.x, coords.y);
  ctx.strokeStyle = "#000000";
};

const draw = (e) => {
  e.preventDefault();
  if (!isDrawing.value) return;

  hasSignature.value = true;
  const coords = getCoordinates(e);
  ctx.lineTo(coords.x, coords.y);
  ctx.stroke();
  ctx.strokeStyle = "#000000";
};

const stopDrawing = () => {
  isDrawing.value = false;
};

const clearSignature = () => {
  const canvas = signatureCanvas.value;
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  ctx.strokeStyle = "#000000";
  hasSignature.value = false;
};

const confirmReservation = async () => {
  if (!hasSignature.value) return;

  isConfirmed.value = true;

  // Trigger confetti
  triggerConfetti();

  const reservationData = {
    restaurant: "Pat & Pat Restaurant",
    location: "Capitol Greenstreet, Capitol Hills Dr, Pansol, Quezon City",
    signature: signatureCanvas.value.toDataURL(),
  };

  // Send to backend API
  try {
    const config = useRuntimeConfig();
    await $fetch(`${config.public.apiUrl}/api/proposal/reservation`, {
      method: "POST",
      body: reservationData,
    });
    console.log("Reservation saved to database!");
  } catch (error) {
    console.error("Failed to save reservation:", error);
  }

  // Emit event to parent
  emit("reservation-confirmed", reservationData);
};

const triggerConfetti = () => {
  if (process.client) {
    import("canvas-confetti").then((confetti) => {
      const duration = 3 * 1000;
      const end = Date.now() + duration;
      const colors = ["#ff69b4", "#ff1493", "#ffd700"];

      const frame = () => {
        confetti.default({
          particleCount: 3,
          angle: 60,
          spread: 55,
          origin: { x: 0 },
          colors: colors,
        });
        confetti.default({
          particleCount: 3,
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

<style scoped>
.touch-none {
  touch-action: none;
}
</style>
