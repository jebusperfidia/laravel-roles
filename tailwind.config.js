/** @type {import('tailwindcss').Config} */
module.exports = {
    // Rutas donde Tailwind debe buscar clases
    content: [
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js",
        "./vendor/ramonrietdijk/livewire-tables/resources/views/**/*.blade.php",
        "./vendor/masmerise/livewire-toaster/resources/views/*.blade.php",
    ],

    theme: {
        extend: {},
    },


    plugins: [
        // Estilos oficiales para la plantilla default de Livewire-Tables
        require("livewire-tables/dist/tailwind"),
       /*  require("livewire-toaster/plugin"), */
    ],
};
