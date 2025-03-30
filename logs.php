<?php
include("include/auth.php");
include("include/nav.php");
function citesteLoguri($categorie) {
    $fisier = 'logs_' . $categorie . '.txt';
    return file_exists($fisier) ? file($fisier) : [];
}

// Verificăm ce tip de loguri să afișăm
$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : 'clienti';
$categorii_permise = ['clienti', 'materiale', 'utilizatori'];

if (!in_array($categorie, $categorii_permise)) {
    $categorie = 'clienti';
}

$loguri = citesteLoguri($categorie);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Loguri</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .log { padding: 5px; border-bottom: 1px solid #ccc; }
        .filter { margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1>Loguri <?php echo ucfirst($categorie); ?></h1>
    <div class="filter">
        <a href="logs.php?categorie=clienti">Loguri Clienți</a> | 
        <a href="logs.php?categorie=materiale">Loguri Materiale</a> | 
        <a href="logs.php?categorie=utilizatori">Loguri Utilizatori</a>
    </div>
    <?php foreach ($loguri as $log): ?>
        <div class="log"><?php echo htmlspecialchars($log); ?></div>
    <?php endforeach; ?>
</body>
</html>
