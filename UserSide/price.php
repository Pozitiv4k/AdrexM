<?php
include("../include/nav_user.php");
include("../db/db.php"); // fișier cu conexiunea la DB
$prices = []; $res = $conn->query("SELECT * FROM price_list");
if ($res) while ($r = $res->fetch_assoc()) $prices[] = $r;
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
    <link href="../lib/flaticon/font/flaticon.css" rel="stylesheet">
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../lib/animate/animate.min.css" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/chat.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid bg-primary p-5 hero-header mb-5">
    <div class="row py-5">
        <div class="col-12 text-center">
            <h1 class="display-1 text-white animated zoomIn">Price List</h1>
            <a href="../index.php" class="h4 text-white">Acasa</a>
            <i class="far fa-circle text-white px-2"></i>
        </div>
    </div>
</div>

<!-- Pricing Plan Start -->
<div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
  <div class="container">
    <div class="text-center mx-auto mb-5" style="max-width: 600px;">
      <h5 class="text-primary text-uppercase" style="letter-spacing: 5px;">Planuri tarifare</h5>
      <h1 class="display-5 mb-0">Lista de prețuri</h1>
    </div>
    <div class="row g-5">
      <?php foreach($prices as $pr): ?>
        <div class="col-lg-4 wow slideInUp d-flex" data-wow-delay="0.3s">
          <div class="position-relative border border-primary rounded w-100 d-flex flex-column">
            <div class="bg-primary text-center pt-5 pb-4">
              <h3 class="text-white"><?= htmlspecialchars($pr['item']) ?></h3>
              <h1 class="display-4 text-white">
                <?= number_format($pr['price'], 2) ?>
                <small class="align-bottom" style="font-size:22px;line-height:45px;">Leu</small>
              </h1>
            </div>
            <div class="text-center py-5 flex-grow-1 d-flex flex-column justify-content-start">
              <?php foreach(explode("\n", $pr['features'] ?? '') as $feat): ?>
                <?php if (trim($feat) !== ''): ?>
                  <p class="border-bottom border-light mb-2 pb-2"><?= htmlspecialchars($feat) ?></p>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
            <div class="text-center pb-4">
              <a href="#" class="btn btn-primary py-2 px-4">Comandă acum</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<!-- Pricing Plan End -->

<a href="#" class="btn btn-lg btn-secondary btn-lg-square rounded back-to-top"><i class="bi bi-arrow-up"></i></a>

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
