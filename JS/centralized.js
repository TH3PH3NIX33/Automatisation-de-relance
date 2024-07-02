document.addEventListener('DOMContentLoaded', function() {
    // Formulaire pour envoyer des emails de relance
    var sendEmailsForm = document.getElementById('sendEmailsForm');
    var responseSection = document.getElementById('responseSection');

    sendEmailsForm.addEventListener('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(sendEmailsForm);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'send_email.php', true);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    responseSection.innerHTML = '<p class="success">' + response.message + '</p>';
                } else {
                    responseSection.innerHTML = '<p class="error">' + response.message + '</p>';
                }
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
        var formData = new FormData(addClientForm);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'add_client.php', true); // Notez que j'ai changé le fichier cible pour ajouter un client
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    addClientResponse.innerHTML = '<p class="success">' + response.message + '</p>';
                } else {
                    addClientResponse.innerHTML = '<p class="error">' + response.message + '</p>';
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
        xhr.send(formData);
    });
});
