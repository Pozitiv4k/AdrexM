<?php
include '../include/auth.php';
include '../include/nav.php';

$conn = new mysqli("localhost", "root", "", "examen");

// Filtru după status
$filtru = $_GET['filtru'] ?? 'toate';

$sql = "SELECT t.*, c.login AS client_login, t.tehnician FROM tasks t 
        JOIN clients c ON t.client_id = c.id";
if ($filtru === "programat") {
    $sql .= " WHERE t.status = 'programat'";
} elseif ($filtru === "finalizat") {
    $sql .= " WHERE t.status = 'finalizat'";
} elseif ($filtru === "in_desfasurare") {
    $sql .= " WHERE t.status = 'in_desfasurare'";
}

$tasks = $conn->query($sql);

// lista de utilizatori pentru dropdown
$users_res = $conn->query("SELECT username FROM users");
$users = [];
while ($u = $users_res->fetch_assoc()) {
    $users[] = $u['username'];
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Taskuri</title>
    <link href="../css/s.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .popup, .overlay {
            display: none;
            position: fixed;
            z-index: 1001;
        }
        .overlay {
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
        }
        .popup {
            background: white;
            padding: 20px;
            border-radius: 10px;
            top: 25%;
            left: 50%;
            transform: translate(-50%, -25%);
            width: 300px;
            box-shadow: 0 0 15px #000;
        }
        .popup select, .popup input {
            width: 100%;
            margin-bottom: 10px;
            padding: 6px;
        }
    </style>
</head>
<body>
<div class="main-page-content">
    <h2>Taskuri</h2>

    <form method="get" style="margin-bottom: 15px;">
        <label for="filtru">Filtru status:</label>
        <select name="filtru" id="filtru" onchange="this.form.submit()">
            <option value="toate" <?= $filtru === 'toate' ? 'selected' : '' ?>>Toate</option>
            <option value="programat" <?= $filtru === 'programat' ? 'selected' : '' ?>>Programat</option>
            <option value="finalizat" <?= $filtru === 'finalizat' ? 'selected' : '' ?>>Finalizat</option>
            <option value="in_desfasurare" <?= $filtru === 'in_desfasurare' ? 'selected' : '' ?>>În lucru</option>
        </select>
    </form>

    <table>
        <tr>
            <th>Tip</th><th>Descriere</th><th>Adresă</th><th>Client</th><th>Status</th><th>Tehnician</th><th>Acțiuni</th>
        </tr>
        <?php while ($t = $tasks->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($t['tip']) ?></td>
                <td><?= htmlspecialchars($t['descriere']) ?></td>
                <td><?= htmlspecialchars($t['adresa']) ?></td>
                <td><?= htmlspecialchars($t['client_login']) ?></td>
                <td><?= htmlspecialchars($t['status']) ?></td>
                <td><?= htmlspecialchars($t['tehnician'] ?: '-') ?></td>
                <td>
                    <?php if ($t['status'] === 'De programat'): ?>
                        <button onclick="deschidePopupProgramare(<?= $t['id'] ?>)">Programează</button>
                    <?php endif; ?>
                    <?php if ($t['status'] === 'programat'): ?>
                        <button onclick="deschidePopupTransmitere(<?= $t['id'] ?>)">Transmite</button>
                    <?php endif; ?>
                    <form method="POST" action="sterge_task.php" style="display:inline;" onsubmit="return confirm('Ștergi taskul?')">
                        <input type="hidden" name="task_id" value="<?= $t['id'] ?>">
                        <button>Șterge</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<!-- Overlay -->
<div class="overlay" id="overlay"></div>

<!-- Popup programare -->
<div class="popup" id="popup_programare">
    <h3>Programare</h3>
    <label>Tehnician:</label>
    <select id="popup_tehnician">
        <option value="">-- Selectează --</option>
        <?php foreach ($users as $u): ?>
            <option value="<?= $u ?>"><?= $u ?></option>
        <?php endforeach; ?>
    </select>
    <label>Data:</label>
    <input type="text" id="popup_data">
    <input type="hidden" id="popup_task_id">
    <button onclick="confirmProgramare()">Confirmă</button>
    <button onclick="inchidePopup()">Anulează</button>
</div>

<!-- Popup transmitere -->
<div class="popup" id="popup_transmitere">
    <h3>Transmitere</h3>
    <label>Tehnician:</label>
    <select id="dropdown_tehnician">
        <option value="">-- Selectează --</option>
        <?php foreach ($users as $u): ?>
            <option value="<?= $u ?>"><?= $u ?></option>
        <?php endforeach; ?>
    </select>
    <input type="hidden" id="task_id_transmitere">
    <button onclick="confirmTransmitere()">Confirmă</button>
    <button onclick="inchidePopup()">Anulează</button>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#popup_data", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: "today"
    });

    function deschidePopupProgramare(taskId) {
        document.getElementById("popup_task_id").value = taskId;
        document.getElementById("popup_programare").style.display = "block";
        document.getElementById("overlay").style.display = "block";
    }

    function deschidePopupTransmitere(taskId) {
        document.getElementById("task_id_transmitere").value = taskId;
        document.getElementById("popup_transmitere").style.display = "block";
        document.getElementById("overlay").style.display = "block";
    }

    function inchidePopup() {
        document.getElementById("overlay").style.display = "none";
        document.querySelectorAll(".popup").forEach(p => p.style.display = "none");
    }

    function confirmProgramare() {
        const taskId = document.getElementById("popup_task_id").value;
        const tehnician = document.getElementById("popup_tehnician").value;
        const data = document.getElementById("popup_data").value;

        if (!tehnician || !data) {
            alert("Completează toate câmpurile.");
            return;
        }

        fetch('programare_task.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `task_id=${taskId}&tehnician=${encodeURIComponent(tehnician)}&data_programata=${encodeURIComponent(data)}`
        }).then(() => location.reload());
    }

    function confirmTransmitere() {
        const taskId = document.getElementById("task_id_transmitere").value;
        const user = document.getElementById("dropdown_tehnician").value;

        if (!user) {
            alert("Selectează un tehnician!");
            return;
        }

        fetch('transmitere_task.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `task_id=${taskId}&tehnician=${encodeURIComponent(user)}`
        }).then(() => location.reload());
    }
</script>
</body>
</html>
