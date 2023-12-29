<?php
session_start();

define("DB_SERVER", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "tournament");
define("DB_PORT", 3308);

function connectDB() {
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

    if ($conn->connect_error) {
        die("La connexion a échoué : " . $conn->connect_error);
    }

    return $conn;
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function loginUser($conn, $username, $password) {
    $stmt = $conn->prepare("SELECT id_us, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user_data = $result->fetch_assoc();
        // Comparaison des mots de passe sans hachage
        if ($password === $user_data['password']) {
            $_SESSION['user_id'] = $user_data['id_us'];
            $_SESSION['username'] = $user_data['username'];
            return true;
        }
    }

    return false;
}

function registerUser($conn, $newUsername, $newPassword) {
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $newUsername, $newPassword);
    $stmt->execute();

    if ($stmt->affected_rows === 1) {
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['username'] = $newUsername;
        return true;
    }

    return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = connectDB();

    if (isset($_POST['signin_username']) && isset($_POST['signin_password'])) {
        $username = mysqli_real_escape_string($conn, $_POST['signin_username']);
        $password = mysqli_real_escape_string($conn, $_POST['signin_password']);

        if (loginUser($conn, $username, $password)) {
            redirect("home.php");
        } else {
            echo "Identifiants incorrects. Veuillez réessayer.";
        }
    } elseif (isset($_POST['username']) && isset($_POST['password'])) {
        $newUsername = mysqli_real_escape_string($conn, $_POST['username']);
        // Stockage du mot de passe en texte brut
        $newPassword = mysqli_real_escape_string($conn, $_POST['password']);

        if (registerUser($conn, $newUsername, $newPassword)) {
            redirect("signin.php");
        } else {
            echo "Erreur lors de l'enregistrement.";
        }
    }

    $conn->close();
}
?>
