<?php
/*
require 'vendor/autoload.php';
require 'config.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$monEmail = 'relance.auto@gmail.com';
$filePath = 'uploads/LISTING_FACT.xlsx';

try {
    $spreadsheet = IOFactory::load($filePath);
    $sheet = $spreadsheet->getSheet(0);

    $conn = new PDO("mysql:host={$databaseConfig['host']};dbname={$databaseConfig['dbname']}", $databaseConfig['username'], $databaseConfig['password']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT Courriel FROM liste_des_clients WHERE code = :code_client");
    $stmt->bindParam(':code_client', $code_client);

    foreach ($sheet->getRowIterator() as $row) {
        $code_client = $sheet->getCell('H' . $row->getRowIndex())->getValue();
        $reglement = $sheet->getCell('AM' . $row->getRowIndex())->getValue();
        $montant = $sheet->getCell('Y' . $row->getRowIndex())->getValue();
        $date = $sheet->getCell('F' . $row->getRowIndex())->getValue();

        if ($reglement == 1) {
            echo "Arrêt du processus d'envoi d'e-mails.";
            break;
        }

        if ($reglement == 0) {
            $stmt->execute();
            $email = $stmt->fetchColumn();

            $config = getSmtpConfig($monEmail);
            if ($email && $config) {
                $mail = new PHPMailer(true);

                $mail->isSMTP();
                $mail->Host = $config['host'];
                $mail->Port = $config['port'];
                $mail->SMTPAuth = true;
                $mail->Username = $config['username'];
                $mail->Password = $config['password'];
                $mail->SMTPSecure = $config['smtp_secure'];

                $mail->setFrom($config['from_address'], $config['from_name']);
                $mail->addAddress('relance.automatique@gmail.com');

                $mail->isHTML(true);
                $mail->Subject = 'Relance';
                $mail->Body = "Bonjour,<br><br>Sauf erreur ou omissions de notre part, notre facture N° {$code_client} datée du {$date} pour un montant TTC de {$montant} € n’a pas encore été réglée.<br><br>Pourriez-vous effectuer le règlement de celle-ci ou nous informer des raisons pour lesquelles elle serait bloquée ?<br><br>Merci d’avance.<br><br>Cordialement,<br>Arnaud DESCHAMPS<br>Adex Logistique, Dirigeant<br>+336 20 73 25 63";

                if ($mail->send()) {
                    echo "E-mail envoyé à $email<br>";
                    $reponse = "E-mail envoyé à $email<br>";
                } else {
                    echo "Échec de l'envoi de l'e-mail à $email : " . $mail->ErrorInfo . "<br>";
                    $reponse = "Échec de l'envoi de l'e-mail à $email : " . $mail->ErrorInfo . "<br>";
                }
            } else {
                echo "Aucun email trouvé pour le code client $code_client ou configuration SMTP non trouvée.<br>";
                $reponse = "Aucun email trouvé pour le code client $code_client ou configuration SMTP non trouvée.<br>";
            }
        }
    }
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
    $reponse = "Erreur : " . $e->getMessage();
} finally {
    $conn = null;
}
*/


/*
require 'config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$email = 'thibaud.lauber67000@gmail.com'; // Adresse email du destinataire

$config = getSmtpConfig($email);

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = $config['host'];
    $mail->SMTPAuth = true;
    $mail->Username = $config['username'];
    $mail->Password = $config['password'];
    $mail->SMTPSecure = $config['smtp_secure'];
    $mail->Port = $config['port'];

    $mail->setFrom($config['from_address'], $config['from_name']);
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Test Email';
    $mail->Body    = 'Ceci est un email de test envoyé via SMTP.';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
*/

date_default_timezone_set('Europe/Paris');
header('Content-Type: application/json');
require 'vendor/autoload.php';
require 'config.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$logs = [];

function logMessage($message) {
    global $logs;
    $logEntry = date('Y-m-d H:i:s') . " - " . $message;
    $logs[] = $logEntry;
    file_put_contents('log.txt', $logEntry . PHP_EOL, FILE_APPEND);
}

function addClient($conn, $clientData) {
    try {
        $sql = "INSERT INTO `liste_des_clients` (
            `Sinari Network`, `Société`, `Agence`, `Code`, `Nom`, `Adresse`, `Complément`,
            `Code Postal`, `Ville`, `Pays`, `Nom court`, `Ville Libre`, `CP Cedex`, `Téléphone`, `Fax`, `Courriel`, 
            `n° IntraComm.`, `n° SIRET`, `Code Regroupement`, `D/H création`, `Création Par`, 
            `D/H modif.`, `Modif. par`
        ) VALUES (
            :Société, :Agence, :Code, :Nom, :Adresse, :Complément,
            :Code_Postal, :Ville, :Pays, :Nom_court, :Ville_Libre, :CP_Cedex, :Téléphone, :Fax, :Courriel, 
            :n°_IntraComm_, :n°_SIRET, :Code_Regroupement, :DhCreation, :CreationPar, 
            :DhModif, :Modif_par
        )";

        $stmt = $conn->prepare($sql);

        // Log et bind des valeurs
        foreach ($clientData as $key => $value) {
            // Vérifier si la clé existe et si la valeur n'est pas vide
            if (isset($clientData[$key]) && !empty($clientData[$key])) {
                logMessage("Binding parameter $key with value: " . ($value === null ? 'NULL' : $value));
                // Assurez-vous que les chaînes de caractères sont liées en tant que PDO::PARAM_STR
                $stmt->bindValue($key, $value, PDO::PARAM_STR);
            } else {
                // Si la valeur est vide, lier NULL à la place
                $stmt->bindValue($key, null, PDO::PARAM_NULL);
            }
        }

        $stmt->execute();
        logMessage("Requête d'insertion exécutée avec succès.");
        return ["status" => "success", "message" => "Client ajouté avec succès."];
    } catch (PDOException $e) {
        logMessage("Erreur lors de l'insertion du client : " . $e->getMessage());
        return ["status" => "error", "message" => "Erreur lors de l'insertion du client : " . $e->getMessage()];
    }
}

$response = ['success' => false, 'message' => '', 'logs' => []];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        logMessage("Action reçue : $action");

        try {
            // Connexion à la base de données
            $conn = new PDO("mysql:host={$databaseConfig['host']};dbname={$databaseConfig['dbname']}", $databaseConfig['username'], $databaseConfig['password']);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            logMessage("Connexion à la base de données réussie");

            switch ($action) {
                case 'sendEmails':
                    $code_client_predit = 'C006666';

                    // Préparation de la requête SQL pour récupérer l'email du client prédit
                    $stmt = $conn->prepare("SELECT Courriel FROM liste_des_clients WHERE Code = :code_client");
                    $stmt->bindParam(':code_client', $code_client_predit);

                    // Exécuter la requête pour récupérer l'email du client
                    $stmt->execute();
                    $email = $stmt->fetchColumn();

                    if ($email) {
                        logMessage("Email trouvé : $email");
                        $config = getSmtpConfig($email);
                        if ($config) {
                            logMessage("Configuration SMTP trouvée pour $email");

                            // Charger le fichier Excel
                            $filePath = 'uploads/LISTING_FACT.xlsx';
                            if (!file_exists($filePath)) {
                                throw new Exception("Le fichier $filePath n'existe pas.");
                            }

                            $spreadsheet = IOFactory::load($filePath);
                            $sheet = $spreadsheet->getSheet(0);

                            // Rechercher le client et vérifier le règlement
                            $current_code_client = null;
                            $reglement = null;
                            $montant = null;
                            $date = null;

                            foreach ($sheet->getRowIterator() as $row) {
                                $current_code_client = $sheet->getCell('H' . $row->getRowIndex())->getValue();
                                $reglement = $sheet->getCell('AM' . $row->getRowIndex())->getValue();
                                $montant = $sheet->getCell('Y' . $row->getRowIndex())->getValue();
                                $date = $sheet->getCell('F' . $row->getRowIndex())->getValue();

                                if ($current_code_client == $code_client_predit && $reglement == 0) {
                                    break;
                                }
                            }

                            if ($current_code_client == $code_client_predit && $reglement == 0) {
                                logMessage("Facture non réglée trouvée pour le client $code_client_predit");

                                $mail = new PHPMailer(true);

                                // Configuration de PHPMailer avec les informations SMTP
                                $mail->isSMTP();
                                $mail->Host = $config['host'];
                                $mail->Port = $config['port'];
                                $mail->SMTPAuth = true;
                                $mail->Username = $config['username'];
                                $mail->Password = $config['password'];
                                $mail->SMTPSecure = $config['smtp_secure'];

                                $mail->setFrom($config['from_address'], $config['from_name']);
                                $mail->addAddress($email);

                                $mail->isHTML(true);
                                $mail->Subject = 'Relance';
                                $mail->Body = "Bonjour,<br><br>Sauf erreur ou omissions de notre part, notre facture N° {$code_client_predit} datée du {$date} pour un montant TTC de {$montant} € n’a pas encore été réglée.<br><br>Pourriez-vous effectuer le règlement de celle-ci ou nous informer des raisons pour lesquelles elle serait bloquée ?<br><br>Merci d’avance.<br><br>Cordialement,<br>Arnaud DESCHAMPS<br>Adex Logistique, Dirigeant<br>+336 20 73 25 63";

                                if ($mail->send()) {
                                    logMessage("E-mail envoyé à $email pour le code client $code_client_predit.");
                                    $response = ['success' => true, 'message' => 'Email envoyé avec succès.'];
                                } else {
                                    logMessage("Échec de l'envoi de l'e-mail à $email : " . $mail->ErrorInfo);
                                    $response['message'] = 'Échec de l\'envoi de l\'e-mail.';
                                }
                            } else {
                                logMessage("Client non trouvé ou facture déjà réglée pour le code client $code_client_predit.");
                                $response['message'] = 'Client non trouvé ou facture déjà réglée.';
                            }
                        } else {
                            logMessage("Configuration SMTP non trouvée pour l'email $email.");
                            $response['message'] = 'Configuration SMTP non trouvée.';
                        }
                    } else {
                        logMessage("Aucun email trouvé pour le code client $code_client_predit.");
                        $response['message'] = 'Aucun email trouvé pour le code client prédit.';
                    }
                    break;

                case 'addClient':
                    logMessage("Contenu de \$_POST avant construction de \$clientData : " . print_r($_POST, true));

                    $clientData = [
                        ':Sinari_Network' => isset($_POST['Sinari_Network']) ? $_POST['Sinari_Network'] : null,
                        ':Société' => isset($_POST['Société']) ? $_POST['Société'] : null,
                        ':Agence' => isset($_POST['Agence']) ? $_POST['Agence'] : null,
                        ':Code' => isset($_POST['Code']) ? $_POST['Code'] : null,
                        ':Nom' => isset($_POST['Nom']) ? $_POST['Nom'] : null,
                        ':Adresse' => isset($_POST['Adresse']) ? $_POST['Adresse'] : null,
                        ':Complément' => isset($_POST['Complément']) ? $_POST['Complément'] : null,
                        ':Code_Postal' => isset($_POST['Code_Postal']) ? $_POST['Code_Postal'] : null,
                        ':Ville' => isset($_POST['Ville']) ? $_POST['Ville'] : null,
                        ':Pays' => isset($_POST['Pays']) ? $_POST['Pays'] : null,
                        ':Nom_court' => isset($_POST['Nom_court']) ? $_POST['Nom_court'] : null,
                        ':Ville_Libre' => isset($_POST['Ville_Libre']) ? $_POST['Ville_Libre'] : null,
                        ':CP_Cedex' => isset($_POST['CP_Cedex']) ? $_POST['CP_Cedex'] : null,
                        ':Téléphone' => isset($_POST['Téléphone']) ? $_POST['Téléphone'] : null,
                        ':Fax' => isset($_POST['Fax']) ? $_POST['Fax'] : null,
                        ':Courriel' => isset($_POST['Courriel']) ? $_POST['Courriel'] : null,
                        ':n°_IntraComm_' => isset($_POST['n°_IntraComm_']) ? $_POST['n°_IntraComm_'] : null,
                        ':n°_SIRET' => isset($_POST['n°_SIRET']) ? $_POST['n°_SIRET'] : null,
                        ':Code_Regroupement' => isset($_POST['Code_Regroupement']) ? $_POST['Code_Regroupement'] : null,
                        ':DhCreation' => date('Y-m-d H:i:s'),
                        ':CreationPar' => 'System',
                        ':DhModif' => date('Y-m-d H:i:s'),
                        ':Modif_par' => 'System',
                    ];
                    
                    $response = addClient($conn, $clientData);
                    break;

                default:
                    logMessage("Erreur : Action non reconnue.");
                    $response['message'] = 'Erreur : Action non reconnue.';
            }
        } catch (Exception $e) {
            logMessage("Erreur : " . $e->getMessage());
            $response['message'] = 'Erreur : ' . $e->getMessage();
        } finally {
            if (isset($conn)) {
                $conn = null;
            }
            logMessage("Connexion à la base de données fermée");
        }
    } else {
        logMessage("Erreur : Action non définie.");
        $response['message'] = 'Erreur : Action non définie.';
    }
}

$response['logs'] = $logs;
echo json_encode($response, JSON_UNESCAPED_UNICODE);

/*
                    $clientData = [];
                    $requiredFields = [
                        `Sinari Network`, `Société`, `Agence`, `Code`, `Nom`, `Adresse`, `Complément`,
                        `Code Postal`, `Ville`, `Pays`, `Nom court`, `Ville Libre`, `CP Cedex`, `Téléphone`, `Fax`, `Courriel`, 
                        `n° IntraComm.`, `n° SIRET`, `Code Regroupement`, `D/H création`, `Création Par`, 
                        `D/H modif.`, `Modif. par`
                    ];
                    
                    foreach ($requiredFields as $field) {
                        $key = ':' . str_replace(' ', '_', $field);
                        if (isset($_POST[$field]) && !empty($_POST[$field])) {
                            $clientData[$key] = $_POST[$field];
                        } else {
                            $clientData[$key] = "null";
                        }
                    }

                    // Ajout des valeurs supplémentaires
                    $clientData[':D/H création'] = date('Y-m-d H:i:s');
                    $clientData[':Création Par'] = 'System';
                    $clientData[':D/H modif.'] = date('Y-m-d H:i:s');
                    $clientData[':Modif. par'] = 'System';

                    foreach ($clientData as $key => $value) {
                        $logs[] = date('Y-m-d H:i:s') . " - Clé : $key, Valeur : " . (is_null($value) ? 'null' : $value);
                    }
*/