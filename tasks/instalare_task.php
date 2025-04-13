<?php
include '../include/auth.php';

$conn = new mysqli("localhost", "root", "", "examen");
if ($conn->connect_error) {
    die("Eroare conexiune DB: " . $conn->connect_error);
}




// Preluăm taskurile asignate tehnicianului
$sql = "SELECT t.*, c.login AS client_login 
        FROM tasks t 
        JOIN clients c ON t.client_id = c.id 
        WHERE t.asignat_la = ? AND t.status = 'in_lucru'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $tehnician);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/s.css" rel="stylesheet">
    <?php include '../include/nav.php';
?>
<title>Document</title>
</head>
<body>
    <div class="main-page-content">
    <h2>Taskuri asignate</h2>

<table>
    <tr>
        <th>Tip Task</th><th>Descriere</th><th>Adresă</th><th>Client</th><th>Data Programare</th><th>Acțiuni</th>
    </tr>
    
    <?php while ($task = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($task['tip_task']) ?></td>
            <td><?= htmlspecialchars($task['descriere']) ?></td>
            <td><?= htmlspecialchars($task['adresa']) ?></td>
            <td><?= htmlspecialchars($task['client_login']) ?></td>
            <td><?= htmlspecialchars($task['data_programare']) ?></td>
            <td>
                <a href="instalare_task.php?task_id=<?= $task['id'] ?>">Începe Instalare</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
</div>
</body>
</html>

