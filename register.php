<?php
require('db.php');
session_start();
// După ce se inserează utilizatorul în baza de date


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $is_superuser = 0; // setăm implicit la 0, poți modifica după cum e necesar
    $inspector = 0; // setăm implicit la 0

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Creăm declarația pregătită
    $sql = "INSERT INTO users (username, password, is_superuser, inspector) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    // Legăm parametrii și executăm declarația pregătită
    $stmt->bind_param("ssii", $username, $hashed_password, $is_superuser, $inspector);
    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Eroare la înregistrare: " . $stmt->error;
    }

    $stmt->close();
}
add_log($conn, $_SESSION['user_id'], "Creare utilizator", "Utilizator nou: $username");
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Înregistrare</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Înregistrare</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Nume de utilizator:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Parolă:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Înregistrare</button>
        </form>
        <?php
        if (isset($error)) {
            echo "<div class='alert alert-danger mt-3'>$error</div>";
        }
        ?>
        <p class="mt-3">Ai deja un cont? <a href="login.php">Autentifică-te aici</a>.</p>
    </div>
</body>
</html>
