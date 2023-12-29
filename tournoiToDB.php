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
// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Récupérer les données du formulaire
$tournamentName = $_POST['intitule'];
$nbreEquipes = $_POST['nbre_equipes'];
$dateDebut = $_POST['date_debut'];
$dateFin = $_POST['date_fin'];
$idUser = $_POST['id_user'];

// Préparer la requête avec un statement
$sql = "INSERT INTO tournoi (id_user, intitule, nbre_equipes, date_debut, date_fin) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Lier les paramètres
$stmt->bind_param("issss", $idUser, $tournamentName, $nbreEquipes, $dateDebut, $dateFin);

// Exécuter la requête
if ($stmt->execute()) {
    // Rediriger vers la même page avec un paramètre pour indiquer le succès
    header("Location: enregister_tournois.php?success=true");
    exit();
} else {
    echo "Erreur lors de l'enregistrement du tournoi : " . $stmt->error;
}

// Fermer le statement et la connexion à la base de données
$stmt->close();
$conn->close();
?>
