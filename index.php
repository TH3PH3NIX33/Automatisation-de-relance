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

        // Charger le fichier Excel
        $spreadsheet = IOFactory::load($filePath);

        // Sélectionner la feuille (0 pour la première feuille)
        $sheet = $spreadsheet->getSheet(0);

        // Lire la valeur de la cellule 
        $cellValue = $sheet->getCell('H2')->getValue();

        $servername = "localhost";
        $username = "root";
        $password = ""; // Laissez vide si c'est le cas
        $dbname = "client_adex_logistique"; // Utilisez des underscores pour éviter les problèmes d'espaces

        try {
            // Établir une connexion à la base de données
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // Définir le mode d'erreur de PDO sur Exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            echo "Connexion réussie à la base de données.<br>";
        
            // Préparer la requête SQL
            $codeClient = $cellValue;
            $stmt = $conn->prepare("SELECT COL 16 FROM liste_des_clients__404_ WHERE code_client = :code_client");
            $stmt->bindParam(':code_client', $codeClient);
            
            $stmt->execute();
            
            // Récupérer le résultat
            $email = null; // Initialiser la variable pour stocker l'email
            if ($stmt->rowCount() > 0) {
                // La ligne existe, récupérer la valeur de l'email
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $email = $row['email'];
                echo "L'email du client est : " . $email;
            } else {
                echo "Aucun client trouvé avec le code client spécifié.";
            }
        } catch(PDOException $e) {
            echo "La connexion a échoué : " . $e->getMessage();
        }
        
        // Fermer la connexion (optionnel, PDO gère automatiquement la fermeture de la connexion)
        $conn = null;
    ?>
</body>
</html>
