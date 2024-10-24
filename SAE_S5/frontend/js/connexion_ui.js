import conf from "./config";
import Handlebars from "handlebars";

function displayConnexion() {
    const container = document.getElementById('main');
    const templateSource = document.getElementById("connexion-template").innerHTML;
    const template = Handlebars.compile(templateSource)
    let html = template();
    container.innerHTML = html;

    const form = document.getElementById('connexion-form');
    form.addEventListener('submit', function(event){
        event.preventDefault();
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        fetch(conf.url + '/signin', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({email, password})
        }).then(response => {
            if(response.status === 200){
                response.json().then(data => {
                    localStorage.setItem('token', data.token);
                    window.location.href = '/index.html';
                });
            } else {
                alert('Email ou mot de passe incorrect');
            }
        });
    });
}

export default {displayConnexion};