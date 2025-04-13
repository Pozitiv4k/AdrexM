<?php
include_once __DIR__ . '/../configs/config.php';
?>
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm py-3 py-lg-0 px-3 px-lg-0">
    <a href="<?= BASE_URL ?>index.php" class="navbar-brand ms-lg-5">
        <h1 class="display-5 m-0 text-primary">Adrex<span class="text-secondary">Cam</span></h1>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-0">
            <a href="<?= BASE_URL ?>index.php" class="nav-item nav-link">Acasa</a>
            <a href="<?= BASE_URL ?>UserSide/about.php" class="nav-item nav-link active">Despre</a>
            <a href="<?= BASE_URL ?>UserSide/service.php" class="nav-item nav-link">Servicii</a>
            <a href="<?= BASE_URL ?>UserSide/price.php" class="nav-item nav-link">Price List</a>
            <a href="<?= BASE_URL ?>UserSide/team.php" class="nav-item nav-link">Echipa noastra</a>
            <a href="<?= BASE_URL ?>UserSide/contact.php" class="nav-item nav-link">Contacte</a>
            <a href="tel:+123456789" class="nav-item nav-link nav-contact bg-secondary text-white px-5 ms-lg-5">
                <i class="bi bi-telephone-outbound me-2"></i>+022844444
            </a>
        </div>
    </div>
</nav>
