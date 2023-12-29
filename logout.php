<?php
session_start();

// Destruction de toutes les données de session
session_unset();
session_destroy();

// Redirection vers la page de connexion après déconnexion
header("Location: signin.php");
exit();
?>
