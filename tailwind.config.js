module.exports = {
  content: [
    './templates/**/*.html.twig', // Ajoutez vos fichiers Twig ici
    './assets/**/*.js', // Ajoutez vos fichiers JavaScript ici
    "./node_modules/tw-elements/src/js/**/*.js",
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require("tw-elements/plugin"),
  ],
};