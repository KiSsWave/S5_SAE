import conf from "./config";
import Handlebars from "handlebars";

function displayAllBillet() {
    let container = document.getElementById('main');
    let templateSource = document.getElementById("all-billet-template").innerHTML;
    let template = Handlebars.compile
    let html = template();
    container.innerHTML = html;
}

export default {displayAllBillet};