<?php
include '../db/db.php';

$userId = intval($_GET['user_id']);
$type = $_GET['type'];

if ($userId && $type) {
    if ($type === 'echipament') {
        $query = "SELECT id, tip_echipament AS tip, numar_serie FROM echipamente WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                'id' => $row['id'],
                'tip' => $row['tip'],
                'numar_serie' => $row['numar_serie'],
            ];
        }
    } else {
        $table = $type === 'material' ? 'materiale' : ($type === 'cablu' ? 'cabluri' : 'instrumente');
        $column = "tip_{$type}";
        $query = "SELECT id, {$column} AS tip, cantitate FROM {$table} WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    echo json_encode($data);
} else {
    echo json_encode([]);
}
?>
