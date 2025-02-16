<?php
include 'include/auth.php';
include("include/nav.php");


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Client</title>
    <link rel="stylesheet" href="styles.css">
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
            if (city && options[city]) {
                options[city].forEach(function(sat) {
                    const opt = document.createElement('option');
                    opt.value = sat;
                    opt.textContent = sat;
                    village.appendChild(opt);
                });
            } else {
                const defaultOpt = document.createElement('option');
                defaultOpt.value = "";
                defaultOpt.textContent = "Select a city first";
                village.appendChild(defaultOpt);
            }
        }
    </script>
</head>
<body>
    <header>
        <h1>Add New Client</h1>
    </header>
    <main>
        <form action="add.php" method="POST" enctype="multipart/form-data">
            <label for="login">Login:</label>
            <input type="text" id="login" name="login" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="serial-number">Serial Number:</label>
            <input type="text" id="serial-number" name="serial_number">

            <label for="city">City:</label>
            <select id="city" name="city" required onchange="updateVillageOptions()">
                <option value="">Select City</option>
                <option value="Cahul">Cahul</option>
                <option value="Cantemir">Cantemir</option>
                <option value="Leova">Leova</option>
            </select>

            <label for="village">Village:</label>
            <select id="village" name="village">
                <option value="">Select a city first</option>
            </select>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="config-file">Upload Configuration File:</label>
            <input type="file" id="config-file" name="config_file">

            <label for="memento">Memento:</label>
            <textarea id="memento" name="memento"></textarea>

            <button type="submit">Add Client</button>
        </form>
    </main>
</body>
</html>
<?php
// Configurare conexiune baza de date
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "examen";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificare conexiune
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verificare dacă datele din formular sunt trimise
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'], $_POST['phone'], $_POST['email'], $_POST['city'])) {
    $login = $_POST['login'];
    $phone = $_POST['phone'];
    $serial_number = $_POST['serial_number'] ?? null;
    $city = $_POST['city'];
    $village = $_POST['village'] ?? null;
    $email = $_POST['email'];
    $memento = $_POST['memento'] ?? null;

    // Gestionarea încărcării fișierului
    $config_file_path = null;
    $uploadDir = "uploads/";

    // Verifică dacă folderul de upload există, altfel creează-l
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Creează folderul cu permisiuni complete
    }

    if (isset($_FILES['config_file']) && $_FILES['config_file']['error'] === UPLOAD_ERR_OK) {
        $newFileName = time() . "_" . basename($_FILES['config_file']['name']);
        $config_file_path = $uploadDir . $newFileName;
        if (move_uploaded_file($_FILES['config_file']['tmp_name'], $config_file_path)) {
            echo "File uploaded successfully!";
        } else {
            echo "Failed to move uploaded file.";
            $config_file_path = null; // Resetare cale dacă încărcarea eșuează
        }
    }

    // Inserare în baza de date
    $stmt = $conn->prepare("INSERT INTO clients (login, phone, serial_number, city, village, email, config_file_path, memento) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssssss", $login, $phone, $serial_number, $city, $village, $email, $config_file_path, $memento);

    if ($stmt->execute()) {
        echo "Client added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close(); 
}
add_log($conn, $_SESSION['user_id'], "Adăugare client", "Client nou: $client_name");

    $conn->close(); 
?>