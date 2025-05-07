<?php
include ("../include/init.php");
include("../include/nav_user.php");
include("../db/db.php"); // fișier cu conexiunea la baza de date

$services = []; $res = $conn->query("SELECT * FROM services");
if ($res) while ($r = $res->fetch_assoc()) $services[] = $r;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Adrex - Servicii</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/chat.css" rel="stylesheet">
    <link href="../lib/animate/animate.min.css" rel="stylesheet">
    <link href="../lib/flaticon/font/flaticon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid bg-primary p-5 hero-header mb-5">
        <div class="row py-5">
            <div class="col-12 text-center">
                <h1 class="display-1 text-white animated zoomIn">Servicii</h1>
                <a href="../index.php" class="h4 text-white">Acasa</a>
             </div>
        </div>
    </div>

 
            <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
  <div class="container">
    <div class="text-center mx-auto mb-5" style="max-width: 600px;">
      <h5 class="text-primary text-uppercase" style="letter-spacing: 5px;">Servicii</h5>
      <h1 class="display-5 mb-0">Ce oferim</h1>
    </div>
    <div class="row g-5">
      <?php foreach($services as $svc): ?>
        <div class="col-lg-4 col-md-6 wow zoomIn d-flex" data-wow-delay="0.3s">
          <div class="service-item bg-light border-bottom border-5 border-primary rounded h-100 d-flex flex-column w-100">
            <div class="position-relative p-5 flex-grow-1 d-flex flex-column">
              <i class="<?= isset($svc['icon']) ? htmlspecialchars($svc['icon']) : 'fa-question' ?> d-block display-1 fw-normal text-secondary mb-3"></i>
              <h5 class="text-primary"><?= htmlspecialchars($svc['title']) ?></h5>
              <h3><?= htmlspecialchars($svc['subtitle'] ?? '') ?></h3>
              <p class="flex-grow-1"><?= htmlspecialchars($svc['description']) ?></p>
              <a href="#" class="mt-3 text-decoration-none text-primary fw-semibold">
                Află mai mult <i class="bi bi-arrow-right ms-2"></i>
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
        </div>
    </div>

    <!-- Footer + JS -->
    <?php
    include("../include/footer.php"); ?>
    <script src="js/main.js"></script>
</body>
</html>
