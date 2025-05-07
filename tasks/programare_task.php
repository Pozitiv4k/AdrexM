<?php
include '../include/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_programare'])) {
    $conn = new mysqli("localhost", "root", "", "examen");

    $task_id = intval($_POST['task_id']);
    $tehnician = $conn->real_escape_string($_POST['tehnician']);
    $data = $conn->real_escape_string($_POST['data_programata']);

    $conn->query("UPDATE tasks SET atribuit_la = '$tehnician', data_programare = '$data', status = 'programat' WHERE id = $task_id");
}
?>
