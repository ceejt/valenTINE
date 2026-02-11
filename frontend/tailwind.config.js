/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx}"],
  theme: {
    extend: {
      colors: {
        paper: "#fef9f3",
        "paper-dark": "#f5ebe0",
      },
      boxShadow: {
        paper: "inset 0 2px 4px rgba(0,0,0,0.06)",
        "paper-deep": "0 10px 25px rgba(0,0,0,0.15)",
      },
      animation: {
        float: "float 3s ease-in-out infinite",
        wiggle: "wiggle 0.5s ease-in-out",
      },
      keyframes: {
        float: {
          "0%, 100%": { transform: "translateY(0px)" },
          "50%": { transform: "translateY(-10px)" },
        },
        wiggle: {
          "0%, 100%": { transform: "rotate(-3deg)" },
          "50%": { transform: "rotate(3deg)" },
        },
      },
    },
  },
  plugins: [],
};
