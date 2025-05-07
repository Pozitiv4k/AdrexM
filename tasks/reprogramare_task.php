<?php
$conn = new mysqli("localhost", "root", "", "examen");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id'])) {
    $task_id = intval($_POST['task_id']);
    $conn->query("UPDATE tasks SET status = 'programat' WHERE id = $task_id");
    header("Location: tasks.php");
    exit();
}
?>
