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
        <a href="send_email.php">Envoye des Relances</a>
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
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if ($_FILES['excelFile']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['excelFile']['tmp_name'])) {
                                $target_dir = "uploads/";
                                $target_file = $target_dir . basename($_FILES["excelFile"]["name"]);
                                $fileType = pathinfo($target_file, PATHINFO_EXTENSION);

                                if (in_array($fileType, ['xlsx', 'xls'])) {
                                    if (move_uploaded_file($_FILES["excelFile"]["tmp_name"], $target_file)) {
                                        echo '<span class="success">Le fichier ' . basename($_FILES["excelFile"]["name"]) . ' a été téléchargé avec succès.</span>';
                                    } else {
                                        echo '<span class="error">Une erreur s\'est produite lors du téléchargement du fichier.</span>';
                                    }
                                } else {
                                    echo '<span class="error">Seuls les fichiers Excel sont autorisés.</span>';
                                }
                            } else {
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