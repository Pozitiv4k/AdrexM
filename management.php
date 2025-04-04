<?php
include 'include/auth.php';
include 'include/nav.php';
include 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['id'];

// Dropdown principal pentru alegere tip
$viewType = $_GET['view'] ?? 'echipamente';

// Filtre specifice
$tipEchipament = $_GET['tip_echipament'] ?? '';
$tipMaterial = $_GET['tip_material'] ?? '';
$tipCablu = $_GET['tip_cablu'] ?? '';

// Funcție reutilizabilă pentru fetch
function fetchItems($table, $userId, $filterColumn = '', $filterValue = '') {
    global $conn;
    if ($filterColumn && $filterValue) {
        $stmt = $conn->prepare("SELECT * FROM $table WHERE user_id = ? AND activ = 1 AND $filterColumn = ?");
        $stmt->bind_param("is", $userId, $filterValue);
    } else {
        $stmt = $conn->prepare("SELECT * FROM $table WHERE user_id = ? AND activ = 1");
        $stmt->bind_param("i", $userId);
    }
    $stmt->execute();
    return $stmt->get_result();
}

// Fetch doar pentru ce e necesar
if ($viewType === 'echipamente') {
    $items = fetchItems('echipamente', $userId, 'tip_echipament', $tipEchipament);
} elseif ($viewType === 'materiale') {
    $items = fetchItems('materiale', $userId, 'tip_material', $tipMaterial);
} elseif ($viewType === 'cabluri') {
    $items = fetchItems('cabluri', $userId, 'tip_cablu', $tipCablu);
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Depozit - Selectare Tip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        table th, table td {
            vertical-align: middle !important;
            text-align: center;
        }
        img.thumbnail {
            max-width: 80px;
            max-height: 80px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <h2 class="text-center mb-5">Depozit - Selectare Tip</h2>

    <!-- Dropdown principal -->
    <form method="GET" class="form-inline justify-content-center mb-4">
        <label class="mr-2">Alege tipul:</label>
        <select name="view" class="form-control mr-2" onchange="this.form.submit()">
            <option value="echipamente" <?= $viewType == 'echipamente' ? 'selected' : '' ?>>Echipamente</option>
            <option value="materiale" <?= $viewType == 'materiale' ? 'selected' : '' ?>>Materiale</option>
            <option value="cabluri" <?= $viewType == 'cabluri' ? 'selected' : '' ?>>Cabluri</option>
        </select>

        <?php if ($viewType == 'echipamente'): ?>
            <select name="tip_echipament" class="form-control mr-2" onchange="this.form.submit()">
                <option value="">Toate</option>
                <option value="Dahua" <?= ($tipEchipament == 'Dahua') ? 'selected' : '' ?>>Dahua</option>
                <option value="Hikvision" <?= ($tipEchipament == 'Hikvision') ? 'selected' : '' ?>>Hikvision</option>
            </select>
        <?php elseif ($viewType == 'materiale'): ?>
            <select name="tip_material" class="form-control mr-2" onchange="this.form.submit()">
                <option value="">Toate</option>
                <option value="Scoabe" <?= ($tipMaterial == 'Scoabe') ? 'selected' : '' ?>>Scoabe</option>
                <option value="Dibluri" <?= ($tipMaterial == 'Dibluri') ? 'selected' : '' ?>>Dibluri</option>
            </select>
        <?php elseif ($viewType == 'cabluri'): ?>
            <select name="tip_cablu" class="form-control mr-2" onchange="this.form.submit()">
                <option value="">Toate</option>
                <option value="UTP" <?= ($tipCablu == 'UTP') ? 'selected' : '' ?>>UTP</option>
                <option value="FTP" <?= ($tipCablu == 'FTP') ? 'selected' : '' ?>>FTP</option>
            </select>
        <?php endif; ?>
    </form>

    <!-- Afișare tabele -->
    <?php if ($viewType == 'echipamente'): ?>
        <h4>Echipamente</h4>
        <table class="table table-bordered table-striped">
            <thead class="thead-light">
                <tr>
                    <th>Nr.</th>
                    <th>Tip echipament</th>
                    <th>Model</th>
                    <th>Imagine</th>
                    <th>Preț</th>
                    <th>Descriere</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; while ($row = $items->fetch_assoc()): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($row['tip_echipament']) ?></td>
                    <td><?= htmlspecialchars($row['model_echipament']) ?></td>
                    <td>
                    <img src="<?= htmlspecialchars($row['imagine']) ?>" class="thumbnail" alt="Imagine">
                    </td>
                    <td><?= $row['pret_piata'] ?> MDL</td>
                    <td><?= htmlspecialchars($row['descriere']) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    <?php elseif ($viewType == 'materiale'): ?>
        <h4>Materiale</h4>
        <table class="table table-bordered table-striped">
            <thead class="thead-light">
                <tr>
                    <th>Nr.</th>
                    <th>Tip material</th>
                    <th>Cantitate</th>
                    <th>Imagine</th>
                    <th>Preț</th>
                    <th>Descriere</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; while ($row = $items->fetch_assoc()): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($row['tip_material']) ?></td>
                    <td><?= htmlspecialchars($row['cantitate']) ?></td>
                    <td>
                    <img src="<?= htmlspecialchars($row['imagine']) ?>" class="thumbnail" alt="Imagine">
                    </td>
                    <td><?= $row['pret_piata'] ?> MDL</td>
                    <td><?= htmlspecialchars($row['descriere']) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    <?php elseif ($viewType == 'cabluri'): ?>
        <h4>Cabluri</h4>
        <table class="table table-bordered table-striped">
            <thead class="thead-light">
                <tr>
                    <th>Nr.</th>
                    <th>Tip cablu</th>
                    <th>Cantitate</th>
                    <th>Imagine</th>
                    <th>Preț</th>
                    <th>Descriere</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; while ($row = $items->fetch_assoc()): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($row['tip_cablu']) ?></td>
                    <td><?= htmlspecialchars($row['cantitate']) ?></td>
                    <td>
                    <img src="<?= htmlspecialchars($row['imagine']) ?>" class="thumbnail" alt="Imagine">
                    </td>
                    <td><?= $row['pret_piata'] ?> MDL</td>
                    <td><?= htmlspecialchars($row['descriere']) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
