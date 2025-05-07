<?php
include("../db/db.php");
session_start();

$userId = $_SESSION['id'] ?? 0;
$tip = $_GET['tip'] ?? '';

if (!$userId || !$tip) {
    echo json_encode([]);
    exit;
}

$table = '';
$modelCol = '';
switch ($tip) {
    case 'echipamente':
        $table = 'echipamente';
        $modelCol = 'model_echipament';
        break;
    case 'materiale':
        $table = 'materiale';
        $modelCol = 'tip_material';
        break;
    case 'cabluri':
        $table = 'cabluri';
        $modelCol = 'tip_cablu';
        break;
    default:
        echo json_encode([]);
        exit;
}

$stmt = $conn->prepare("SELECT id, $modelCol as model, imagine, pret_piata, descriere FROM $table WHERE user_id = ? AND activ = 1");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $row['descriere'] = $row['descriere'] ?? ''; // default empty string if null
    $data[] = $row;
}

echo json_encode($data);
?>
