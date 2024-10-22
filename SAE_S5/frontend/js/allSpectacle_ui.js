import Handlebars from "handlebars";
import conf from './config.js';

async function displayAllSpectacles(Spectacles) {
    const container = document.getElementById('main');
    const templateSource = document.getElementById("liste-spectacle-template").innerHTML;
    const template = Handlebars.compile(templateSource)
    let html = template({Spectacles});
    container.innerHTML = html;
}

export default {displayAllSpectacles};