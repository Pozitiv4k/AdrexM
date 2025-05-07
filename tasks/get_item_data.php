<?php
$conn = new mysqli("localhost", "root", "", "examen");
if ($conn->connect_error) {
    die("Conexiunea a eșuat.");
}

$tip = $_GET['tip'] ?? '';
$data = [];

switch ($tip) {
    case 'echipamente':
        $result = $conn->query("SELECT id, model, pret_piata FROM echipamente WHERE disponibil = 1");
        break;
    case 'materiale':
        $result = $conn->query("SELECT id, tip_material AS model, pret_piata FROM materiale WHERE cantitate > 0");
        break;
    case 'cabluri':
        $result = $conn->query("SELECT id, tip_cablu AS model, pret_piata FROM cabluri WHERE cantitate > 0");
        break;
    case 'instrumente':
        $result = $conn->query("SELECT id, denumire AS model, pret_piata FROM instrumente WHERE cantitate > 0");
        break;
    default:
        $result = false;
        break;
}

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($data);
