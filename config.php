<?php
// Configuration de la base de données
$databaseConfig = [
    'host' => 'localhost',
    'dbname' => 'client_adex_logistique',
    'username' => 'root',
    'password' => '',
];

$modeTest = true;
// Fonction pour récupérer la configuration SMTP
function getSmtpConfig($email)
{
    $modeTest = true;
    $smtpConfigurations = [
        'relance.auto@gmail.com' => [
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'username' => getenv('SMTP_USERNAME'),
            'password' => getenv('SMTP_PASSWORD'),
            'smtp_secure' => 'tls',
            'from_address' => getenv('SMTP_USERNAME'),
            'from_name' => 'Lauber',
        ],
        // Ajoutez d'autres configurations SMTP si nécessaire
    ];

    if ($modeTest) {
        $smtpConfigurations['relance.auto@gmail.com']['from_address'] = 'thibaud.lauber67000@gmail.com'; 
    }
    // Vérifier si la configuration SMTP existe pour l'e-mail spécifié
    if (isset($smtpConfigurations[$email])) {
        return $smtpConfigurations[$email];
    } else {
        throw new Exception("Configuration SMTP non trouvée pour l'adresse e-mail : $email");
    }
}
?>
