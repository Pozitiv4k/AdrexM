<?php
include '../include/auth.php';
include '../include/nav.php';

$conn = new mysqli("localhost", "root", "", "examen");
$tasks = $conn->query("SELECT t.*, c.login AS client_login FROM tasks t JOIN clients c ON t.client_id = c.id");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/s.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <title>Admin</title>
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
        <td><?= $t['status'] ?></td>
        <td>
            <form method="POST" action="programare_task.php" style="display:inline;">
                <input type="hidden" name="task_id" value="<?= $t['id'] ?>">
                <button name="action" value="programare">Programează</button>
            </form>
            <form method="POST" action="transmitere_task.php" style="display:inline;">
                <input type="hidden" name="task_id" value="<?= $t['id'] ?>">
                <button name="action" value="transmitere">Transmite</button>
            </form>
            <form method="POST" action="sterge_task.php" style="display:inline;" onsubmit="return confirm('Sigur?')">
                <input type="hidden" name="task_id" value="<?= $t['id'] ?>">
                <button name="action" value="sterge">Șterge</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
</div>
</body>
</html>