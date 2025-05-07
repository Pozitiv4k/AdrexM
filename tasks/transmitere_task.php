<?php
include '../include/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "", "examen");

    $task_id = intval($_POST['task_id']);
    $tehnician = $conn->real_escape_string($_POST['tehnician']);

    $conn->query("UPDATE tasks SET atribuit_la = '$tehnician', status = 'atribuit' WHERE id = $task_id");
}
?>
