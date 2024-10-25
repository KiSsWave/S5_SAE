import conf from "./config";
import Handlebars from "handlebars";

async function displayCreateSpectacle() {
    const container = document.getElementById('main');
    const templateSource = document.getElementById("create-spectacle-template").innerHTML;
    const template = Handlebars.compile(templateSource)
    let html = template();
    container.innerHTML = html;

    const form = document.getElementById('create-spectacle-form');
    form.addEventListener('submit', function(event){
        event.preventDefault();
        const titre = document.getElementById('titre').value;
        const description = document.getElementById('description').value;
        const date = document.getElementById('date').value;
        const heure = document.getElementById('heure').value;
        const style = document.getElementById('style').value;
        fetch(conf.url + '/spectacle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            },
            body: JSON.stringify({titre, description, style, urlvideo, image, date, heure})
        }).then(response => {
            if(response.status === 200){
                window.location.href = '/index.html';
            } else {
                alert('Erreur lors de la création du spectacle');
            }
        });
    });
}

export default {displayCreateSpectacle};