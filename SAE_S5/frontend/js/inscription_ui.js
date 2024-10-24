import conf from "./config";
import Handlebars from "handlebars";
import connexion_ui from "./connexion_ui";

function displayInscription() {
    const container = document.getElementById('main');
    const templateSource = document.getElementById("inscription-template").innerHTML;
    const template = Handlebars.compile(templateSource)
    let html = template();
    container.innerHTML = html;

    const form = document.getElementById('inscription-form');
    form.addEventListener('submit', function(event){
        event.preventDefault();
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const nom = document.getElementById('nom').value;
        const prenom = document.getElementById('prenom').value;
        const numerotel = document.getElementById('numerotel').value;
        const birthdate = document.getElementById('birthdate').value;
        const eligible = document.getElementById('eligible').value;
        const role = 1;
        fetch(conf.url + '/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({email, password, nom, prenom, numerotel, birthdate, eligible, role})
        }).then(response => {
            if(response.status === 200){
                connexion_ui.displayConnexion();
            } else {
                alert('Email déjà utilisé');
            }
        });
    });
}

export default {displayInscription};