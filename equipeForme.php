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

// Tableau associatif des tournois
$tournois = array();
while ($row = $result->fetch_assoc()) {
    $tournois[$row['id_tournoi']] = $row['intitule'];
}

// Fermer la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="images/favicon-32x32.png">
    <title>Enregistrer une nouvelle équipe</title>
    <link rel="stylesheet" href="css/nouveau_tournois.css">
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
    <h1>Ajouter une Équipe</h1>

    <form action="traitement_equipe.php" method="post" id="equipeForm">
        <label for="nom_equipe" class="form-label">Nom de l'Équipe:</label>
        <input type="text" id="nom_equipe" name="nom_equipe" class="form-input" required><br>

        <label for="pays" class="form-label">Pays:</label>
        <input type="text" id="pays" name="pays" class="form-input"><br>

        <label for="autres_informations" class="form-label">Autres Informations:</label>
        <textarea id="autres_informations" name="autres_informations" class="form-input"></textarea><br>

        <label for="tournoi_id" class="form-label">Sélectionner un Tournoi:</label>
        <select id="tournoi_id" name="tournoi_id" class="form-input" required>
            <?php
            // Afficher les options du menu déroulant avec les tournois de l'utilisateur
            foreach ($tournois as $id => $intitule) {
                echo "<option value=\"$id\">$intitule</option>";
            }
            ?>
        </select><br>

        <input type="submit" value="Ajouter l'Équipe" class="form-input">
    </form>
</main>

<footer class="footer">
    <p>&copy; 2023 Tous droits réservés <span><a href="https://moscouiptv.com">mos</a></span>.</p>
</footer>

</body>
</html>
