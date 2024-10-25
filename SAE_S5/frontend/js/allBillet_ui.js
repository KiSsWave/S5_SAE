import conf from "./config";
import Handlebars from "handlebars";

function displayAllBillet(data) {
    let container = document.getElementById('main');
    let templateSource = document.getElementById("liste-billet-template").innerHTML;
    let template = Handlebars.compile(templateSource);
    let html = template(data);
    container.innerHTML = html;
}

export default {displayAllBillet};