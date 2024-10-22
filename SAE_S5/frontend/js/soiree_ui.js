import Handlebars from "handlebars";
import conf from './config.js';

async function displaySoiree(Soiree) {
    const container = document.getElementById('main');
    const templateSource = document.getElementById("soiree-template").innerHTML;
    const template = Handlebars.compile(templateSource)
    let html = template({Soiree});
    container.innerHTML = html;
}

export default {displaySoiree};