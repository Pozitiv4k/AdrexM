<?php
include_once __DIR__ . '/../configs/config.php';
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

<style>
/* Navbar stilizat clar și aerisit */
.navbar.adrex-navbar {
    background-color: #ffffff;
    border-bottom: 1px solid #dee2e6;
    padding: 0.75rem 1.5rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.adrex-navbar .navbar-brand h1 {
    font-size: 1.8rem;
    margin: 0;
    color: #007bff;
    font-weight: bold;
}

.adrex-navbar .navbar-brand span {
    color: #6c757d;
    font-weight: normal;
}

.adrex-navbar .nav-link {
    color: #343a40 !important;
    margin-right: 1rem;
    font-size: 1rem;
    font-weight: 500;
}

.adrex-navbar .nav-link:hover {
    color: #007bff !important;
    text-decoration: none;
}

.adrex-navbar .dropdown-menu {
    border-radius: 0.25rem;
    border: 1px solid #dee2e6;
}

.adrex-navbar .dropdown-item {
    font-size: 0.95rem;
    padding: 0.5rem 1.2rem;
}

.adrex-navbar .dropdown-item:hover {
    background-color: #f8f9fa;
    color: #007bff;
}
</style>

<nav class="navbar navbar-expand-lg navbar-light adrex-navbar">
<a class="navbar-brand" href="<?php 
    if (isset($_SESSION['username'])) {
        echo BASE_URL . 'admin.php';  // Daca este logat, linkul duce la admin.php
    } else {
        echo '#';  // Daca nu este logat, nu duce nicăieri
    }
?>">
    <h1>Adrex<span>Cam</span></h1>
</a>

<?php
if (!isset($_SESSION['username'])) {  // Verificăm dacă utilizatorul nu este logat
    echo '<script>alert("Nu esti logat! Te rugam sa te autentifici pentru a accesa pagina.");</script>';
}
?>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent"
        aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
        <ul class="navbar-nav">
            <?php
            if (isset($_SESSION['username'])) {
                echo '<li class="nav-item"><a class="nav-link" href="' . BASE_URL . 'configs/schimbap.php">Schimbă Parola</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="' . BASE_URL . 'depozit/management.php">Depozit</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="' . BASE_URL . 'depozit/create_offer.php">Oferte</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="' . BASE_URL . 'tasks/instalare_task.php">Instalare</a></li>';

                if (isset($_SESSION['is_superuser']) && $_SESSION['is_superuser'] == 1) {
                    echo '<li class="nav-item"><a class="nav-link" href="' . BASE_URL . 'tasks/create_task.php">Creare Task</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="' . BASE_URL . 'tasks/tasks.php">Taskuri</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="' . BASE_URL . 'logs/logs.php">Logs</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="' . BASE_URL . 'adminF.php">DashBoard</a></li>';

                    echo '
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Administrare
                        </a>
                        <div class="dropdown-menu" aria-labelledby="adminDropdown">
                            <a class="dropdown-item" href="' . BASE_URL . 'depozit/adaugare.php">Adăugare Depozit</a>
                            <a class="dropdown-item" href="' . BASE_URL . 'depozit/b.add.php">Transmitere între Depozite</a>
                            <a class="dropdown-item" href="' . BASE_URL . 'users_clients/add.php">Adăugare Client</a>
                            <a class="dropdown-item" href="' . BASE_URL . 'users_clients/search.php">Căutare Client</a>
                            <a class="dropdown-item" href="' . BASE_URL . 'users_clients/admuser.php">Useri</a>
                        </div>
                    </li>';
                }

                echo '<li class="nav-item"><a class="nav-link" href="' . BASE_URL . 'logout.php">Logout</a></li>';
            } else {
                echo '<li class="nav-item"><a class="nav-link" href="' . BASE_URL . 'login.php">Autentificare</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="' . BASE_URL . 'index.php">Pagina Principală</a></li>';
            }
            ?>
        </ul>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
