import loader from "./js/loader";
import soiree_ui from "./js/soiree_ui";
import allSpectacle_ui from "./js/allSpectacle_ui";
import conf from "./js/config";
import connexion_ui from "./js/connexion_ui";
import inscription_ui from "./js/inscription_ui";
import navbar_ui from "./js/navbar_ui";
import createSpectacle_ui from "./js/createSpectacle_ui";

function getSoiree(url){
    let loading = document.createElement('div');
    loading.innerHTML = "<h2>Chargement ...</h2>";
    loading.classList.add('loading');
    document.getElementById('main').appendChild(loading);
    loader.loadSoiree(url).then(data => {
        data.json().then(async data => {
            await soiree_ui.displaySoiree(data.Soiree);

            let button = document.getElementById('add-to-cart');
            let inputTarifReduit = document.getElementById('tarif-reduit');
            let inputTarifPlein = document.getElementById('tarif-normal');     
            let nbPlacesReduites;
            let nbPlacesStandard;     


            let soireeId = data.links.self.href.split('/')[data.links.self.href.split('/').length - 1];

            button.addEventListener('click', () => {
                
                if(inputTarifReduit.value != null && inputTarifReduit.value >= 0){
                    nbPlacesReduites = inputTarifReduit.value;
                } else {
                    nbPlacesReduites = 0;
                } 

                if(inputTarifPlein.value != null && inputTarifPlein.value >= 0){
                    nbPlacesStandard = inputTarifPlein.value;
                } else {
                    nbPlacesStandard = 0;
                }
                let token = localStorage.getItem('token');
                let idsoiree = soireeId;
                let nbplaces = nbPlacesReduites;
                let categorie = 'reduit';
                let montant = data.Soiree.TarifReduit*nbplaces;
                console.log({idsoiree, nbplaces, categorie, montant});
                if(token == null){
                    alert('Vous devez être connecté pour effectuer un achat');
                    getConnexion();
                } else {
                    if(nbPlacesReduites != 0){
                        let url = conf.url + '/create';
                        fetch(url, {
                            method: 'POST',
                            headers: {
                                'Authorization': 'Bearer ' + token,
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({idsoiree, nbplaces, categorie, montant})
                        });

                    }
                    if (nbPlacesStandard != 0){
                        let url = conf.url + '/create';
                        nbplaces = nbPlacesStandard;
                        categorie = 'standard';
                        montant = data.Soiree.Tarif*nbplaces;
                        fetch(url, {
                            method: 'POST',
                            headers: {
                                'Authorization': 'Bearer ' + token,
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({idsoiree, nbplaces, categorie, montant})
                        })
                    } 
                    if(nbPlacesReduites == 0 && nbPlacesStandard == 0){
                        alert('Veuillez renseigner le nombre de places souhaitées');
                    }
                    updateCart();
                }

                
            });

        }); 
    });
}

function updateCart(){
    
    let token = localStorage.getItem('token');
    let url = conf.url + '/panier';
    let cart = document.getElementById('cart-content');
    fetch(url, {
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token,
            'Content-Type': 'application/json',
        }
    }).then(data => {
        
        data.json().then(data => {
            cart.innerHTML = '';
            let total = 0;
            let nomSoiree = '';
            
            data.Panier.forEach(achat => {
                nomSoiree = achat.Soiree;
                let div = document.createElement('div');
                div.classList.add('achat');
                div.innerHTML = `<h3>${nomSoiree}</h3><p>${achat.NbPlaces} place(s), Tarif ${achat.Categorie}</p><p>${achat.Montant} €</p>`;
                total += achat.Montant;
                cart.appendChild(div);
                document.getElementById('cart-total').innerHTML = total;
            });
        });
        
    });
}

function getPaiement(){
    paiement_ui.displayPaiement();
}

function getAllSpectacles(url, filter = '', value = ''){
    let loading = document.createElement('div');
    loading.innerHTML = "<h2>Chargement ...</h2>";
    loading.classList.add('loading');
    document.getElementById('main').appendChild(loading);
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
            }
        });
    });

    loader.loadLieux(conf.url + '/lieux').then(dataLieux => {
        dataLieux.json().then(async dataLieux => {
            dataLieux.Lieux.forEach(lieu => {
                if(!lieux.includes(lieu.Nom)){
                    lieux.push(lieu.Nom);
                }

                if(filter == 'lieu'){
                    document.querySelector('#filter-value').innerHTML = '';
                    lieux.forEach(lieu => {
                        let option = document.createElement('option');
                        option.value = lieu;
                        option.innerHTML = lieu;
                        document.querySelector('#filter-value').appendChild(option);
                    });
                    document.querySelector('#filter-value').value = value;
                }
            }
            );

        });
    });
}

function getConnexion(){
    connexion_ui.displayConnexion();
    document.getElementById('inscription-btn').addEventListener('click', () => {
        getInscription();
    });
}

function getInscription(){
    inscription_ui.displayInscription();
}

function getNavbar(){
    if(localStorage.getItem("token")!=null){
        
        navbar_ui.displayVisiteurCo();
        document.getElementById('accueil').addEventListener('click', () => {
            getAllSpectacles(conf.url + '/spectacles',"none","");
        });
        document.getElementById('deconnexion').addEventListener('click', () => {
            localStorage.removeItem('token');
            window.location.href = '/index.html';
        });
        document.getElementById('panier').addEventListener('click', () => {
            document.getElementById('cart').classList.remove('hide');
        });
        document.getElementById('close-cart').addEventListener('click', () => {
            document.getElementById('cart').classList.add('hide');
        });
    } else {
        navbar_ui.displayVisiteurNonCo();
        document.getElementById('accueil').addEventListener('click', () => {
            getAllSpectacles(conf.url + '/spectacles',"none","");
        });
        document.getElementById('connexion').addEventListener('click', () => {
            getConnexion();
        });
        document.getElementById('inscription').addEventListener('click', () => {
            getInscription();
        });
    }
}

function getCreateSpectacle(){
    createSpectacle_ui.displayCreateSpectacle();
}

getCreateSpectacle();
//getSoiree(conf.url + '/soiree/S001');
getNavbar();
//getAllSpectacles(conf.url + '/spectacles',"none","");
updateCart();




