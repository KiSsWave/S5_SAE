import loader from "./js/loader";
import soiree_ui from "./js/soiree_ui";
import allSpectacle_ui from "./js/allSpectacle_ui";

function getSoiree(url){
    loader.loadSoiree(url).then(data => {
        data.json().then(async data => {
            console.log(data.Soiree);
            await soiree_ui.displaySoiree(data.Soiree);
        }); 
    });
}

function getAllSpectacles(url){
    loader.loadAllSpectacles(url).then(data => {
        data.json().then(async data => {
            console.log(data.Spectacles);
            await allSpectacle_ui.displayAllSpectacles(data.Spectacles);
        }); 
    });
}

//getSoiree('http://localhost:42050/soiree/S1');
getAllSpectacles('http://localhost:42050/spectacles');