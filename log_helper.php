<?php

function adaugaLog($categorie, $mesaj) {
    $dataOra = date('Y-m-d H:i:s');
    $log = "[$dataOra] $mesaj" . PHP_EOL;

    // Alegem fișierul de log în funcție de categorie
    if ($categorie === 'clienti') {
        file_put_contents('logs_clienti.txt', $log, FILE_APPEND);
    } elseif ($categorie === 'materiale') {
        file_put_contents('logs_materiale.txt', $log, FILE_APPEND);
    } elseif ($categorie === 'utilizatori') {
        file_put_contents('logs_utilizatori.txt', $log, FILE_APPEND);
    }
}

function logAction($action, $details) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO logs (action, details, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $action, $details);
    $stmt->execute();
}
?>