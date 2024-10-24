import Handlebars from "handlebars";
function displayVisiteurNonCo() {
    const navbar = document.getElementById('headerNav');
    const templateSource = document.getElementById("visiteur-template").innerHTML;
    const template = Handlebars.compile(templateSource);
    let html = template();
    navbar.innerHTML=html;
}

function displayVisiteurCo() {
    const navbar = document.getElementById('headerNav');
    const templateSource = document.getElementById("utilisateur-template").innerHTML;
    const template = Handlebars.compile(templateSource);
    navbar.innerHTML = ` `;
    let html = template();
    navbar.innerHTML=html;
}

function displayOrganisateurCo() {
    const navbar = document.getElementById('headerNav');
    const templateSource = document.getElementById("organisateur-template").innerHTML;
    const template = Handlebars.compile(templateSource);
    navbar.innerHTML = ` `;
    let html = template();
    navbar.innerHTML=html;
}


export default {displayOrganisateurCo,displayVisiteurCo,displayVisiteurNonCo}