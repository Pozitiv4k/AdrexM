<?php

include '../include/auth.php';
include("../include/nav.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Client</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script>
        // Script pentru a afișa/ascunde câmpuri în funcție de criteriul selectat
        function updateSearchForm() {
            const criteria = document.getElementById('criteria').value;
            const valueField = document.getElementById('value-field');
            const locationFields = document.getElementById('location-fields');

            if (criteria === 'address' || criteria === 'location') {
                valueField.style.display = 'none';
                locationFields.style.display = 'block';
            } else {
                valueField.style.display = 'block';
                locationFields.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <header>
        <h1>Search Client</h1>
    </header>
    <main>
        <form action="clients/users/search.php" method="POST">
            <label for="criteria">Search by:</label>
            <select id="criteria" name="criteria" required onchange="updateSearchForm()">
                <option value="id">ID</option>
                <option value="login">Login</option>
                <option value="phone">Phone</option>
                <option value="serial_number">Serial Number</option>
                <option value="email">Email</option>
                <option value="address">Address</option>
                <option value="location">City/Village</option>
            </select>

            <div id="value-field">
                <label for="value">Enter Value:</label>
                <input type="text" id="value" name="value">
            </div>

            <div id="location-fields" style="display: none;">
                <label for="city">Filter by City:</label>
                <select id="city" name="city">
                    <option value="">Any</option>
                    <option value="Cahul">Cahul</option>
                    <option value="Cantemir">Cantemir</option>
                    <option value="Leova">Leova</option>
                </select>

                <label for="village">Filter by Village:</label>
                <select id="village" name="village">
                    <option value="">Any</option>
                    <optgroup label="Cahul">
                        <option value="Rosu">Roșu</option>
                        <option value="Burlacu">Burlacu</option>
                        <option value="Colibasi">Colibași</option>
                    </optgroup>
                    <optgroup label="Cantemir">
                        <option value="Cania">Cania</option>
                        <option value="Baimaclia">Baimaclia</option>
                        <option value="Gotești">Gotești</option>
                    </optgroup>
                    <optgroup label="Leova">
                        <option value="Iargara">Iargara</option>
                        <option value="Sarata-Razesi">Sărata-Răzeși</option>
                        <option value="Romanovca">Romanovca</option>
                    </optgroup>
                </select>
            </div>

            <button type="submit">Search</button>
        </form>
        <div id="results">
            <!-- Rezultatele vor fi afișate aici -->
        </div>
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $criteria = $_POST['criteria'];
    $value = $_POST['value'] ?? '';
    $city = $_POST['city'] ?? '';
    $village = $_POST['village'] ?? '';

    // Construire interogare dinamică
    $query = "SELECT id, login, city, village FROM clients WHERE 1=1";
    $params = [];
    $types = "";

    if ($criteria !== 'address' && $criteria !== 'location' && !empty($value)) {
        $query .= " AND $criteria LIKE ?";
        $params[] = "%$value%";
        $types .= "s";
    }

    if (!empty($city)) {
        $query .= " AND city = ?";
        $params[] = $city;
        $types .= "s";
    }

    if (!empty($village)) {
        $query .= " AND village = ?";
        $params[] = $village;
        $types .= "s";
    }

    // Pregătire interogare
    $stmt = $conn->prepare($query);
    if ($types) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2>Search Results:</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "<a href='edit_client.php?id=" . $row['id'] . "'>Client: " . htmlspecialchars($row['login']) . " (City: " . $row['city'] . ", Village: " . $row['village'] . ")</a><br>";
        }
    } else {
        echo "<p>No clients found for the selected criteria and filters.</p>";
    }

    $stmt->close();
}

$conn->close();
?>
