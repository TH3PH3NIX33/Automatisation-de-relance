<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adex Logistique - Automatisation de Relance de Factures</title>
    <link rel="stylesheet" href="CSS.css">
</head>
<body>
    <header>
        <h1>Adex Logistique - Automatisation de Relance de Factures</h1>
    </header>
    <nav>
        <a href="#">Accueil</a>
        <a href="#">Services</a>
        <a href="#">Contact</a>
    </nav>
    <section>
        <h2>Contenu principal de votre site</h2>
        <p>Ici vous pouvez ajouter vos informations, vos services, etc.</p>
    </section>
    <section>
        <div>
            <h3>Mise à jour du fichier Excel</h3>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <label for="excelFile">Sélectionnez un nouveau fichier Excel :</label>
                <input type="file" name="excelFile" id="excelFile" accept=".xlsx, .xls">
                <br><br>
                <input type="submit" value="Envoyer">
            </form>
        </div>
    </section>
    <footer>
        <p>&copy; 2024 Adex Logistique. Tous droits réservés.</p>
    </footer>
    <?php
        require 'vendor/autoload.php';
        use PhpOffice\PhpSpreadsheet\IOFactory;
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        // Configurations SMTP pour différentes adresses email
        $smtpConfigurations = [
            'Thibaudlemono@gmail.com' => [
                'host' => 'smtp.gmail.com',
                'port' => 587,
                'username' => 'your-gmail-address@gmail.com',
                'password' => 'your-gmail-password',
                'smtp_secure' => 'tls', // SSL ou TLS selon le serveur
                'from_address' => 'your-gmail-address@gmail.com',
                'from_name' => 'Votre Nom'
            ],
            '2mbi@2mbi.fr' => [
                'host' => 'smtp.example.com',
                'port' => 25,
                'username' => 'your-email@your-domain.com',
                'password' => 'your-password',
                'smtp_secure' => '', // SSL ou TLS selon le serveur
                'from_address' => 'your-email@your-domain.com',
                'from_name' => 'Votre Nom'
            ],

        ];

        // Adresse email à utiliser pour l'envoi (peut être récupérée dynamiquement)
        $monEmail = 'Thibaud.lauber67000@gmail.com';

        // Vérifier si le formulaire a été soumis pour l'upload du fichier
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Vérifier si un fichier a été téléchargé
            if ($_FILES['excelFile']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['excelFile']['tmp_name'])) {
                $target_dir = "uploads/"; // Dossier où vous souhaitez stocker les fichiers téléchargés
                $target_file = $target_dir . basename($_FILES["excelFile"]["name"]);
                $uploadOk = true;
                $fileType = pathinfo($target_file, PATHINFO_EXTENSION);

                // Vérifier si le fichier est un fichier Excel
                if ($fileType != "xlsx" && $fileType != "xls") {
                    echo "Seuls les fichiers Excel sont autorisés.";
                    $uploadOk = false;
                }

                // Si tout est bon, télécharger le fichier
                if ($uploadOk) {
                    if (move_uploaded_file($_FILES["excelFile"]["tmp_name"], $target_file)) {
                        echo "Le fichier " . basename($_FILES["excelFile"]["name"]) . " a été téléchargé avec succès.";

                        header("Location: index.php");
                        exit;
                    } else {
                        echo "Une erreur s'est produite lors du téléchargement du fichier.";
                    }
                }
            } else {
                echo "Aucun fichier n'a été téléchargé ou une erreur est survenue.";
            }
        }

        $filePath = 'LISTING_FACT.xlsx';

        try {
            // Charger le fichier Excel
            $spreadsheet = IOFactory::load($filePath);
            // Sélectionner la feuille (0 pour la première feuille)
            $sheet = $spreadsheet->getSheet(0);

            // Informations de connexion à la base de données
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "client_adex_logistique";

            // Créer une connexion PDO
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // Définir le mode d'erreur de PDO sur Exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Boucle pour parcourir les lignes et envoyer des emails
            foreach ($sheet->getRowIterator() as $row) {
                $code_client = $sheet->getCell('H'.$row->getRowIndex())->getValue();
                $reglement = $sheet->getCell('AM'.$row->getRowIndex())->getValue();

                if ($reglement == 1) {
                    echo "Arrêt du processus d'envoi d'e-mails.";
                    break;
                }

                if ($reglement == 0) {
                    // Requête SQL pour récupérer l'email du client en fonction du code client
                    $stmt = $conn->prepare("SELECT Courriel FROM liste_des_clients WHERE code = :code_client");
                    $stmt->bindParam(':code_client', $code_client);
                    $stmt->execute();
                    $email = $stmt->fetchColumn();

                    // Vérifier si l'email a été trouvé dans la base de données
                    if ($email && isset($smtpConfigurations[$monEmail])) {
                        $config = $smtpConfigurations[$monEmail];

                        // Création de l'objet PHPMailer
                        $mail = new PHPMailer(true);

                        // Paramètres SMTP
                        $mail->isSMTP();
                        $mail->Host = $config['host'];
                        $mail->Port = $config['port'];
                        $mail->SMTPAuth = true;
                        $mail->Username = $config['username'];
                        $mail->Password = $config['password'];
                        $mail->SMTPSecure = $config['smtp_secure']; // SSL ou TLS selon le serveur

                        $mail->setFrom($config['from_address'], $config['from_name']);
                        $mail->addAddress($email);

                        $mail->isHTML(true); // Définir le format de l'email en HTML
                        $mail->Subject = 'Objet de l\'email';
                        $mail->Body = 'Contenu du message';

                        // Envoyer l'e-mail
                        if ($mail->send()) {
                            echo "E-mail envoyé à $email";
                        } else {
                            echo "Échec de l'envoi de l'e-mail à $email : " . $mail->ErrorInfo;
                        }
                    } else {
                        echo "Aucun email trouvé pour le code client $code_client ou configuration SMTP non trouvée.";
                    }
                }
            }
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        } finally {
            $conn = null;
        }
    ?>
</body>
</html>
