document.addEventListener('DOMContentLoaded', function() {
    var sendEmailsForm = document.getElementById('sendEmailsForm');
    var responseSection = document.getElementById('responseSection');
    var logsSection = document.getElementById('logSection'); // Corrected ID for logs section

    sendEmailsForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent normal form submission
        console.log('Formulaire de relance soumis');

        var formData = new FormData(sendEmailsForm);
        console.log('FormData créé pour le formulaire de relance');

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'send_email.php', true);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                var response = JSON.parse(xhr.responseText);
                console.log('Réponse du serveur reçue', response);
                if (response.success) {
                    responseSection.innerHTML = '<p class="success">' + response.message + '</p>';
                } else {
                    responseSection.innerHTML = '<p class="error">' + response.message + '</p>';
                }
                displayLogs(response.logs);
            } else {
                console.error('Erreur lors de la requête : ' + xhr.status);
                responseSection.innerHTML = '<p class="error">Une erreur est survenue lors de l\'envoi du formulaire.</p>';
            }
        };
        xhr.onerror = function() {
            console.error('Erreur réseau.');
            responseSection.innerHTML = '<p class="error">Erreur réseau lors de l\'envoi du formulaire.</p>';
        };
        xhr.send(formData);
    });

    // Formulaire pour ajouter un client manuellement
    var addClientForm = document.getElementById('addClientForm');
    var addClientResponse = document.getElementById('addClientResponse');

    addClientForm.addEventListener('submit', function(event) {
        event.preventDefault();
        console.log('Formulaire d\'ajout de client soumis');

        var formData = new FormData(addClientForm);
        console.log('FormData créé pour le formulaire d\'ajout de client');

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'send_email.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    console.log('Réponse du serveur reçue', response);
                    if (response.success) {
                        addClientResponse.innerHTML = '<p class="success">' + response.message + '</p>';
                    } else {
                        addClientResponse.innerHTML = '<p class="error">' + response.message + '</p>';
                    }
                    displayLogs(response.logs);
                } catch (error) {
                    console.error('Erreur lors du parsing JSON: ', error);
                    addClientResponse.innerHTML = '<p class="error">Erreur inattendue lors de la réponse du serveur.</p>';
                }
            } else {
                console.error('Erreur lors de la requête : ' + xhr.status);
                addClientResponse.innerHTML = '<p class="error">Une erreur est survenue lors de l\'envoi du formulaire.</p>';
            }
        };

        xhr.onerror = function() {
            console.error('Erreur réseau.');
            addClientResponse.innerHTML = '<p class="error">Erreur réseau lors de l\'envoi du formulaire.</p>';
        };

        xhr.send(new URLSearchParams(formData)); // Envoi des données après conversion en URLSearchParams
    });

    function displayLogs(logs) {
        logsSection.innerHTML = ''; // Clear previous logs
        logs.forEach(log => {
            var logElement = document.createElement('p');
            logElement.textContent = log;
            logsSection.appendChild(logElement);
        });
    }
});