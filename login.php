<?php
require("db/db.php");
include("include/auth.php");
include("include/nav.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Creăm declarația pregătită
    $sql = "SELECT id, password, is_superuser FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    // Legăm parametrii și executăm declarația pregătită
    $stmt->bind_param("s", $username);
    $stmt->execute();

    // Obținem rezultatul
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Numărăm rândurile
    $count = $result->num_rows;

    if ($count == 1) {
        // Verificăm parola folosind password_verify
        if (password_verify($password, $row['password'])) {
            $_SESSION['id'] = $row['id']; // Adăugăm id-ul utilizatorului în sesiune
            $_SESSION['username'] = $username;
            $_SESSION['is_superuser'] = $row['is_superuser'];
            header("location: admin.php");
            exit();
        } else {
            $error = "Nume de utilizator sau parolă incorecte.";
        }
    } else {
        $error = "Nume de utilizator sau parolă incorecte.";
    }

    // Închidem declarația pregătită și rezultatul
    $stmt->close();
    $result->close();
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">


<link href="css/style.css" rel="stylesheet">
    <title>Autentificare</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Autentificare</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Nume de utilizator:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Parolă:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Autentificare</button>
        </form>
        <?php
        if (isset($error)) {
            echo "<div class='alert alert-danger mt-3'>$error</div>";
        }
        ?>
    </div>
</body>
</html>
