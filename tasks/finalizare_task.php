<?php
$conn = new mysqli("localhost", "root", "", "examen");
if ($conn->connect_error) {
    die("Conexiunea a eșuat: " . $conn->connect_error);
}

$task_id = $_POST['task_id'];
$client_id = $_POST['client_id'];
$data_montare = date("Y-m-d H:i:s");

// 1. Marcare task ca finalizat
$conn->query("UPDATE tasks SET status = 'finalizat' WHERE id = $task_id");

// 2. Alocare echipamente
if (!empty($_POST['echipamente_ids'])) {
    foreach ($_POST['echipamente_ids'] as $echip_id) {
        $echip_id = intval($echip_id);

        // Obținem detaliile echipamentului
        $res = $conn->query("SELECT * FROM echipamente WHERE id = $echip_id");
        $echip = $res->fetch_assoc();

        // Inserăm în tabelul echipamente_client (creat pentru alocări)
        $stmt = $conn->prepare("INSERT INTO echipamente_client (client_id, echipament_id, tip_echipament, model_echipament, numar_serie, imagine, data_montare) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisssss", $client_id, $echip_id, $echip['tip_echipament'], $echip['model_echipament'], $echip['numar_serie'], $echip['imagine'], $data_montare);
        $stmt->execute();

        // Setăm ca indisponibil
        $conn->query("UPDATE echipamente SET disponibil = 0 WHERE id = $echip_id");
    }
}

// 3. Costuri materiale
$cost_total_materiale = 0;
if (!empty($_POST['materiale_ids'])) {
    foreach ($_POST['materiale_ids'] as $index => $mat_id) {
        $mat_id = intval($mat_id);
        $cantitate = floatval($_POST['materiale_cantitati'][$index]);

        $res = $conn->query("SELECT pret_piata FROM materiale WHERE id = $mat_id");
        $pret = $res->fetch_assoc()['pret_piata'];
        $cost_total_materiale += $cantitate * $pret;
    }
}

// 4. Costuri cabluri
$cost_total_cabluri = 0;
if (!empty($_POST['cabluri_ids'])) {
    foreach ($_POST['cabluri_ids'] as $index => $cab_id) {
        $cab_id = intval($cab_id);
        $metri = floatval($_POST['cabluri_metri'][$index]);

        $res = $conn->query("SELECT pret_piata FROM cabluri WHERE id = $cab_id");
        $pret = $res->fetch_assoc()['pret_piata'];
        $cost_total_cabluri += $metri * $pret;
    }
}

// 5. Costuri manoperă și lucrări adiționale
$cost_manopera = floatval($_POST['cost_manopera']);
$cost_lucrari_aditionale = floatval($_POST['cost_lucrari_aditionale']);
$descriere_aditionale = $_POST['lucrari_aditionale_descriere'];

$cost_total = $cost_total_materiale + $cost_total_cabluri + $cost_manopera + $cost_lucrari_aditionale;

// 6. Salvare în conturi client
$stmt = $conn->prepare("INSERT INTO conturi_client (client_id, task_id, cost_materiale, cost_cabluri, manopera, lucrari_descriere, cost_lucrari, total, data_inregistrare) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iidddsdds", $client_id, $task_id, $cost_total_materiale, $cost_total_cabluri, $cost_manopera, $descriere_aditionale, $cost_lucrari_aditionale, $cost_total, $data_montare);
$stmt->execute();

// Redirecționare către pagina clientului
header("Location: ../users_clients/edit_client.php?id=" . $client_id);
exit;
?>
