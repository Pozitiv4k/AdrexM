<?php
session_start();
require('db.php');
include "include/nav.php";

// Procesare actualizare parolă
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPassword = mysqli_real_escape_string($conn, $_POST['newPassword']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);

    if ($newPassword === $confirmPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $username = $_SESSION['username'];
        $sql = "UPDATE users SET password='$hashedPassword' WHERE username='$username'";
        mysqli_query($conn, $sql);
        $successMessage = "Parolă actualizată cu succes!";

        // Înregistrează în log doar dacă parola s-a schimbat
        add_log($conn, $_SESSION['user_id'], "Schimbare parolă", "Parola modificată pentru utilizator ID: {$_SESSION['user_id']}");
    } else {
        $errorMessage = "Parolele nu se potrivesc.";
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Schimbă Parola</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            flex: 1;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            text-align: center;
        }
        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .logo-container img {
            width: 50px;
            height: auto;
            background: none;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Schimbă Parola</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="newPassword">Noua Parolă:</label>
                <input type="password" class="form-control" id="newPassword" name="newPassword" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirmă Parola:</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizează Parola</button>
        </form>
        <?php
        if (isset($successMessage)) {
            echo "<div class='alert alert-success mt-3'>$successMessage</div>";
        }
        if (isset($errorMessage)) {
            echo "<div class='alert alert-danger mt-3'>$errorMessage</div>";
        }
        ?>
    </div>

    <?php include "include/feedback.php"; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</body>
</html>
