import Handlebars from "handlebars";
import conf from './config.js';
import loader from './loader.js';

async function displaySoiree(Soiree) {

    let spectacles = []; 
    for (const spectacle of Soiree.Spectacles) {
        const loadedSpectacle = await loader.loadSpectacle(conf.url + spectacle);
        spectacles.push(loadedSpectacle);  // Ajoute la valeur au tableau sans écraser
    }

    console.log(spectacles);
    
    const container = document.getElementById('main');
    const templateSource = document.getElementById("soiree-template").innerHTML;
    const template = Handlebars.compile(templateSource)
    let html = template({Soiree : Soiree, spectacles : spectacles});
    container.innerHTML = html;
}

export default {displaySoiree};