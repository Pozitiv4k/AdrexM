<?php
require("db/db.php");

// Pornim sesiunea dacă nu a fost deja pornită
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Dacă sesiunea este deja activă și utilizatorul e autentificat,
// nu are rost să mai vadă pagina de login — îl redirecționăm.
if (isset($_SESSION['username'])) {
    header("Location: admin.php");
    exit();
}

// Verificăm dacă sesiunea anterioară a expirat și afișăm un mesaj
if (isset($_GET['expired']) && $_GET['expired'] == 1) {
    $error = "Sesiunea a expirat din cauza inactivității. Vă rugăm să vă autentificați din nou.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Declarație pregătită pentru prevenirea SQL Injection
    $sql = "SELECT id, password, is_superuser FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $count = $result->num_rows;

    if ($count == 1) {
       if (password_verify($password, $row['password'])) {
    $_SESSION['id'] = $row['id'];
    $_SESSION['username'] = $username;
    $_SESSION['is_superuser'] = $row['is_superuser'];
    $_SESSION['login_time'] = time(); // <<< AICI salvăm timpul autentificării
    header("location: admin.php");
    exit();
}
 else {
            $error = "Nume de utilizator sau parolă incorecte.";
        }
    } else {
        $error = "Nume de utilizator sau parolă incorecte.";
    }

    $stmt->close();
    $result->close();
}
?>
<?php
if (isset($_GET['expired']) && $_GET['expired'] == 1) {
    echo "<div class='alert alert-warning mt-3'>Sesiunea a expirat. Te rugăm să te autentifici din nou.</div>";
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autentificare</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5" style="max-width: 500px;">
        <h2 class="text-center mb-4">Autentificare</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Nume de utilizator:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group mt-3">
                <label for="password">Parolă:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Autentificare</button>
            </div>
        </form>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger mt-3 text-center"><?= $error ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
