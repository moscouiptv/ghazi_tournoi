<?php
// Inclure le fichier contenant la fonction
require_once('connectToDatabase.php');

// Appeler la fonction pour obtenir la connexion
$conn = connectToDatabase();

// Récupérer l'identifiant du tournoi à partir de la requête AJAX
$tournoiId = $_POST['tournoi_id'];

// Sélectionner les équipes pour le tournoi spécifié
$sql = "SELECT id_equipe, nom_equipe FROM equipe WHERE id_tournoi = $tournoiId";
$result = $conn->query($sql);

// Construire les options du menu déroulant
$options = '';
while ($row = $result->fetch_assoc()) {
    $options .= "<option value=\"{$row['id_equipe']}\">{$row['nom_equipe']}</option>";
}

// Retourner les options au script AJAX
echo $options;
?>
