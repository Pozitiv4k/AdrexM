<?php
include("../include/auth.php");
include("../include/nav.php");
include("../db/db.php");
?>
<!DOCTYPE html>
    <link href="../css/bootstrap.min.css" rel="stylesheet">

<link href="css/style.css" rel="stylesheet">
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Creare Ofertă Dinamică</title>
    <style>
        body { font-family: Calibri, sans-serif; padding: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        th, td { border: 1px solid #999; padding: 10px; text-align: center; vertical-align: middle; }
        th { background-color: #eee; }
        select, input[type="text"], input[type="number"], textarea { width: 100%; box-sizing: border-box; }
        textarea { resize: vertical; height: 80px; }
        .add-row-btn, .manual-row-btn { margin: 15px 10px; padding: 8px 16px; }
        .remove-btn { background: red; color: white; border: none; padding: 4px 8px; cursor: pointer; }
        img.preview { max-height: 60px; }
    </style>
    
</head>
<body>

<h2>Creare Ofertă</h2>

<form action="depozit/export_offer.php" method="POST" enctype="multipart/form-data" id="offerForm">
    <table id="offerTable">
        <thead>
            <tr>
                <th>Nr.</th>
                <th>Tip</th>
                <th>Model</th>
                <th>Cantitate</th>
                <th>Imagine</th>
                <th>Preț</th>
                <th>Descriere</th>
                <th>Acțiune</th>
            </tr>
        </thead>
        <tbody id="offerBody">
            <!-- Randuri dinamice -->
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5"></td>
                <td><strong>Total:</strong></td>
                <td><input type="text" name="total_general" id="total_general" readonly></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <button type="button" class="add-row-btn" onclick="addAutoRow()">Adaugă din depozit</button>
    <button type="button" class="manual-row-btn" onclick="addManualRow()">Adaugă manual</button>
    <br><br>
    <button type="submit" name="export" value="excel">Generează Ofertă Excel</button>
    <button type="submit" name="export" value="pdf">Generează Ofertă PDF</button>
</form>

<script>
let index = 1;

function addAutoRow() {
    const row = document.createElement("tr");
    row.innerHTML = `
        <td>${index++}</td>
        <td>
            <select name="items[][tip]" onchange="loadModels(this)">
                <option value="">-- Selectează --</option>
                <option value="echipamente">Echipament</option>
                <option value="materiale">Material</option>
                <option value="cabluri">Cablu</option>
            </select>
        </td>
        <td>
            <select name="items[][model]" onchange="fillDetails(this)" disabled>
                <option value="">-- Selectează model --</option>
            </select>
        </td>
        <td><input type="number" name="items[][cantitate]" value="0" min="0" oninput="calculateTotal()"></td>
        <td><img src="" class="preview" alt=""><input type="hidden" name="items[][imagine]"></td>
        <td><input type="number" name="items[][pret]" step="0.01" oninput="calculateTotal()"></td>
        <td><textarea name="items[][descriere]"></textarea></td>
        <td><button type="button" class="remove-btn" onclick="removeRow(this)">Șterge</button></td>
    `;
    document.getElementById("offerBody").appendChild(row);
}

function addManualRow() {
    const row = document.createElement("tr");
    row.innerHTML = `
        <td>${index++}</td>
        <td><input type="text" name="items[][tip]"></td>
        <td><input type="text" name="items[][model]"></td>
        <td><input type="number" name="items[][cantitate]" value="0" min="0" oninput="calculateTotal()"></td>
        <td><input type="text" name="items[][imagine]"><br><img src="" class="preview" onerror="this.style.display='none'"></td>
        <td><input type="number" name="items[][pret]" step="0.01" oninput="calculateTotal()"></td>
        <td><textarea name="items[][descriere]"></textarea></td>
        <td><button type="button" class="remove-btn" onclick="removeRow(this)">Șterge</button></td>
    `;
    document.getElementById("offerBody").appendChild(row);
}

function removeRow(btn) {
    btn.closest("tr").remove();
    calculateTotal();
}

function loadModels(select) {
    const tip = select.value;
    const row = select.closest("tr");
    const modelSelect = row.querySelector('select[name="items[][model]"]');

    if (!tip) return;

    fetch(`get_item_data.php?tip=${tip}`)
        .then(res => res.json())
        .then(data => {
            modelSelect.innerHTML = '<option value="">-- Selectează model --</option>';
            data.forEach(item => {
                const opt = document.createElement("option");
                opt.value = item.id;
                opt.textContent = item.model;
                opt.dataset.item = JSON.stringify(item);
                modelSelect.appendChild(opt);
            });
            modelSelect.disabled = false;
        });
}

function fillDetails(select) {
    const row = select.closest("tr");
    const selectedOption = select.options[select.selectedIndex];
    if (!selectedOption || !selectedOption.dataset.item) return;

    const item = JSON.parse(selectedOption.dataset.item);
    row.querySelector('img.preview').src = item.imagine;
    row.querySelector('input[name="items[][imagine]"]').value = item.imagine;
    row.querySelector('input[name="items[][pret]"]').value = item.pret_piata;
    row.querySelector('textarea[name="items[][descriere]"]').value = item.descriere || '';
    calculateTotal();
}

function calculateTotal() {
    let total = 0;
    const rows = document.querySelectorAll('#offerBody tr');
    rows.forEach(row => {
        const pret = parseFloat(row.querySelector('input[name="items[][pret]"]')?.value) || 0;
        const cantitate = parseFloat(row.querySelector('input[name="items[][cantitate]"]')?.value) || 0;
        total += pret * cantitate;
    });
    document.getElementById("total_general").value = total.toFixed(2) + " LEU";
}

addAutoRow(); // primul rând automat la încărcare
</script>

</body>
</html>
