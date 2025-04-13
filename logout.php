<?php
session_start();

// Ștergem toate datele din sesiune și deconectăm utilizatorul
include 'logs/log_manager.php';

// if (isset($_SESSION['user'])) {
//     addLog($_SESSION['user'], 'Logout', 'Utilizatorul s-a delogat.');
// }
session_unset();
session_destroy();

// Redirecționăm către pagina de login
header("Location: login.php");
exit();
?>