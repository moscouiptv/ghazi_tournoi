<?php
session_start();

// Vérification si l'utilisateur est connecté, sinon le rediriger vers signin.php
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="images/favicon-32x32.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>Tournament Management - Register Teams</title>    
</head>
<body>

    <header>
        <!-- <a href="home.html" class="logo">Tournoi Gestionnaire</a> -->
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


    <section class="main">
        <div>
            <h1>Bonjour, <?php echo $username; ?>!</h1>
            <h2>Bienvenue sur notre<br><span>Gestionnaire de tournoi</span></h2>
            <h3>Organisez et suivez facilement vos tournois sportifs</h3>
            <div class="main-buttons">
                <a href="enregister_tournois.php" class="enregistre-btm">Nouveau tournoi</a>
                <a href="display_results.php" class="enregistre-btm">Voir Résultats</a>
                <a href="results_matchs.php" class="enregistre-btm">Résultats Matchs</a>
            </div>
        </div>
    </section>

    <footer class="footer">
          <p>&copy; 2023 Tous droits réservés
            <SPan><a href="https://moscouiptv.com">moscouiptv.com</a></SPan>.</p>
    </footer>
      

</body>
</html>