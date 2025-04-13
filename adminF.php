<?php
include("include/auth.php");
include("db/dbF.php");
include("include/nav.php"); // Navigare header

// Adăugare membru echipă
if (isset($_POST['add_team_member'])) {
    $nume_prenume = $_POST['nume_prenume'];
    $functie = $_POST['functie'];
    $imagine = $_FILES['imagine']['name'];
    $target = "uploads/" . basename($imagine);

    // Validare imagine
    if ($_FILES['imagine']['size'] > 500000) {
        echo "Fișierul este prea mare!";
    } elseif (!in_array(strtolower(pathinfo($target, PATHINFO_EXTENSION)), ['jpg', 'png', 'jpeg', 'gif'])) {
        echo "Doar fișiere JPG, JPEG, PNG și GIF sunt permise!";
    } else {
        move_uploaded_file($_FILES['imagine']['tmp_name'], $target);

        // Prepared statement pentru a preveni SQL injection
        $stmt = $conn->prepare("INSERT INTO team (nume_prenume, functie, imagine) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nume_prenume, $functie, $imagine);
        if ($stmt->execute()) {
            echo "Membru adăugat cu succes!";
        } else {
            echo "Eroare la adăugare membru: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Ștergere membru echipă
if (isset($_GET['delete_team_member'])) {
    $id = $_GET['delete_team_member'];
    $conn->query("DELETE FROM team WHERE id = $id");
}

// Adăugare serviciu
if (isset($_POST['add_service'])) {
    $serviciu = $_POST['serviciu'];
    $descriere = $_POST['descriere'];
    $iconita = $_POST['iconita'];

    $stmt = $conn->prepare("INSERT INTO servicii (serviciu, descriere, iconita) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $serviciu, $descriere, $iconita);
    if ($stmt->execute()) {
        echo "Serviciu adăugat cu succes!";
    } else {
        echo "Eroare la adăugare serviciu: " . $stmt->error;
    }
    $stmt->close();
}

// Ștergere serviciu
if (isset($_GET['delete_service'])) {
    $id = $_GET['delete_service'];
    $conn->query("DELETE FROM servicii WHERE id = $id");
}

// Adăugare preț
if (isset($_POST['add_price'])) {
    $serviciu = $_POST['serviciu'];
    $pret = $_POST['pret'];
    $descriere = $_POST['descriere'];

    $stmt = $conn->prepare("INSERT INTO price_list (serviciu, pret, descriere) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $serviciu, $pret, $descriere);
    if ($stmt->execute()) {
        echo "Preț adăugat cu succes!";
    } else {
        echo "Eroare la adăugare preț: " . $stmt->error;
    }
    $stmt->close();
}

// Ștergere preț
if (isset($_GET['delete_price'])) {
    $id = $_GET['delete_price'];
    $conn->query("DELETE FROM price_list WHERE id = $id");
}

// Adăugare secțiune About
if (isset($_POST['add_about'])) {
    $titlu = $_POST['titlu'];
    $descriere = $_POST['descriere'];

    $stmt = $conn->prepare("INSERT INTO about (titlu, descriere) VALUES (?, ?)");
    $stmt->bind_param("ss", $titlu, $descriere);
    if ($stmt->execute()) {
        echo "Secțiune 'About' adăugată cu succes!";
    } else {
        echo "Eroare la adăugare secțiune About: " . $stmt->error;
    }
    $stmt->close();
}
if (isset($_GET['delete_about'])) {
    $id = $_GET['delete_about'];
    $conn->query("DELETE FROM about WHERE id = $id");
}
// Adăugare imagini pentru Carousel
if (isset($_POST['add_carousel'])) {
    $imagine_carousel = $_FILES['imagine_carousel']['name'];
    $target_carousel = "uploads/carousel/" . basename($imagine_carousel);

    if ($_FILES['imagine_carousel']['size'] > 500000) {
        echo "Fișierul carousel este prea mare!";
    } elseif (!in_array(strtolower(pathinfo($target_carousel, PATHINFO_EXTENSION)), ['jpg', 'png', 'jpeg'])) {
        echo "Doar fișiere JPG, JPEG, PNG sunt permise!";
    } else {
        move_uploaded_file($_FILES['imagine_carousel']['tmp_name'], $target_carousel);

        $stmt = $conn->prepare("INSERT INTO carousel (imagine) VALUES (?)");
        $stmt->bind_param("s", $imagine_carousel);
        if ($stmt->execute()) {
            echo "Imagine adăugată cu succes în carousel!";
        } else {
            echo "Eroare la adăugare imagine în carousel: " . $stmt->error;
        }
        $stmt->close();
    }
}
if (isset($_GET['delete_carousel'])) {
    $id = $_GET['delete_carousel'];
    $conn->query("DELETE FROM carousel WHERE id = $id");
}

// Obținem datele pentru echipă, servicii, prețuri, secțiune About și carousel
$team_result = $conn->query("SELECT * FROM team");
$service_result = $conn->query("SELECT * FROM servicii");
$price_result = $conn->query("SELECT * FROM price_list");
$about_result = $conn->query("SELECT * FROM about");
$carousel_result = $conn->query("SELECT * FROM carousel");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Adrex Admin</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Admin Page" name="keywords">
    <meta content="Admin Page" name="description">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styl.css" rel="stylesheet">
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">
</head>

<body>

    <div class="container-fluid">
        <h1 class="my-4">Admin Dashboard</h1>

        <!-- Adăugare membru echipă -->
        <div class="my-4">
            <h2>Adăugare membru echipă</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="text" name="nume_prenume" placeholder="Nume și Prenume" required>
                <input type="text" name="functie" placeholder="Funcție" required>
                <input type="file" name="imagine" required>
                <button type="submit" name="add_team_member">Adaugă</button>
            </form>
        </div>

        <!-- Adăugare serviciu -->
        <div class="my-4">
            <h2>Adăugare serviciu</h2>
            <form action="" method="POST">
                <input type="text" name="serviciu" placeholder="Nume serviciu" required>
                <input type="text" name="descriere" placeholder="Descriere" required>
                <select name="iconita" required>
                    <option value="">Selectează o iconiță</option>
                    <option value="flaticon-cctv">📹 CCTV</option>
                    <option value="flaticon-retail">🛍️ Retail</option>
                    <option value="flaticon-maintenance">🔧 Mentenanță</option>
                    <option value="flaticon-security">🔒 Securitate</option>
                    <option value="flaticon-tools">🛠️ Unelte</option>
                    <option value="flaticon-network">🌐 Rețea</option>
                    <option value="flaticon-recorder">Recorder</option>
                    <option value="flaticon-security-system">Monitoring</option>
                    <option value="flaticon-surveillance">Configurare</option>
                </select>
                <button type="submit" name="add_service">Adaugă</button>
            </form>
        </div>

        <!-- Adăugare preț -->
        <div class="my-4">
            <h2>Adăugare preț</h2>
            <form action="" method="POST">
                <input type="text" name="serviciu" placeholder="Serviciu" required>
                <input type="text" name="pret" placeholder="Preț" required>
                <input type="text" name="descriere" placeholder="Descriere" required>
                <button type="submit" name="add_price">Adaugă</button>
            </form>
        </div>

        <!-- Adăugare secțiune About -->
        <div class="my-4">
            <h2>Adăugare secțiune About</h2>
            <form action="" method="POST">
                <input type="text" name="titlu" placeholder="Titlu" required>
                <textarea name="descriere" placeholder="Descriere" required></textarea>
                <button type="submit" name="add_about">Adaugă</button>
            </form>
        </div>

        <!-- Carousel -->
        <div class="my-4">
            <h2>Adăugare imagine în Carousel</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="file" name="imagine_carousel" required>
                <button type="submit" name="add_carousel">Adaugă imagine</button>
            </form>
        </div>

        <!-- Lista echipei -->
        <div class="my-4">
            <h2>Lista echipei</h2>
            <table class="table">
                <tr>
                    <th>Nume</th>
                    <th>Funcție</th>
                    <th>Imagine</th>
                    <th>Acțiuni</th>
                </tr>
                <?php while ($row = $team_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['nume_prenume'] ?></td>
                        <td><?= $row['functie'] ?></td>
                        <td><img src="uploads/<?= $row['imagine'] ?>" width="50" alt="imagine"></td>
                        <td><a href="?delete_team_member=<?= $row['id'] ?>">Șterge</a></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <!-- Lista serviciilor -->
        <div class="my-4">
            <h2>Lista serviciilor</h2>
            <table class="table">
                <tr>
                    <th>Serviciu</th>
                    <th>Descriere</th>
                    <th>Iconiță</th>
                    <th>Acțiuni</th>
                </tr>
                <?php while ($row = $service_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['serviciu'] ?></td>
                        <td><?= $row['descriere'] ?></td>
                        <td><i class="<?= $row['iconita'] ?>"></i></td>
                        <td><a href="?delete_service=<?= $row['id'] ?>">Șterge</a></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <!-- Lista prețurilor -->
        <div class="my-4">
            <h2>Lista prețurilor</h2>
            <table class="table">
                <tr>
                    <th>Serviciu</th>
                    <th>Preț</th>
                    <th>Descriere</th>
                    <th>Acțiuni</th>
                </tr>
                <?php while ($row = $price_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['serviciu'] ?></td>
                        <td><?= $row['pret'] ?></td>
                        <td><?= $row['descriere'] ?></td>
                        <td><a href="?delete_price=<?= $row['id'] ?>">Șterge</a></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <!-- Secțiunea About -->
        <div class="my-4">
            <h2>Secțiune About</h2>
            <table class="table">
                <tr>
                    <th>Titlu</th>
                    <th>Descriere</th>
                    <th>Subtitlu</th>
                    <th>Extra text</th>
                    <th>Imagine</th>
                </tr>
                <?php while ($row = $about_result->fetch_assoc()) { ?>
                    <tr>
                        <td><img src="uploads/<?= $row['imagine'] ?>" width="50" alt="imagine"></td> 
                        <td><?= $row['title'] ?></td>
                        <td><?= $row['description'] ?></td>
                        <td><?= $row['subtitle'] ?></td>
                        <td><?= $row['extra_text'] ?></td>
                        <td><a href="?delete_about=<?= $row['id'] ?>">Șterge</a></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <!-- Carousel Images -->
        <div class="my-4">
            <h2>Imagini din Carousel</h2>
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php $active = 'active'; ?>
                    <?php while ($row = $carousel_result->fetch_assoc()) { ?>
                        <div class="carousel-item <?= $active ?>">
                            <img src="uploads/carousel/<?= $row['imagine'] ?>" class="d-block w-100" alt="...">
                        </div>
                        <?php $active = ''; ?>
                    <?php } ?>
                    <td><a href="?delete_carousel=<?= $row['id'] ?>">Șterge</a></td>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
