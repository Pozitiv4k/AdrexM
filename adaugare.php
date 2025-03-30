<?php
include 'log_helper.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numeMaterial = $_POST['material'];

    // Procesul de adăugare în baza de date...

    // Înregistrăm logul
    adaugaLog('materiale', "A fost adăugat un nou material: $numeMaterial.");
}


include 'include/auth.php';
include 'include/nav.php';
include 'db.php';

// Funcție pentru verificarea și adăugarea datelor în baza de date
function addOrUpdateData($tableName, $fields, $values, $uniqueCheck = []) {
    global $conn;

    // Verificare existență pentru `material`, `cablu` și `instrument`
    if ($uniqueCheck) {
        $checkQuery = "SELECT * FROM $tableName WHERE " . implode(" AND ", array_map(fn($col) => "$col = ?", array_keys($uniqueCheck)));
        $checkStmt = $conn->prepare($checkQuery);
        $checkValues = array_values($uniqueCheck);
        $types = str_repeat("s", count($checkValues));
        $checkStmt->bind_param($types, ...$checkValues);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        $existing = $result->fetch_assoc();

        if ($existing) {
            // Dacă există deja, actualizăm cantitatea
            if ($tableName === 'materiale' || $tableName === 'cablu' || $tableName === 'instrumente') {
                $updateQuery = "UPDATE $tableName SET cantitate = cantitate + ? WHERE id = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("ii", $values[1], $existing['id']);
                return $updateStmt->execute() ? true : $updateStmt->error;
            }

            // Pentru echipamente, verificăm unicitatea numelui și a numărului de serie
            if ($tableName === 'echipamente') {
                return "Echipament cu numărul de serie dat deja există!";
            }
        }
    }

    // Dacă nu există, inserăm o nouă intrare
    $columns = implode(",", $fields);
    $placeholders = implode(",", array_fill(0, count($fields), "?"));
    $query = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";
    $stmt = $conn->prepare($query);
    $types = str_repeat("s", count($values));
    $stmt->bind_param($types, ...$values);
    return $stmt->execute() ? true : $stmt->error;
}

// Funcții pentru obținerea utilizatorilor și tipurilor
function getUsers() {
    global $conn;
    $query = "SELECT id, username FROM users";
    return $conn->query($query)->fetch_all(MYSQLI_ASSOC);
}

function getTipuri() {
    global $conn;
    $query = "SELECT id, tip, categorie FROM tipuri";
    return $conn->query($query)->fetch_all(MYSQLI_ASSOC);
}

// Gestionarea formularului
$successMessage = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_tip']) || isset($_POST['remove_tip'])) {
        // Gestionare adăugare/ștergere tipuri
        if (!empty($_POST['tip']) && !empty($_POST['categorie'])) {
            if (isset($_POST['add_tip'])) {
                $query = "INSERT INTO tipuri (tip, categorie) VALUES (?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ss", $_POST['tip'], $_POST['categorie']);
                $stmt->execute();
                $successMessage = "Tip adăugat cu succes!";
            } elseif (isset($_POST['remove_tip'])) {
                $query = "DELETE FROM tipuri WHERE tip = ? AND categorie = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ss", $_POST['tip'], $_POST['categorie']);
                $stmt->execute();
                $successMessage = "Tip șters cu succes!";
            }
        } else {
            $errorMessage = "Completați toate câmpurile pentru adăugare/ștergere tip.";
        }
    } else {
        // Gestionare formular principal
        $userId = $_POST['user_id'] ?? null;
        $tip = $_POST['tip'] ?? null;

        if ($tip && $userId) {
            switch ($tip) {
                case 'echipament':
                    if (!empty($_POST['tip_echipament']) && !empty($_POST['numar_serie'])) {
                        $fields = ['tip_echipament', 'numar_serie', 'user_id'];
                        $values = [$_POST['tip_echipament'], $_POST['numar_serie'], $userId];
                        $uniqueCheck = ['tip_echipament' => $_POST['tip_echipament'], 'numar_serie' => $_POST['numar_serie']];
                        $result = addOrUpdateData('echipamente', $fields, $values, $uniqueCheck);
                        $successMessage = $result === true ? "Echipamentul a fost adăugat cu succes!" : $result;
                    } else {
                        $errorMessage = "Toate câmpurile pentru echipament sunt obligatorii.";
                    }
                    break;
                    case 'material':
                        case 'cablu':
                        case 'instrument':
                            $typeKey = "tip_" . $tip;
                            $quantityKey = "cantitate_" . $tip; // Adăugăm cheie specifică pentru cantitate
                            
                            if (!empty($_POST[$typeKey]) && !empty($_POST[$quantityKey]) && is_numeric($_POST[$quantityKey]) && $_POST[$quantityKey] > 0) {
                                $fields = [$typeKey, 'cantitate', 'user_id'];
                                $values = [$_POST[$typeKey], $_POST[$quantityKey], $userId];
                                $uniqueCheck = [$typeKey => $_POST[$typeKey], 'user_id' => $userId];
                                $result = addOrUpdateData("${tip}e", $fields, $values, $uniqueCheck);
                                $successMessage = $result === true ? ucfirst($tip) . " a fost adăugat cu succes!" : $result;
                            } else {
                                $errorMessage = "Toate câmpurile sunt obligatorii, iar cantitatea trebuie să fie numerică și mai mare de 0.";
                            }
                            break;
                        
                default:
                    $errorMessage = "Tip invalid.";
            }
        } else {
            $errorMessage = "Toate câmpurile sunt obligatorii.";
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_tip']) || isset($_POST['remove_tip'])) {
        // Gestionare adăugare/ștergere tipuri
        if (!empty($_POST['tip']) && !empty($_POST['categorie'])) {
            if (isset($_POST['add_tip'])) {
                $query = "INSERT INTO tipuri (tip, categorie) VALUES (?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ss", $_POST['tip'], $_POST['categorie']);
                $stmt->execute();
                $_SESSION['successMessage'] = "Tip adăugat cu succes!";
            } elseif (isset($_POST['remove_tip'])) {
                $query = "DELETE FROM tipuri WHERE tip = ? AND categorie = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ss", $_POST['tip'], $_POST['categorie']);
                $stmt->execute();
                $_SESSION['successMessage'] = "Tip șters cu succes!";
            }
        } else {
            $_SESSION['errorMessage'] = "Completați toate câmpurile pentru adăugare/ștergere tip.";
        }
    } else {
        // Gestionare formular principal
        $userId = $_POST['user_id'] ?? null;
        $tip = $_POST['tip'] ?? null;

        if ($tip && $userId) {
            switch ($tip) {
                case 'echipament':
                    if (!empty($_POST['tip_echipament']) && !empty($_POST['numar_serie'])) {
                        $fields = ['tip_echipament', 'numar_serie', 'user_id'];
                        $values = [$_POST['tip_echipament'], $_POST['numar_serie'], $userId];
                        $uniqueCheck = ['tip_echipament' => $_POST['tip_echipament'], 'numar_serie' => $_POST['numar_serie']];
                        $result = addOrUpdateData('echipamente', $fields, $values, $uniqueCheck);
                        $_SESSION['successMessage'] = $result === true ? "Echipamentul a fost adăugat cu succes!" : $result;
                    } else {
                        $_SESSION['errorMessage'] = "Toate câmpurile pentru echipament sunt obligatorii.";
                    }
                    break;
                case 'material':
                case 'cablu':
                case 'instrument':
                    $typeKey = "tip_" . $tip;
                    $quantityKey = "cantitate_" . $tip;

                    if (!empty($_POST[$typeKey]) && !empty($_POST[$quantityKey]) && is_numeric($_POST[$quantityKey]) && $_POST[$quantityKey] > 0) {
                        $fields = [$typeKey, 'cantitate', 'user_id'];
                        $values = [$_POST[$typeKey], $_POST[$quantityKey], $userId];
                        $uniqueCheck = [$typeKey => $_POST[$typeKey], 'user_id' => $userId];
                        $result = addOrUpdateData("${tip}e", $fields, $values, $uniqueCheck);
                        $_SESSION['successMessage'] = $result === true ? ucfirst($tip) . " a fost adăugat cu succes!" : $result;
                    } else {
                        $_SESSION['errorMessage'] = "Toate câmpurile sunt obligatorii, iar cantitatea trebuie să fie numerică și mai mare de 0.";
                    }
                    break;

                default:
                    $_SESSION['errorMessage'] = "Tip invalid.";
            }
        } else {
            $_SESSION['errorMessage'] = "Toate câmpurile sunt obligatorii.";
        }
    }

    // Redirect pentru a preveni re-trimiterea formularului
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Afișare mesaje din sesiune
if (isset($_SESSION['successMessage'])) {
    echo "<p style='color: green;'>" . $_SESSION['successMessage'] . "</p>";
    unset($_SESSION['successMessage']); // Ștergem mesajul după afișare
}

if (isset($_SESSION['errorMessage'])) {
    echo "<p style='color: red;'>" . $_SESSION['errorMessage'] . "</p>";
    unset($_SESSION['errorMessage']); // Ștergem mesajul după afișare
}



$users = getUsers();
$tipuri = getTipuri();
?>


<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adăugare Date</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Adăugare Date</h2>
    
    <!-- Mesaje de succes și eroare -->
    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success"><?= $successMessage ?></div>
    <?php endif; ?>
    <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger"><?= $errorMessage ?></div>
    <?php endif; ?>
    
    <!-- Formular principal -->
    <form method="POST">
        <!-- Selectare utilizator -->
        <div class="mb-3">
            <label for="user_id" class="form-label">Utilizator</label>
            <select class="form-select" id="user_id" name="user_id" required>
                <option value="">Selectați utilizatorul</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id'] ?>"><?= $user['username'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <!-- Selectare tip -->
        <div class="mb-3">
            <label for="tip" class="form-label">Tip</label>
            <select class="form-select" id="tip" name="tip" required>
                <option value="">Selectați tipul</option>
                <option value="echipament">Echipament</option>
                <option value="material">Material</option>
                <option value="cablu">Cablu</option>
                <option value="instrument">Instrument</option>
            </select>
        </div>
        
        <!-- Secțiune pentru echipamente -->
        <div id="echipament-fields" class="mb-3 d-none">
            <label for="tip_echipament" class="form-label">Tip Echipament</label>
            <select class="form-select" id="tip_echipament" name="tip_echipament">
                <option value="">Selectați tipul echipamentului</option>
                <?php foreach ($tipuri as $tip): ?>
                    <?php if ($tip['categorie'] === 'echipament'): ?>
                        <option value="<?= $tip['tip'] ?>"><?= $tip['tip'] ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
            <label for="numar_serie" class="form-label mt-3">Număr Serie</label>
            <input type="text" class="form-control" id="numar_serie" name="numar_serie">
        </div>
        
        <!-- Secțiune pentru materiale și cabluri -->
        <div id="material-fields" class="mb-3 d-none">
    <label for="tip_material" class="form-label">Tip Material</label>
    <select class="form-select" id="tip_material" name="tip_material">
        <option value="">Selectați tipul</option>
        <?php foreach ($tipuri as $tip): ?>
            <?php if ($tip['categorie'] === 'material'): ?>
                <option value="<?= $tip['tip'] ?>"><?= $tip['tip'] ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
    <label for="cantitate_material" class="form-label mt-3">Cantitate</label>
    <input type="number" class="form-control" id="cantitate_material" name="cantitate_material" min="1">
</div>

<div id="cablu-fields" class="mb-3 d-none">
    <label for="tip_cablu" class="form-label">Tip Cablu</label>
    <select class="form-select" id="tip_cablu" name="tip_cablu">
        <option value="">Selectați tipul</option>
        <?php foreach ($tipuri as $tip): ?>
            <?php if ($tip['categorie'] === 'cablu'): ?>
                <option value="<?= $tip['tip'] ?>"><?= $tip['tip'] ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
    <label for="cantitate_cablu" class="form-label mt-3">Cantitate</label>
    <input type="number" class="form-control" id="cantitate_cablu" name="cantitate_cablu" min="1">
</div>

<div id="instrument-fields" class="mb-3 d-none">
    <label for="tip_instrument" class="form-label">Tip Instrument</label>
    <select class="form-select" id="tip_instrument" name="tip_instrument">
        <option value="">Selectați tipul</option>
        <?php foreach ($tipuri as $tip): ?>
            <?php if ($tip['categorie'] === 'instrument'): ?>
                <option value="<?= $tip['tip'] ?>"><?= $tip['tip'] ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
    <label for="cantitate_instrument" class="form-label mt-3">Cantitate</label>
    <input type="number" class="form-control" id="cantitate_instrument" name="cantitate_instrument" min="1">
</div>

        
        <button type="submit" class="btn btn-primary">Adaugă</button>
    </form>
    
    <hr>
    
    <!-- Formular pentru gestionarea tipurilor -->
    <h3>Gestionare Tipuri</h3>
    <form method="POST" class="d-flex align-items-end">
        <div class="mb-3 me-3">
            <label for="tip" class="form-label">Tip</label>
            <input type="text" class="form-control" id="tip" name="tip">
        </div>
        <div class="mb-3 me-3">
            <label for="categorie" class="form-label">Categorie</label>
            <select class="form-select" id="categorie" name="categorie">
                <option value="echipament">Echipament</option>
                <option value="material">Material</option>
                <option value="cablu">Cablu</option>
            </select>
        </div>
        <div class="d-flex">
            <button type="submit" name="add_tip" class="btn btn-success me-2">Add</button>
            <button type="submit" name="remove_tip" class="btn btn-danger">Remove</button>
        </div>
    </form>
</div>
<script>
    // Afișează câmpurile relevante în funcție de tipul selectat
const tipSelect = document.getElementById('tip');
const echipamentFields = document.getElementById('echipament-fields');


tipSelect.addEventListener('change', function () {
    const value = this.value;

    echipamentFields.classList.toggle('d-none', value !== 'echipament');
 
});
</script>
<script>
   document.getElementById('tip').addEventListener('change', function () {
    // Ascundem toate câmpurile
    document.getElementById('material-fields').classList.add('d-none');
    document.getElementById('cablu-fields').classList.add('d-none');
    document.getElementById('instrument-fields').classList.add('d-none');

    // Afișăm câmpurile relevante în funcție de selecție
    const selectedTip = this.value;
    if (selectedTip === 'material') {
        document.getElementById('material-fields').classList.remove('d-none');
    } else if (selectedTip === 'cablu') {
        document.getElementById('cablu-fields').classList.remove('d-none');
    } else if (selectedTip === 'instrument') {
        document.getElementById('instrument-fields').classList.remove('d-none');
    }
});

</script>
</body>
</html>
