<?php include_once __DIR__ . '/../configs/config.php'; ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

<style>
/* Stil general pentru pagină */
body {
    margin: 0;
    font-family: "Segoe UI", sans-serif;
}

/* Sidebar fixat pentru desktop */
.sidebar {
    height: 100vh;
    width: 240px;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #2d3e50;
    padding-top: 20px;
    color: white;
    transition: left 0.3s ease;
}

/* Stil pentru titluri și linkuri */
.sidebar h2 {
    font-size: 1.4rem;
    text-align: center;
    font-weight: bold;
    color: #fff;
    margin-bottom: 30px;
}

.sidebar h2 span {
    color: #00aaff;
    font-weight: normal;
}

.sidebar a {
    padding: 12px 20px;
    text-decoration: none;
    font-size: 1rem;
    color: #ccc;
    display: block;
}

.sidebar a:hover {
    background-color: #1a252f;
    color: #fff;
}

/* Dropdown menu */
.sidebar .dropdown-menu {
    background-color: #2d3e50;
    border: none;
    padding-left: 10px;
}

.sidebar .dropdown-item {
    color: #ccc;
}

.sidebar .dropdown-item:hover {
    color: #fff;
    background-color: #1a252f;
}

/* Zona de conținut */
.content {
    margin-left: 240px;
    padding: 20px;
    transition: margin-left 0.3s ease;
}

/* Responsive pentru mobile */
@media (max-width: 768px) {
    /* Sidebar-ul va fi ascuns pe mobil */
    .sidebar {
        left: -240px; /* Ascunde complet sidebar-ul */
        position: absolute;
    }

    /* Conținutul se pune mai pe stânga pe mobil */
    .content {
        margin-left: 0;
    }

    /* Butonul de meniu pentru mobil (hamburger) */
    .sidebar-toggle {
        display: block;
        background-color: #2d3e50;
        color: white;
        padding: 10px;
        font-size: 1.5rem;
        cursor: pointer;
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 1000;
    }

    /* Arată sidebar-ul când este activat */
    .sidebar.show {
        left: 0;
    }

    /* Ascunde linkurile și dropdown-urile pe mobil până când sidebar-ul e deschis */
    .sidebar a, .sidebar .dropdown-item {
        display: none;
    }

    /* Arată linkurile și dropdown-urile când sidebar-ul este deschis */
    .sidebar.show a, .sidebar.show .dropdown-item {
        display: block;
    }
}


</style>

<!-- Butonul pentru a deschide sidebar-ul pe mobil -->
<span class="sidebar-toggle">&#9776; Meniu</span>

<div class="sidebar">
    <h2>Adrex<span>Cam</span></h2>

    <?php if (!isset($_SESSION['username'])): ?>
        <script>alert("Nu esti logat! Te rugam sa te autentifici pentru a accesa pagina.");</script>
    <?php endif; ?>

    <?php if (isset($_SESSION['username'])): ?>
        <a href="<?= BASE_URL ?>configs/schimbap.php">Schimbă Parola</a>
        <a href="<?= BASE_URL ?>depozit/management.php">Depozit</a>
        <a href="<?= BASE_URL ?>depozit/create_offer.php">Oferte</a>
        <a href="<?= BASE_URL ?>tasks/instalare_task.php">Instalare</a>

        <?php if (isset($_SESSION['is_superuser']) && $_SESSION['is_superuser'] == 1): ?>
            <a href="<?= BASE_URL ?>tasks/create_task.php">Creare Task</a>
            <a href="<?= BASE_URL ?>tasks/tasks.php">Taskuri</a>
            <a href="<?= BASE_URL ?>logs/logs.php">Logs</a>
            <a href="<?= BASE_URL ?>adminF.php">DashBoard</a>

            <!-- Dropdown simplu pentru Administrare -->
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="adminDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Administrare
                </a>
                <div class="dropdown-menu" aria-labelledby="adminDropdown">
                    <a class="dropdown-item" href="<?= BASE_URL ?>depozit/adaugare.php">Adăugare Depozit</a>
                    <a class="dropdown-item" href="<?= BASE_URL ?>depozit/b.add.php">Transmitere între Depozite</a>
                    <a class="dropdown-item" href="<?= BASE_URL ?>users_clients/add.php">Adăugare Client</a>
                    <a class="dropdown-item" href="<?= BASE_URL ?>users_clients/search.php">Căutare Client</a>
                    <a class="dropdown-item" href="<?= BASE_URL ?>users_clients/admuser.php">Useri</a>
                </div>
            </div>
        <?php endif; ?>

        <a href="<?= BASE_URL ?>logout.php">Ieșire</a>
    <?php else: ?>
        <a href="<?= BASE_URL ?>login.php">Autentificare</a>
        <a href="<?= BASE_URL ?>index.php">Pagina Principală</a>
    <?php endif; ?>
</div>



<script>
    // Alege butonul de meniu (hamburger) și sidebar
const sidebarToggle = document.querySelector('.sidebar-toggle');
const sidebar = document.querySelector('.sidebar');

// Adaugă un eveniment pentru a schimba starea sidebar-ului
sidebarToggle.addEventListener('click', function() {
    sidebar.classList.toggle('show'); // Activează sau dezactivează sidebar-ul
});

</script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
