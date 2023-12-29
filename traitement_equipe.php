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

// Récupérer les données du formulaire
$nomEquipe = $_POST['nom_equipe'];
$pays = $_POST['pays'];
$autresInformations = $_POST['autres_informations'];
$tournoiId = $_POST['tournoi_id'];
$userId = $_SESSION['user_id'];

// Insertion des données dans la table 'equipe'
$sql = "INSERT INTO equipe (nom_equipe, pays, autres_informations, tournoi_id, user_id) 
        VALUES ('$nomEquipe', '$pays', '$autresInformations', '$tournoiId', '$userId')";

if ($conn->query($sql) === TRUE) {
    // Rediriger vers la même page avec un paramètre pour indiquer le succès
    header("Location: equipeForme.php?success=true");
    exit();
} else {
    echo "Erreur lors de l'ajout de l'équipe : " . $conn->error;
}

// Fermer la connexion à la base de données
$conn->close();
?>
