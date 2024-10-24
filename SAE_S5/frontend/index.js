import loader from "./js/loader";
import soiree_ui from "./js/soiree_ui";
import allSpectacle_ui from "./js/allSpectacle_ui";

function getSoiree(url){
    loader.loadSoiree(url).then(data => {
        data.json().then(async data => {
            await soiree_ui.displaySoiree(data.Soiree);
        }); 
    });
}

function getAllSpectacles(url){
    loader.loadAllSpectacles(url).then(data => {
        data.json().then(async data => {
            data.Spectacles.sort((a, b) => a.Horaire.localeCompare(b.Horaire));
            await allSpectacle_ui.displayAllSpectacles(data.Spectacles);

            document.querySelectorAll('.spectacle').forEach(spectacle => {
                spectacle.addEventListener('click', () => {
                    getSoiree(spectacle.getAttribute('data-url'));
                });
            });

        }); 
    });
}

//getSoiree('http://localhost:42050/soiree/S1');
getAllSpectacles('http://localhost:42050/spectacles');