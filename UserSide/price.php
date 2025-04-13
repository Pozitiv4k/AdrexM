<?php
session_start();
include("../include/nav_user.php");
include("../db/dbF.php"); // fișier cu conexiunea la DB
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

<div class="container-fluid bg-primary p-5 hero-header mb-5">
    <div class="row py-5">
        <div class="col-12 text-center">
            <h1 class="display-1 text-white animated zoomIn">Price List</h1>
            <a href="index.php" class="h4 text-white">Acasa</a>
            <i class="far fa-circle text-white px-2"></i>
        </div>
    </div>
</div>

<!-- Pricing Plan Start -->
<div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s" style="margin-bottom: 75px;">
    <div class="container">
        <div class="text-center mx-auto mb-5" style="max-width: 600px;">
            <h5 class="text-primary text-uppercase" style="letter-spacing: 5px;">Plan tarifar</h5>
            <h1 class="display-5 mb-0">Plan tarifar pentru serviciile noastre</h1>
        </div>
        <div class="row g-5">
            <?php
            $sql = "SELECT serviciu, pret, descriere FROM price_list";
            $result = mysqli_query($conn, $sql);

            $colors = ['primary', 'secondary', 'primary'];
            $index = 0;

            while ($row = mysqli_fetch_assoc($result)) {
                $serviciu = $row['serviciu'];
                $pret = $row['pret'];
                $descriere = $row['descriere'];
                $color = $colors[$index % count($colors)];
                echo "
                <div class='col-lg-4 wow slideInUp' data-wow-delay='" . (0.3 + $index * 0.3) . "s'>
                    <div class='position-relative border border-$color rounded'>
                        <div class='bg-$color text-center pt-5 pb-4'>
                            <h3 class='text-white'>$serviciu</h3>
                            <h1 class='display-4 text-white'>
                                <small class='align-top' style='font-size: 22px; line-height: 45px;'></small>$pret<small class='align-bottom' style='font-size: 16px; line-height: 40px;'>MDL</small>
                            </h1>
                        </div>
                        <div class='text-center py-5'>
                            <p class='mb-2 pb-2'>$descriere</p>
                        </div>
                        <a href='#' class='btn btn-$color py-2 px-4 position-absolute top-100 start-50 translate-middle'>Order Now</a>
                    </div>
                </div>";
                $index++;
            }
            ?>
        </div>
    </div>
</div>
<!-- Pricing Plan End -->

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
