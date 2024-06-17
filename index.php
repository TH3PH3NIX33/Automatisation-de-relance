test

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

            // Boucle pour parcourir les lignes et envoyer des emails
            foreach ($sheet->getRowIterator() as $row) {
                // Exemple : obtenir la valeur de la cellule qui contient le code client (par exemple, cellule H2)
                $code_client = $sheet->getCell('H'.$row->getRowIndex())->getValue();
                $valeur_condition = $sheet->getCell('AM'.$row->getRowIndex())->getValue(); // Supposons que la condition soit dans la colonne A

                // Vérifiez la condition pour arrêter l'envoi d'e-mails
                if ($valeur_condition == 1) {
                    echo "La condition est remplie (valeur = 1), arrêt du processus d'envoi d'e-mails.";
                    break;
                }

                // Si la valeur est 0, continuez à traiter cet envoi d'email
                if ($valeur_condition == 0) {
                    // Exécutez le reste de votre code pour récupérer l'email du client et l'envoyer
                    // Connexion à la base de données et récupération de l'email comme dans votre exemple précédent

                    // Exemple simplifié pour envoyer un e-mail (utilisation de la fonction mail() de PHP)
                    $to = $email; // Supposons que $email contient l'adresse email du client
                    $subject = 'Objet de l\'email';
                    $message = 'Contenu du message';

                    // Envoyer l'e-mail
                    if (mail($to, $subject, $message)) {
                        echo "E-mail envoyé à $to";
                    } else {
                        echo "Échec de l'envoi de l'e-mail à $to";
                    }
                }
            }
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    ?>
</body>
</html>
