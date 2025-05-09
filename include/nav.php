<?php include_once __DIR__ . '/../configs/config.php'; ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/nav.css">

<!-- Butonul pentru a deschide sidebar-ul pe mobil -->
<span class="sidebar-toggle">&#9776; Meniu</span>

<div class="sidebar">
    <h2>Adrex<span>Cam</span></h2>

    <?php if (!isset($_SESSION['username'])): ?>
        <script>alert("Nu esti logat! Te rugam sa te autentifici pentru a accesa pagina.");</script>
    <?php endif; ?>

    <?php if (isset($_SESSION['username'])): ?>
        <a href="<?= BASE_URL ?>configs/schimbap.php">Schimbă Parola</a>
        <a href="<?= BASE_URL ?>users_clients/leads.php">Leads</a>
        <a href="<?= BASE_URL ?>depozit/management.php">Depozit</a>
        <a href="<?= BASE_URL ?>depozit/create_offer.php">Oferte</a>
        <div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="adminDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Taskuri
                </a>
                <div class="dropdown-menu" aria-labelledby="adminDropdown">
                <a href="<?= BASE_URL ?>tasks/taskuri_utilizator.php">Taskurile mele </a>
                    <?php if (isset($_SESSION['is_superuser']) && $_SESSION['is_superuser'] == 1): ?>
                        <a href="<?= BASE_URL ?>tasks/create_task.php">Creare Task</a>
                        <a href="<?= BASE_URL ?>tasks/tasks.php">Taskuri</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php if (isset($_SESSION['is_superuser']) && $_SESSION['is_superuser'] == 1): ?>
            <a href="<?= BASE_URL ?>logs/logs.php">Logs</a>
            <a href="<?= BASE_URL ?>admin_index.php">DashBoard</a>
            

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
