document.addEventListener('DOMContentLoaded', function() {
    // Formulaire pour envoyer des emails de relance
    var sendEmailsForm = document.getElementById('sendEmailsForm');
    var responseSection = document.getElementById('response');

    sendEmailsForm.addEventListener('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(sendEmailsForm);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'send_email.php', true);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                var response = JSON.parse(xhr.responseText);
                responseSection.innerHTML = response.join('<br>');
            } else {
                console.error('Erreur lors de la requête : ' + xhr.status);
                responseSection.innerHTML = '<p>Une erreur est survenue lors de l\'envoi du formulaire.</p>';
            }
        };
        xhr.onerror = function() {
            console.error('Erreur réseau.');
            responseSection.innerHTML = '<p>Erreur réseau lors de l\'envoi du formulaire.</p>';
        };
        xhr.send(formData);
    });

    // Formulaire pour ajouter un client manuellement
    var addClientForm = document.getElementById('addClientForm');
    var addClientResponse = document.getElementById('addClientMessage');

    addClientForm.addEventListener('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(addClientForm);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'send_email.php', true);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                var response = JSON.parse(xhr.responseText);
                addClientResponse.innerHTML = response.join('<br>');
            } else {
                console.error('Erreur lors de la requête : ' + xhr.status);
                addClientResponse.innerHTML = '<p>Une erreur est survenue lors de l\'envoi du formulaire.</p>';
            }
        };
        xhr.onerror = function() {
            console.error('Erreur réseau.');
            addClientResponse.innerHTML = '<p>Erreur réseau lors de l\'envoi du formulaire.</p>';
        };
        xhr.send(formData);
    });
});
