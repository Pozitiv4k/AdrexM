<?php
include '../include/auth.php';
include '../include/nav.php';

$conn = new mysqli("localhost", "root", "", "examen");
$tasks = $conn->query("SELECT t.*, c.login AS client_login FROM tasks t JOIN clients c ON t.client_id = c.id");

// obținem toți utilizatorii pentru dropdown
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
    <title>Admin - Taskuri</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            z-index: 1000;
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
    <table>
        <tr>
            <th>Tip</th><th>Descriere</th><th>Adresă</th><th>Client</th><th>Status</th><th>Acțiuni</th>
        </tr>
        <?php while($t = $tasks->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($t['tip']) ?></td>
                <td><?= htmlspecialchars($t['descriere']) ?></td>
                <td><?= htmlspecialchars($t['adresa']) ?></td>
                <td><?= htmlspecialchars($t['client_login']) ?></td>
                <td><?= htmlspecialchars($t['status']) ?></td>
                <td>
                    <button onclick="deschidePopup(<?= $t['id'] ?>)">Programează</button>
                    <button onclick="transmitTask(<?= $t['id'] ?>)">Transmite</button>
                    <form method="POST" action="sterge_task.php" style="display:inline;" onsubmit="return confirm('Sigur?')">
                        <input type="hidden" name="task_id" value="<?= $t['id'] ?>">
                        <button name="action" value="sterge">Șterge</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<!-- POPUP + overlay -->
<div class="overlay" id="overlay"></div>
<div class="popup" id="popup">
    <h3>Programare Task</h3>
    <label for="popup_tehnician">Tehnician:</label>
    <select id="popup_tehnician">
        <option value="">-- Selectează --</option>
        <?php foreach ($users as $u): ?>
            <option value="<?= $u ?>"><?= $u ?></option>
        <?php endforeach; ?>
    </select>

    <label for="popup_data">Data programată:</label>
    <input type="text" id="popup_data">

    <input type="hidden" id="popup_task_id">
    <button onclick="confirmProgramare()">Confirmă</button>
    <button onclick="inchidePopup()">Anulează</button>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#popup_data", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: "today"
    });

    function deschidePopup(taskId) {
        document.getElementById("popup_task_id").value = taskId;
        document.getElementById("overlay").style.display = "block";
        document.getElementById("popup").style.display = "block";
    }

    function inchidePopup() {
        document.getElementById("overlay").style.display = "none";
        document.getElementById("popup").style.display = "none";
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
            body: `task_id=${taskId}&tehnician=${encodeURIComponent(tehnician)}&data_programata=${encodeURIComponent(data)}&submit_programare=1`
        }).then(() => location.reload());
    }

    function transmitTask(taskId) {
        const user = prompt("Introduceți numele tehnicianului către care transmiteți:");
        if (!user) return;

        fetch('transmitere_task.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `task_id=${taskId}&tehnician=${encodeURIComponent(user)}`
        }).then(() => location.reload());
    }
</script>
</body>
</html>
