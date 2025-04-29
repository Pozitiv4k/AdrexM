<?php
include ("include/init.php");
include("include/nav.php");
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagină Principală</title>
       
    <link href="css/s.css" rel="stylesheet">
</head>
<body>
    <div class="main-page-content">
    <h1>Bine ai venit, <?= htmlspecialchars($_SESSION['username']); ?>!</h1>
    </div>
    <script>
        const userId = <?php echo isset($_SESSION['id']) ? json_encode($_SESSION['id']) : 'null'; ?>;
        console.log('User ID:', userId); // Verificăm user ID-ul
    </script>
  sty
</body>
</html>
