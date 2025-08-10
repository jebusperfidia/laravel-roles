// resources/js/app.js
//PowerGrid
import "./../../vendor/power-components/livewire-powergrid/dist/powergrid";
//Toaster
import '../../vendor/masmerise/livewire-toaster/resources/js'; //


Alpine.plugin(Toaster); // 👈

window.Alpine = Alpine;
Alpine.start();

setTimeout(() => {
    const alerta = document.getElementById("alerta");
    if (alerta) {
        alerta.style.transition = "opacity 0.5s ease";
        alerta.style.opacity = "0";
        setTimeout(() => alerta.remove(), 500);
    }
}, 3000); // 3 segundos
