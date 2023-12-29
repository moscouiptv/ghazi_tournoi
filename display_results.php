<?php
session_start();

// Vérification si l'utilisateur est connecté, sinon le rediriger vers signin.php
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

// Inclure le fichier contenant la fonction
require_once('connectToDatabase.php');

// Appeler la fonction pour obtenir la connexion
$conn = connectToDatabase();

// Récupérer les tournois de l'utilisateur
$user_id = $_SESSION['user_id'];
$sql = "SELECT id_tournoi, intitule FROM tournoi WHERE id_user = $user_id";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="images/favicon-32x32.png">
    <link rel="stylesheet" href="css/results.css">
    <title>Résultats des Tournois</title>
</head>
<body>

<header>
    <a href="home.php" class="logo">
        <img src="images/logo.png" alt="Logo Gestion de tournoi">
    </a>

    <nav class="navigation">
        <a href="home.php">Accueil</a>
        <a href="enregister_tournois.php">Nouveau Tournoi</a>
        <a href="display_results.php">Voir Résultats</a>
        <a href="results_matchs.php">Résultats Matchs</a>
        <a href="dashboard.php">Dashboard</a>
    </nav>
</header>

<main>
    <h1>Résultats des Tournois</h1>

    <form action="display_results.php" method="post" id="displayResultsForm">
        <label for="tournoi_id">Sélectionner un Tournoi:</label>
        <select id="tournoi_id" name="tournoi_id" required>
            <?php
            // Afficher les options du menu déroulant avec les tournois de l'utilisateur
            while ($row = $result->fetch_assoc()) {
                echo "<option value=\"{$row['id_tournoi']}\">{$row['intitule']}</option>";
            }
            ?>
        </select><br>

        <input type="submit" value="Afficher Résultats">
    </form>

    <?php
    // Afficher les résultats du tournoi sélectionné s'il y a un formulaire posté
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $selectedTournoiId = $_POST['tournoi_id'];

        // Récupérer les informations du tournoi sélectionné
        $sqlTournoi = "SELECT * FROM tournoi WHERE id_tournoi = $selectedTournoiId";
        $resultTournoi = $conn->query($sqlTournoi);

        if ($resultTournoi->num_rows > 0) {
            $rowTournoi = $resultTournoi->fetch_assoc();

            // Afficher les informations du tournoi
            echo "<h2>Informations du Tournoi</h2>";
            echo "<p>Intitulé du Tournoi: {$rowTournoi['intitule']}</p>";
            echo "<p>Nombre d'équipes: {$rowTournoi['nbre_equipes']}</p>";
            echo "<p>Date de début: {$rowTournoi['date_debut']}</p>";
            echo "<p>Date de fin: {$rowTournoi['date_fin']}</p>";

            // Récupérer les équipes du tournoi
            $sqlEquipes = "SELECT * FROM equipe WHERE tournoi_id = $selectedTournoiId";
            $resultEquipes = $conn->query($sqlEquipes);

            if ($resultEquipes->num_rows > 0) {
                echo "<h2>Équipes du Tournoi</h2>";
                echo "<table>";
                echo "<tr><th>Nom de l'Équipe</th><th>Pays</th><th>Autres Informations</th></tr>";
                while ($equipeRow = $resultEquipes->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$equipeRow['nom_equipe']}</td>";
                    echo "<td>{$equipeRow['pays']}</td>";
                    echo "<td>{$equipeRow['autres_informations']}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Aucune équipe n'est actuellement inscrite à ce tournoi.</p>";
            }
        } else {
            echo "<p>Le tournoi sélectionné n'existe pas ou a été supprimé.</p>";
        }
    }
    ?>
</main>

<footer class="footer">
    <p>&copy; 2023 Tous droits réservés <span><a href="https://moscouiptv.com">moscouiptv.com</a></span>.</p>
</footer>
</body>
</html>

<?php
// Fermer la connexion à la base de données
$conn->close();
?>
