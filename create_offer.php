<?php
include("include/auth.php");
include("include/nav.php");
include("db.php"); // Include conexiunea la baza de date
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Creare Ofertă Detaliată</title>
    <style>
        body {
            font-family: Calibri, sans-serif;
            padding: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        th, td {
            border: 1px solid #999;
            padding: 10px;
            text-align: center;
            vertical-align: middle;
        }
        th {
            background-color: #eee;
        }
        input[type="text"], input[type="number"], textarea {
            width: 100%;
            box-sizing: border-box;
        }
        input[type="file"] {
            width: 100%;
        }
        textarea {
            resize: vertical;
            height: 100px;
        }
        .add-row-btn {
            margin: 20px 0;
            padding: 8px 16px;
        }
    </style>
    <script>
        let rowIndex = 1;

        function addRow() {
            const table = document.getElementById('offerTable');
            const row = table.insertRow(table.rows.length - 1);
            row.innerHTML = `
                <td>${rowIndex++}</td>
                <td><input type="text" name="items[][nume]" required></td>
                <td><input type="file" name="items[][imagine]" accept="image/*"></td>
                <td><input type="text" name="items[][pret]" required></td>
                <td><input type="text" name="items[][pret_final]" required></td>
                <td><textarea name="items[][descriere]"></textarea></td>
            `;
        }
    </script>
</head>
<body>

<h2>Creare Ofertă</h2>

<form action="export_offer.php" method="POST" enctype="multipart/form-data">
    <table id="offerTable">
        <thead>
            <tr>
                <th>Nr.</th>
                <th>Nume</th>
                <th>Imagine</th>
                <th>Preț</th>
                <th>Preț Final</th>
                <th>Descriere</th>
            </tr>
        </thead>
        <tbody>
            <!-- Randuri generate dinamic -->
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4"></td>
                <td><strong>Total:</strong></td>
                <td><input type="text" name="total_general" placeholder="ex: 8230 LEU" required></td>
            </tr>
        </tfoot>
    </table>

    <button type="button" class="add-row-btn" onclick="addRow()">Adaugă rând</button>
    <br>
    <button type="submit">Generează Ofertă Excel</button>
</form>

<script>addRow();</script>

</body>
</html>

