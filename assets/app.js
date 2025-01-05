import './styles/app.css';

//  Boutons de connexion

document.addEventListener("DOMContentLoaded", function() {
    // Sélectionner les éléments
    const btn = document.querySelector(".btn");
    const singInLink = document.querySelector(".singIn");
    const connectButtons = document.querySelector(".connect-buttons");

    // Fonction pour afficher/masquer la div .connect-buttons
    function toggleConnectButtons() {
        connectButtons.classList.toggle("show");
    }

    // Fonction pour fermer la div .connect-buttons si on clique en dehors
    function closeConnectButtons(event) {
        if (!connectButtons.contains(event.target) && !btn.contains(event.target) && !singInLink.contains(event.target)) {
            connectButtons.classList.remove("show");
        }
    }

    // En mode web : afficher la div connect-buttons au clic sur le bouton
    if (window.innerWidth > 768) {
        btn.addEventListener("click", toggleConnectButtons);
    }

    // En mode responsive : afficher la div connect-buttons au clic sur le lien "Se connecter"
    if (window.innerWidth <= 768) {
        singInLink.addEventListener("click", toggleConnectButtons);
    }

    // Ajouter un écouteur d'événement pour fermer la div lorsque l'utilisateur clique ailleurs
    document.addEventListener("click", closeConnectButtons);
});

// pour le second header après le scroll
document.addEventListener("DOMContentLoaded", ()=>{
    // Quand on commence par scroller
    document.addEventListener("scroll", ()=>{
        const  header = document.querySelector(".sticky-header");
        header.classList.toggle("sticky", window.scrollY > 70)
    })
});

// Le menu hamburger
const humberger = document.getElementById("humburger");
const nav = document.querySelector("nav ul");

// Lorsque le hamburger est cliqué, on toggle la classe 'open' pour afficher/masquer le menu
humberger.addEventListener("click", (e) => {
    nav.classList.toggle('open');
    e.stopPropagation(); // Empêche le clic de se propager et de fermer immédiatement
});

// Lorsque l'utilisateur clique en dehors du menu, on le ferme
document.addEventListener("click", (e) => {
    // Vérifie si le clic est à l'extérieur du menu et du hamburger
    if (!nav.contains(e.target) && !humberger.contains(e.target)) {
        nav.classList.remove('open'); // Ferme le menu
    }
});


//activation du choix de la langue

document.addEventListener("DOMContentLoaded", () => {
    // Sélection uniquement dans .language-switcher
    const languageSwitcher = document.querySelector(".language-switcher");

    if (!languageSwitcher) return; // Si la div n'existe pas, stoppe l'exécution

    const activeLanguage = languageSwitcher.querySelector("#active-language");
    const languageOptions = languageSwitcher.querySelector("#language-options");
    const languageItems = languageOptions.querySelectorAll("a");

    // Fonction pour mettre à jour la langue active
    function updateActiveLanguage(clickedItem) {
        const newLangHTML = clickedItem.innerHTML; // Récupère le contenu HTML
        activeLanguage.innerHTML = newLangHTML; // Met à jour la langue active
        languageOptions.style.display = "none"; // Ferme le menu
    }

    // Gestion des clics sur chaque option de langue
    languageItems.forEach((item) => {
        item.addEventListener("click", (event) => {
            event.preventDefault();
            event.stopPropagation();
            updateActiveLanguage(item);
        });
    });

    // Gestion du clic sur l'élément actif pour ouvrir/fermer le menu
    activeLanguage.addEventListener("click", (event) => {
        event.preventDefault();
        event.stopPropagation();
        const isMenuVisible = languageOptions.style.display === "block";
        languageOptions.style.display = isMenuVisible ? "none" : "block";
    });

    // Ferme le menu si clic en dehors de .language-switcher
    document.addEventListener("click", (event) => {
        if (!event.target.closest(".language-switcher")) {
            languageOptions.style.display = "none";
        }
    });

    // Empêche le clic sur le menu de fermer immédiatement
    languageOptions.addEventListener("click", (event) => {
        event.stopPropagation();
    });
});


// Hero - slides
let list = document.querySelector('.slider .list');
let items = document.querySelectorAll('.slider .list .item');
let dots = document.querySelectorAll('.slider .dots li');
let prev = document.getElementById('prev');
let next = document.getElementById('next');

let active = 0;
let lengthItems = items.length - 1;

// Fonction pour avancer au slide suivant
next.onclick = function () {
    if (active + 1 > lengthItems) {
        active = 0;
    } else {
        active = active + 1;
    }
    reloadSlider();
};

// Fonction pour revenir au slide précédent
prev.onclick = function () {
    if (active - 1 < 0) {
        active = lengthItems;
    } else {
        active = active - 1;
    }
    reloadSlider();
};

// Initialisation de l'autoplay
let refreshSlider = setInterval(() => {
    next.click();
}, 5000);

// Fonction pour recharger le slider
function reloadSlider() {
    // Calcule la position de l'élément actif
    list.style.transform = `translateX(-${active * 100}vw)`; // Active item centered
    
    // Mise à jour des dots
    let lastActiveDot = document.querySelector('.slider .dots li.active');
    if (lastActiveDot) lastActiveDot.classList.remove('active');
    dots[active].classList.add('active');

    // Réinitialise et relance l'autoplay
    clearInterval(refreshSlider);
    refreshSlider = setInterval(() => {
        next.click();
    }, 5000);
}

// Ajout d'écouteurs sur les dots pour la navigation manuelle
dots.forEach((li, key) => {
    li.addEventListener('click', () => {
        active = key;
        reloadSlider();
    });
});

// Arrêter l'autoplay au survol
list.addEventListener('mouseover', () => {
    clearInterval(refreshSlider);
});

// Relancer l'autoplay après le survol
list.addEventListener('mouseout', () => {
    refreshSlider = setInterval(() => {
        next.click();
    }, 5000);
});
