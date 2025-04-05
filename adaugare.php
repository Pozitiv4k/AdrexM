<?php
include 'log_helper.php';
include 'include/auth.php';
include 'include/nav.php';
require_once 'db.php';

// Funcție pentru verificare și adăugare/update
function addOrUpdateData($tableName, $fields, $values, $uniqueCheck = []) {
    global $conn;

    // Verificare existență
    if ($uniqueCheck) {
        $checkQuery = "SELECT * FROM $tableName WHERE " . implode(" AND ", array_map(fn($col) => "$col = ?", array_keys($uniqueCheck)));
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bind_param(str_repeat("s", count($uniqueCheck)), ...array_values($uniqueCheck));
        $checkStmt->execute();
        $existing = $checkStmt->get_result()->fetch_assoc();

        if ($existing) {
            if (in_array($tableName, ['materiale', 'cablu', 'instrumente'])) {
                $updateQuery = "UPDATE $tableName SET cantitate = cantitate + ? WHERE id = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("ii", $values[array_search('cantitate', $fields)], $existing['id']);
                return $updateStmt->execute() ? true : $updateStmt->error;
            }

            if ($tableName === 'echipamente') {
                return "Echipamentul există deja!";
            }
        }
    }

    // Inserare
    $query = "INSERT INTO $tableName (" . implode(",", $fields) . ") VALUES (" . rtrim(str_repeat("?,", count($fields)), ",") . ")";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(str_repeat("s", count($values)), ...$values);
    return $stmt->execute() ? true : $stmt->error;
}

function getUsers() {
    global $conn;
    return $conn->query("SELECT id, username FROM users")->fetch_all(MYSQLI_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'] ?? null;
    $tip = $_POST['tip'] ?? null;
    $descriere = $_POST['descriere'] ?? null;
    $pretPiata = $_POST['pret_piata'] ?? null;
    $pretMontator = $_POST['pret_montator'] ?? null;
    $imagine = null;

    if (isset($_FILES['imagine']) && $_FILES['imagine']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $fileName = basename($_FILES['imagine']['name']);
        $targetFile = $uploadDir . time() . "_" . $fileName;
        if (move_uploaded_file($_FILES['imagine']['tmp_name'], $targetFile)) {
            $imagine = $targetFile;
        }
    }

    if ($tip && $userId) {
        switch ($tip) {
            case 'echipament':
                if (!empty($_POST['tip_echipament']) && !empty($_POST['numar_serie']) && !empty($_POST['model_echipament'])) {
                    $fields = ['tip_echipament', 'numar_serie', 'model_echipament', 'user_id', 'imagine', 'descriere', 'pret_piata', 'pret_montator'];
                    $values = [$_POST['tip_echipament'], $_POST['numar_serie'], $_POST['model_echipament'], $userId, $imagine, $descriere, $pretPiata, $pretMontator];
                    $uniqueCheck = ['tip_echipament' => $_POST['tip_echipament'], 'numar_serie' => $_POST['numar_serie']];
                    $result = addOrUpdateData('echipamente', $fields, $values, $uniqueCheck);
                    $_SESSION['successMessage'] = $result === true ? "Echipament adăugat!" : $result;
                } else {
                    $_SESSION['errorMessage'] = "Completează toate câmpurile pentru echipament.";
                }
                break;

            case 'material':
            case 'cablu':
                $typeKey = "tip_" . $tip;
                $quantityKey = "cantitate_" . $tip;
                if (!empty($_POST[$typeKey]) && is_numeric($_POST[$quantityKey]) && $_POST[$quantityKey] > 0) {
                    $fields = [$typeKey, 'cantitate', 'user_id', 'imagine', 'descriere', 'pret_piata', 'pret_montator'];
                    $values = [$_POST[$typeKey], $_POST[$quantityKey], $userId, $imagine, $descriere, $pretPiata, $pretMontator];
                    $uniqueCheck = [$typeKey => $_POST[$typeKey], 'user_id' => $userId];
                    $result = addOrUpdateData($tip . "e", $fields, $values, $uniqueCheck);
                    $_SESSION['successMessage'] = $result === true ? ucfirst($tip) . " adăugat!" : $result;
                } else {
                    $_SESSION['errorMessage'] = "Completează toate câmpurile pentru " . $tip . ".";
                }
                break;

            case 'instrument':
                $typeKey = "tip_instrument";
                $quantityKey = "cantitate_instrument";
                if (!empty($_POST[$typeKey]) && is_numeric($_POST[$quantityKey]) && $_POST[$quantityKey] > 0) {
                    $fields = [$typeKey, 'cantitate', 'user_id', 'pret_piata', 'pret_montator'];
                    $values = [$_POST[$typeKey], $_POST[$quantityKey], $userId, $pretPiata, $pretMontator];
                    $uniqueCheck = [$typeKey => $_POST[$typeKey], 'user_id' => $userId];
                    $result = addOrUpdateData('instrumente', $fields, $values, $uniqueCheck);
                    $_SESSION['successMessage'] = $result === true ? "Instrument adăugat!" : $result;
                } else {
                    $_SESSION['errorMessage'] = "Completează toate câmpurile pentru instrument.";
                }
                break;

            default:
                $_SESSION['errorMessage'] = "Tip invalid.";
        }
    } else {
        $_SESSION['errorMessage'] = "Toate câmpurile sunt obligatorii.";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$users = getUsers();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Adăugare Date</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Adăugare Date</h2>

    <?php if (isset($_SESSION['successMessage'])): ?>
        <div class="alert alert-success"><?= $_SESSION['successMessage']; unset($_SESSION['successMessage']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['errorMessage'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['errorMessage']; unset($_SESSION['errorMessage']); ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="user_id">Utilizator</label>
            <select class="form-select" name="user_id" required>
                <option value="">Selectează</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id'] ?>"><?= $user['username'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="tip">Tip</label>
            <select class="form-select" id="tip" name="tip" required>
                <option value="">Selectează</option>
                <option value="echipament">Echipament</option>
                <option value="material">Material</option>
                <option value="cablu">Cablu</option>
                <option value="instrument">Instrument</option>
            </select>
        </div>

        <!-- Echipament -->
        <div id="echipament-fields" class="d-none mb-3">
            <label>Tip Echipament</label>
            <input type="text" class="form-control" name="tip_echipament">
            <label class="mt-2">Model</label>
            <input type="text" class="form-control" name="model_echipament">
            <label class="mt-2">Număr Serie</label>
            <input type="text" class="form-control" name="numar_serie">
        </div>

        <!-- Material -->
        <div id="material-fields" class="d-none mb-3">
            <label>Tip Material</label>
            <input type="text" class="form-control" name="tip_material">
            <label class="mt-2">Cantitate</label>
            <input type="number" class="form-control" name="cantitate_material" min="1">
        </div>

        <!-- Cablu -->
        <div id="cablu-fields" class="d-none mb-3">
            <label>Tip Cablu</label>
            <input type="text" class="form-control" name="tip_cablu">
            <label class="mt-2">Cantitate</label>
            <input type="number" class="form-control" name="cantitate_cablu" min="1">
        </div>

        <!-- Instrument -->
        <div id="instrument-fields" class="d-none mb-3">
            <label>Tip Instrument</label>
            <input type="text" class="form-control" name="tip_instrument">
            <label class="mt-2">Cantitate</label>
            <input type="number" class="form-control" name="cantitate_instrument" min="1">
        </div>

        <!-- Comune -->
        <div id="common-fields" class="d-none mb-3">
            <label>Imagine (opțional)</label>
            <input type="file" name="imagine" class="form-control">
            <label class="mt-2">Descriere</label>
            <textarea name="descriere" class="form-control" rows="3"></textarea>
            <label class="mt-2">Preț Piață</label>
            <input type="number" class="form-control" name="pret_piata" step="0.01">
            <label class="mt-2">Preț Montator</label>
            <input type="number" class="form-control" name="pret_montator" step="0.01">
        </div>

        <button type="submit" class="btn btn-primary">Adaugă</button>
    </form>
</div>

<script>
    const tipSelect = document.getElementById('tip');
    tipSelect.addEventListener('change', function () {
        const tip = this.value;
        ['echipament', 'material', 'cablu', 'instrument'].forEach(id => {
            document.getElementById(`${id}-fields`).classList.add('d-none');
        });
        if (tip) {
            document.getElementById(`${tip}-fields`).classList.remove('d-none');
        }

        document.getElementById('common-fields').classList.toggle('d-none', tip === '' || tip === null);
    });
</script>
</body>
</html>
