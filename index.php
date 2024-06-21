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
        <script>
            function validateForm() {
                var fileInput = document.getElementById('excelFile');
                var filePath = fileInput.value;
                var allowedExtensions = /(\.xlsx|\.xls)$/i;

                if (!allowedExtensions.exec(filePath)) {
                    alert('Seuls les fichiers Excel (.xlsx, .xls) sont autorisés.');
                    return false;
                }
                return true;
            }
        </script>
    </header>
    <nav>
        <a href="index.php">Accueil</a>
        <a href="send_email.html">Envoye des Relances</a>
    </nav>
    <main>
        <section>
            <h2>Mise à jour du fichier Excel</h2>
                <form id="uploadForm" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <label for="excelFile">Sélectionnez un nouveau fichier Excel :</label>
                    <input type="file" name="excelFile" id="excelFile" accept=".xlsx, .xls">
                    <br><br>
                    <input type="submit" value="Envoyer">
                </form>

                <section id="responseSection">
                    <div id="response">
                    <?php
                    // Vérifie si la requête est une requête POST (indiquant que le formulaire a été soumis)
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Vérifie s'il n'y a pas d'erreur d'upload et si le fichier a bien été téléchargé
                        if ($_FILES['excelFile']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['excelFile']['tmp_name'])) {
                            $target_dir = "uploads/"; // Répertoire cible pour le téléchargement des fichiers
                            $newFileName = "LISTING_FACT.xlsx"; // Nom du fichier cible
                            $target_file = $target_dir . $newFileName; // Chemin complet du fichier cible
                            $fileType = pathinfo($_FILES["excelFile"]["name"], PATHINFO_EXTENSION); // Obtient l'extension du fichier uploadé

                            // Vérifie si le fichier a une extension autorisée (xlsx ou xls)
                            if (in_array($fileType, ['xlsx', 'xls'])) {
                                // Vérifie si un fichier avec le même nom existe déjà et le supprime
                                if (file_exists($target_file)) {
                                    if (!unlink($target_file)) {
                                        echo '<span class="error">Impossible de supprimer l\'ancien fichier.</span>';
                                        exit();
                                    }
                                }

                                // Déplace le fichier uploadé vers le répertoire cible avec le nom spécifié
                                if (move_uploaded_file($_FILES["excelFile"]["tmp_name"], $target_file)) {
                                    echo '<span class="success">Le fichier ' . htmlspecialchars(basename($_FILES["excelFile"]["name"])) . ' a été téléchargé et remplacé avec succès.</span>';
                                } else {
                                    // Affiche un message d'erreur si le déplacement du fichier échoue
                                    echo '<span class="error">Une erreur s\'est produite lors du téléchargement du fichier.</span>';
                                }
                            } else {
                                // Affiche un message d'erreur si le fichier n'a pas une extension autorisée
                                echo '<span class="error">Seuls les fichiers Excel sont autorisés.</span>';
                            }
                        } else {
                            // Affiche un message d'erreur si aucun fichier n'a été téléchargé ou s'il y a une erreur d'upload
                            echo '<span class="error">Aucun fichier n\'a été téléchargé ou une erreur est survenue.</span>';
                        }
                    }
                    ?>
                    </div>
                </section>
    </main>
    <footer>
        <p>&copy; 2024 Adex Logistique. Tous droits réservés.</p>
    </footer>
</body>
</html>