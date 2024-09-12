<?php
require 'config.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
try {
    $conn = new PDO("mysql:host={$databaseConfig['host']};dbname={$databaseConfig['dbname']}", $databaseConfig['username'], $databaseConfig['password']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    switch ($action) {
        case 'add':
            // Ajout d'un client
            $clientData = [
                'Sinari Network' => $_POST['Sinari_Network'] ?? null,
                'Société' => $_POST['Société'] ?? null,
                'Agence' => $_POST['Agence'] ?? null,
                'Code' => $_POST['Code'] ?? null,
                'Nom' => $_POST['Nom'] ?? null,
                'Adresse' => $_POST['Adresse'] ?? null,
                'Complément' => $_POST['Complément'] ?? null,
                'Code Postal' => $_POST['Code_Postal'] ?? null,
                'Ville' => $_POST['Ville'] ?? null,
                'Pays' => $_POST['Pays'] ?? null,
                'Nom court' => $_POST['Nom_court'] ?? null,
                'Ville Libre' => $_POST['Ville_Libre'] ?? null,
                'CP Cedex' => $_POST['CP_Cedex'] ?? null,
                'Téléphone' => $_POST['Téléphone'] ?? null,
                'Fax' => $_POST['Fax'] ?? null,
                'Courriel' => $_POST['Courriel'] ?? null,
                'n° IntraComm.' => $_POST['n°_IntraComm_'] ?? null,
                'n° SIRET' => $_POST['n°_SIRET'] ?? null,
                'Code Regroupement' => $_POST['Code_Regroupement'] ?? null,
                'D/H création' => date('Y-m-d H:i:s'),
                'Création Par' => 'System',
                'D/H modif.' => date('Y-m-d H:i:s'),
                'Modif. par' => 'System'
            ];
            
            $sql = "INSERT INTO `liste_des_clients` (
                `Sinari Network`, `Société`, `Agence`, `Code`, `Nom`, `Adresse`, `Complément`,
                `Code Postal`, `Ville`, `Pays`, `Nom court`, `Ville Libre`, `CP Cedex`, `Téléphone`, `Fax`, `Courriel`, 
                `n° IntraComm.`, `n° SIRET`, `Code Regroupement`, `D/H création`, `Création Par`, 
                `D/H modif.`, `Modif. par`
            ) VALUES (
                :Sinari_Network, :Société, :Agence, :Code, :Nom, :Adresse, :Complément,
                :Code_Postal, :Ville, :Pays, :Nom_court, :Ville_Libre, :CP_Cedex, :Téléphone, :Fax, :Courriel, 
                :n°_IntraComm_, :n°_SIRET, :Code_Regroupement, :DhCreation, :CreationPar, 
                :DhModif, :Modif_par
            )";

            $stmt = $conn->prepare($sql);

            foreach ($clientData as $key => $value) {
                $stmt->bindValue(":$key", $value, $value === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            }

            if ($stmt->execute()) {
                $message = 'Client ajouté avec succès.';
            } else {
                $message = 'Erreur lors de l\'ajout du client.';
            }
            break;

        case 'update':
            // Mise à jour d'un client
            $clientData = [
                'Code' => $_POST['Code'] ?? null,
                'Nom' => $_POST['Nom'] ?? null,
                'Adresse' => $_POST['Adresse'] ?? null,
                'Complément' => $_POST['Complément'] ?? null,
                'Code Postal' => $_POST['Code_Postal'] ?? null,
                'Ville' => $_POST['Ville'] ?? null,
                'Pays' => $_POST['Pays'] ?? null,
                'Nom court' => $_POST['Nom_court'] ?? null,
                'Ville Libre' => $_POST['Ville_Libre'] ?? null,
                'CP Cedex' => $_POST['CP_Cedex'] ?? null,
                'Téléphone' => $_POST['Téléphone'] ?? null,
                'Fax' => $_POST['Fax'] ?? null,
                'Courriel' => $_POST['Courriel'] ?? null,
                'n° IntraComm.' => $_POST['n°_IntraComm_'] ?? null,
                'n° SIRET' => $_POST['n°_SIRET'] ?? null,
                'Code Regroupement' => $_POST['Code_Regroupement'] ?? null,
                'D/H modif.' => date('Y-m-d H:i:s'),
                'Modif. par' => 'System'
            ];
            
            $sql = "UPDATE `liste_des_clients` SET
                `Nom` = :Nom, `Adresse` = :Adresse, `Complément` = :Complément, `Code Postal` = :Code_Postal,
                `Ville` = :Ville, `Pays` = :Pays, `Nom court` = :Nom_court, `Ville Libre` = :Ville_Libre,
                `CP Cedex` = :CP_Cedex, `Téléphone` = :Téléphone, `Fax` = :Fax, `Courriel` = :Courriel,
                `n° IntraComm.` = :n°_IntraComm_, `n° SIRET` = :n°_SIRET, `Code Regroupement` = :Code_Regroupement,
                `D/H modif.` = :DhModif, `Modif. par` = :Modif_par
                WHERE `Code` = :Code";

            $stmt = $conn->prepare($sql);

            foreach ($clientData as $key => $value) {
                $stmt->bindValue(":$key", $value, $value === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            }

            if ($stmt->execute()) {
                $message = 'Client mis à jour avec succès.';
            } else {
                $message = 'Erreur lors de la mise à jour du client.';
            }
            break;

        case 'delete':
            // Suppression d'un client
            $code = $_POST['Code'] ?? null;

            $sql = "DELETE FROM `liste_des_clients` WHERE `Code` = :Code";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':Code', $code, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $message = 'Client supprimé avec succès.';
            } else {
                $message = 'Erreur lors de la suppression du client.';
            }
            break;

        default:
            $message = 'Action non reconnue.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Clients - Adex Logistique</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS.css">
</head>
<body>
    <header class="bg-danger text-white py-4">
        <div class="container">
            <h1 class="text-center">Adex Logistique - Gestion des Clients</h1>
        </div>
    </header>

    <nav class="bg-dark text-white py-2">
        <div class="container">
            <a href="index.php" class="text-white">Accueil</a>
            <a href="send_email.html" class="text-white">Envoyer des Relances</a>
            <a href="interfaces_bdd.php" class="text-white">Gestion des Clients</a>
        </div>
    </nav>
    <section class="container mt-4">
        <?php if (isset($message)): ?>
            <div class="alert <?= strpos($message, 'Erreur') === false ? 'alert-success' : 'alert-danger' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- Button to Open the Modal -->
        <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#addClientModal">Ajouter un Client</button>

        <!-- Modal for Adding Client -->
    <div class="modal fade" id="addClientModal" tabindex="-1" role="dialog" aria-labelledby="addClientModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addClientModalLabel">Ajouter un Client</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <input type="hidden" name="action" value="add">
                        
                        <div class="form-group">
                            <label for="Sinari_Network">Sinari Network</label>
                            <input type="text" class="form-control" id="Sinari_Network" name="Sinari_Network">
                        </div>

                        <div class="form-group">
                            <label for="Société">Société</label>
                            <input type="text" class="form-control" id="Société" name="Société">
                        </div>

                        <div class="form-group">
                            <label for="Agence">Agence</label>
                            <input type="text" class="form-control" id="Agence" name="Agence">
                        </div>

                        <div class="form-group">
                            <label for="Code">Code</label>
                            <input type="text" class="form-control" id="Code" name="Code">
                        </div>

                        <div class="form-group">
                            <label for="Nom">Nom</label>
                            <input type="text" class="form-control" id="Nom" name="Nom">
                        </div>

                        <div class="form-group">
                            <label for="Adresse">Adresse</label>
                            <input type="text" class="form-control" id="Adresse" name="Adresse">
                        </div>

                        <div class="form-group">
                            <label for="Complément">Complément</label>
                            <input type="text" class="form-control" id="Complément" name="Complément">
                        </div>

                        <div class="form-group">
                            <label for="Code_Postal">Code Postal</label>
                            <input type="text" class="form-control" id="Code_Postal" name="Code_Postal">
                        </div>

                        <div class="form-group">
                            <label for="Ville">Ville</label>
                            <input type="text" class="form-control" id="Ville" name="Ville">
                        </div>

                        <div class="form-group">
                            <label for="Pays">Pays</label>
                            <input type="text" class="form-control" id="Pays" name="Pays">
                        </div>

                        <div class="form-group">
                            <label for="Nom_court">Nom court</label>
                            <input type="text" class="form-control" id="Nom_court" name="Nom_court">
                        </div>

                        <div class="form-group">
                            <label for="Ville_Libre">Ville Libre</label>
                            <input type="text" class="form-control" id="Ville_Libre" name="Ville_Libre">
                        </div>

                        <div class="form-group">
                            <label for="CP_Cedex">CP Cedex</label>
                            <input type="text" class="form-control" id="CP_Cedex" name="CP_Cedex">
                        </div>

                        <div class="form-group">
                            <label for="Téléphone">Téléphone</label>
                            <input type="text" class="form-control" id="Téléphone" name="Téléphone">
                        </div>

                        <div class="form-group">
                            <label for="Fax">Fax</label>
                            <input type="text" class="form-control" id="Fax" name="Fax">
                        </div>

                        <div class="form-group">
                            <label for="Courriel">Courriel</label>
                            <input type="email" class="form-control" id="Courriel" name="Courriel">
                        </div>

                        <div class="form-group">
                            <label for="n°_IntraComm_">n° IntraComm.</label>
                            <input type="text" class="form-control" id="n°_IntraComm_" name="n°_IntraComm_">
                        </div>

                        <div class="form-group">
                            <label for="n°_SIRET">n° SIRET</label>
                            <input type="text" class="form-control" id="n°_SIRET" name="n°_SIRET">
                        </div>

                        <div class="form-group">
                            <label for="Code_Regroupement">Code Regroupement</label>
                            <input type="text" class="form-control" id="Code_Regroupement" name="Code_Regroupement">
                        </div>

                        <div class="form-group">
                            <label for="DhCreation">D/H création</label>
                            <input type="text" class="form-control" id="DhCreation" name="DhCreation" readonly value="<?= date('Y-m-d H:i:s') ?>">
                        </div>

                        <div class="form-group">
                            <label for="CreationPar">Création Par</label>
                            <input type="text" class="form-control" id="CreationPar" name="CreationPar" readonly value="System">
                        </div>

                        <div class="form-group">
                            <label for="DhModif">D/H modif.</label>
                            <input type="text" class="form-control" id="DhModif" name="DhModif" readonly value="<?= date('Y-m-d H:i:s') ?>">
                        </div>

                        <div class="form-group">
                            <label for="Modif_par">Modif. par</label>
                            <input type="text" class="form-control" id="Modif_par" name="Modif_par" readonly value="System">
                        </div>

                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        <!-- Formulaire de mise à jour de client -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>Modifier un Client</h2>
            </div>
            <div class="card-body">
                <form method="post">
                    <input type="hidden" name="action" value="update">
                    <div class="form-group">
                        <label for="Code">Code du Client</label>
                        <input type="text" class="form-control" id="Code" name="Code">
                    </div>
                    <!-- Ajoutez ici les champs nécessaires pour modifier un client -->
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </form>
            </div>
        </div>

        <!-- Formulaire de suppression de client -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>Supprimer un Client</h2>
            </div>
            <div class="card-body">
                <form method="post">
                    <input type="hidden" name="action" value="delete">
                    <div class="form-group">
                        <label for="Code">Code du Client</label>
                        <input type="text" class="form-control" id="Code" name="Code">
                    </div>
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>

        <!-- Liste des clients -->
        <div class="card">
            <div class="card-header">
                <h2>Liste des Clients</h2>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Sinari Network</th>
                            <th>Société</th>
                            <th>Agence</th>
                            <th>Code</th>
                            <th>Nom</th>
                            <th>Adresse</th>
                            <th>Complément</th>
                            <th>Code Postal</th>
                            <th>Ville</th>
                            <th>Pays</th>
                            <th>Nom court</th>
                            <th>Ville libre</th>
                            <th>CP Cedex</th>
                            <th>Téléphone</th>
                            <th>Fax</th>
                            <th>Courriel</th>
                            <th>n° IntraComm.</th>
                            <th>n° SIRET</th>
                            <th>Code Regroupement</th>
                            <th>D/H création</th>
                            <th>Création par</th>
                            <th>D/H modif.</th>
                            <th>Modif. par</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $conn->query("SELECT * FROM `liste_des_clients`");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['Sinari Network'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['Société'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['Agence'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['Code'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['Nom'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['Adresse'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['Complément'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['Code Postal'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['Ville'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['Pays'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['Nom court'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['Ville libre'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['CP Cedex'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['Téléphone'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['Fax'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['Courriel'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['n° IntraComm.'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['n° SIRET'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['Code Regroupement'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['D/H création'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['Création par'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['D/H modif.'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['Modif. par'] ?? 'N/A') ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </section>

    <footer class="bg-danger text-white py-4">
        <div class="container">
            <p class="text-center">&copy; 2024 Adex Logistique. Tous droits réservés.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>