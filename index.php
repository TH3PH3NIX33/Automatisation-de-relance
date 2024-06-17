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
    <footer>
        <p>&copy; 2024 Adex Logistique. Tous droits réservés.</p>
    </footer>
    <?php
        require 'vendor/autoload.php';

        use PhpOffice\PhpSpreadsheet\IOFactory;

        // Chemin vers votre fichier Excel
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
                // Exemple : obtenir la valeur de la cellule qui contient le code client (par exemple, cellule H2)
                $code_client = $sheet->getCell('H'.$row->getRowIndex())->getValue();
                $valeur_condition = $sheet->getCell('A'.$row->getRowIndex())->getValue(); // Supposons que la condition soit dans la colonne A

                // Vérifier la condition pour arrêter l'envoi d'e-mails
                if ($valeur_condition == 1) {
                    echo "La condition est remplie (valeur = 1), arrêt du processus d'envoi d'e-mails.";
                    break;
                }

                // Si la valeur est 0, continuez à traiter cet envoi d'email
                if ($valeur_condition == 0) {
                    // Requête SQL pour récupérer l'email du client en fonction du code client
                    $stmt = $conn->prepare("SELECT Courriel FROM liste_des_clients WHERE code = :code_client");
                    $stmt->bindParam(':code_client', $code_client);
                    $stmt->execute();
                    $email = $stmt->fetchColumn();

                    // Vérifier si l'email a été trouvé dans la base de données
                    if ($email) {
                        // Exemple simplifié pour envoyer un e-mail (utilisation de la fonction mail() de PHP)
                        $to = $email;
                        $subject = 'Objet de l\'email';
                        $message = 'Contenu du message';

                        // Envoyer l'e-mail
                        if (mail($to, $subject, $message)) {
                            echo "E-mail envoyé à $to";
                        } else {
                            echo "Échec de l'envoi de l'e-mail à $to";
                        }
                    } else {
                        echo "Aucun email trouvé pour le code client $code_client";
                    }
                }
            }
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        } finally {
            // Fermer la connexion à la base de données
            $conn = null;
        }
    ?>
</body>
</html>
