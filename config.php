<?php
require 'vendor/autoload.php';

// Charger les variables d'environnement à partir du fichier .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, 'variable.env');
$dotenv->load();

//echo "SMTP Username : " . $_ENV['SMTP_USERNAME'] . "<br>";

// Autres configurations comme la base de données
$databaseConfig = [
    'host' => $_ENV['DATABASE_HOST'],
    'dbname' => $_ENV['DATABASE_NAME'],
    'username' => $_ENV['DATABASE_USER'],
    'password' => $_ENV['DATABASE_PASSWORD'],
];

// Fonction pour récupérer la configuration SMTP
function getSmtpConfig($email)
{
    // Configuration SMTP par défaut
    $gmailConfig = [
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'username' => $_ENV['SMTP_USERNAME'],
        'password' => $_ENV['SMTP_PASSWORD'],
        'smtp_secure' => 'tls',
        'from_address' => $_ENV['SMTP_USERNAME'],
        'from_name' => 'Adex Logistique', // Nom de l'expéditeur par défaut
    ];

    // Exemple de logique pour déterminer la configuration SMTP en fonction du domaine de l'email destinataire
    $domain = explode('@', $email)[1]; // Récupère le domaine de l'adresse email

    switch ($domain) {
        case 'gmail.com':
            return $gmailConfig; // Utilise la configuration par défaut pour les emails Gmail
        // Ajoutez d'autres cas pour d'autres domaines si nécessaire
        default:
            throw new Exception("Configuration SMTP non trouvée pour le domaine de l'adresse e-mail : $domain");
    }
}
?>
