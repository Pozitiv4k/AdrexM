<?php
include 'include/auth.php';
include 'include/nav.php';
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $itemType = $_POST['item_type'];
    $itemId = $_POST['item_id'];
    $destinationUser = $_POST['destination_user'];
    $quantity = $_POST['quantity'];

    // Actualizare cantități în baza de date
    $query = "UPDATE $itemType SET cantitate = cantitate - ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $quantity, $itemId);
    $stmt->execute();

    // Adăugare cantitate la utilizatorul/depozitul destinație
    $query = "INSERT INTO $itemType (id, cantitate, user_id)
              VALUES (?, ?, ?)
              ON DUPLICATE KEY UPDATE cantitate = cantitate + ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiii", $itemId, $quantity, $destinationUser, $quantity);
    $stmt->execute();

    header("Location: transfer.php?success=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Materiale</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="text-center">Transfer Materiale</h1>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Transferul a fost realizat cu succes!</div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="item_type">Selectați tipul de articol:</label>
            <select id="item_type" name="item_type" class="form-control" required>
                <option value="echipamente">Echipamente</option>
                <option value="materiale">Materiale</option>
                <option value="cabluri">Cabluri</option>
                <option value="instrumente">Instrumente</option>
            </select>
        </div>

        <div class="form-group">
            <label for="item_id">Selectați articolul:</label>
            <select id="item_id" name="item_id" class="form-control" required>
                <!-- Articolele vor fi populate din baza de date printr-un script AJAX -->
            </select>
        </div>

        <div class="form-group">
            <label for="quantity">Cantitate:</label>
            <input type="number" id="quantity" name="quantity" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="destination_user">Destinație:</label>
            <select id="destination_user" name="destination_user" class="form-control" required>
                <?php
                $query = "SELECT id, username FROM users";
                $result = $conn->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['username']}</option>";
                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Transferă</button>
    </form>
</div>

<script>
    document.getElementById('item_type').addEventListener('change', function() {
        const itemType = this.value;
        const itemSelect = document.getElementById('item_id');

        // Solicitați articolele din baza de date printr-un apel AJAX
        fetch(`get_items.php?type=${itemType}`)
            .then(response => response.json())
            .then(data => {
                itemSelect.innerHTML = '';
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.name;
                    itemSelect.appendChild(option);
                });
            });
    });
</script>

</body>
</html>
