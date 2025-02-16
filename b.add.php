<?php
include 'include/auth.php';
include 'include/nav.php';
include 'db.php'; // Include fișierul pentru conectarea la baza de date

// Verifică dacă utilizatorul este autentificat
if (!isset($_SESSION['id'])) {
    header("Location: login.php"); // Redirect la pagina de logare dacă nu e autentificat
    exit();
}



// Funcția pentru extragerea datelor active pentru utilizatorul selectat
function fetchDataForUser($tableName, $userId, $activ = 1) {
    global $conn;
    $query = "SELECT * FROM $tableName WHERE user_id = ? AND activ = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $userId, $activ);
    $stmt->execute();
    return $stmt->get_result();
}

// Verifică transferul de echipamente sau alte materiale
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['transfer'])) {
    $sourceUser = intval($_POST['source_user']);
    $targetUser = intval($_POST['target_user']);
    $itemId = intval($_POST['item_id']);
    $quantity = intval($_POST['quantity']);
    $type = $_POST['type'];

    if ($sourceUser && $targetUser && $itemId && $type) {
        if ($type === 'echipament') {
            // Transfer echipamente pe baza numărului de serie
            $query = "SELECT id, tip_echipament, numar_serie FROM echipamente WHERE id = ? AND user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $itemId, $sourceUser);
            $stmt->execute();
            $item = $stmt->get_result()->fetch_assoc();

            if ($item) {
                // Actualizează user_id la utilizatorul țintă pentru echipament specificat prin număr de serie
                $updateQuery = "UPDATE echipamente SET user_id = ? WHERE id = ? AND user_id = ?";
                $stmt = $conn->prepare($updateQuery);
                $stmt->bind_param("iii", $targetUser, $itemId, $sourceUser);

                if ($stmt->execute()) {
                    $_SESSION['success_message'] = "Echipamentul cu numărul de serie " . htmlspecialchars($item['numar_serie']) . " a fost transferat cu succes!";
                } else {
                    $_SESSION['error_message'] = "Transferul echipamentului a eșuat!";
                }
            } else {
                $_SESSION['error_message'] = "Echipamentul nu există pentru utilizatorul sursă!";
            }
        } else {
            // Transfer materiale, cabluri, instrumente (cu cantitate)
            $table = $type === 'material' ? 'materiale' : ($type === 'cablu' ? 'cabluri' : 'instrumente');
            $query = "SELECT cantitate, tip_{$type} FROM {$table} WHERE id = ? AND user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $itemId, $sourceUser);
            $stmt->execute();
            $item = $stmt->get_result()->fetch_assoc();

            if ($item && $item['cantitate'] >= $quantity) {
                // Scade cantitatea de la utilizatorul sursă
                $updateSource = "UPDATE {$table} SET cantitate = cantitate - ? WHERE id = ? AND user_id = ?";
                $stmt = $conn->prepare($updateSource);
                $stmt->bind_param("iii", $quantity, $itemId, $sourceUser);
                $stmt->execute();

                // Verifică dacă utilizatorul țintă are deja acest tip
                $checkTarget = "SELECT id, cantitate FROM {$table} WHERE tip_{$type} = ? AND user_id = ?";
                $stmt = $conn->prepare($checkTarget);
                $stmt->bind_param("si", $item["tip_{$type}"], $targetUser);
                $stmt->execute();
                $targetItem = $stmt->get_result()->fetch_assoc();

                if ($targetItem) {
                    // Actualizează cantitatea
                    $updateTarget = "UPDATE {$table} SET cantitate = cantitate + ? WHERE id = ?";
                    $stmt = $conn->prepare($updateTarget);
                    $stmt->bind_param("ii", $quantity, $targetItem['id']);
                } else {
                    // Adaugă elementul pentru utilizatorul țintă
                    $insertTarget = "INSERT INTO {$table} (tip_{$type}, cantitate, user_id) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($insertTarget);
                    $stmt->bind_param("sii", $item["tip_{$type}"], $quantity, $targetUser);
                }

                if ($stmt->execute()) {
                    $_SESSION['success_message'] = ucfirst($type) . " a fost transferat cu succes!";
                } else {
                    $_SESSION['error_message'] = "Transferul a eșuat!";
                }
            } else {
                $_SESSION['error_message'] = "Utilizatorul sursă nu are suficientă cantitate!";
            }
        }
    } else {
        $_SESSION['error_message'] = "Toate câmpurile sunt obligatorii!";
    }

    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

// Obține utilizatorii
$users = $conn->query("SELECT id, username FROM users");
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Materiale</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script>
        function updateForm() {
            const userId = document.getElementById("source_user").value;
            const type = document.getElementById("type").value;
            const serialNumberField = document.getElementById("serial_number_field");

            // Ascunde sau arată câmpul pentru numărul de serie în funcție de tipul selectat
            if (type === 'echipament') {
                serialNumberField.style.display = 'block'; // Arată câmpul numărului de serie
            } else {
                serialNumberField.style.display = 'none'; // Ascunde câmpul numărului de serie
            }

            if (userId && type) {
                fetch(`fetch_data.php?user_id=${userId}&type=${type}`)
                    .then(response => response.json())
                    .then(data => {
                        const select = document.getElementById("item_id");
                        select.innerHTML = '<option value="">-- Selectați --</option>';
                        data.forEach(item => {
                            let text = item.tip;
                            if (type === 'echipament' && item.numar_serie) {
                                text += ` (Nr. serie: ${item.numar_serie})`;
                            } else if (item.cantitate) {
                                text += ` (Cantitate: ${item.cantitate})`;
                            }
                            select.innerHTML += `<option value="${item.id}">${text}</option>`;
                        });
                    })
                    .catch(error => console.error('Eroare:', error));
            }
        }
    </script>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Transfer Materiale</h1>
    <?php if (!empty($_SESSION['success_message'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success_message']; ?></div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error_message'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error_message']; ?></div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="source_user">Utilizator sursă:</label>
            <select id="source_user" name="source_user" class="form-control" onchange="updateForm()" required>
                <option value="">-- Selectați --</option>
                <?php while ($row = $users->fetch_assoc()): ?>
                    <option value="<?= $row['id']; ?>"><?= htmlspecialchars($row['username']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="type">Tip:</label>
            <select id="type" name="type" class="form-control" onchange="updateForm()" required>
                <option value="">-- Selectați --</option>
                <option value="material">Material</option>
                <option value="cablu">Cablu</option>
                <option value="instrument">Instrument</option>
                <option value="echipament">Echipament</option>
            </select>
        </div>
        <div class="form-group">
            <label for="item_id">Item:</label>
            <select id="item_id" name="item_id" class="form-control" required>
                <option value="">-- Selectați --</option>
            </select>
        </div>
        <div id="serial_number_field" class="form-group" style="display:none;">
            <label for="serial_number">Număr de serie (pentru echipament):</label>
            <input type="text" id="serial_number" name="serial_number" class="form-control">
        </div>
        <div class="form-group">
            <label for="quantity">Cantitate (dacă este aplicabil):</label>
            <input type="number" id="quantity" name="quantity" class="form-control">
        </div>
        <div class="form-group">
            <label for="target_user">Utilizator destinație:</label>
            <select id="target_user" name="target_user" class="form-control" required>
                <option value="">-- Selectați --</option>
                <?php
                $users->data_seek(0); // Resetăm pointerul
                while ($row = $users->fetch_assoc()): ?>
                    <option value="<?= $row['id']; ?>"><?= htmlspecialchars($row['username']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" name="transfer" class="btn btn-primary">Transferă</button>
    </form>
</div>
</body>
</html>
