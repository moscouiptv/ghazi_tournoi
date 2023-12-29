<?php
// Démarre ou restaure une session
session_start();

// Fonction pour vérifier si l'utilisateur est connecté
function isUserLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Fonction pour rediriger l'utilisateur vers la page de connexion si nécessaire
function redirectToLogin() {
    if (!isUserLoggedIn()) {
        header("Location: signin.php");
        exit();
    }
}

// Fonction pour déconnecter l'utilisateur
function logoutUser() {
    session_unset();
    session_destroy();
    header("Location: signin.php");
    exit();
}
?>
