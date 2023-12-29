<?php
session_start();

// Vérification si l'utilisateur est connecté, sinon le rediriger vers signin.php
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

// Inclure le fichier contenant la fonction
require_once('connectToDatabase.php');

// Message pour afficher les erreurs
$error_message = "";

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Appeler la fonction pour obtenir la connexion
    $conn = connectToDatabase();

    $selectedTournoiId = $_POST['id_tournoi'];
    $equipe1 = $_POST['equipe1'];
    $equipe2 = $_POST['equipe2'];
    $score_equipe1 = $_POST['score_equipe1'];
    $score_equipe2 = $_POST['score_equipe2'];

    // Vérifier que les équipes sélectionnées ne sont pas les mêmes
    if ($equipe1 == $equipe2) {
        $error_message = "Veuillez sélectionner des équipes différentes pour Équipe 1 et Équipe 2.";
    } else {
        // Enregistrer les scores dans la table 'match'
        $sqlInsertMatch = "INSERT INTO `match` (id_tournoi, equipe1, equipe2, score_equipe1, score_equipe2) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sqlInsertMatch);
        $stmt->bind_param("issii", $selectedTournoiId, $equipe1, $equipe2, $score_equipe1, $score_equipe2);

        if ($stmt->execute()) {
            // Succès de l'enregistrement
            echo "Scores enregistrés avec succès.";
        } else {
            // Erreur lors de l'enregistrement
            echo "Erreur lors de l'enregistrement des scores : " . $stmt->error;
        }

        // Fermer la connexion à la base de données
        $stmt->close();
    }
}

// Fermer la connexion à la base de données
$conn->close();
?>
