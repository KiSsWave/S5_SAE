import conf from './config.js';

const token = localStorage.getItem('token');

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

async function loadAllSpectacles(url, filter = '', value = '') {
    if (filter != 'none') {
        url += `?${filter}=${value}`;
    }
    return fetch(url).catch(error => {
        console.error('Erreur lors de la récupération de la liste des spectacles');
    });
}

async function loadSpectacleBySoiree(url){
    return fetch(url).catch(error=>{
        console.error('Erreur de la récupération de la liste des spectacles')
    })
}

async function loadLieux(url){
    return fetch(url).catch(error=>{
        console.error('Erreur de la récupération de la liste des lieux')
    })
}


export default {loadSoiree, loadSpectacle, loadAllSpectacles, loadSpectacleBySoiree, loadLieux};