<?php
session_start();
include 'db.php'; // Include fișierul pentru conectarea la baza de date

// Verifică dacă utilizatorul este autentificat
if (!isset($_SESSION['id'])) {
    header("Location: login.php"); // Redirect la pagina de logare dacă nu e autentificat
    exit();
}

// Extrage datele active din tabelele corespunzătoare pentru utilizatorul curent
function fetchDataForUser($tableName, $userId, $activ = 1) {
    global $conn;
    $query = "SELECT * FROM $tableName WHERE user_id = ? AND activ = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $userId, $activ);
    $stmt->execute();
    return $stmt->get_result();
}

$userId = $_SESSION['id']; // ID-ul utilizatorului autenticat
$echipamente = fetchDataForUser('echipamente', $userId);
$materiale = fetchDataForUser('materiale', $userId);
$cabluri = fetchDataForUser('cabluri', $userId);
$instrumente = fetchDataForUser('instrumente', $userId);

$tipuriEchipamente = [];
while ($row = $echipamente->fetch_assoc()) {
    $tipuriEchipamente[$row['tip_echipament']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Depozit Materiale</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
include('include/nav.php');
?>
<div class="container">
    <h1 class="text-center">Depozit Materiale</h1>

    <!-- Tabel pentru echipamente -->
    <h3>Tipul echipamentului</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tip echipament</th>
                <th>Număr de serie</th>
                <th>Cantitate</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select id="tip_echipament" class="form-control" onchange="updateSerialAndQuantity(this.value)">
                        <option value="">Selectați un tip echipament</option>
                        <?php foreach (array_keys($tipuriEchipamente) as $tip): ?>
                            <option value="<?= $tip; ?>"><?= $tip; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <select id="numar_serie" class="form-control">
                        <option value="">Selectați un număr de serie</option>
                    </select>
                </td>
                <td>
                    <h4 id="cantitate_echipamente">0</h4>
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
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select id="tip_material" class="form-control" onchange="updateMaterialQuantity(this.value)">
                        <option value="">Selectați un tip material</option>
                        <?php while ($row = $materiale->fetch_assoc()): ?>
                            <option value="<?= $row['tip_material']; ?>"><?= $row['tip_material']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </td>
                <td>
                    <h4 id="cantitate_material">0</h4>
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
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select id="tip_cablu" class="form-control" onchange="updateCabluQuantity(this.value)">
                        <option value="">Selectați un tip cablu</option>
                        <?php while ($row = $cabluri->fetch_assoc()): ?>
                            <option value="<?= $row['tip_cablu']; ?>"><?= $row['tip_cablu']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </td>
                <td>
                    <h4 id="cantitate_cablu">0</h4>
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
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select id="tip_instrument" class="form-control" onchange="updateInstrumentQuantity(this.value)">
                        <option value="">Selectați un tip instrument</option>
                        <?php while ($row = $instrumente->fetch_assoc()): ?>
                            <option value="<?= $row['tip_instrument']; ?>"><?= $row['tip_instrument']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </td>
                <td>
                    <h4 id="cantitate_instrument">0</h4>
                </td>
            </tr>
        </tbody>
    </table>
</div>


<script>
function updateSerialAndQuantity(selectedType) {
    const serialDropdown = document.getElementById('numar_serie');
    const quantityCell = document.getElementById('cantitate_echipamente');

    // Reset the serial dropdown and quantity
    serialDropdown.innerHTML = `<option value="">Selectați un număr de serie</option>`;
    quantityCell.textContent = '0';

    if (selectedType) {
        // Fetch serial numbers and quantity via AJAX
        fetch('get_serials.php?tip=' + encodeURIComponent(selectedType))
            .then(response => response.json())
            .then(data => {
                data.forEach(item => {
                    serialDropdown.innerHTML += `<option value="${item.numar_serie}">${item.numar_serie}</option>`;
                });
                // Set quantity
                quantityCell.textContent = data.reduce((acc, item) => acc + parseInt(item.cantitate), 0);
            })
            .catch(error => {
                console.error('Error fetching serial data:', error);
            });
    }
}

function updateMaterialQuantity(selectedType) {
    const quantityCell = document.getElementById('cantitate_material');

    // Reset quantity
    quantityCell.textContent = '0';

    if (selectedType) {
        // Fetch quantity via AJAX based on material type
        fetch('get_material_quantity.php?tip=' + encodeURIComponent(selectedType))
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                quantityCell.textContent = data.cantitate || '0'; // Afișează cantitatea
            })
            .catch(error => {
                console.error('Error fetching material data:', error);
            });
    }
}

function updateCabluQuantity(selectedType) {
    const quantityCell = document.getElementById('cantitate_cablu');

    // Reset quantity
    quantityCell.textContent = '0';

    if (selectedType) {
        // Fetch quantity via AJAX based on cable type
        fetch('get_cablu_quantity.php?tip=' + encodeURIComponent(selectedType))
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                quantityCell.textContent = data.cantitate || '0'; // Afișează cantitatea
            })
            .catch(error => {
                console.error('Error fetching cable data:', error);
            });
    }
}

function updateInstrumentQuantity(selectedType) {
    const quantityCell = document.getElementById('cantitate_instrument');

    // Reset quantity
    quantityCell.textContent = '0';

    if (selectedType) {
        // Fetch quantity via AJAX based on instrument type
        fetch('get_instrument_quantity.php?tip=' + encodeURIComponent(selectedType))
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                quantityCell.textContent = data.cantitate || '0'; // Afișează cantitatea
            })
            .catch(error => {
                console.error('Error fetching instrument data:', error);
            });
    }
}
</script>
</body>
</html>
