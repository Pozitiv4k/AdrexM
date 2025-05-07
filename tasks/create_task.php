<?php
include '../include/auth.php';
$conn = new mysqli("localhost", "root", "", "examen");

// Selectăm clienți și utilizatori
$clienti = $conn->query("SELECT id, login FROM clients");
$utilizatori = $conn->query("SELECT id, username FROM users");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tip = !empty($_POST['tip_custom']) ? $_POST['tip_custom'] : $_POST['tip'];
    $descriere = $_POST['descriere'];
    $adresa = $_POST['adresa'];
    $client_id = $_POST['client_id'];
    $user_id = $_POST['id_user'];
    $data_programare = $_POST['data_programare'];

    date_default_timezone_set('Europe/Bucharest');
    $acum = date('Y-m-d H:i:s');

    // Determinăm statusul inițial
    $status = ($data_programare > $acum) ? 'programat' : 'transmis';

    // Pregătim query-ul
    $stmt = $conn->prepare("INSERT INTO tasks (tip, descriere, adresa, client_id, id_user, data_programare, status, data_transmitere)
                            VALUES (?, ?, ?, ?, ?, ?, ?, IF(? = 'transmis', NOW(), NULL))");
    $stmt->bind_param("sssissss", $tip, $descriere, $adresa, $client_id, $user_id, $data_programare, $status, $status);
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
        <input type="text" name="tip_custom" placeholder="Alt tip (opțional)" oninput="if(this.value){document.querySelector('select[name=tip]').disabled=true;}else{document.querySelector('select[name=tip]').disabled=false;}">

        <label>Descriere:</label>
        <textarea name="descriere" required></textarea>

        <label>Adresă:</label>
        <input type="text" name="adresa" required>

        <label>Client:</label>
        <select name="client_id" required>
            <?php while($row = $clienti->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['login'] ?></option>
            <?php endwhile; ?>
        </select>

        <label>Utilizator responsabil:</label>
        <select name="id_user" required>
            <?php while($user = $utilizatori->fetch_assoc()): ?>
                <option value="<?= $user['id'] ?>"><?= $user['username'] ?></option>
            <?php endwhile; ?>
        </select>

        <label>Data și ora programării:</label>
        <input type="datetime-local" name="data_programare" required>

        <button type="submit">Înregistrează Task</button>
    </form>
</div>
</body>
</html>
