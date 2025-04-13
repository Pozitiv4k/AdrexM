<?php
include_once __DIR__ . '/../configs/config.php';
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">


<nav class="navbar navbar-expand-lg navbar-light bg-light">
<a class="nav-link" href="<?php echo BASE_URL; ?>admin.php">
            <h1 class="display-5 m-0 text-primary">Adrex<span class="text-secondary">Cam</span></h1>
        </a>
    <ul class="navbar-nav mr-auto">
    <?php
if (isset($_SESSION['username'])) {
    echo '<li class="nav-item"><a class="nav-link" href="' . BASE_URL . 'configs/schimbap.php">Schimba Parola</a></li>';
    echo '<li class="nav-item"><a class="nav-link" href="' . BASE_URL . 'depozit/management.php">Depozit</a></li>';
    echo '<li class="nav-item"><a class="nav-link" href="' . BASE_URL . 'depozit/create_offer.php">Oferte</a></li>';
    echo '<li class="nav-item"><a class="nav-link" href="' . BASE_URL . 'tasks/instalare_task.php">Instalare</a></li>';

    if (isset($_SESSION['is_superuser']) && $_SESSION['is_superuser'] == 1) {
        echo '<li class="nav-item"><a class="nav-link" href="' . BASE_URL . 'tasks/create_task.php">Creare Task</a></li>';
        echo '<li class="nav-item"><a class="nav-link" href="' . BASE_URL . 'tasks/tasks.php">Taskuri</a></li>';
        echo '<li class="nav-item"><a class="nav-link" href="' . BASE_URL . 'logs/logs.php">Logs</a></li>';
        echo '
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Administrare
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="' . BASE_URL . 'depozit/adaugare.php">Adaugare Depozit</a>
                <a class="dropdown-item" href="' . BASE_URL . 'depozit/b.add.php">Transmitere intre Depozite</a>
                <a class="dropdown-item" href="' . BASE_URL . 'users_clients/add.php">Adaugare Client</a>
                <a class="dropdown-item" href="' . BASE_URL . 'users_clients/search.php">Cautare Client</a>
                <a class="dropdown-item" href="' . BASE_URL . 'users_clients/admuser.php">Useri</a>
            </div>
        </div>
        ';
    }

    echo '<li class="nav-item"><a class="nav-link" href="' . BASE_URL . 'configs/logout.php">Logout</a></li>';
} else {
    echo '<li class="nav-item"><a class="nav-link" href="' . BASE_URL . 'configs/login.php">Autentificare</a></li>';
}
?>

    </ul>
</nav>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>