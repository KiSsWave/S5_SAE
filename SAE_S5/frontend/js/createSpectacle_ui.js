import conf from "./config";
import Handlebars from "handlebars";

async function displayCreateSpectacle() {
    const container = document.getElementById('main');
    const templateSource = document.getElementById("add-spectacle-template").innerHTML;
    const template = Handlebars.compile(templateSource)
    let html = template();
    container.innerHTML = html;

    const form = document.getElementById('create-spectacle-form');
    form.addEventListener('submit', function(event){
        event.preventDefault();
        const titre = document.getElementById('titre').value;
        const description = document.getElementById('description').value;
        const date = document.getElementById('date').value;
        const heure = document.getElementById('horaire').value;
        let horaire = date + ' ' + heure+':00';
        const style = document.getElementById('style').value;
        const urlVideo = document.getElementById('urlvideo').value;
        const images = "zakkudorett.jpg";
        fetch(conf.url + '/spectacle', {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({titre, description, style, urlVideo, images, horaire})
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