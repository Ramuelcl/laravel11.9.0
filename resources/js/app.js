// resources/js/app.js
// import './bootstrap';  // Importa el archivo de configuración de bootstrap (si lo usas)
// import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Alpine from 'alpinejs'; // Importa Alpine.js

window.Alpine = Alpine; // Asigna Alpine a la ventana global para que esté accesible en tu app

Alpine.start();  // Inicializa Alpine.js

