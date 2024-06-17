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
        
            // Exemple : obtenir la valeur de la cellule qui contient le code client (par exemple, cellule H2)
            $code_client = $sheet->getCell('H2')->getValue();
        
            // Vérifiez que le code client a été trouvé dans le fichier Excel
            if (empty($code_client)) {
                throw new Exception('Code client introuvable dans le fichier Excel.');
            }
        
            // Informations de connexion à la base de données
            $servername = "localhost";
            $username = "root";
            $password = ""; // Laissez vide si c'est le cas
            $dbname = "votre_base_de_donnees"; // Assurez-vous d'utiliser le nom correct de votre base de données
        
            // Créer une connexion PDO
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // Définir le mode d'erreur de PDO sur Exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            // Préparer la requête SQL
            $stmt = $conn->prepare("SELECT Courriel FROM liste_des_clients__404_ WHERE code_client = :code_client");
            $stmt->bindParam(':code_client', $code_client);
        
            // Exécuter la requête
            $stmt->execute();
        
            // Récupérer le résultat
            $email = $stmt->fetchColumn();
        
            if ($email) {
                echo "L'email du client avec le code client $code_client est : $email";
            } else {
                echo "Aucun email trouvé pour le code client $code_client";
            }
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        } catch (PDOException $e) {
            echo "La connexion a échoué : " . $e->getMessage();
        }
        
        // Fermer la connexion (optionnel, PDO gère automatiquement la fermeture de la connexion)
        $conn = null;
    ?>
</body>
</html>
