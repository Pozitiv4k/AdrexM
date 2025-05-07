<?php
include '../include/auth.php';

// Conectare la baza de date
$conn = new mysqli("localhost", "root", "", "examen");

// Verifică dacă s-a trimis un ID valid prin POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['task_id'])) {
    $task_id = intval($_POST['task_id']);

    // Pregătește și execută ștergerea taskului
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $task_id);
    
    if ($stmt->execute()) {
        // Redirecționează înapoi către pagina cu taskuri
        header("Location: tasks.php");
        exit();
    } else {
        echo "Eroare la ștergere: " . $stmt->error;
    }
} else {
    echo "Cerere invalidă.";
}
?>
