<?php
include '../include/auth.php';
include('../include/nav.php');
include '../logs/log_helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $phone = $_POST['phone'];
    $numar_serie = $_POST['numar_serie'];
    $city = $_POST['city'];
    $village = $_POST['village'];
    $email = $_POST['email'];
    $memento = $_POST['memento'];

    // Obținem utilizatorul autentificat
    $user = isset($_SESSION['username']) ? $_SESSION['username'] : 'Unknown User';

    // Înregistrăm modificările în log
    adaugaLog('clienti', "$user a modificat clientul $login: Telefon: $phone, SN: $numar_serie, Oras: $city, Sat: $village, Email: $email, Memento: $memento.");
}

// Configurare conexiune baza de date
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "examen";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Obținerea datelor despre client
    $stmt = $conn->prepare("SELECT * FROM clients WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $client = $result->fetch_assoc();
    } else {
        die("Client not found.");
    }
    $stmt->close();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $stmt = $conn->prepare("UPDATE clients SET login = ?, phone = ?, numar_serie = ?, city = ?, village = ?, email = ?, memento = ? WHERE id = ?");
        $stmt->bind_param("sssssssi", $login, $phone, $numar_serie, $city, $village, $email, $memento, $id);

        if ($stmt->execute()) {
            
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
} else {
    die("Invalid client ID.");
}


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

// Verificare dacă există un ID valid în URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Obținerea datelor despre client
    $stmt = $conn->prepare("SELECT * FROM clients WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $client = $result->fetch_assoc();
    } else {
        die("Client not found.");
    }
    $stmt->close();

    // Salvarea datelor actualizate
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = $_POST['login'];
        $phone = $_POST['phone'];
        $numar_serie = $_POST['numar_serie'];
        $city = $_POST['city'];
        $village = $_POST['village'];
        $email = $_POST['email'];
        $memento = $_POST['memento'];

        // Gestionare fișiere existente și fișier nou încărcat
        $existingFiles = $client['config_file_path'] ? explode(',', $client['config_file_path']) : [];
        $newFiles = [];

        // Dacă un fișier nou este încărcat, îl salvăm
        if (!empty($_FILES['new_config_file']['name'])) {
            $targetDir = "../depozit/uploads/";
            $newFileName = time() . "_" . basename($_FILES['new_config_file']['name']);
            $newFilePath = $targetDir . $newFileName;

            // Încercare încărcare fișier
            if (move_uploaded_file($_FILES['new_config_file']['tmp_name'], $newFilePath)) {
                echo "New configuration file uploaded successfully.";
                $newFiles[] = $newFilePath; // Adaugă noul fișier în lista de fișiere
            } else {
                echo "Error uploading new configuration file.";
            }
        }

        // Combinarea fișierelor existente și a celor noi
        $allFiles = array_merge($existingFiles, $newFiles);
        $configFilePath = implode(',', $allFiles); // Transformăm lista într-un string separat prin virgulă

        // Actualizare date client
        $stmt = $conn->prepare("UPDATE clients SET login = ?, phone = ?, numar_serie = ?, city = ?, village = ?, email = ?, config_file_path = ?, memento = ? WHERE id = ?");
        $stmt->bind_param("ssssssssi", $login, $phone, $numar_serie, $city, $village, $email, $configFilePath, $memento, $id);

        if ($stmt->execute()) {
            
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    // Obținerea fișierelor existente
    $files = $client['config_file_path'] ? explode(',', $client['config_file_path']) : [];
} else {
    die("Invalid client ID.");
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client</title>
    <link href="../css/s.css" rel="stylesheet">
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
    <div class="main-page-content">
    <header>
        <h1>Edit Client</h1>
    </header>
    <main>
        <form action="edit_client.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
            <label for="login">Login:</label>
            <input type="text" id="login" name="login" value="<?php echo htmlspecialchars($client['login']); ?>" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($client['phone']); ?>">

            <label for="numar_serie">Serial Number:</label>
            <input type="text" id="numar_serie" name="numar_serie" value="<?php echo htmlspecialchars($client['numar_serie']); ?>">

            <label for="city">City:</label>
            <select id="city" name="city" required onchange="updateVillageOptions()">
                <option value="">Select City</option>
                <option value="Cahul" <?php echo $client['city'] === 'Cahul' ? 'selected' : ''; ?>>Cahul</option>
                <option value="Cantemir" <?php echo $client['city'] === 'Cantemir' ? 'selected' : ''; ?>>Cantemir</option>
                <option value="Leova" <?php echo $client['city'] === 'Leova' ? 'selected' : ''; ?>>Leova</option>
            </select>

            <label for="village">Village:</label>
            <select id="village" name="village">
                <option value="">Select Village</option>
            </select>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($client['email']); ?>">

            <label for="config_file_path">Existing Configuration Files:</label>
            <ul>
                <?php
                foreach ($files as $filePath) {
                    echo "<li><a href='" . htmlspecialchars($filePath) . "' download>" . basename($filePath) . "</a></li>";
                }
                ?>
            </ul>

            <label for="new_config_file">Upload New Configuration File:</label>
            <input type="file" id="new_config_file" name="new_config_file">

            <label for="memento">Memento:</label>
            <textarea id="memento" name="memento"><?php echo htmlspecialchars($client['memento']); ?></textarea>

            <button type="submit">Save Changes</button>
        </form>
    </main>
</div>
</body>
</html>
