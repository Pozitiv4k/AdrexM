<?php
session_start();
include '../include/auth.php';
include '../include/nav.php';

$conn = new mysqli("localhost", "root", "", "examen");
$user = $_SESSION['username'];

// Filtru după status (GET)
$statusFilter = "";
if (isset($_GET['status']) && $_GET['status'] !== '') {
    $status = $conn->real_escape_string($_GET['status']);
    $statusFilter = " AND t.status = '$status'";
} else {
    $status = '';
}

$tasks = $conn->query("SELECT t.*, c.login AS client_login FROM tasks t 
                       JOIN clients c ON t.client_id = c.id 
                       WHERE t.atribuit_la = '$user' $statusFilter");
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskuri Utilizator</title>
    <link rel="stylesheet" href="../css/s.css">
    <style>
        button {
            padding: 5px 10px;
            margin: 2px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .start-btn { background-color: #28a745; color: white; }
        .replanifica-btn { background-color: #ffc107; color: black; }
    </style>
</head>
<body>
<div class="main-page-content">
    <h2>Taskuri alocate pentru <?= htmlspecialchars($user) ?></h2>

    <!-- Filtru status -->
    <form method="GET" style="margin-bottom: 20px;">
        <label for="status">Filtrează după status:</label>
        <select name="status" id="status" onchange="this.form.submit()">
            <option value="programat" <?= $status === 'programat' ? 'selected' : '' ?>>Programat</option>
            <option value="in lucru" <?= $status === 'in_lucru' ? 'selected' : '' ?>>În lucru</option>
            <option value="finalizat" <?= $status === 'finalizat' ? 'selected' : '' ?>>Finalizat</option>
        </select>
    </form>

    <!-- Tabel taskuri -->
    <table>
        <tr>
            <th>Tip</th><th>Descriere</th><th>Adresă</th><th>Client</th><th>Status</th><th>Acțiuni</th>
        </tr>
        <?php while ($t = $tasks->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($t['tip']) ?></td>
            <td><?= htmlspecialchars($t['descriere']) ?></td>
            <td><?= htmlspecialchars($t['adresa']) ?></td>
            <td><?= htmlspecialchars($t['client_login']) ?></td>
            <td><?= htmlspecialchars($t['status']) ?></td>
            <td>
                <?php if ($t['status'] != 'finalizat'): ?>
    <a href="instalare_task.php?task_id=<?= $t['id'] ?>">
        <button class="start-btn">Start Task</button>
    </a>
    <form method="POST" action="replanifica_task.php" style="display:inline;">
        <input type="hidden" name="task_id" value="<?= $t['id'] ?>">
        <input type="hidden" name="redirect_status" value="<?= $status ?>">
        <button class="replanifica-btn" type="submit"
            onclick="return confirm('Ești sigur că vrei să replanifici acest task?')">
            Replanifică
        </button>
    </form>
<?php else: ?>
    ✔️ Finalizat
<?php endif; ?>

            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php if (isset($_SESSION['replanificat'])): ?>
<script>
    alert('✅ Task replanificat cu succes!');
</script>
<?php unset($_SESSION['replanificat']); endif; ?>

</body>
</html>
