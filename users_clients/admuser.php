<?php
include '../include/auth.php';
include '../include/nav.php';
include '../logs/log_helper.php'; // Adăugat pentru loguri

if (basename($_SERVER['PHP_SELF']) == 'admin.php') {
    if (!(isset($_SESSION['is_superuser']) && $_SESSION['is_superuser'] == 1)) {
        showErrorAndRedirect("Nu aveți permisiuni pentru a accesa această pagină.", "index.php", 2);
    }
}

function addData($tableName, $fields, $values) {
    global $conn;
    $columns = implode(",", $fields);
    $placeholders = implode(",", array_fill(0, count($fields), "?"));
    $query = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";
    $stmt = $conn->prepare($query);
    $types = str_repeat("s", count($values));
    $stmt->bind_param($types, ...$values);
    return $stmt->execute();
}

function deleteUser($userId) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    return $stmt->execute();
}

function updateSuperuserStatus($userId, $isSuperuser) {
    global $conn;
    $stmt = $conn->prepare("UPDATE users SET is_superuser = ? WHERE id = ?");
    $stmt->bind_param("ii", $isSuperuser, $userId);
    return $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $currentUser = $_SESSION['username'] ?? 'Necunoscut'; // Utilizatorul care face modificarea

    if ($action == 'add_user') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $is_superuser = isset($_POST['is_superuser']) ? 1 : 0;
        $fields = ['username', 'password', 'is_superuser', 'created_at'];
        $values = [$username, password_hash($password, PASSWORD_BCRYPT), $is_superuser, date('Y-m-d H:i:s')];

        if (addData('users', $fields, $values)) {
            adaugaLog('utilizatori', "$currentUser a adăugat utilizatorul $username cu rol " . ($is_superuser ? "Administrator" : "User") . ".");
        }
    } elseif ($action == 'delete_user') {
        $userId = $_POST['user_id'];

        // Obținem numele utilizatorului înainte de ștergere
        $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $deletedUsername = $result['username'] ?? 'Necunoscut';

        if (deleteUser($userId)) {
            adaugaLog('utilizatori', "$currentUser a șters utilizatorul $deletedUsername.");
        }
    } elseif ($action == 'toggle_admin') {
        $userId = $_POST['user_id'];
        $isSuperuser = $_POST['is_superuser'];

        // Obținem numele utilizatorului
        $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $targetUsername = $result['username'] ?? 'Necunoscut';

        if ($targetUsername !== 'superuser' && updateSuperuserStatus($userId, $isSuperuser)) {
            $actionText = $isSuperuser ? "a acordat drepturi de administrator" : "a revocat drepturile de administrator";
            adaugaLog('utilizatori', "$currentUser $actionText pentru utilizatorul $targetUsername.");
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$search = $_GET['search'] ?? '';
$users = $conn->query("SELECT * FROM users WHERE username LIKE '%$search%'")->fetch_all(MYSQLI_ASSOC);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrație - Gestionare Utilizatori</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
   


</head>
<body>

<div class="container">
    <h1 class="text-center">Administrație - Gestionare Utilizatori</h1>

    <!-- Formular adăugare utilizator nou -->
    <div>
        <h2>Adaugă Utilizator Nou</h2>
        <form method="POST">
            <input type="hidden" name="action" value="add_user">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Parolă:</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" name="is_superuser">
                <label class="form-check-label" for="is_superuser">Administrator</label>
            </div>
            <button type="submit" class="btn btn-success">Adaugă Utilizator</button>
        </form>
    </div>

    <!-- Bara de căutare -->
    <div>
        <h2>Caută Utilizator</h2>
        <form method="GET">
            <div class="form-group">
                <input type="text" class="form-control" name="search" placeholder="Caută după username" value="<?= htmlspecialchars($search) ?>">
            </div>
            <button type="submit" class="btn btn-primary">Caută</button>
        </form>
    </div>

    <!-- Afișare utilizatori existenți -->
    <div>
        <h2>Utilizatori Curenti</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Admin</th>
                    <th>Acțiuni</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= $user['is_superuser'] ? 'Da' : 'Nu' ?></td>
                        <td>
                            <?php if ($user['username'] !== 'superuser'): ?>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <button type="submit" name="action" value="delete_user" class="btn btn-danger">Șterge</button>
                                </form>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <input type="hidden" name="is_superuser" value="<?= $user['is_superuser'] ? 0 : 1 ?>">
                                    <button type="submit" name="action" value="toggle_admin" class="btn btn-<?= $user['is_superuser'] ? 'danger' : 'success' ?>">
                                        <?= $user['is_superuser'] ? 'Revocă Admin' : 'Setează Admin' ?>
                                    </button>
                                </form>
                            <?php else: ?>
                                <button class="btn btn-secondary" disabled>Admin Permanent</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
