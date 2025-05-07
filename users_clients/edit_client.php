<?php
include '../include/auth.php';
include('../include/nav.php');
include '../logs/log_helper.php';

// Conectare la baza de date
$conn = new mysqli("localhost", "root", "", "examen");
if ($conn->connect_error) {
    die("Eroare conexiune: " . $conn->connect_error);
}

// Verificăm dacă ID-ul este valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID client invalid.");
}
$id = (int)$_GET['id'];

// Preluăm clientul
$stmt = $conn->prepare("SELECT * FROM clients WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Client inexistent.");
}
$client = $result->fetch_assoc();
$stmt->close();

// Salvare modificări client
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $phone = $_POST['phone'];
    $numar_serie = $_POST['numar_serie'];
    $city = $_POST['city'];
    $village = $_POST['village'];
    $email = $_POST['email'];
    $memento = $_POST['memento'];

    // Gestionare fișiere
    $existingFiles = $client['config_file_path'] ? explode(',', $client['config_file_path']) : [];
    $newFiles = [];

    if (!empty($_FILES['new_config_file']['name'])) {
        $targetDir = "../depozit/uploads/";
        $newFileName = time() . "_" . basename($_FILES['new_config_file']['name']);
        $newFilePath = $targetDir . $newFileName;

        if (move_uploaded_file($_FILES['new_config_file']['tmp_name'], $newFilePath)) {
            $newFiles[] = $newFilePath;
        } else {
            echo "Eroare la încărcarea fișierului nou.";
        }
    }

    $allFiles = array_merge($existingFiles, $newFiles);
    $configFilePath = implode(',', $allFiles);

    // Actualizare date
    $stmt = $conn->prepare("UPDATE clients SET login=?, phone=?, numar_serie=?, city=?, village=?, email=?, config_file_path=?, memento=? WHERE id=?");
    $stmt->bind_param("ssssssssi", $login, $phone, $numar_serie, $city, $village, $email, $configFilePath, $memento, $id);

    if ($stmt->execute()) {
        $user = $_SESSION['username'] ?? 'Unknown';
        adaugaLog('clienti', "$user a modificat clientul $login: Telefon: $phone, SN: $numar_serie, Oraș: $city, Sat: $village, Email: $email, Memento: $memento.");
        header("Location: clienti.php");
        exit;
    } else {
        echo "Eroare la actualizare: " . $stmt->error;
    }
    $stmt->close();
}

// Obținem fișierele și echipamentele
$files = $client['config_file_path'] ? explode(',', $client['config_file_path']) : [];
$eq_res = $conn->query("SELECT * FROM echipamente_client WHERE client_id = $id");

$conn->close();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Editare Client</title>
    <link rel="stylesheet" href="../css/s.css">
    <script>
        function updateVillageOptions() {
            const city = document.getElementById('city').value;
            const village = document.getElementById('village');
            const options = {
                "Cahul": ["", "Roșu", "Burlacu", "Colibași"],
                "Cantemir": ["", "Cania", "Baimaclia", "Gotești"],
                "Leova": ["", "Iargara", "Sărata-Răzeși", "Romanovca"]
            };
            village.innerHTML = "";
            (options[city] || ["Selectați un oraș"]).forEach(sat => {
                const opt = document.createElement('option');
                opt.value = sat;
                opt.textContent = sat;
                village.appendChild(opt);
            });
        }
        window.onload = updateVillageOptions;
    </script>
</head>
<body>
<div class="main-page-content">
    <header>
        <h1>Editare Client</h1>
    </header>
    <main>
        <form method="POST" enctype="multipart/form-data">
            <label for="login">Login:</label>
            <input type="text" id="login" name="login" value="<?= htmlspecialchars($client['login']) ?>" required>

            <label for="city">City:</label>
<select id="city" name="city" required onchange="updateVillageOptions()">
    <option value="">Select City</option>
</select>

<label for="village">Village:</label>
<select id="village" name="village">
    <option value="">Select a city first</option>
</select>

<script>
window.onload = function() {
    fetch('../include/get_cities.php')
        .then(response => response.json())
        .then(data => {
            const citySelect = document.getElementById('city');
            data.forEach(city => {
                const option = document.createElement('option');
                option.value = city;
                option.text = city;
                citySelect.appendChild(option);
            });
        });
};

function updateVillageOptions() {
    const city = document.getElementById('city').value;
    const villageSelect = document.getElementById('village');
    villageSelect.innerHTML = '<option value="">Loading...</option>';

    fetch('../include/get_villages.php?city=' + encodeURIComponent(city))
        .then(response => response.json())
        .then(data => {
            villageSelect.innerHTML = '';
            data.forEach(village => {
                const option = document.createElement('option');
                option.value = village;
                option.text = village;
                villageSelect.appendChild(option);
            });
        });
}
</script>


            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($client['email']) ?>">

            <label>Fișiere Configurare Existente:</label>
            <ul>
                <?php foreach ($files as $f): ?>
                    <li><a href="<?= htmlspecialchars($f) ?>" download><?= basename($f) ?></a></li>
                <?php endforeach; ?>
            </ul>

            <label for="new_config_file">Încărcare fișier nou:</label>
            <input type="file" id="new_config_file" name="new_config_file">

            <label for="memento">Memento:</label>
            <textarea id="memento" name="memento"><?= htmlspecialchars($client['memento']) ?></textarea>

            <button type="submit">Salvează Modificările</button>
        </form>

        <h3>Echipamente Instalate</h3>
        <table border="1">
            <tr>
                <th>Tip</th>
                <th>Model</th>
                <th>Număr serie</th>
                <th>Imagine</th>
                <th>Data montare</th>
            </tr>
            <?php while ($eq = $eq_res->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($eq['tip_echipament']) ?></td>
                    <td><?= htmlspecialchars($eq['model_echipament']) ?></td>
                    <td><?= htmlspecialchars($eq['numar_serie']) ?></td>
                    <td><img src="../depozit/<?= htmlspecialchars($eq['imagine']) ?>" width="100"></td>
                    <td><?= htmlspecialchars($eq['data_montare']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </main>
</div>
</body>
</html>
