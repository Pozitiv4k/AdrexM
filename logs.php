<?php
include 'nav.php';
require 'db.php'; // Conectare la baza de date

// Verifică dacă utilizatorul este autentificat ca administrator
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php");
    exit();
}

// Căutare în loguri
$search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';
$user_id = $_GET['user_id'] ?? '';

// Construim interogarea dinamic
$query = "SELECT logs.id, users.username, logs.action, logs.details, logs.timestamp 
          FROM logs 
          LEFT JOIN users ON logs.user_id = users.id 
          WHERE (logs.action LIKE ? OR logs.details LIKE ?)";

$params = [$search, $search];

if (!empty($start_date)) {
    $query .= " AND logs.timestamp >= ?";
    $params[] = $start_date;
}
if (!empty($end_date)) {
    $query .= " AND logs.timestamp <= ?";
    $params[] = $end_date;
}
if (!empty($user_id)) {
    $query .= " AND logs.user_id = ?";
    $params[] = $user_id;
}

$query .= " ORDER BY logs.timestamp DESC";

$stmt = $conn->prepare($query);
$stmt->execute($params);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Descărcare loguri
if (isset($_GET['download'])) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=logs.csv');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['ID', 'Utilizator', 'Acțiune', 'Detalii', 'Data']);
    foreach ($logs as $row) {
        fputcsv($output, $row);
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loguri</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Loguri</h2>
    <form method="GET">
    <input type="text" name="search" placeholder="Caută loguri" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
    
    <input type="date" name="start_date" value="<?php echo $_GET['start_date'] ?? ''; ?>">
    <input type="date" name="end_date" value="<?php echo $_GET['end_date'] ?? ''; ?>">

    <select name="user_id">
        <option value="">Toți utilizatorii</option>
        <?php
        $users = $conn->query("SELECT id, username FROM users")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($users as $user) {
            $selected = (isset($_GET['user_id']) && $_GET['user_id'] == $user['id']) ? 'selected' : '';
            echo "<option value='{$user['id']}' $selected>{$user['username']}</option>";
        }
        ?>
    </select>

    <button type="submit">Filtrează</button>
</form>
    <a href="logs.php?download=1">Descarcă CSV</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Utilizator</th>
            <th>Acțiune</th>
            <th>Detalii</th>
            <th>Data</th>
        </tr>
        <?php foreach ($logs as $log): ?>
        <tr>
            <td><?php echo $log['id']; ?></td>
            <td><?php echo htmlspecialchars($log['username'] ?? 'Sistem'); ?></td>
            <td><?php echo htmlspecialchars($log['action']); ?></td>
            <td><?php echo htmlspecialchars($log['details']); ?></td>
            <td><?php echo $log['timestamp']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
