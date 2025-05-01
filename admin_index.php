
<?php
include("include/auth.php");
include("db/db.php");
include("include/nav.php");

$uploadDir = __DIR__ . '/uploads';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

function showMessage($message) {
    echo "<p style='color:green;'>$message</p>";
}

// --- CAROUSEL ---
if (isset($_GET['delete_carousel'])) {
    $id = intval($_GET['delete_carousel']);
    $stmt = $conn->prepare("DELETE FROM carousel WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    showMessage("Imagine carusel ștearsă cu succes.");
}

if (isset($_POST['add_carousel'])) {
    $title = $_POST['title'];
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $filename = basename($_FILES['image']['name']);
        $targetPath = "$uploadDir/$filename";
        $relativePath = "uploads/$filename";
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $stmt = $conn->prepare("INSERT INTO carousel (title, image_path) VALUES (?, ?)");
            $stmt->bind_param("ss", $title, $relativePath);
            $stmt->execute();
            showMessage("Imagine carusel adăugată.");
        } else {
            showMessage("Eroare la mutarea fișierului.");
        }
    }
}

if (isset($_POST['update_carousel'])) {
    $id = intval($_POST['carousel_id']);
    $title = $_POST['title'];
    $stmt = $conn->prepare("UPDATE carousel SET title = ? WHERE id = ?");
    $stmt->bind_param("si", $title, $id);
    $stmt->execute();
    showMessage("Titlu carusel actualizat.");
}

// --- ABOUT ---
if (isset($_POST['update_about'])) {
    $description = $_POST['description'];
    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $filename = basename($_FILES['image']['name']);
        $targetPath = "$uploadDir/$filename";
        $relativePath = "uploads/$filename";
        move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
        $stmt = $conn->prepare("UPDATE about SET description = ?, image_path = ? WHERE id = 1");
        $stmt->bind_param("ss", $description, $relativePath);
    } else {
        $stmt = $conn->prepare("UPDATE about SET description = ? WHERE id = 1");
        $stmt->bind_param("s", $description);
    }
    $stmt->execute();
    showMessage("Despre actualizat.");
}

// --- SERVICES ---
if (isset($_POST['add_service'])) {
    $title = $_POST['service_title'];
    $description = $_POST['service_description'];
    $icon = $_POST['service_icon'];
    $stmt = $conn->prepare("INSERT INTO services (title, description, icon) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $description, $icon);
    $stmt->execute();
    showMessage("Serviciu adăugat.");
}

if (isset($_POST['update_service'])) {
    $id = intval($_POST['service_id']);
    $title = $_POST['service_title'];
    $description = $_POST['service_description'];
    $icon = $_POST['service_icon'];
    $stmt = $conn->prepare("UPDATE services SET title = ?, description = ?, icon = ? WHERE id = ?");
    $stmt->bind_param("sssi", $title, $description, $icon, $id);
    $stmt->execute();
    showMessage("Serviciu actualizat.");
}

if (isset($_GET['delete_service'])) {
    $id = intval($_GET['delete_service']);
    $stmt = $conn->prepare("DELETE FROM services WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    showMessage("Serviciu șters.");
}

// --- PRICE ---
if (isset($_POST['add_price'])) {
    $item = $_POST['price_item'];
    $price = $_POST['price_value'];
    $features = $_POST['price_features'];
    $stmt = $conn->prepare("INSERT INTO price_list (item, price, features) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $item, $price, $features);
    $stmt->execute();
    showMessage("Preț adăugat.");
}

if (isset($_POST['update_price'])) {
    $id = intval($_POST['price_id']);
    $item = $_POST['price_item'];
    $price = $_POST['price_value'];
    $features = $_POST['price_features'];
    $stmt = $conn->prepare("UPDATE price_list SET item = ?, price = ?, features = ? WHERE id = ?");
    $stmt->bind_param("sdsi", $item, $price, $features, $id);
    $stmt->execute();
    showMessage("Preț actualizat.");
}

if (isset($_GET['delete_price'])) {
    $id = intval($_GET['delete_price']);
    $stmt = $conn->prepare("DELETE FROM price_list WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    showMessage("Preț șters.");
}


// ===================TeAM=====================
if (isset($_POST['add_team_member'])) {
  $nume_prenume = $_POST['nume_prenume'];
  $functie = $_POST['functie'];
  $imagine = $_FILES['imagine']['name'];
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($imagine);

  if (isset($_POST['update_team'])) {
    $nume_prenume = $_POST['nume_prenume'];
    $functie = $_POST['functie'];
    $imagine = $_POST['imagine']['name'];
    $stmt->bind_param("sdsi", $nume_prenume, $functie, $imagine);
    $stmt->execute();
    showMessage("Team member actualizat.");
}
  // Creează folderul dacă nu există
  if (!file_exists($target_dir)) {
      mkdir($target_dir, 0777, true);
  }

  // Mută fișierul
  if (move_uploaded_file($_FILES["imagine"]["tmp_name"], $target_file)) {
      $sql = "INSERT INTO team (nume_prenume, functie, imagine) VALUES ('$nume_prenume', '$functie', '$imagine')";
      if ($conn->query($sql)) {
          echo "<p style='color:green;'>Membru adăugat cu succes!</p>";
      } else {
          echo "Eroare SQL: " . $conn->error;
      }
  } else {
      echo "<p style='color:red;'>Eroare la încărcarea imaginii.</p>";
  }
}

// Ștergere membru echipă
if (isset($_GET['delete_team_member'])) {
  $id = $_GET['delete_team_member'];
  $conn->query("DELETE FROM team WHERE id = $id");
}
// --- FETCH ---
$carousel = $conn->query("SELECT * FROM carousel")->fetch_all(MYSQLI_ASSOC);
$about = $conn->query("SELECT * FROM about WHERE id = 1")->fetch_assoc();
$services = $conn->query("SELECT * FROM services")->fetch_all(MYSQLI_ASSOC);
$prices = $conn->query("SELECT * FROM price_list")->fetch_all(MYSQLI_ASSOC);
$team_result = $conn->query("SELECT * FROM team");




?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Admin Front</title>
  <link rel="stylesheet" href="css/s.css">
  <link rel="stylesheet" href="css/nav.css">
</head>
<body>
<div class="main-page-content">

<!-- CAROUSEL -->
<form method="POST" enctype="multipart/form-data">
  <h2>🖼️ Carusel</h2>
  <input type="text" name="title" placeholder="Titlu" required>
  <input type="file" name="image" required>
  <button name="add_carousel">Adaugă</button>
</form>
<ul>
<?php foreach ($carousel as $img): ?>
  <li>
    <form method="POST">
      <input type="hidden" name="carousel_id" value="<?= $img['id'] ?>">
      <img class="preview" src="<?= htmlspecialchars($img['image_path']) ?>">
      <input type="text" name="title" value="<?= htmlspecialchars($img['title']) ?>">
      <button name="update_carousel">💾</button>
      <a href="?delete_carousel=<?= $img['id'] ?>">🗑️</a>
    </form>
  </li>
<?php endforeach; ?>
</ul>

<hr>

<!-- ABOUT -->
<form method="POST" enctype="multipart/form-data">
  <h2>ℹ️ Despre</h2>
  <textarea name="description" rows="4"><?= htmlspecialchars($about['description'] ?? '') ?></textarea><br>
  <input type="file" name="image">
  <button name="update_about">Actualizează</button>
  <?php if (!empty($about['image_path'])): ?>
    <img class="preview" src="<?= htmlspecialchars($about['image_path']) ?>">
  <?php endif; ?>
</form>

<hr>

<!-- SERVICES -->
<form method="POST">
  <h2>🛠️ Servicii</h2>
  <input type="text" name="service_title" placeholder="Titlu" required>
  <input type="text" name="service_description" placeholder="Descriere" required>
  <input type="text" name="service_icon" placeholder="Icon fa (ex: fa-wifi)" required>
  <button name="add_service">Adaugă</button>
</form>
<ul>
<?php foreach ($services as $srv): ?>
  <li>
    <form method="POST">
      <input type="hidden" name="service_id" value="<?= $srv['id'] ?>">
      <input type="text" name="service_title" value="<?= htmlspecialchars($srv['title']) ?>">
      <input type="text" name="service_description" value="<?= htmlspecialchars($srv['description']) ?>">
      <input type="text" name="service_icon" value="<?= htmlspecialchars($srv['icon']) ?>">
      <button name="update_service">💾</button>
      <a href="?delete_service=<?= $srv['id'] ?>">🗑️</a>
    </form>
  </li>
<?php endforeach; ?>
</ul>

<hr>

<!-- PRICE LIST -->
<form method="POST">
  <h2>💰 Listă Prețuri</h2>
  <input type="text" name="price_item" placeholder="Serviciu / Produs" required>
  <input type="number" step="0.01" name="price_value" placeholder="Preț" required>
  <textarea name="price_features" placeholder="Caracteristici (una pe linie)"></textarea>
  <button name="add_price">Adaugă</button>
</form>
<ul>
<?php foreach ($prices as $p): ?>
  <li>
    <form method="POST">
      <input type="hidden" name="price_id" value="<?= $p['id'] ?>">
      <input type="text" name="price_item" value="<?= htmlspecialchars($p['item']) ?>">
      <input type="number" step="0.01" name="price_value" value="<?= $p['price'] ?>">
      <textarea name="price_features"><?= htmlspecialchars($p['features'] ?? '') ?></textarea>
      <button name="update_price">💾</button>
      <a href="?delete_price=<?= $p['id'] ?>">🗑️</a>
    </form>
  </li>
<?php endforeach; ?>
</ul><!-- Secțiune: Adăugare membru echipă -->
<form method="POST" enctype="multipart/form-data">
  <h2>👥 Adaugă Membru Echipa</h2>
  <input type="text" name="nume_prenume" placeholder="Nume și Prenume" required>
  <input type="text" name="functie" placeholder="Funcție" required>
  <input type="file" name="imagine" accept="image/*" required>
  <button name="add_team_member">Adaugă</button>
</form>

<!-- Listă Membri Echipă -->
<ul>
<?php while ($row = $team_result->fetch_assoc()): ?>
  <li>
    <form method="POST" enctype="multipart/form-data">
      <input type="hidden" name="team_id" value="<?= $row['id'] ?>">

      <input type="text" name="nume_prenume" value="<?= htmlspecialchars($row['nume_prenume']) ?>" required>
      <input type="text" name="functie" value="<?= htmlspecialchars($row['functie']) ?>" required>

      <!-- Imagine curentă -->
      <img src="uploads/<?= htmlspecialchars($row['imagine']) ?>" width="50" alt="Imagine curentă">

      <!-- Schimbă imaginea -->
      <input type="file" name="imagine" accept="image/*">

      <button name="update_team_member">💾</button>
      <a href="?delete_team_member=<?= $row['id'] ?>">🗑️</a>
    </form>
  </li>
<?php endwhile; ?>
</ul>

<!-- Script: Prevenire dublă trimitere -->
<script>
  document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
      if (form.dataset.submitted === 'true') {
        e.preventDefault();
      } else {
        form.dataset.submitted = 'true';
      }
    });
  });

  // Prevenire resubmit la refresh
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
</script>


</div>
</body>
</html>
