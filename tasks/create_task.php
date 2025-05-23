<?php
include '../include/auth.php';

$conn = new mysqli("localhost", "root", "", "examen");
$clienti = $conn->query("SELECT id, login FROM clients");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tip = $_POST['tip'];
    $descriere = $_POST['descriere'];
    $adresa = $_POST['adresa'];
    $client_id = $_POST['client_id'];

    $stmt = $conn->prepare("INSERT INTO tasks (tip, descriere, adresa, client_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $tip, $descriere, $adresa, $client_id);
    $stmt->execute();
    header("Location: tasks.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/s.css" rel="stylesheet">
    <?php include '../include/nav.php';
?>
<title>Document</title>
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
    <textarea name="descriere"></textarea>

    <label>Adresă:</label>
    <input type="text" name="adresa">

    <label>Client:</label>
    <select name="client_id">
        <?php while($row = $clienti->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>"><?= $row['login'] ?></option>
        <?php endwhile; ?>
    </select>

    <button type="submit">Înregistrează Task</button>
</form>
</div>
</body>
</html>

 
