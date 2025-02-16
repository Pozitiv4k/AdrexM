<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<?php
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">
        <div class="logo-container">
            <img src="adrex.png" alt="Logo">
        </div>
    </a>
    <ul class="navbar-nav mr-auto">
        <?php
        if (isset($_SESSION['username'])) {
            echo '<li class="nav-item"><a class="nav-link" href="schimbap.php">Schimba Parola</a></li>';
            echo '<li class="nav-item"><a class="nav-link" href="management.php">Depozit</a></li>';
            if (isset($_SESSION['is_superuser']) && $_SESSION['is_superuser'] == 1) {
                echo '
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Administrare
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="adaugare.php">Adaugare Depozit</a>
                        <a class="dropdown-item" href="b.add.php">Transmitere intre Depozite</a>
                        <a class="dropdown-item" href="add.php">Adaugare Client</a>
                        <a class="dropdown-item" href="search.php">Cautare Client</a>
                        <a class="dropdown-item" href="admuser.php">Useri</a>
                    </div>
                </div>
                ';
            }
            
            echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
        } else {
            echo '<li class="nav-item"><a class="nav-link" href="login.php">Autentificare</a></li>';
        }
        ?>
    </ul>
</nav>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>