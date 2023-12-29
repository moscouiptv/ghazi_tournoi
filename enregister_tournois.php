<?php
session_start();

// Vérification si l'utilisateur est connecté, sinon le rediriger vers signin.php
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="images/favicon-32x32.png">
    <title>Enregistrer un nouveau tournoi</title>
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

<?php
    // Afficher un message de succès si le paramètre "success" est présent dans l'URL
    if (isset($_GET['success']) && $_GET['success'] == 'true') {
        echo '<p style="color: green;">Nouveau tournoi enregistré avec succès!</p>';
    }
?>

<main>
    <h1>Enregistrer un Tournoi</h1>

    <form action="tournoiToDB.php" method="post" id="tournamentForm">
        <label for="intitule" class="form-label">Intitulé du Tournoi:</label>
        <input type="text" id="intitule" name="intitule" class="form-input" required><br>

        <label for="nbre_equipes" class="form-label">Nombre d'équipes:</label>
        <input type="number" id="nbre_equipes" name="nbre_equipes" class="form-input" required><br>

        <label for="date_debut" class="form-label">Date de début:</label>
        <input type="date" id="date_debut" name="date_debut" class="form-input" required><br>

        <label for="date_fin" class="form-label">Date de fin:</label>
        <input type="date" id="date_fin" name="date_fin" class="form-input"><br>

        <!-- Ajoutez un champ caché pour stocker l'ID de l'utilisateur -->
        <input type="hidden" name="id_user" value="<?php echo $_SESSION['user_id']; ?>">

        <input type="submit" value="Enregistrer" class="form-input">
    </form>

    <!-- Ajoutez un bouton vers equipeForm.php dans la section main -->
    <a href="equipeForme.php" class="form-button">Ajouter une Équipe</a>
</main>

<footer class="footer">
    <p>&copy; 2023 Tous droits réservés <span><a href="https://moscouiptv.com">moscouiptv.com</a></span>.</p>
</footer>

</body>
</html>
