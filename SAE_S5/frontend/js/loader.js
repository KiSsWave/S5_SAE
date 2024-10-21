import conf from './config.js';

async function loadSpectacle(url) {
    return fetch(url).catch(error => {
        console.error('Erreur lors de la récupération du spectacle');
    });
}

