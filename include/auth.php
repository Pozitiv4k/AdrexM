<?php
session_start();

// Funcție pentru afișarea unui mesaj de eroare și redirecționare
function showErrorAndRedirect($message, $redirectUrl, $seconds = 2) {
    echo "<p style='color: red; text-align: center;'>$message</p>";
    echo "<p style='text-align: center;'>Veți fi redirecționat în $seconds secunde...</p>";
    header("Refresh: $seconds; URL=$redirectUrl");
    exit();
}

// Funcție pentru deconectarea utilizatorului
function logoutUser() {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Verificăm dacă utilizatorul încearcă să acceseze `login.php` fiind deja logat
if (basename($_SERVER['PHP_SELF']) == 'login.php' && isset($_SESSION['username'])) {
    showErrorAndRedirect("Un utilizator este deja logat: " . htmlspecialchars($_SESSION['username']), "index.php");
}

// Verificăm dacă utilizatorul este autentificat pentru paginile protejate
if (!isset($_SESSION['username']) && basename($_SERVER['PHP_SELF']) != 'login.php') {
    header("Location: login.php");
    exit();
}

// Funcție pentru verificarea permisiunilor de acces pe pagini
function checkPermissions($page) {
    if (basename($_SERVER['PHP_SELF']) == $page) {
        if (!(isset($_SESSION['is_superuser']) && $_SESSION['is_superuser'] == 1)) {
            showErrorAndRedirect("Nu aveți permisiuni pentru a accesa această pagină.", "index.php");
        }
    }
}


// Verificăm permisiunile pentru paginile cu acces restricționat
checkPermissions('adaugare.php');
checkPermissions('admuser.php');
checkPermissions('add.php');
checkPermissions('search.php');

// Securizare redirecționare edit_client.php?id=1, edit_client.php?id=2 etc.
if (basename($_SERVER['PHP_SELF']) == 'edit_client.php' && isset($_GET['id'])) {
    // Verificăm dacă utilizatorul are permisiuni pentru a edita clientul cu ID-ul respectiv
    // Se poate folosi o logică bazată pe datele specifice clientului pentru a verifica accesul
    // De exemplu, doar superuserii pot edita un client
    if (!(isset($_SESSION['is_superuser']) && $_SESSION['is_superuser'] == 1)) {
        showErrorAndRedirect("Nu aveți permisiuni pentru a edita acest client.", "index.php");
    }

  }
    
?>
