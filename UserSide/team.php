<?php
include ("../include/init.php");
include("../db/dbF.php");
include("../include/nav_user.php");

// Obținem toți membrii echipei din baza de date
$result = $conn->query("SELECT * FROM team");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Adrex</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
   

    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
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
    <div class="container-fluid bg-primary p-5 hero-header mb-5">
        <div class="row py-5">
            <div class="col-12 text-center">
                <h1 class="display-1 text-white animated zoomIn">Echipa Adrex</h1>
                <a href="index.php" class="h4 text-white">Acasa</a>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width: 600px;">
                <h5 class="text-primary text-uppercase" style="letter-spacing: 5px;">Echipa Adrex</h5>
                <h1 class="display-5 mb-0">Profesionistii nostri </h1>
            </div>
            <div class="row g-5">
                <?php
                // Afișăm membrii echipei din baza de date
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Obținem datele fiecărui membru
                        $imagine = 'uploads/' . $row['imagine']; // Assume image is stored in 'uploads' folder
                        $nume_prenume = $row['nume_prenume'];
                        $functie = $row['functie'];

                        echo "
                        <div class='col-lg-4 wow slideInUp' data-wow-delay='0.3s'>
                            <div class='position-relative rounded-top'>
                                <img class='img-fluid rounded-top w-100' src='$imagine' alt='$nume_prenume'>
                                <div class='position-absolute bottom-0 end-0 d-flex flex-column bg-white p-1' style='margin-right: -25px;'>
                                    <a class='btn btn-outline-secondary btn-square m-1' href='#'><i class='fab fa-twitter fw-normal'></i></a>
                                    <a class='btn btn-outline-secondary btn-square m-1' href='#'><i class='fab fa-facebook-f fw-normal'></i></a>
                                    <a class='btn btn-outline-secondary btn-square m-1' href='#'><i class='fab fa-linkedin-in fw-normal'></i></a>
                                    <a class='btn btn-outline-secondary btn-square m-1' href='#'><i class='fab fa-instagram fw-normal'></i></a>
                                </div>
                            </div>
                            <div class='bg-primary text-center rounded-bottom p-4'>
                                <h3 class='text-white'>$nume_prenume</h3>
                                <p class='text-white m-0'>$functie</p>
                            </div>
                        </div>";
                    }
                } else {
                    echo "<p class='text-center'>Nu există membri în echipă.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <a href="#" class="btn btn-lg btn-secondary btn-lg-square rounded back-to-top"><i class="bi bi-arrow-up"></i></a>

    <?php
    include("../include/feedback.php");
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
