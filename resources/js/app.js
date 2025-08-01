
import './bootstrap';  // Importa as configurações do Laravel/Echo/Pusher
import Alpine from 'alpinejs';

window.Alpine = Alpine;  // Registra o Alpine globalmente

Alpine.start();  // Inicializa o Alpine