// resources/js/app.js

// 1. bootstrap.js PRIMERO. Es crucial porque inicializa Alpine.
//import "./bootstrap";

// 2. Ahora importa el resto de paquetes de vendor y CSS.
// PowerGrid
import "./../../vendor/power-components/livewire-powergrid/dist/powergrid";
//Toaster
import "../../vendor/masmerise/livewire-toaster/resources/js";

// Leaflet
import "leaflet/dist/leaflet.css";
import L from "leaflet";

// 3. Haz que las librerías importantes sean globales (si es necesario).
//    bootstrap.js ya hace "window.Alpine = Alpine".
window.L = L;

// 4. Registra los plugins de Alpine DESPUÉS de que Alpine exista.
//    Asegúrate de que la variable 'Toaster' esté disponible (la importación de masmerise debería encargarse de ello).
Alpine.plugin(Toaster);

// 5. Inicia Alpine.
Alpine.start();

// 6. Tu lógica personalizada al final.
setTimeout(() => {
    const alerta = document.getElementById("alerta");
    if (alerta) {
        alerta.style.transition = "opacity 0.5s ease";
        alerta.style.opacity = "0";
        setTimeout(() => alerta.remove(), 500);
    }
}, 3000); // 3 segundos
