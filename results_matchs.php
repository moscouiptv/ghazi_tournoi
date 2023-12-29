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

// Message pour afficher les erreurs
$error_message = "";
$success_message = "";

// Récupérer les tournois de l'utilisateur
$user_id = $_SESSION['user_id'];
$sql = "SELECT id_tournoi, intitule FROM tournoi WHERE id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Initialiser les variables pour stocker les noms d'équipes
$equipeNames = array();

// Récupérer les noms des équipes si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedTournoiId = $_POST['tournoi_id'] ?? null;

    // Récupérer les noms des équipes du tournoi sélectionné
    $sqlEquipes = "SELECT nom_equipe FROM equipe WHERE tournoi_id = ?";
    $stmtEquipes = $conn->prepare($sqlEquipes);
    $stmtEquipes->bind_param("i", $selectedTournoiId);
    $stmtEquipes->execute();
    $resultEquipes = $stmtEquipes->get_result();

    if ($resultEquipes->num_rows > 0) {
        while ($equipeRow = $resultEquipes->fetch_assoc()) {
            $equipeNames[] = $equipeRow['nom_equipe'];
        }
    }

    // Fermer la connexion à la base de données
    $stmtEquipes->close();
}

// Enregistrement des scores
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['enregistrer_scores'])) {
    $selectedTournoiId = $_POST['tournoi_id'];
    $equipe1 = $_POST['equipe1'];
    $score_equipe1 = $_POST['score_equipe1'];
    $equipe2 = $_POST['equipe2'];
    $score_equipe2 = $_POST['score_equipe2'];

    // Vérifier que les équipes sélectionnées ne sont pas les mêmes
    if ($equipe1 == $equipe2) {
        $error_message = "Veuillez sélectionner des équipes différentes pour Équipe 1 et Équipe 2.";
    } else {
        // Enregistrer les scores dans la table 'match'
        $sqlInsertMatch = "INSERT INTO `match` (id_tournoi, equipe1, equipe2, score_equipe1, score_equipe2) VALUES (?, ?, ?, ?, ?)";
        $stmtInsertMatch = $conn->prepare($sqlInsertMatch);
        $stmtInsertMatch->bind_param("isssi", $selectedTournoiId, $equipe1, $equipe2, $score_equipe1, $score_equipe2);

        if ($stmtInsertMatch->execute()) {
            // Succès de l'enregistrement
            $success_message = "Scores enregistrés avec succès.";
        } else {
            // Erreur lors de l'enregistrement
            $error_message = "Erreur lors de l'enregistrement des scores : " . $stmtInsertMatch->error;
        }

        // Fermer la connexion à la base de données
        $stmtInsertMatch->close();
    }
}

// Fermer la connexion à la base de données
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="images/favicon-32x32.png">
    <link rel="stylesheet" href="css/matchs.css">
    <title>Résultats des Matchs</title>
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
    <h1>Résultats des Matchs</h1>

    <form action="results_matchs.php" method="post" id="displayResultsForm">
        <label for="tournoi_id">Sélectionner un Tournoi:</label>
        <select id="tournoi_id" name="tournoi_id" required>
            <?php
            // Afficher les options du menu déroulant avec les tournois de l'utilisateur
            while ($row = $result->fetch_assoc()) {
                echo "<option value=\"{$row['id_tournoi']}\">{$row['intitule']}</option>";
            }
            ?>
        </select>
        <br>

        <input type="submit" value="Afficher Résultats">
    </form>

    <?php
    // Afficher le formulaire d'enregistrement des scores
    if (!empty($equipeNames)) {
        echo "<form action=\"results_matchs.php\" method=\"post\">";
        echo "<input type=\"hidden\" name=\"tournoi_id\" value=\"$selectedTournoiId\">";

        echo "<label for=\"equipe1\">Équipe 1:</label>";
        echo "<select id=\"equipe1\" name=\"equipe1\" required>";
        foreach ($equipeNames as $equipeName) {
            echo "<option value=\"$equipeName\">$equipeName</option>";
        }
        echo "</select>";

        echo "<br>";

        echo "<label for=\"score_equipe1\">Score Équipe 1:</label>";
        echo "<input type=\"number\" id=\"score_equipe1\" name=\"score_equipe1\" required>";

        echo "<br>";

        echo "<label for=\"equipe2\">Équipe 2:</label>";
        echo "<select id=\"equipe2\" name=\"equipe2\" required>";
        foreach ($equipeNames as $equipeName) {
            echo "<option value=\"$equipeName\">$equipeName</option>";
        }
        echo "</select>";

        echo "<br>";

        echo "<label for=\"score_equipe2\">Score Équipe 2:</label>";
        echo "<input type=\"number\" id=\"score_equipe2\" name=\"score_equipe2\" required>";

        echo "<br>";

        echo "<input type=\"submit\" name=\"enregistrer_scores\" value=\"Enregistrer Résultats\">";
        echo "</form>";

        // Afficher le message d'erreur ou de succès le cas échéant
        if (!empty($error_message)) {
            echo "<p style=\"color: red;\">$error_message</p>";
        } elseif (!empty($success_message)) {
            echo "<p style=\"color: green;\">$success_message</p>";
        }
    }
    ?>
</main>

<footer class="footer">
    <p>&copy; 2023 Tous droits réservés <span><a href="https://moscouiptv.com">moscouiptv.com</a></span>.</p>
</footer>
</body>
</html>
