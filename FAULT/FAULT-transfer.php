<?php
session_start();
include 'db.php'; // Include fișierul pentru conectarea la baza de date

// Functie pentru a manipula elementele din liste (eliminare/reactivare)
function handlePostRequest($tableName, $operation, $id) {
    global $conn;
    if ($operation == 'elimina') {
        $query = "UPDATE $tableName SET activ = 0 WHERE id = ?";
    } elseif ($operation == 'reactiveaza') {
        $query = "UPDATE $tableName SET activ = 1 WHERE id = ?";
    }
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Verifică post request pentru fiecare secțiune
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['elimina'])) {
        handlePostRequest($_POST['table'], 'elimina', $_POST['id']);
    } elseif (isset($_POST['reactiveaza'])) {
        handlePostRequest($_POST['table'], 'reactiveaza', $_POST['id']);
    }
}

// Extrage datele active și inactive din tabelele corespunzătoare
function fetchData($tableName, $activ = 1) {
    global $conn;
    $query = "SELECT * FROM $tableName WHERE activ = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $activ);
    $stmt->execute();
    return $stmt->get_result();
}

$echipamente = fetchData('echipamente');
$materiale = fetchData('materiale');
$cabluri = fetchData('cabluri');
$instrumente = fetchData('instrumente');

$echipamente_eliminate = fetchData('echipamente', 0);
$materiale_eliminate = fetchData('materiale', 0);
$cabluri_eliminate = fetchData('cabluri', 0);
$instrumente_eliminate = fetchData('instrumente', 0);

function generateDropdownOptions($result, $field) {
    echo "<option value=''>-</option>";
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row[$field]}'>{$row[$field]}</option>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Materiale</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1 class="text-center">Transfer Materiale</h1>

    <!-- Lista de echipamente -->
    <h3>Tipul echipamentului</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tip echipament</th>
                <th>Număr de serie</th>
                <th>Clonă?</th>
                <th>Cantitate</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select name="tip_echipament">
                        <?php generateDropdownOptions($echipamente, 'tip_echipament'); ?>
                    </select>
                </td>
                <td>
                    <select name="numar_serie">
                        <?php generateDropdownOptions($echipamente, 'numar_serie'); ?>
                    </select>
                </td>
                <td>
                    <select name="clona">
                        <option value="true">true</option>
                        <option value="false">false</option>
                    </select>
                </td>
                <td>
                    <input type="text" name="cantitate" class="form-control" placeholder="Cantitate">
                </td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                        <input type="hidden" name="table" value="echipamente">
                        <button type="submit" name="elimina" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Lista de materiale -->
    <h3>Tipul materialului</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tip material</th>
                <th>Cantitate</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select name="tip_material">
                        <?php generateDropdownOptions($materiale, 'tip_material'); ?>
                    </select>
                </td>
                <td>
                    <input type="text" name="cantitate" class="form-control" placeholder="Cantitate">
                </td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                        <input type="hidden" name="table" value="materiale">
                        <button type="submit" name="elimina" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Lista de cabluri -->
    <h3>Tipul cablului</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tip cablu</th>
                <th>Cantitate</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select name="tip_cablu">
                        <?php generateDropdownOptions($cabluri, 'tip_cablu'); ?>
                    </select>
                </td>
                <td>
                    <input type="text" name="cantitate" class="form-control" placeholder="Cantitate">
                </td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                        <input type="hidden" name="table" value="cabluri">
                        <button type="submit" name="elimina" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Lista de instrumente -->
    <h3>Tipul instrumentului</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tip instrument</th>
                <th>Cantitate</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select name="tip_instrument">
                        <?php generateDropdownOptions($instrumente, 'tip_instrument'); ?>
                    </select>
                </td>
                <td>
                    <input type="text" name="cantitate" class="form-control" placeholder="Cantitate">
                </td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                        <input type="hidden" name="table" value="instrumente">
                        <button type="submit" name="elimina" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>
