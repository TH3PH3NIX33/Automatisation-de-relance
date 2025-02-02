<?php
require 'vendor/autoload.php';

// Charger les variables d'environnement à partir du fichier .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, 'variable.env');
$dotenv->load();

//echo "SMTP Username : " . $_ENV['SMTP_USERNAME'] . "<br>";

$databaseConfig = [
    'host' => $_ENV['DATABASE_HOST'],
    'dbname' => $_ENV['DATABASE_NAME'],
    'username' => $_ENV['DATABASE_USER'],
    'password' => $_ENV['DATABASE_PASSWORD'],
];

function getSmtpConfig($email)
{
    $gmailConfig = [
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'username' => $_ENV['SMTP_USERNAME'],
        'password' => $_ENV['SMTP_PASSWORD'],
        'smtp_secure' => 'tls',
        'from_address' => $_ENV['SMTP_USERNAME'],
        'from_name' => 'Adex Logistique',
    ];

    $domain = explode('@', $email)[1];

    switch ($domain) {
        case 'gmail.com':
            return $gmailConfig;

        default:
            throw new Exception("Configuration SMTP non trouvée pour le domaine de l'adresse e-mail : $domain");
    }
}
?>
