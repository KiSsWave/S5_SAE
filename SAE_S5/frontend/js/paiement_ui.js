import Handlebars from "handlebars";
function displayPaiement() {
    const paiement = document.getElementById('main');
    const templateSource = document.getElementById("paiement-template").innerHTML;
    const template = Handlebars.compile(templateSource);
    let html = template();
    paiement.innerHTML=html;
}





export default {displayPaiement};