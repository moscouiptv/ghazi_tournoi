<?php

function connectToDatabase() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tournament";
    $port = 3308;

    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    return $conn;
}

?>
