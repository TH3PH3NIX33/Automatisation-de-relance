<?php
require 'vendor/autoload.php';
require 'config.php'; // Inclure le fichier de configuration

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
                $mail->addAddress('thibaudlemono@gmail.com');

                $mail->isHTML(true);
                $mail->Subject = 'Relance';
                $mail->Body = "Bonjour,<br><br>Sauf erreur ou omissions de notre part, notre facture N° {$code_client} datée du {$date} pour un montant TTC de {$montant} € n’a pas encore été réglée.<br><br>Pourriez-vous effectuer le règlement de celle-ci ou nous informer des raisons pour lesquelles elle serait bloquée ?<br><br>Merci d’avance.<br><br>Cordialement,<br>Arnaud DESCHAMPS<br>Adex Logistique, Dirigeant<br>+336 20 73 25 63";

                if ($mail->send()) {
                    echo "E-mail envoyé à $email<br>";
                } else {
                    echo "Échec de l'envoi de l'e-mail à $email : " . $mail->ErrorInfo . "<br>";
                }
            } else {
                echo "Aucun email trouvé pour le code client $code_client ou configuration SMTP non trouvée.<br>";
            }
        }
    }
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
} finally {
    $conn = null;
}
?>
