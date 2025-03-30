<script>
    CREATE TABLE logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categorie ENUM('clienti', 'materiale', 'utilizatori') NOT NULL,
    mesaj TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

</script>
<?php
include("db.php"); // Asigură-te că ai conexiunea la baza de date

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
