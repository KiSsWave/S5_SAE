import Handlebars from "handlebars";
function displayVisiteurNonCo() {
    const navbar = document.getElementById('navbar');
    const templateSource = document.getElementById("visiteur-template");
    const template = Handlebars.compile(templateSource);
    let html = template();
}

function displayVisiteurCo() {
    const navbar = document.getElementById('navbar');
    navbar.innerHTML = ` `;
    if (localStorage.getItem('token') != null) {
        navbar.innerHTML = `<li>
                    <p href="index.html" type="button" id="accueil"> <i class="fa-solid fa-house"></i> | Accueil</p>
                </li>
                                <li>
                    <p href="index.html" type="button" id="panier"> <i class="fa-solid fa-cart-shopping"></i> | Panier</p>
                </li>
                <li>
                    <p href="index.html" type="button" id="deconnexion"> <i class="fa-solid fa-right-from-bracket"> </i>|
                        Deconnexion</p>
                </li>`;
    }
}

function displayOrganisateurCo() {
    const navbar = document.getElementById('navbar');
    nabar.innerHTML = ` `;
    if (localStorage.getItem('token') != null) {
        navbar.innerHTML = `<li>
                    <p href="index.html" type="button" id="accueil"> <i class="fa-solid fa-house"></i> | Accueil</p>
                </li>
                <p href="index.html" type="button" id="deconnexion"> <i class="fa-solid fa-right-from-bracket"> </i>|
                        Deconnexion</p>
                </li>`;
    }
}

export default {displayOrganisateurCo,displayVisiteurCo,displayVisiteurNonCo}