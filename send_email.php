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

// Code client spécifique prédéfini
$code_client_predit = 'C006666';

try {
    // Connexion à la base de données
    $conn = new PDO("mysql:host={$databaseConfig['host']};dbname={$databaseConfig['dbname']}", $databaseConfig['username'], $databaseConfig['password']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL pour récupérer l'email à partir du code client prédéfini
    $stmt = $conn->prepare("SELECT Courriel FROM liste_des_clients WHERE code = :code_client");
    $stmt->bindParam(':code_client', $code_client_predit);
    $stmt->execute();
    $email = $stmt->fetchColumn();
    //echo " Voici l'email trouver : ". $email;

    // Chemin vers le fichier Excel
    $filePath = 'uploads/LISTING_FACT.xlsx';

    // Charger le fichier Excel
    $spreadsheet = IOFactory::load($filePath);
    $sheet = $spreadsheet->getSheet(0);

    // Récupérer les données du fichier Excel pour le code client prédéfini
    foreach ($sheet->getRowIterator() as $row) {
        $code_client_excel = $sheet->getCell('H' . $row->getRowIndex())->getValue();
        $reglement = $sheet->getCell('AM' . $row->getRowIndex())->getValue();
        $montant = $sheet->getCell('Y' . $row->getRowIndex())->getValue();
        $date = $sheet->getCell('F' . $row->getRowIndex())->getValue();

        // Vérifie si le code client correspond au code prédéfini
        if ($code_client_excel !== $code_client_predit) {
            continue; // Passe au prochain code client si ce n'est pas celui prédéfini
        }

        // Vérifie le statut de règlement
        if ($reglement == 1) {
            echo "Arrêt du processus d'envoi d'e-mails pour le code client $code_client_excel.<br>";
            break;
        }

        // Envoi de l'e-mail
        $config = getSmtpConfig($email);

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
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Relance';
            $mail->Body = "Bonjour,<br><br>Sauf erreur ou omissions de notre part, notre facture N° {$code_client_predit} datée du {$date} pour un montant TTC de {$montant} € n’a pas encore été réglée.<br><br>Pourriez-vous effectuer le règlement de celle-ci ou nous informer des raisons pour lesquelles elle serait bloquée ?<br><br>Merci d’avance.<br><br>Cordialement,<br>Arnaud DESCHAMPS<br>Adex Logistique, Dirigeant<br>+336 20 73 25 63";

            if ($mail->send()) {
                echo "E-mail envoyé à $email pour le code client $code_client_predit.<br>";
                $reponse = "E-mail envoyé à $email pour le code client $code_client_predit.<br>";

            } else {
                echo "Échec de l'envoi de l'e-mail à $email : " . $mail->ErrorInfo . "<br>";
                $reponse = "Échec de l'envoi de l'e-mail à $email : " . $mail->ErrorInfo . "<br>";
            }
        } else {
            echo "Aucun email trouvé pour le code client prédéfini $code_client_predit ou configuration SMTP non trouvée.<br>";
            $reponse = "Aucun email trouvé pour le code client prédéfini $code_client_predit ou configuration SMTP non trouvée.<br>";
        }
    }
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
    $reponse = "Erreur : " . $e->getMessage();
} finally {
    $conn = null;
}
?>

<?php

try {
    $conn = new PDO("mysql:host={$databaseConfig['host']};dbname={$databaseConfig['dbname']}", $databaseConfig['username'], $databaseConfig['password']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparer la requête d'insertion
    $stmt = $conn->prepare("INSERT INTO liste_des_clients (Societe, Agence, Code, Nom, Adresse, Complement, Code_Postal, Ville, Pays, Nom_Court, Ville_Libre, CP_Codex, Telephone, Fax, Courriel, IntraComm, SIRET, Code_Regroupement) 
                            VALUES (:societe, :agence, :code, :nom, :adresse, :complement, :code_postal, :ville, :pays, :nom_court, :ville_libre, :cp_codex, :telephone, :fax, :courriel, :intra_comm, :siret, :code_regroupement)");

    // Liaison des paramètres avec les valeurs du formulaire
    $stmt->bindParam(':societe', $_POST['societe']);
    $stmt->bindParam(':agence', $_POST['agence']);
    $stmt->bindParam(':code', $_POST['code']);
    $stmt->bindParam(':nom', $_POST['nom']);
    $stmt->bindParam(':adresse', $_POST['adresse']);
    $stmt->bindParam(':complement', $_POST['complement']);
    $stmt->bindParam(':code_postal', $_POST['code_postal']);
    $stmt->bindParam(':ville', $_POST['ville']);
    $stmt->bindParam(':pays', $_POST['pays']);
    $stmt->bindParam(':nom_court', $_POST['nom_court']);
    $stmt->bindParam(':ville_libre', $_POST['ville_libre']);
    $stmt->bindParam(':cp_codex', $_POST['cp_codex']);
    $stmt->bindParam(':telephone', $_POST['telephone']);
    $stmt->bindParam(':fax', $_POST['fax']);
    $stmt->bindParam(':courriel', $_POST['courriel']);
    $stmt->bindParam(':intra_comm', $_POST['intra_comm']);
    $stmt->bindParam(':siret', $_POST['siret']);
    $stmt->bindParam(':code_regroupement', $_POST['code_regroupement']);

    // Exécuter la requête
    $stmt->execute();

    echo "Client ajouté avec succès.";
    $reponse = "Client ajouté avec succès.";

} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    $reponse = "Erreur : " . $e->getMessage();
}

$conn = null;
?>


