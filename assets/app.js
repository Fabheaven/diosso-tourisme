import './styles/app.css';
//activation du choix de la langue

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


// Le menu humburger
const humberger = document.getElementById("humburger");
humberger.addEventListener("click", (e) =>{
    const nav = document.querySelector("nav ul");
    nav.classList.toggle('open')
})

// connect-buttons
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
