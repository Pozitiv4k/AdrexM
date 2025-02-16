<?php
include 'db.php'; // Include fișierul pentru conectarea la baza de date

// Asigură-te că utilizatorul este autentificat
session_start();
if (!isset($_SESSION['id'])) {
    http_response_code(403); // Respinge cererea dacă utilizatorul nu este autentificat
    exit();
}

if (isset($_GET['tip'])) {
    $tip = $_GET['tip'];
    $userId = $_SESSION['id']; // Obține ID-ul utilizatorului curent

    // Modifică interogarea pentru a include user_id
    $query = "SELECT numar_serie, COUNT(*) as cantitate 
              FROM echipamente 
              WHERE tip_echipament = ? AND user_id = ? AND activ = 1 
              GROUP BY numar_serie";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $tip, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $serials = [];
    while ($row = $result->fetch_assoc()) {
        $serials[] = $row;
    }

    echo json_encode($serials);
}
?>
