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
$stmt->bind_param("i", $task_id);
$stmt->execute();
$result = $stmt->get_result();
$task = $result->fetch_assoc();

if (!$task) {
    die("Taskul nu a fost găsit.");
}

// Preluăm lista de utilizatori (tehnicieni)
$tehnicieni = [];
$res = $conn->query("SELECT username FROM users");
while ($r = $res->fetch_assoc()) {
    $tehnicieni[] = $r['username'];
}

// Formulă finalizare transmitere
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_transmitere'])) {
    $tehnician = $_POST['tehnician'];
    $noua_data = $_POST['data_programata'];

    // Actualizare task cu tehnicianul asignat și data programării
    $update = $conn->prepare("UPDATE tasks SET asignat_la = ?, status = 'in_lucru', data_programata = ? WHERE id = ?");
    if ($update === false) {
        die("Eroare la pregătirea interogării de actualizare: " . $conn->error);
    }

    $update->bind_param("ssi", $tehnician, $noua_data, $task_id);
    $update->execute();

    // Logăm acțiunea
    adaugaLog('taskuri', "{$_SESSION['username']} a transmis taskul ID $task_id către $tehnician, programat pentru $noua_data.");
    echo "<p style='color:green;'>Task transmis către $tehnician.</p>";
    echo "<a href='tasks.php'>Înapoi la Taskuri</a>";
    exit;
}
?>

<h2>Transmitere Task</h2>
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

    <label for="data_programata">Reprogramează (opțional):</label>
    <input type="date" name="data_programata" value="<?= $task['data_programata'] ?>"><br><br>

    <button type="submit" name="submit_transmitere">Transmite Task</button>
</form>
