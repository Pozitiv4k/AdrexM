<?php
session_start();
$conn = new mysqli("localhost", "root", "", "examen");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id'])) {
    $task_id = (int) $_POST['task_id'];

    // Marchează taskul ca "reprogramat"
    $conn->query("UPDATE tasks SET status = 'reprogramat' WHERE id = $task_id");

    $_SESSION['replanificat'] = true;

    // Redirecționează înapoi cu filtrul păstrat
    $redirectStatus = isset($_POST['redirect_status']) ? $_POST['redirect_status'] : '';
    header("Location: task_user.php?status=" . urlencode($redirectStatus));
    exit();
}
?>
