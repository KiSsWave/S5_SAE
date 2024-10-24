import loader from "./js/loader";
import soiree_ui from "./js/soiree_ui";
import allSpectacle_ui from "./js/allSpectacle_ui";
import conf from "./js/config";
import connexion_ui from "./js/connexion_ui";
import inscription_ui from "./js/inscription_ui";

function getSoiree(url){
    loader.loadSoiree(url).then(data => {
        data.json().then(async data => {
            await soiree_ui.displaySoiree(data.Soiree);
        }); 
    });
}

function getAllSpectacles(url, filter = '', value = ''){

    let styles = []
    let dates = []
    let lieux = []
    styles.push('Aucun');
    dates.push('Aucun');
    lieux.push('Aucun');

    loader.loadAllSpectacles(url, filter, value).then(data => {
        data.json().then(async data => {

            data.Spectacles.sort((a, b) => a.Horaire.localeCompare(b.Horaire));
            await allSpectacle_ui.displayAllSpectacles(data.Spectacles);

            if(filter == 'none')
                {
                    document.querySelector('#filter-value-container').classList.add('hide');
                }

            document.querySelectorAll('.spectacle').forEach(spectacle => {
                spectacle.addEventListener('click', () => {
                    getSoiree(spectacle.getAttribute('data-url'));
                });
            });

            document.querySelector('#choose-filter').value = filter;
            


            document.querySelector('#choose-filter').addEventListener('input', () => {
                if(document.querySelector('#choose-filter').value == 'none')
                {
                    document.querySelector('#filter-value-container').classList.add('hide');
                    if(value != '')
                        getAllSpectacles(url, document.querySelector("#choose-filter").value, '');
                } else {
                    document.querySelector('#filter-value-container').classList.remove('hide');
                    if(document.querySelector('#choose-filter').value == 'style'){
                        document.querySelector('#filter-value').innerHTML = '';
                        styles.forEach(style => {
                            let option = document.createElement('option');
                            option.value = style;
                            option.innerHTML = style;
                            document.querySelector('#filter-value').appendChild(option);
                        });
                    } else if(document.querySelector('#choose-filter').value == 'date'){
                        document.querySelector('#filter-value').innerHTML = '';
                        dates.forEach(date => {
                            let option = document.createElement('option');
                            option.value = date;
                            option.innerHTML = date;
                            document.querySelector('#filter-value').appendChild(option);
                    });

                    } else if(document.querySelector('#choose-filter').value == 'lieu'){
                        document.querySelector('#filter-value').innerHTML = '';
                        lieux.forEach(lieu => {
                            let option = document.createElement('option');
                            option.value = lieu;
                            option.innerHTML = lieu;
                            document.querySelector('#filter-value').appendChild(option);
                        });
                    }
                }
            });


            document.querySelector('#filter-value').addEventListener('input', () => {
                if(document.querySelector('#filter-value').value != 'Aucun')
                {
                    getAllSpectacles(url, document.querySelector("#choose-filter").value, document.querySelector('#filter-value').value);
                } else {
                    getAllSpectacles(url, document.querySelector("#choose-filter").value, '');
                }
            });

            
            
        }); 
    });

    loader.loadAllSpectacles(url).then(dataAll => {
        dataAll.json().then(async dataAll => {
            dataAll.Spectacles.forEach(spectacle => {
                if(!styles.includes(spectacle.Style)){
                    styles.push(spectacle.Style);
                }
            });

            dataAll.Spectacles.forEach(spectacle => {
                if(!dates.includes(spectacle.Date)){
                    dates.push(spectacle.Date);
                }
            });

            dataAll.Spectacles.forEach(spectacle => {
                loader.loadSoiree(conf.url + spectacle.SoireeAssociee.href).then(data => {
                    data.json().then(data => {
                        if(!lieux.includes(data.Soiree.Lieu.Nom)){
                            lieux.push(data.Soiree.Lieu.Nom);
                        }
                    });
                });
            });

            if(filter == 'style'){
                document.querySelector('#filter-value').innerHTML = '';
                styles.forEach(style => {
                    let option = document.createElement('option');
                    option.value = style;
                    option.innerHTML = style;
                    document.querySelector('#filter-value').appendChild(option);
                });
                document.querySelector('#filter-value').value = value;
            } else if(filter == 'date'){
                document.querySelector('#filter-value').innerHTML = '';
                dates.forEach(date => {
                    let option = document.createElement('option');
                    option.value = date;
                    option.innerHTML = date;
                    document.querySelector('#filter-value').appendChild(option);
                });
                document.querySelector('#filter-value').value = value;
            } else if(filter == 'lieu'){
                document.querySelector('#filter-value').innerHTML = '';
                lieux.forEach(lieu => {
                    let option = document.createElement('option');
                    option.value = lieu;
                    option.innerHTML = lieu;
                    document.querySelector('#filter-value').appendChild(option);
                });
                document.querySelector('#filter-value').value = value;
            }
        });
    });
}

function getConnexion(){
    connexion_ui.displayConnexion();
}

function getInscription(){
    inscription_ui.displayInscription();
}

//getSoiree('http://localhost:42050/soiree/S1');
//getAllSpectacles(conf.url + '/spectacles',"none","");

/*if(localStorage.getItem('token') != null){
    getAllSpectacles(conf.url + '/spectacles',"none","");
} else {
    getConnexion();
}*/

//getAllSpectacles(conf.url + '/spectacles',"none","");
getInscription();