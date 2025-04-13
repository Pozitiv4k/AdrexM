<?php
include '../include/auth.php';
include '../include/nav.php';

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
    header("Location: tasks/tasks.php");
    exit();
}
?>
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- Template Stylesheet -->
<link href="../css/styles.css" rel="stylesheet">
<h2>Creare Task</h2>
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
