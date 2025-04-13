<?php
include("../include/auth.php");
include("../include/nav.php");
include("../db/db.php"); // Include conexiunea la baza de date

function citesteLoguri($categorie) {
    global $conn;

    if (!$conn) {
        die("Eroare: Conexiunea la baza de date nu este validă!");
    }

    $stmt = $conn->prepare("SELECT mesaj, created_at FROM logs WHERE categorie = ? ORDER BY created_at DESC");

    if (!$stmt) {
        die("Eroare SQL: " . $conn->error);
    }

    $stmt->bind_param("s", $categorie);
    $stmt->execute();
    $result = $stmt->get_result();

    $loguri = [];
    while ($row = $result->fetch_assoc()) {
        $loguri[] = "[" . $row['created_at'] . "] " . $row['mesaj'];
    }

    $stmt->close();
    return $loguri;
}


// Verificăm categoria selectată
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
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/styl.css" rel="stylesheet">
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
    <form action="logs/export_logs.php" method="GET">
    <label for="duration">Selectează durata:</label>
    <select name="duration" id="duration">
        <option value="1day">Ultima zi</option>
        <option value="1week">Ultima săptămână</option>
        <option value="1month">Ultima lună</option>
    </select>
    <input type="hidden" name="categorie" value="<?php echo htmlspecialchars($categorie); ?>">
    <button type="submit">Exportă Loguri Excel</button>
</form>

</form>

    <?php foreach ($loguri as $log): ?>
        <div class="log"><?php echo htmlspecialchars($log); ?></div>
    <?php endforeach; ?>
    
</body>
</html>
