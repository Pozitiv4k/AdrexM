<?php
include("../db/db.php"); // Asigură-te că ai conexiunea la baza de date

function adaugaLog($categorie, $mesaj) {
    global $conn;
    
    $stmt = $conn->prepare("INSERT INTO logs (categorie, mesaj, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $categorie, $mesaj);
    $stmt->execute();
    $stmt->close();
}

function logAction($action, $details) {
    adaugaLog($action, $details);
}
?>
