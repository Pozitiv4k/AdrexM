<?php
// Pornim sesiunea doar dacă nu a fost deja pornită
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    if (!isset($_SESSION['login_time'])) {
    // Dacă nu există login_time, redirecționăm la login
    header("Location: /adrexm/login.php");
    exit();
}

// Timpul de viață al sesiunii: 30 minute (1800 secunde)
$sessionLifetime = 1800;

if (time() - $_SESSION['login_time'] > $sessionLifetime) {
    session_unset();
    session_destroy();
    header("Location: /adrexm/login.php?expired=1"); // Poți afișa un mesaj în login.php
    exit();
}

}

// Includem configurația aplicației (ex. conexiunea la baza de date)
include_once __DIR__ . '/../configs/config.php';

// Setăm limita de timp pentru sesiune (în secunde)
$session_timeout = 300; // 5 minute

// Dacă sesiunea este activă și avem o înregistrare a ultimei activități
if (isset($_SESSION['last_activity'])) {
    // Calculăm timpul scurs de la ultima activitate
    $inactivity_duration = time() - $_SESSION['last_activity'];

    // Dacă timpul de inactivitate depășește limita admisă
    if ($inactivity_duration > $session_timeout) {
        // Distrugem toate variabilele de sesiune și redirecționăm la login
        session_unset();
        session_destroy();

        // Redirecționăm utilizatorul către pagina de autentificare cu mesaj
        header("Location: /login.php?expired=1");
        exit();
    }
}

// Actualizăm timpul ultimei activități în sesiune
$_SESSION['last_activity'] = time();
