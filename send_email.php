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

require 'vendor/autoload.php';
require 'config.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$logFile = 'log.txt';

function logMessage($message) {
    global $logFile;
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - " . $message . PHP_EOL, FILE_APPEND);
}

function addClient($conn, $clientData) {
    try {
        $stmt = $conn->prepare("INSERT INTO liste_des_clients (societe, agence, code, nom, adresse, complement, code_postal, ville, pays, nom_court, ville_libre, cp_codex, telephone, fax, courriel, num_intracomm, num_siret, code_regroupement, dh_creation, creation_par, dh_modif, modif_par) VALUES (:societe, :agence, :code, :nom, :adresse, :complement, :code_postal, :ville, :pays, :nom_court, :ville_libre, :cp_codex, :telephone, :fax, :courriel, :num_intracomm, :num_siret, :code_regroupement, :dh_creation, :creation_par, :dh_modif, :modif_par)");
        
        $stmt->execute($clientData);
        return ['success' => true, 'message' => 'Client ajouté avec succès.'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Erreur : ' . $e->getMessage()];
    }
}

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        try {
            // Connexion à la base de données
            $conn = new PDO("mysql:host={$databaseConfig['host']};dbname={$databaseConfig['dbname']}", $databaseConfig['username'], $databaseConfig['password']);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            switch ($action) {
                case 'sendEmails':
                    $code_client_predit = 'C006666';

                    // Préparation de la requête SQL pour récupérer l'email du client prédit
                    $stmt = $conn->prepare("SELECT Courriel FROM liste_des_clients WHERE code = :code_client");
                    $stmt->bindParam(':code_client', $code_client_predit);

                    // Exécuter la requête pour récupérer l'email du client
                    $stmt->execute();
                    $email = $stmt->fetchColumn();

                    if ($email) {
                        $config = getSmtpConfig($email);
                        if ($config) {
                            // Charger le fichier Excel
                            $filePath = 'uploads/LISTING_FACT.xlsx';
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
                    // Logic for adding a client
                    if (isset($_POST['societe'])) {
                        $clientData = [
                            ':societe' => $_POST['societe'],
                            ':agence' => $_POST['agence'],
                            ':code' => $_POST['code'],
                            ':nom' => $_POST['nom'],
                            ':adresse' => $_POST['adresse'],
                            ':complement' => $_POST['complement'],
                            ':code_postal' => $_POST['code_postal'],
                            ':ville' => $_POST['ville'],
                            ':pays' => $_POST['pays'],
                            ':nom_court' => $_POST['nom_court'],
                            ':ville_libre' => $_POST['ville_libre'],
                            ':cp_codex' => $_POST['cp_codex'],
                            ':telephone' => $_POST['telephone'],
                            ':fax' => $_POST['fax'],
                            ':courriel' => $_POST['courriel'],
                            ':num_intracomm' => $_POST['num_intracomm'],
                            ':num_siret' => $_POST['num_siret'],
                            ':code_regroupement' => $_POST['code_regroupement'],
                            ':dh_creation' => date('Y-m-d H:i:s'),
                            ':creation_par' => 'System',
                            ':dh_modif' => date('Y-m-d H:i:s'),
                            ':modif_par' => 'System'
                        ];
                        $response = addClient($conn, $clientData);
                    } else {
                        $response['message'] = 'Données du client manquantes.';
                    }
                    break;

                default:
                    $response['message'] = 'Erreur : Action non reconnue.';
            }
        } catch (Exception $e) {
            logMessage("Erreur : " . $e->getMessage());
            $response['message'] = 'Erreur : ' . $e->getMessage();
        } finally {
            $conn = null;
        }
    } else {
        $response['message'] = 'Erreur : Action non définie.';
    }
}

echo json_encode($response);




/*
function addClient($conn, $clientData) {
    try {
        $stmt = $conn->prepare("INSERT INTO liste_des_clients (societe, agence, code, nom, adresse, complement, code_postal, ville, pays, nom_court, ville_libre, cp_codex, telephone, fax, courriel, num_intracomm, num_siret, code_regroupement, dh_creation, creation_par, dh_modif, modif_par) VALUES (:societe, :agence, :code, :nom, :adresse, :complement, :code_postal, :ville, :pays, :nom_court, :ville_libre, :cp_codex, :telephone, :fax, :courriel, :num_intracomm, :num_siret, :code_regroupement, :dh_creation, :creation_par, :dh_modif, :modif_par)");
        
        $stmt->execute($clientData);
        return ['success' => true, 'message' => 'Client ajouté avec succès.'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Erreur : ' . $e->getMessage()];
    }
}

try {
    $conn = new PDO("mysql:host={$databaseConfig['host']};dbname={$databaseConfig['dbname']}", $databaseConfig['username'], $databaseConfig['password']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['societe'])) {
            $clientData = [
                ':societe' => $_POST['societe'],
                ':agence' => $_POST['agence'],
                ':code' => $_POST['code'],
                ':nom' => $_POST['nom'],
                ':adresse' => $_POST['adresse'],
                ':complement' => $_POST['complement'],
                ':code_postal' => $_POST['code_postal'],
                ':ville' => $_POST['ville'],
                ':pays' => $_POST['pays'],
                ':nom_court' => $_POST['nom_court'],
                ':ville_libre' => $_POST['ville_libre'],
                ':cp_codex' => $_POST['cp_codex'],
                ':telephone' => $_POST['telephone'],
                ':fax' => $_POST['fax'],
                ':courriel' => $_POST['courriel'],
                ':num_intracomm' => $_POST['num_intracomm'],
                ':num_siret' => $_POST['num_siret'],
                ':code_regroupement' => $_POST['code_regroupement'],
                ':dh_creation' => $_POST['dh_creation'],
                ':creation_par' => $_POST['creation_par'],
                ':dh_modif' => $_POST['dh_modif'],
                ':modif_par' => $_POST['modif_par'],
            ];
            $response = addClient($conn, $clientData);
        } else {
            $filePath = 'uploads/LISTING_FACT.xlsx';
            sendReminderEmails($conn, $filePath);
            $response = ['success' => true, 'message' => 'Emails envoyés avec succès.'];
        }

        echo json_encode($response);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()]);
} finally {
    $conn = null;
}
*/
?>
