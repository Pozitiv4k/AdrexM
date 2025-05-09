<?php
$conn = new mysqli("localhost", "root", "", "examen");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $task_id = $_POST['task_id'] ?? null;
    $tehnician = $_POST['tehnician'] ?? null;

    if ($task_id && $tehnician) {
        $stmt = $conn->prepare("UPDATE tasks SET status = 'in_desfasurare', tehnician = ? WHERE id = ?");
        $stmt->bind_param("si", $tehnician, $task_id);
        $stmt->execute();
        $stmt->close();

        // Redirect sau altceva
    }
}
?>
