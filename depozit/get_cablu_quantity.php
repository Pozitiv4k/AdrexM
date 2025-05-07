<?php
session_start();
include '../db/db.php'; // Include fișierul pentru conectarea la baza de date

if (isset($_GET['tip'])) {
    $tip = $_GET['tip'];
    
    // Debugging: verificăm ce tip este primit
    error_log("Tip cablu: " . $tip);
    
    $query = "SELECT cantitate FROM cabluri WHERE tip_cablu = ? AND activ = 1 LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $tip);
    $stmt->execute();
    
    $result = $stmt->get_result()->fetch_assoc();
    
    // Debugging: verificăm ce rezultat a fost obținut
    error_log("Rezultatul: " . json_encode($result));
    
    header('Content-Type: application/json');
    echo json_encode($result);
} else {
    error_log("Tipul cablului nu a fost setat.");
}
?>
