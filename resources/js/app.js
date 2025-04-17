import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Fonction pour afficher ou masquer le menu déroulant
function toggleDropdown(id) {
    const dropdown = document.getElementById(id);
    if (dropdown) {
        dropdown.classList.toggle('hidden'); // Masque ou affiche l'élément
    } else {
        console.error(`Dropdown with ID "${id}" not found.`);
    }
}

// Rendez la fonction accessible globalement si elle est appelée dans le HTML
window.toggleDropdown = toggleDropdown;