import conf from "./config";
import Handlebars from "handlebars";

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
        fetch(conf.url + '/register', {
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
                alert('Email déjà utilisé');
            }
        });
    });
}

export default {displayInscription};