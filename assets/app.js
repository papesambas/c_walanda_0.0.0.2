import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */

// Importations communes
import 'bootstrap/dist/css/bootstrap.min.css'; // Import du CSS de Bootstrap
import 'bootstrap'; // Import du JavaScript de Bootstrap
import '@popperjs/core'; // Import de Popper.js (requis par Bootstrap)

// Initialisation de Bootstrap (si nécessaire)
import { Alert, Dropdown } from 'bootstrap';
import * as bootstrap from 'bootstrap'; // Importation complète de Bootstrap

// Exemple d'utilisation de Bootstrap
document.addEventListener('DOMContentLoaded', () => {
    // Initialiser un dropdown Bootstrap
    const dropdownElementList = document.querySelectorAll('.dropdown-toggle');
    const dropdownList = [...dropdownElementList].map(dropdownToggleEl => new bootstrap.Dropdown(dropdownToggleEl));
});

// Highlight.js (optionnel)
import hljs from 'highlight.js/lib/core';
import javascript from 'highlight.js/lib/languages/javascript';
import '@fortawesome/fontawesome-free/css/all.min.css';

hljs.registerLanguage('javascript', javascript);
hljs.highlightAll();

//import "./vendor/toastr/toastr.min.js"; // Import du script
//import "./vendor/toastr/toastr.min.css"; // Import du CSS

// Configuration de Toastr (facultatif)
//toastr.options = {
//    closeButton: true,
//    progressBar: true,
//    positionClass: "toast-top-right",
//    timeOut: "3000",
//};


// Import des styles Sass (optionnel)
import './styles/app.scss';
//import './scripts/select2.js';
//import './scripts/eleves.js';
//import './scripts/checkbox.js';
//import './scripts/sante.js';
//import './scripts/deleteDoc.js';
//import './scripts/anneeScolaire.js';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');