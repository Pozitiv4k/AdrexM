<?php
session_start();
include("include/init.php");
include("include/nav_user.php");
require 'db/db.php';

$carousel = []; $res = $conn->query("SELECT * FROM carousel"); 
if ($res) while ($r = $res->fetch_assoc()) $carousel[] = $r;

$about = null; $res = $conn->query("SELECT * FROM about WHERE id=1");
if ($res) $about = $res->fetch_assoc();

$services = []; $res = $conn->query("SELECT * FROM services");
if ($res) while ($r = $res->fetch_assoc()) $services[] = $r;

$prices = []; $res = $conn->query("SELECT * FROM price_list");
if ($res) while ($r = $res->fetch_assoc()) $prices[] = $r;
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="utf-8">
  <title>Adrex</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link rel="icon" href="img/favicon.ico">
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="lib/animate/animate.min.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <style>
    .carousel-item {
      height: 100%;
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }
    .carousel-item img {
      display: none;
    }
    .carousel-caption {
      background: rgba(0, 0, 0, 0.4);
      padding: 20px;
      border-radius: 10px;
    }
  </style>
</head>
<body>

<!-- Carousel Start -->
<div class="container-fluid p-0 mb-5">
  <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <?php foreach($carousel as $i => $slide): ?>
        <button type="button"
                data-bs-target="#header-carousel"
                data-bs-slide-to="<?= $i ?>"
                class="<?= $i===0 ? 'active' : '' ?>"
                <?= $i===0 ? 'aria-current="true"' : '' ?>
                aria-label="Slide <?= $i+1 ?>"></button>
      <?php endforeach; ?>
    </div>
    <div class="carousel-inner">
      <?php foreach($carousel as $i => $slide): ?>
        <div class="carousel-item <?= $i===0 ? 'active' : '' ?>" style="background-image: url('<?= htmlspecialchars($slide['image_path']) ?>');">
          <div class="carousel-caption d-flex flex-column align-items-center justify-content-center h-100">
            <div class="p-3 text-center" style="max-width: 900px;">
              <h5 class="text-white text-uppercase animated bounceInDown"><?= htmlspecialchars($slide['title']) ?></h5>
              <?php if (!empty($slide['subtitle'])): ?>
                <h1 class="display-1 text-white mb-md-4 animated zoomIn"><?= htmlspecialchars($slide['subtitle']) ?></h1>
              <?php endif; ?>
              <a href="userside/leads.php" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Obține oferta</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
      <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
      <span class="visually-hidden">Următor</span>
    </button>
  </div>
</div>
<!-- Carousel End -->

<!-- Despre Start -->
<?php if($about): ?>
<div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
  <div class="container">
    <div class="row gx-5">
      <div class="col-lg-5 mb-5 mb-lg-0" style="min-height: 500px;">
        <div class="position-relative h-100">
        <img class="position-absolute w-100 h-100 rounded wow zoomIn" data-wow-delay="0.3s"
        src="<?= htmlspecialchars($about['image_path']) ?>" style="object-fit: contain; background-color: #0b0c2a;">
        </div>
      </div>
      <div class="col-lg-4 col-md-6 wow zoomIn">
        <div class="mb-4">
          <h5 class="text-primary text-uppercase" style="letter-spacing: 5px;">Despre noi</h5>
          <h1 class="display-5 mb-0">Securitatea este în mâinile tale</h1>
        </div>
        <h4 class="text-body fst-italic mb-4"><?= nl2br(htmlspecialchars($about['short_heading'] ?? '')) ?></h4>
        <p class="mb-4"><?= nl2br(htmlspecialchars($about['description'])) ?></p>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
<!-- Despre End -->

<!-- Secțiunea servicii Start -->
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
<!-- Secțiunea servicii End -->


<!-- Prețuri Start -->
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
<!-- Prețuri End -->

<a href="#" class="btn btn-lg btn-secondary btn-lg-square rounded back-to-top"><i class="bi bi-arrow-up"></i></a>

<?php include("include/footer.php"); ?>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/wow/wow.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
