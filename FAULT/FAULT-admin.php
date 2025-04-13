<?php
include 'include/auth.php'; // Include fișierul de securitate
include 'include/nav.php';
include 'db.php'; // Include fișierul pentru conectarea la baza de date

// Funcție pentru adăugarea datelor în tabelele corespunzătoare
function addData($tableName, $fields, $values) {
    global $conn;
    $columns = implode(",", $fields);
    $placeholders = implode(",", array_fill(0, count($fields), "?"));
    $query = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";
    $stmt = $conn->prepare($query);
    $types = str_repeat("s", count($values));  // Presupunem că toate valorile sunt stringuri
    $stmt->bind_param($types, ...$values);
    return $stmt->execute();
}

// Funcție pentru actualizarea cantității la cabluri deja existente
function updateCablu($tip_cablu, $cantitate) {
    global $conn;
    $query = "UPDATE cabluri SET cantitate = cantitate + ? WHERE tip_cablu = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $cantitate, $tip_cablu);
    $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tip = $_POST['tip'];
    
    // Obține ID-ul utilizatorului curent
    $userId = $_SESSION['id'];
    
    if ($tip == 'echipament') {
        // Verificăm dacă utilizatorul este superuser
        if ($userId == 1) {
            // Dacă este superuser, căutăm dacă echipamentul există pentru un alt utilizator
            $query = "SELECT * FROM echipamente WHERE tip_echipament = ? AND numar_serie = ? AND user_id != 1";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $_POST['tip_echipament'], $_POST['numar_serie']);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // Dacă echipamentul există pentru un alt utilizator, adăugăm un nou rând pentru superuser
                $fields = ['tip_echipament', 'numar_serie', 'clona', 'cantitate', 'user_id'];
                $values = [$_POST['tip_echipament'], $_POST['numar_serie'], $_POST['clona'], $_POST['cantitate'], $userId];
                addData('echipamente', $fields, $values);
            } else {
                // Dacă nu există, adaugă direct echipamentul
                $fields = ['tip_echipament', 'numar_serie', 'clona', 'cantitate', 'user_id'];
                $values = [$_POST['tip_echipament'], $_POST['numar_serie'], $_POST['clona'], $_POST['cantitate'], $userId];
                addData('echipamente', $fields, $values);
            }
        } else {
            // Dacă nu este superuser, adăugăm echipamentul normal
            $fields = ['tip_echipament', 'numar_serie', 'clona', 'cantitate', 'user_id'];
            $values = [$_POST['tip_echipament'], $_POST['numar_serie'], $_POST['clona'], $_POST['cantitate'], $userId];
            addData('echipamente', $fields, $values);
        }
    } elseif ($tip == 'material') {
        $fields = ['tip_material', 'cantitate', 'user_id'];
        $values = [$_POST['tip_material'], $_POST['cantitate'], $userId];
        addData('materiale', $fields, $values);
    } elseif ($tip == 'cablu') {
        $tip_cablu = $_POST['tip_cablu'];
        $cantitate = $_POST['cantitate'];

        // Verificăm dacă cablul există deja în baza de date
        $query = "SELECT * FROM cabluri WHERE tip_cablu = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $tip_cablu);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Dacă cablul există, actualizăm cantitatea
            updateCablu($tip_cablu, $cantitate);
        } else {
            // Dacă nu există, adăugăm un nou cablu
            $fields = ['tip_cablu', 'cantitate', 'user_id'];
            $values = [$tip_cablu, $cantitate, $userId];
            addData('cabluri', $fields, $values);
        }
    } elseif ($tip == 'instrument') {
        $fields = ['tip_instrument', 'cantitate', 'user_id'];
        $values = [$_POST['tip_instrument'], $_POST['cantitate'], $userId];
        addData('instrumente', $fields, $values);
    }

    // Redirectăm pentru a preveni re-submit-ul formularului
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrație - Adăugare Date</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script>
        function updateForm() {
            var tip = document.getElementById("tip").value;

            // Ascundem toate formularele
            document.querySelectorAll('.form-section').forEach(function(section) {
                section.style.display = 'none';
                var inputs = section.querySelectorAll('input, select');
                inputs.forEach(function(input) {
                    input.disabled = true; // Dezactivăm câmpurile neutilizate
                });
            });

            // Afișăm și activăm doar câmpurile pentru formularul selectat
            if (tip === 'echipament') {
                var echipamentForm = document.getElementById("echipamentForm");
                echipamentForm.style.display = 'block';
                echipamentForm.querySelectorAll('input, select').forEach(function(input) {
                    input.disabled = false;
                });
            } else if (tip === 'material') {
                var materialForm = document.getElementById("materialForm");
                materialForm.style.display = 'block';
                materialForm.querySelectorAll('input, select').forEach(function(input) {
                    input.disabled = false;
                });
            } else if (tip === 'cablu') {
                var cabluForm = document.getElementById("cabluForm");
                cabluForm.style.display = 'block';
                cabluForm.querySelectorAll('input, select').forEach(function(input) {
                    input.disabled = false;
                });
            } else if (tip === 'instrument') {
                var instrumentForm = document.getElementById("instrumentForm");
                instrumentForm.style.display = 'block';
                instrumentForm.querySelectorAll('input, select').forEach(function(input) {
                    input.disabled = false;
                });
            }
        }
    </script>
</head>
<body>

<div class="container">
    <h1 class="text-center">Pagina de Administrare - Adăugare Date</h1>

    <form method="POST">
        <div class="form-group">
            <label for="tip">Selectează ce dorești să adaugi:</label>
            <select id="tip" name="tip" class="form-control" onchange="updateForm()" required>
                <option value="">-- Selectează --</option>
                <option value="echipament">Echipament</option>
                <option value="material">Material</option>
                <option value="cablu">Cablu</option>
                <option value="instrument">Instrument</option>
            </select>
        </div>

        <!-- Form pentru Echipamente -->
        <div id="echipamentForm" class="form-section" style="display:none;">
            <div class="form-group">
                <label for="tip_echipament">Tip Echipament:</label>
                <input type="text" class="form-control" name="tip_echipament" placeholder="Introduceți tipul echipamentului" required>
            </div>
            <div class="form-group">
                <label for="numar_serie">Număr Serie:</label>
                <input type="text" class="form-control" name="numar_serie" placeholder="Introduceți numărul de serie" required>
            </div>
            <div class="form-group">
                <label for="clona">Clonă:</label>
                <input type="text" class="form-control" name="clona" placeholder="Introduceți clonă" required>
            </div>
            <div class="form-group">
                <label for="cantitate">Cantitate:</label>
                <input type="number" class="form-control" name="cantitate" placeholder="Introduceți cantitatea" required>
            </div>
        </div>

        <!-- Form pentru Materiale -->
        <div id="materialForm" class="form-section" style="display:none;">
            <div class="form-group">
                <label for="tip_material">Tip Material:</label>
                <input type="text" class="form-control" name="tip_material" placeholder="Introduceți tipul materialului" required>
            </div>
            <div class="form-group">
                <label for="cantitate">Cantitate:</label>
                <input type="number" class="form-control" name="cantitate" placeholder="Introduceți cantitatea" required>
            </div>
        </div>

        <!-- Form pentru Cabluri -->
        <div id="cabluForm" class="form-section" style="display:none;">
            <div class="form-group">
                <label for="tip_cablu">Tip Cablu:</label>
                <select name="tip_cablu" class="form-control" required>
                    <option value="Cablu | Optic | 1FO | G.657 | drop | 1.2kN">Cablu | Optic | 1FO | G.657 | drop | 1.2kN</option>
                    <option value="Cablu | Ethernet | Cat5 | UTP 4x2">Cablu | Ethernet | Cat5 | UTP 4x2</option>
                    <option value="Cablu | Optic | 2FO | G.652D | aerial">Cablu | Optic | 2FO | G.652D | aerial</option>
                    <option value="Cablu | Coaxial | RG6">Cablu | Coaxial | RG6</option>
                </select>
            </div>
            <div class="form-group">
                <label for="cantitate">Cantitate:</label>
                <input type="number" class="form-control" name="cantitate" placeholder="Introduceți cantitatea" required>
            </div>
        </div>

        <!-- Form pentru Instrumente -->
        <div id="instrumentForm" class="form-section" style="display:none;">
            <div class="form-group">
                <label for="tip_instrument">Tip Instrument:</label>
                <input type="text" class="form-control" name="tip_instrument" placeholder="Introduceți tipul instrumentului" required>
            </div>
            <div class="form-group">
                <label for="cantitate">Cantitate:</label>
                <input type="number" class="form-control" name="cantitate" placeholder="Introduceți cantitatea" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Adaugă</button>
    </form>
</div>

</body>
</html>
