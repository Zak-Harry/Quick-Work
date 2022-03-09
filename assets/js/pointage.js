const app = {
    apiRootUrl: 'http://localhost:8080/',
    /**
     * Méthode init
     */
    init: function() {
        console.log("init");
        const startShiftElement = document.getElementById('#startShift');
        startShiftElement.addEventListener('click', app.handleStartShift);

        const startLunchElement = document.getElementById('#startLunch');
        startLunchElement.addEventListener('click', app.handleStartLunch);

        const endLunchElement = document.getElementById('#endLunch');
        endLunchElement.addEventListener('click', app.handleEndLunch);

        const endShiftElement = document.getElementById('#endShift');
        endShiftElement.addEventListener('click', app.handleEndShift);
        
    },
    
    // handle START SHIFT
    handleStartShift: function(evt) {

        console.log('bouton cliqué - début journée');

        const d = new Date();
        let hour = d.getUTCHours();
        let minutes = d.getUTCMinutes();

        const httpHeaders = new Headers();
        httpHeaders.append("Content-Type", "application/json");

        const fetchOptions = {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            headers: httpHeaders,
            body: 'startShift'
        };

        fetch(app.apiRootUrl + 'log/startshift' , fetchOptions)
        .then(
            function(response) {
               
                // Si HTTP status code à 200 => OK
                if (response.status == 200) {        
                    // On modifie le texte du <button> avec la date
                    startShiftElement.textContent = hour + 'h' + minutes; 
                    return response;                    
                }
                else {
                    alert('La modification a échoué');
                }
            }
        )
    },

     // handle START LUNCH
     handleStartLunch: function(evt) {

        console.log('bouton cliqué - début repas');

        const d = new Date();
        let hour = d.getUTCHours();
        let minutes = d.getUTCMinutes();

        const httpHeaders = new Headers();
        httpHeaders.append("Content-Type", "application/json");

        const fetchOptions = {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            headers: httpHeaders,
            body: 'startLunch'
        };

        fetch(app.apiRootUrl + 'log/startlunch' , fetchOptions)
        .then(
            function(response) {
               
                // Si HTTP status code à 200 => OK
                if (response.status == 200) {        
                    // On modifie le texte du <button> avec la date
                    startLunchElement.textContent = hour + 'h' + minutes; 
                    return response;                    
                }
                else {
                    alert('La modification a échoué');
                }
            }
        )
    },

     // handle END LUNCH
     handleEndLunch: function(evt) {

        console.log('bouton cliqué - fin repas');

        const d = new Date();
        let hour = d.getUTCHours();
        let minutes = d.getUTCMinutes();

        const httpHeaders = new Headers();
        httpHeaders.append("Content-Type", "application/json");

        const fetchOptions = {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            headers: httpHeaders,
            body: 'endLunch'
        };

        fetch(app.apiRootUrl + 'log/endlunch' , fetchOptions)
        .then(
            function(response) {
               
                // Si HTTP status code à 200 => OK
                if (response.status == 200) {        
                    // On modifie le texte du <button> avec la date
                    endLunchElement.textContent = hour + 'h' + minutes; 
                    return response;                    
                }
                else {
                    alert('La modification a échoué');
                }
            }
        )
    },

     // handle END SHIFT
     handleStartShift: function(evt) {

        console.log('bouton cliqué - fin journée');

        const d = new Date();
        let hour = d.getUTCHours();
        let minutes = d.getUTCMinutes();

        const httpHeaders = new Headers();
        httpHeaders.append("Content-Type", "application/json");

        const fetchOptions = {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            headers: httpHeaders,
            body: 'endShift'
        };

        fetch(app.apiRootUrl + 'log/endshift' , fetchOptions)
        .then(
            function(response) {
               
                // Si HTTP status code à 200 => OK
                if (response.status == 200) {        
                    // On modifie le texte du <button> avec la date
                    endShiftElement.textContent = hour + 'h' + minutes; 
                    return response;                    
                }
                else {
                    alert('La modification a échoué');
                }
            }
        )
    }

};
// On veut exécuter la méthode init de l'objet app au chargement de la page
document.addEventListener('DOMContentLoaded', app.init);