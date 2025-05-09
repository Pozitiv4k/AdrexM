<?php
include '../include/init.php';
include '../include/auth.php';
$conn = new mysqli("localhost", "root", "", "examen");

// Obținem toți clienții
$clienti = $conn->query("SELECT id, login, city, village, phone FROM clients");
$client_data = [];
while ($row = $clienti->fetch_assoc()) {
    $client_data[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tip = !empty($_POST['tip_custom']) ? $_POST['tip_custom'] : $_POST['tip'];
    $descriere = $_POST['descriere'];
    $adresa = $_POST['adresa'];
    $client_id = $_POST['client_id'];
    $data_programare = $_POST['data_programare'];

    date_default_timezone_set('Europe/Bucharest');
    $acum = date('Y-m-d H:i:s');
    $status = ($data_programare > $acum) ? 'programat' : 'transmis';

    $stmt = $conn->prepare("INSERT INTO tasks (tip, descriere, adresa, client_id, data_programare, status, data_transmitere)
                            VALUES (?, ?, ?, ?, ?, ?, IF(? = 'transmis', NOW(), NULL))");
    $stmt->bind_param("sssisss", $tip, $descriere, $adresa, $client_id, $data_programare, $status, $status);
    $stmt->execute();

    header("Location: tasks.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/s.css" rel="stylesheet">
    <?php include '../include/nav.php'; ?>
    <title>Creare Task</title>
    <script>
        const clienti = <?= json_encode($client_data) ?>;

        function completeazaClient(dinInput) {
            const input = dinInput.value.trim().toLowerCase();
            const select = document.getElementById('client_id');
            const adresa = document.getElementById('adresa');
            const telefon = document.getElementById('telefon_client');

            const client = clienti.find(c =>
                c.id.toString() === input || c.login.toLowerCase() === input
            );

            if (client) {
                select.value = client.id;
                adresa.value = client.city + (client.village ? ' / ' + client.village : '');
                telefon.value = client.phone;
            } else {
                select.value = '';
                adresa.value = '';
                telefon.value = '';
            }
        }

        function actualizeazaSugestii(val) {
            const datalist = document.getElementById("suggestions");
            datalist.innerHTML = "";
            if (val.length === 0) return;

            clienti.forEach(c => {
                if (
                    c.login.toLowerCase().startsWith(val.toLowerCase()) ||
                    c.id.toString().startsWith(val)
                ) {
                    const opt = document.createElement("option");
                    opt.value = c.login;
                    opt.label = `ID: ${c.id} - ${c.city}${c.village ? ' / ' + c.village : ''}`;
                    datalist.appendChild(opt);
                }
            });
        }
    </script>
</head>
<body>
<div class="main-page-content">
    <h2 class="text-center mb-5">Creare Task</h2>
    <form method="POST">
        <label>Tip task:</label>
        <select name="tip">
            <option value="Instalare">Instalare</option>
            <option value="Mentenanță">Mentenanță</option>
            <option value="Reparație">Reparație</option>
        </select>
        <input type="text" name="tip_custom" placeholder="Alt tip (opțional)"
               oninput="this.form.tip.disabled = !!this.value">

        <label>Descriere:</label>
        <textarea name="descriere" required></textarea>

        <label>Caută client (ID sau login):</label>
        <input list="suggestions" id="client_search" name="client_search"
               oninput="actualizeazaSugestii(this.value)"
               onchange="completeazaClient(this)" placeholder="ex: 3 sau ion.popescu">
        <datalist id="suggestions"></datalist>

        <label>Client selectat:</label>
        <select name="client_id" id="client_id" required>
            <option value="">-- selectează --</option>
            <?php foreach ($client_data as $row): ?>
                <option value="<?= $row['id'] ?>">
                    <?= "ID: {$row['id']} - {$row['login']} - {$row['city']}" ?>
                    <?= $row['village'] ? " / {$row['village']}" : '' ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Adresă intervenție:</label>
        <input type="text" name="adresa" id="adresa" readonly required>

        <label>Număr de telefon client:</label>
        <input type="text" id="telefon_client" readonly>

        <label>Data și ora programării:</label>
        <input type="datetime-local" name="data_programare" required>

        <button type="submit">Înregistrează Task</button>
    </form>
</div>
</body>
</html>
