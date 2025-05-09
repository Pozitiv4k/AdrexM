<?php
session_start();
$conn = new mysqli("localhost", "root", "", "examen");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['task_id'])) {
    $task_id = (int)$_POST['task_id'];

    // Resetare status și atribuție
    $conn->query("UPDATE tasks SET atribuit_la = NULL, status = 'programat' WHERE id = $task_id");

    $_SESSION['replanificat'] = true;

    // Redirect cu statusul anterior
    $redirect_status = $_POST['redirect_status'] ?? '';
    $query = $redirect_status ? "?status=" . urlencode($redirect_status) : '';
    header("Location: taskuri_utilizator.php" . $query);
    exit();
}
?>
