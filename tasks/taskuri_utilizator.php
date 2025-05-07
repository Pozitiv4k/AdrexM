<?php
include '../include/auth.php';
include '../include/nav.php';

$conn = new mysqli("localhost", "root", "", "examen");
$user = $_SESSION['username'];

$tasks = $conn->query("SELECT t.*, c.login AS client_login FROM tasks t JOIN clients c ON t.client_id = c.id WHERE t.atribuit_la = '$user'");
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskuri Utilizator</title>
    <link rel="stylesheet" href="../css/s.css">
</head>
<body>
    <div class="main-page-content">
        <h2>Taskuri alocate pentru <?= htmlspecialchars($user) ?></h2>
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
                            <button>Start Task</button>
                        </a>
                    <?php else: ?>
                        ✔️ Finalizat
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
<script>
let rowIndex = 1;
function addInstallRow() {
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>${rowIndex++}</td>
        <td>
            <select name="items[][tip]" onchange="loadInstallModels(this)">
                <option value="">-- Selectează --</option>
                <option value="echipamente">Echipament</option>
                <option value="materiale">Material</option>
                <option value="cabluri">Cablu</option>
                <option value="instrumente">Instrument</option>
            </select>
        </td>
        <td>
            <select name="items[][model]" disabled onchange="fillInstallDetails(this)">
                <option value="">-- Selectează model --</option>
            </select>
        </td>
        <td><input type="number" name="items[][cantitate]" value="1" min="1" oninput="updateRowTotal(this)"></td>
        <td><input type="number" name="items[][pret]" step="0.01" oninput="updateRowTotal(this)"></td>
        <td><input type="text" name="items[][total]" readonly></td>
        <td><button type="button" onclick="this.closest('tr').remove(); calculateInstallTotal();">Șterge</button></td>
    `;
    document.getElementById("installBody").appendChild(row);
}

function loadInstallModels(select) {
    const tip = select.value;
    const row = select.closest('tr');
    const modelSelect = row.querySelector('select[name="items[][model]"]');

    if (!tip) return;

    fetch(`get_item_data.php?tip=${tip}`)
        .then(res => res.json())
        .then(data => {
            modelSelect.innerHTML = '<option value="">-- Selectează model --</option>';
            data.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item.id;
                opt.textContent = item.model;
                opt.dataset.item = JSON.stringify(item);
                modelSelect.appendChild(opt);
            });
            modelSelect.disabled = false;
        });
}

function fillInstallDetails(select) {
    const row = select.closest('tr');
    const item = JSON.parse(select.selectedOptions[0].dataset.item || '{}');
    row.querySelector('input[name="items[][pret]"]').value = item.pret_piata || 0;
    updateRowTotal(row.querySelector('input[name="items[][cantitate]"]'));
}

function updateRowTotal(input) {
    const row = input.closest('tr');
    const cantitate = parseFloat(row.querySelector('input[name="items[][cantitate]"]').value) || 0;
    const pret = parseFloat(row.querySelector('input[name="items[][pret]"]').value) || 0;
    row.querySelector('input[name="items[][total]"]').value = (cantitate * pret).toFixed(2);
    calculateInstallTotal();
}

function calculateInstallTotal() {
    let total = 0;
    document.querySelectorAll('input[name="items[][total]"]').forEach(input => {
        total += parseFloat(input.value) || 0;
    });
    document.getElementById('total_general').value = total.toFixed(2) + ' MDL';
}

addInstallRow(); // prima linie
</script>

</html>
