<?php
include ("../include/init.php");
include("../include/nav_user.php");
include("../db/dbF.php"); // fișier cu conexiunea la baza de date
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Adrex - Servicii</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/chat.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid bg-primary p-5 hero-header mb-5">
        <div class="row py-5">
            <div class="col-12 text-center">
                <h1 class="display-1 text-white animated zoomIn">Servicii</h1>
                <a href="index.php" class="h4 text-white">Acasa</a>
             </div>
        </div>
    </div>

    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width: 600px;">
                <h5 class="text-primary text-uppercase" style="letter-spacing: 5px;">Servicii</h5>
                <h1 class="display-6 mb-0">Ce servicii oferim</h1>
                
            </div>
            <div class="row g-5">
                <?php
                $sql = "SELECT * FROM servicii";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                        ?>
                        <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.3s">
                            <div class="service-item bg-light border-bottom border-5 border-primary rounded">
                                <div class="position-relative p-5">
                                    <i class="<?= htmlspecialchars($row['iconita']) ?> d-block display-1 fw-normal text-secondary mb-3"></i>
                                    <h5 class="text-primary mb-0"><?= htmlspecialchars($row['serviciu']) ?></h5>
                                    <p class="mt-3"><?= htmlspecialchars($row['descriere']) ?></p>
                                    <a href="#">Read More<i class="bi bi-arrow-right ms-2"></i></a>
                                </div>
                            </div>
                        </div>
                        <?php
                    endwhile;
                else:
                    echo "<p class='text-center'>Nu există servicii disponibile momentan.</p>";
                endif;
                ?>
            </div>
        </div>
    </div>

    <!-- Footer + JS -->
    <?php
    include("../include/footer.php"); ?>
    <script src="js/main.js"></script>
</body>
</html>
