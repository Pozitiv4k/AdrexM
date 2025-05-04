<?php
include '../include/auth.php';
include '../include/nav.php';
include '../logs/log_helper.php';

$conn = new mysqli("localhost", "root", "", "examen");
if ($conn->connect_error) {
    die("Eroare conexiune DB: " . $conn->connect_error);
}

if (!isset($_POST['task_id'])) {
    die("ID-ul taskului lipsește.");
}

$task_id = (int)$_POST['task_id'];

$sql = "SELECT t.*, c.login AS client_login FROM tasks t JOIN clients c ON t.client_id = c.id WHERE t.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $task_id);
$stmt->execute();
$result = $stmt->get_result();
$task = $result->fetch_assoc();

if (!$task) {
    die("Taskul nu a fost găsit.");
}

$tehnicieni = [];
$res = $conn->query("SELECT username FROM users");
while ($r = $res->fetch_assoc()) {
    $tehnicieni[] = $r['username'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_transmitere'])) {
    $tehnician = $_POST['tehnician'];
    $noua_data = $_POST['data_programata'] ?: null;

    $update = $conn->prepare("UPDATE tasks SET asignat_la = ?, status = 'in_lucru', data_programata = ? WHERE id = ?");
    if ($update === false) {
        die("Eroare la pregătirea interogării de actualizare: " . $conn->error);
    }

    $update->bind_param("ssi", $tehnician, $noua_data, $task_id);
    $update->execute();

    adaugaLog('taskuri', "{$_SESSION['username']} a transmis taskul ID $task_id către $tehnician, programat pentru $noua_data.");
    echo "<p style='color:green;'>Task transmis către $tehnician.</p>";
    echo "<a href='tasks.php'>Înapoi la Taskuri</a>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/s.css">
    <title>Transmitere Task</title>
</head>
<body>
<div class="main-page-content">
    <h2>Transmitere Task</h2>
    <p><strong>Client:</strong> <?= htmlspecialchars($task['client_login']) ?></p>
    <p><strong>Tip Task:</strong> <?= htmlspecialchars($task['tip']) ?></p>
    <p><strong>Descriere:</strong> <?= htmlspecialchars($task['descriere']) ?></p>
    <p><strong>Adresă:</strong> <?= htmlspecialchars($task['adresa']) ?></p>
    <p><strong>Data curentă programare:</strong> <?= htmlspecialchars($task['data_programata']) ?></p>

    <form method="POST">
        <input type="hidden" name="task_id" value="<?= $task_id ?>">

        <label for="tehnician">Alege tehnician:</label>
        <select name="tehnician" required>
            <option value="">-- Alege --</option>
            <?php foreach ($tehnicieni as $tech): ?>
                <option value="<?= $tech ?>"><?= $tech ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="data_programata">Data programare (opțional):</label>
        <input type="datetime-local" name="data_programata" value="<?= date('Y-m-d\TH:i', strtotime($task['data_programata'])) ?>"><br><br>

        <button type="submit" name="submit_transmitere">Transmite Task</button>
    </form>
</div>
</body>
</html>
