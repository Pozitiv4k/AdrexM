<?php
include '../db/db.php'; // include conexiunea la baza de date

$query = "SELECT DISTINCT city FROM localitati ORDER BY city";
$result = $conn->query($query);

$cities = [];
while ($row = $result->fetch_assoc()) {
    $cities[] = $row['city'];
}

echo json_encode($cities);
?>
