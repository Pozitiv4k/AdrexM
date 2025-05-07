<?php
include("../include/init.php");
include("../db/db.php");
include("../include/nav.php"); // Sidebar-ul e inclus de tine separat

$order_by = "id DESC";
$search_id = '';
if (isset($_GET['sort'])) {
    if ($_GET['sort'] == 'nume_asc') $order_by = "nume ASC";
    if ($_GET['sort'] == 'nume_desc') $order_by = "nume DESC";
    if ($_GET['sort'] == 'data_asc') $order_by = "id ASC";
    if ($_GET['sort'] == 'data_desc') $order_by = "id DESC";
}
if (!empty($_GET['id_cautat'])) {
    $search_id = intval($_GET['id_cautat']);
    $sql = "SELECT * FROM leads WHERE id = $search_id";
} else {
    $sql = "SELECT * FROM leads ORDER BY $order_by";
}
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Leads - Solicitări Clienți</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/nav.css" rel="stylesheet"> <!-- Sidebar CSS deja existent -->
    <style>
        .main-content {
            padding: 20px;
            padding-left: 260px; /* compensare pentru sidebar */
        }
        @media (max-width: 768px) {
            .main-content {
                padding-left: 20px; /* pe mobil, sidebar e ascuns/colapsat */
            }
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="container-fluid">
        <h2 class="text-center mb-4">Solicitări primite de la clienți</h2>

        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="id_cautat" class="form-control" placeholder="Caută după ID..." value="<?= htmlspecialchars($search_id) ?>">
            </div>
            <div class="col-md-4">
                <select name="sort" class="form-select">
                    <option value="">Sortează după...</option>
                    <option value="nume_asc" <?= @$_GET['sort'] == 'nume_asc' ? 'selected' : '' ?>>Nume A-Z</option>
                    <option value="nume_desc" <?= @$_GET['sort'] == 'nume_desc' ? 'selected' : '' ?>>Nume Z-A</option>
                    <option value="data_desc" <?= @$_GET['sort'] == 'data_desc' ? 'selected' : '' ?>>Cele mai recente</option>
                    <option value="data_asc" <?= @$_GET['sort'] == 'data_asc' ? 'selected' : '' ?>>Cele mai vechi</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Aplică filtre</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nume</th>
                        <th>Prenume</th>
                        <th>Email</th>
                        <th>Telefon</th>
                        <th>Adresă</th>
                        <th>Serviciu</th>
                        <th>Descriere</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['nume']) ?></td>
                            <td><?= htmlspecialchars($row['prenume']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['telefon']) ?></td>
                            <td><?= htmlspecialchars($row['adresa']) ?></td>
                            <td><?= htmlspecialchars($row['serviciu']) ?></td>
                            <td><?= nl2br(htmlspecialchars($row['descriere'])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="8">Nu s-au găsit rezultate.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
