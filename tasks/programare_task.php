<?php
include '../include/auth.php';
include '../include/nav.php';
include '../logs/log_helper.php';

$conn = new mysqli("localhost", "root", "", "examen");
if ($conn->connect_error) {
    die("Eroare conexiune DB: " . $conn->connect_error);
}

// Verificăm dacă există ID task
if (!isset($_POST['task_id'])) {
    die("ID-ul taskului lipsește.");
}

$task_id = (int)$_POST['task_id'];

// Preluăm detalii despre task
$sql = "SELECT t.*, c.login AS client_login FROM tasks t JOIN clients c ON t.client_id = c.id WHERE t.id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Eroare la pregătirea interogării SQL: " . $conn->error);
}

$stmt->bind_param("i", $task_id);
$stmt->execute();

// Verificăm dacă interogarea a returnat rezultate
$result = $stmt->get_result();
if (!$result) {
    die("Eroare la executarea interogării SQL: " . $conn->error);
}

$task = $result->fetch_assoc();

if (!$task) {
    die("Taskul nu a fost găsit.");
}

// Preluăm lista de utilizatori (tehnicieni)
$tehnicieni = [];
$res = $conn->query("SELECT username FROM users");
if (!$res) {
    die("Eroare la preluarea utilizatorilor: " . $conn->error);
}
while ($r = $res->fetch_assoc()) {
    $tehnicieni[] = $r['username'];
}

// Formulă programare task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_programare'])) {
    $tehnician = $_POST['tehnician'];
    $noua_data = $_POST['data_programata'];

    // Actualizăm taskul cu noul tehnician și data programării
    $update = $conn->prepare("UPDATE tasks SET asignat_la = ?, data_programata = ? WHERE id = ?");
    if (!$update) {
        die("Eroare la pregătirea interogării de actualizare: " . $conn->error);
    }
    
    $update->bind_param("ssi", $tehnician, $noua_data, $task_id);
    $update->execute();

    adaugaLog('tasks', "{$_SESSION['username']} a programat taskul ID $task_id pentru $tehnician la data $noua_data.");
    echo "<p style='color:green;'>Task programat pentru $tehnician la data $noua_data.</p>";
    echo "<a href='tasks.php'>Înapoi la tasks</a>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/s.css">
    <title>Programare</title>
</head>
<body>
    <div class="main-page-contenr">
    <h2>Programare Task</h2>
<p><strong>Client:</strong> <?= htmlspecialchars($task['client_login']) ?></p>
<p><strong>Tip Task:</strong> <?= htmlspecialchars($task['tip']) ?></p>
<p><strong>Descriere:</strong> <?= htmlspecialchars($task['descriere']) ?></p>
<p><strong>Adresă:</strong> <?= htmlspecialchars($task['adresa']) ?></p>
<p><strong>Data Programare curentă:</strong> <?= htmlspecialchars($task['data_programata']) ?></p>

<form method="POST">
    <input type="hidden" name="task_id" value="<?= $task_id ?>">
    
    <label for="tehnician">Alege tehnician:</label>
    <select name="tehnician" required>
        <option value="">-- Alege --</option>
        <?php foreach ($tehnicieni as $tech): ?>
            <option value="<?= $tech ?>"><?= $tech ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="data_programata">Nouă dată de programare:</label>
    <input type="date" name="data_programata" value="<?= $task['data_programata'] ?>"><br><br>

    <button type="submit" name="submit_programare">Programează Task</button>
</div>
</form>
</body>
</html>

