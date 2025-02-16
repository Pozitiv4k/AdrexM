<?php
// Conectare la baza de date
$servername = "localhost";
$username = "root"; // Modificați dacă e cazul
$password = ""; // Modificați dacă e cazul
$dbname = "examen";

// Creare conexiune
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificare conexiune
if ($conn->connect_error) {
    die("Conexiunea a eșuat: " . $conn->connect_error);
}

// Preluare date din formular
$nume = $_POST['nume'];
$email = $_POST['email'];
$mesaj = $_POST['mesaj'];

// Pregătire și executare interogare SQL
$sql = "INSERT INTO feedback (nume, email, mesaj) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nume, $email, $mesaj);

if ($stmt->execute()) {
    // Mesaj de succes
    echo "<script>alert('Mesajul a fost trimis cu succes!'); window.location.href = 'index.php';</script>";
} else {
    echo "Eroare: " . $sql . "<br>" . $conn->error;
}

// Închidere conexiune
$stmt->close();
$conn->close();
?>
