import conf from './config.js';

async function loadSpectacle(url) {
    return fetch(url).catch(error => {
        console.error('Erreur lors de la récupération du spectacle');
    });
}

async function loadSoiree(url) {
    return fetch(url).catch(error => {
        console.error('Erreur lors de la récupération de la soirée');
    });
}

async function loadAllSpectacles(url) {
    return fetch(url).catch(error => {
        console.error('Erreur lors de la récupération de la liste des spectacles');
    });
}

async function loadSpectacleBySoiree(url){
    return fetch(url).catch(error=>{
        console.error('Erreur de la récupération de la liste des spectacles')
    })
}

export default {loadSoiree, loadSpectacle, loadAllSpectacles};