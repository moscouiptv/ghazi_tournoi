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

// Récupérer l'ID du tournoi sélectionné depuis le formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedTournoiId = $_POST['tournoi_id'];

    // Récupérer les informations du tournoi sélectionné
    $sql = "SELECT * FROM tournoi WHERE id_tournoi = $selectedTournoiId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Afficher les informations du tournoi
        echo "<h2>Informations du Tournoi</h2>";
        echo "<p>Intitulé du Tournoi: {$row['intitule']}</p>";
        echo "<p>Nombre d'équipes: {$row['nbre_equipes']}</p>";
        echo "<p>Date de début: {$row['date_debut']}</p>";
        echo "<p>Date de fin: {$row['date_fin']}</p>";

        // Afficher les équipes du tournoi
        $sqlEquipes = "SELECT * FROM equipe WHERE tournoi_id = $selectedTournoiId";
        $resultEquipes = $conn->query($sqlEquipes);

        if ($resultEquipes->num_rows > 0) {
            echo "<h2>Équipes du Tournoi</h2>";
            echo "<ul>";
            while ($equipeRow = $resultEquipes->fetch_assoc()) {
                echo "<li>Nom de l'Équipe: {$equipeRow['nom_equipe']}</li>";
                echo "<li>Pays: {$equipeRow['pays']}</li>";
                echo "<li>Autres Informations: {$equipeRow['autres_informations']}</li>";
                echo "<br>";
            }
            echo "</ul>";
        } else {
            echo "<p>Aucune équipe n'est actuellement inscrite à ce tournoi.</p>";
        }
    } else {
        echo "<p>Le tournoi sélectionné n'existe pas ou a été supprimé.</p>";
    }
}

// Fermer la connexion à la base de données
$conn->close();
?>
