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

// Lista tehnicieni
$tehnicieni = [];
$res = $conn->query("SELECT username FROM users");
while ($r = $res->fetch_assoc()) {
    $tehnicieni[] = $r['username'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_programare'])) {
    $tehnician = $_POST['tehnician'];
    $noua_data = $_POST['data_programata'];

    $update = $conn->prepare("UPDATE tasks SET asignat_la = ?, data_programata = ? WHERE id = ?");
    $update->bind_param("ssi", $tehnician, $noua_data, $task_id);
    $update->execute();

    adaugaLog('tasks', "{$_SESSION['username']} a programat taskul ID $task_id pentru $tehnician la data $noua_data.");
    echo "<p style='color:green;'>Task programat pentru $tehnician la data $noua_data.</p>";
    echo "<a href='tasks.php'>Înapoi la tasks</a>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Programare Task</title>
    <link rel="stylesheet" href="../css/s.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .popup {
            display: none;
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translate(-50%, 0);
            background: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            z-index: 1001;
            width: 300px;
            box-shadow: 0 0 10px #333;
            border-radius: 8px;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }
        button {
            padding: 5px 10px;
        }
    </style>
</head>
<body>
    <div class="main-page-content">
        <h2>Programare Task</h2>
        <p><strong>Client:</strong> <?= htmlspecialchars($task['client_login']) ?></p>
        <p><strong>Tip Task:</strong> <?= htmlspecialchars($task['tip']) ?></p>
        <p><strong>Descriere:</strong> <?= htmlspecialchars($task['descriere']) ?></p>
        <p><strong>Adresă:</strong> <?= htmlspecialchars($task['adresa']) ?></p>
        <p><strong>Data Programare curentă:</strong> <?= htmlspecialchars($task['data_programata']) ?></p>

        <button onclick="deschidePopup()">Programează Task</button>
    </div>

    <!-- Overlay și popup -->
    <div class="overlay" id="overlay"></div>
    <div class="popup" id="popup">
        <form method="POST">
            <input type="hidden" name="task_id" value="<?= $task_id ?>">

            <label for="tehnician">Selectează Tehnician:</label>
            <select name="tehnician" required>
                <option value="">-- Alege --</option>
                <?php foreach ($tehnicieni as $tech): ?>
                    <option value="<?= $tech ?>"><?= $tech ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="data_programata">Selectează Data:</label>
            <input type="text" name="data_programata" id="data_programata" required><br><br>

            <button type="submit" name="submit_programare">Confirmă</button>
            <button type="button" onclick="inchidePopup()">Anulează</button>
        </form>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#data_programata", {
            dateFormat: "Y-m-d",
            minDate: "today"
        });

        function deschidePopup() {
            document.getElementById("overlay").style.display = "block";
            document.getElementById("popup").style.display = "block";
        }

        function inchidePopup() {
            document.getElementById("overlay").style.display = "none";
            document.getElementById("popup").style.display = "none";
        }
    </script>
</body>
</html>
