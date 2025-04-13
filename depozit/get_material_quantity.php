<?php
session_start();
include '../db/db.php'; // Include fișierul pentru conectarea la baza de date

if (isset($_GET['tip'])) {
    $tip = $_GET['tip'];
    $query = "SELECT cantitate FROM materiale WHERE tip_material = ? AND activ = 1 LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $tip);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    header('Content-Type: application/json');
    echo json_encode($result);
}


?>
