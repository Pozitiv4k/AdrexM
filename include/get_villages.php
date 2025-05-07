<?php
include '../db/db.php';

$city = $_GET['city'] ?? '';

$stmt = $conn->prepare("SELECT village FROM localitati WHERE city = ? ORDER BY village");
$stmt->bind_param("s", $city);
$stmt->execute();
$result = $stmt->get_result();

$villages = [];
while ($row = $result->fetch_assoc()) {
    $villages[] = $row['village'];
}

echo json_encode($villages);
?>
