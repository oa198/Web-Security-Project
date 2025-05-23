/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.jsx",
    "./resources/**/*.ts",
    "./resources/**/*.tsx",
  ],
  theme: {
    extend: {
      colors: {
        black: "var(--black)",
        darkpurple: "var(--darkpurple)",
        descedent: "var(--descedent)",
        purple: "var(--purple)",
      },
      fontFamily: {
        text: "var(--text-font-family)",
      },
    },
  },
  plugins: [],
}; 