<?php
session_start();
include '../include/auth.php';
include '../include/nav.php';

$conn = new mysqli("localhost", "root", "", "examen");
if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

$user = $_SESSION['username'];

// Statusuri valide permise
$validStatuses = ['in_desfasurare', 'finalizat'];
$statusFilter = "";
$status = '';

// Verifică dacă statusul din URL este valid
if (isset($_GET['status']) && in_array($_GET['status'], $validStatuses)) {
    $status = $conn->real_escape_string($_GET['status']);
    $statusFilter = " AND t.status = '$status'";
} else {
    $noStatus = true;
}

// Execută interogarea doar dacă e setat un status valid
$tasks = null;
if (!isset($noStatus)) {
    $tasks = $conn->query("SELECT t.*, c.login AS client_login 
                           FROM tasks t 
                           JOIN clients c ON t.client_id = c.id 
                           WHERE (t.atribuit_la = '$user' OR t.tehnician = '$user') $statusFilter");

    if (!$tasks) {
        echo "Eroare la interogare: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Taskuri Utilizator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <h2>Taskuri alocate pentru utilizatorul: <strong><?= htmlspecialchars($user) ?></strong></h2>

    <!-- Filtru status -->
    <form method="GET" style="margin-bottom: 20px;">
        <label for="status">Filtrează după status:</label>
        <select name="status" id="status" onchange="this.form.submit()">
            <option value="">-- Alege status --</option>
            <option value="in_desfasurare" <?= $status === 'in_desfasurare' ? 'selected' : '' ?>>În lucru</option>
            <option value="finalizat" <?= $status === 'finalizat' ? 'selected' : '' ?>>Finalizat</option>
        </select>
    </form>

    <!-- Tabel taskuri -->
    <table>
        <tr>
            <th>Tip</th><th>Descriere</th><th>Adresă</th><th>Client</th><th>Status</th><th>Acțiuni</th>
        </tr>
        <?php if (isset($noStatus)): ?>
            <tr><td colspan="6">⚠️ Selectează un status pentru a vedea taskurile asignate.</td></tr>
        <?php elseif ($tasks && $tasks->num_rows > 0): ?>
            <?php while ($t = $tasks->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($t['tip']) ?></td>
                    <td><?= htmlspecialchars($t['descriere']) ?></td>
                    <td><?= htmlspecialchars($t['adresa']) ?></td>
                    <td><?= htmlspecialchars($t['client_login']) ?></td>
                    <td><?= htmlspecialchars($t['status']) ?></td>
                    <td>
                        <?php if ($t['status'] !== 'finalizat'): ?>
                            <a href="instalare_task.php?task_id=<?= $t['id'] ?>">
                                <button class="start-btn">Start Task</button>
                            </a>
                            <form method="POST" action="replanifica_task.php" style="display:inline;">
                                <input type="hidden" name="task_id" value="<?= $t['id'] ?>">
                                <input type="hidden" name="redirect_status" value="<?= $status ?>">
                                <button class="replanifica-btn" type="submit"
                                    onclick="return confirm('Ești sigur că vrei să replanifici acest task?\nVa fi eliminat din lista ta.')">
                                    Replanifică
                                </button>
                            </form>
                        <?php else: ?>
                            ✔️ Finalizat
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">❌ Nu sunt taskuri pentru statusul selectat.</td></tr>
        <?php endif; ?>
    </table>
</div>

<!-- Alertă dacă taskul a fost replanificat -->
<?php if (isset($_SESSION['replanificat'])): ?>
<script>
    alert('✅ Task replanificat cu succes!');
</script>
<?php unset($_SESSION['replanificat']); endif; ?>

</body>
</html>
