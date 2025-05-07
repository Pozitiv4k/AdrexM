<?php
include '../include/auth.php';
include '../include/nav.php';

$conn = new mysqli("localhost", "root", "", "examen");
if ($conn->connect_error) {
    die("Conexiunea a eșuat: " . $conn->connect_error);
}

if (!isset($_GET['task_id'])) {
    die("Lipsește ID-ul taskului.");
}

$task_id = intval($_GET['task_id']);
$tehnician = $_SESSION['username'];

$sql = "SELECT t.*, c.login AS client_login, c.id AS client_id
        FROM tasks t 
        JOIN clients c ON t.client_id = c.id
        WHERE t.id = ? AND t.atribuit_la = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $task_id, $tehnician);
$stmt->execute();
$result = $stmt->get_result();
$task = $result->fetch_assoc();

if (!$task) {
    die("Taskul nu a fost găsit sau nu este alocat acestui tehnician.");
}

if ($task['status'] === 'neinceput') {
    $conn->query("UPDATE tasks SET status = 'in_lucru' WHERE id = $task_id");
    $task['status'] = 'in_lucru';
}

$echipamente = $conn->query("SELECT id, tip_echipament, model_echipament, numar_serie, imagine, pret_piata FROM echipamente WHERE disponibil = 1");
$materiale = $conn->query("SELECT id, tip_material, pret_piata FROM materiale WHERE cantitate > 0");
$cabluri = $conn->query("SELECT id, tip_cablu, pret_piata FROM cabluri WHERE cantitate > 0");
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Instalare Task</title>
    <link href="../css/s.css" rel="stylesheet">
    <style>
        .form-section { margin-bottom: 20px; }
        .item-row { margin-bottom: 10px; }
        .item-row input, .item-row select { margin-right: 10px; }
    </style>
    <script>
        function adaugaRand(tip) {
            const container = document.getElementById(tip + '-container');
            const template = document.getElementById(tip + '-template');
            const clone = template.cloneNode(true);
            clone.classList.remove('hidden');
            clone.removeAttribute('id');
            container.appendChild(clone);
        }
    </script>
</head>
<body>
<div class="main-page-content">
    <h2>Instalare pentru client: <?= htmlspecialchars($task['client_login']) ?></h2>
    <p>Status curent: <strong><?= htmlspecialchars($task['status']) ?></strong></p>

    <form action="finalizare_task.php" method="POST">
        <input type="hidden" name="task_id" value="<?= $task_id ?>">
        <input type="hidden" name="client_id" value="<?= $task['client_id'] ?>">

        <!-- Echipamente -->
        <div class="form-section">
            <h3>Echipamente</h3>
            <div id="echipamente-container"></div>
            <button type="button" onclick="adaugaRand('echipamente')">Adaugă echipament</button>
            <div id="echipamente-template" class="item-row hidden">
                <select name="echipamente_ids[]">
                <?php while ($e = $echipamente->fetch_assoc()): ?>
                     <option value="<?= $e['id'] ?>">
                      <?= htmlspecialchars($e['tip_echipament'] . ' - ' . $e['model_echipament'] . ' - SN: ' . $e['numar_serie'] . ' (' . $e['pret_piata'] . ' MDL)') ?>
                     </option>
                <?php endwhile; ?>

                </select>
            </div>
        </div>

        <!-- Materiale -->
        <div class="form-section">
            <h3>Materiale</h3>
            <div id="materiale-container"></div>
            <button type="button" onclick="adaugaRand('materiale')">Adaugă material</button>
            <div id="materiale-template" class="item-row hidden">
                <select name="materiale_ids[]">
                    <option value="">-- Selectează material --</option>
                    <?php $materiale->data_seek(0); while ($m = $materiale->fetch_assoc()): ?>
                        <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['tip_material'] . ' (' . $m['pret_piata'] . ' MDL)') ?></option>
                    <?php endwhile; ?>
                </select>
                <input type="number" name="materiale_cantitati[]" placeholder="Cantitate" min="1">
            </div>
        </div>

        <!-- Cabluri -->
        <div class="form-section">
            <h3>Cabluri</h3>
            <div id="cabluri-container"></div>
            <button type="button" onclick="adaugaRand('cabluri')">Adaugă cablu</button>
            <div id="cabluri-template" class="item-row hidden">
                <select name="cabluri_ids[]">
                    <option value="">-- Selectează cablu --</option>
                    <?php while ($c = $cabluri->fetch_assoc()): ?>
                        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['tip_cablu'] . ' (' . $c['pret_piata'] . ' MDL/m)') ?></option>
                    <?php endwhile; ?>
                </select>
                <input type="number" name="cabluri_metri[]" placeholder="Metri" step="0.1" min="0.1">
            </div>
        </div>

        <!-- Costuri -->
        <div class="form-section">
            <h3>Costuri adiționale</h3>
            <label>Cost manoperă (MDL):</label>
            <input type="number" name="cost_manopera" step="0.01" required><br><br>

            <label>Lucrări adiționale (descriere):</label>
            <input type="text" name="lucrari_aditionale_descriere"><br><br>

            <label>Cost lucrări adiționale (MDL):</label>
            <input type="number" name="cost_lucrari_aditionale" step="0.01"><br>
        </div>

        <button type="submit">Finalizează Instalarea</button>
    </form>
</div>
</body>
</html>
