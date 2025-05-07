<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Front";

// Creare conexiune
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificare conexiune
if ($conn->connect_error) {
    die("Conexiunea a eșuat: " . $conn->connect_error);
}

// Funcția getData
function getData($query, $params = []) {
    global $conn;
    
    $stmt = $conn->prepare($query);

    if (!empty($params)) {
        $types = str_repeat('s', count($params)); // Presupunem că toți parametrii sunt stringuri.
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    return $stmt->get_result();
}

// Funcția pentru adăugarea unui log
function add_log($conn, $user_id, $action, $details) {
    $stmt = $conn->prepare("INSERT INTO logs (user_id, action, details, created_at) VALUES (?, ?, ?, NOW())");
    
    if (!$stmt) {
        die("Eroare SQL: " . $conn->error); // Depanare în cazul unei erori de pregătire
    }

    $stmt->bind_param("iss", $user_id, $action, $details);
    $stmt->execute();
    $stmt->close();
}
?>
