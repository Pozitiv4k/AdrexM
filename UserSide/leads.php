<?php 
include ("../include/init.php"); 
include("../db/dbF.php"); // fișier cu conexiunea la DB
                if (isset($_POST['submit_lead'])) {
                    $nume = mysqli_real_escape_string($conn, $_POST['nume']);
                    $prenume = mysqli_real_escape_string($conn, $_POST['prenume']);
                    $email = mysqli_real_escape_string($conn, $_POST['email']);
                    $telefon = mysqli_real_escape_string($conn, $_POST['telefon']);
                    $adresa = mysqli_real_escape_string($conn, $_POST['adresa']);
                    $serviciu = mysqli_real_escape_string($conn, $_POST['serviciu']);
                    $descriere = mysqli_real_escape_string($conn, $_POST['descriere']);

                    $sql_insert = "INSERT INTO leads (nume, prenume, email, telefon, adresa, serviciu, descriere) 
                                VALUES ('$nume', '$prenume', '$email', '$telefon', '$adresa', '$serviciu', '$descriere')";
                    if (mysqli_query($conn, $sql_insert)) {
                        // Redirecționează cu un parametru de succes
                        header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
                        exit();
                    } else {
                        header("Location: " . $_SERVER['PHP_SELF'] . "?error=1");
                        exit();
                    }
                }
include("../include/nav_user.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Adrex</title>
    <link href="img/favicon.ico" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/chat.css" rel="stylesheet">
</head>
<body>
<!-- Formular Contact Serviciu Start -->
<div class="container py-5">
    <div class="text-center mx-auto mb-5" style="max-width: 600px;">
        <h5 class="text-primary text-uppercase" style="letter-spacing: 5px;">Contact</h5>
        <h1 class="display-5 mb-0">Trimite o solicitare pentru un serviciu</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form method="POST" action="">
                <div class="row g-3">
                    <div class="col-md-6">
                        <input type="text" name="nume" class="form-control" placeholder="Nume" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="prenume" class="form-control" placeholder="Prenume" required>
                    </div>
                    <div class="col-md-6">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="telefon" class="form-control" placeholder="Număr de telefon" required>
                    </div>
                    <div class="col-12">
                        <input type="text" name="adresa" class="form-control" placeholder="Adresă completă" required>
                    </div>
                    <div class="col-12">
                        <select name="serviciu" class="form-select" required>
                            <option value="" selected disabled>Selectează serviciul dorit</option>
                            <option value="Consultare">Consultare</option>
                            <option value="Mentenanță">Mentenanță</option>
                            <option value="Reparații și diagnostică">Reparații și diagnostică</option>
                            <option value="Configurare echipament personal">Configurare echipament personal</option>
                            <option value="Alt serviciu">Alt serviciu</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <textarea name="descriere" rows="5" class="form-control" placeholder="Descrie cerința ta..." required></textarea>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" name="submit_lead" class="btn btn-primary px-4 py-2">Trimite solicitarea</button>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>
<!-- Formular Contact Serviciu End -->


<?php 
    include("../include/footer.php");
     ?>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/wow/wow.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
