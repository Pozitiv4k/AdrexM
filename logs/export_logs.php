<?php
require '../vendor/autoload.php';
require '../db/db.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (!$conn) {
    die("Eroare: Conexiunea la baza de date nu este validă!");
}

// Verificăm durata selectată
$duration = $_GET['duration'] ?? '1day';
$categorie = $_GET['categorie'] ?? 'clienti';
$categorii_permise = ['clienti', 'materiale', 'utilizatori'];

if (!in_array($categorie, $categorii_permise)) {
    die("Eroare: Categorie invalidă!");
}

$date_condition = "";
switch ($duration) {
    case '1week':
        $date_condition = "AND created_at >= NOW() - INTERVAL 7 DAY";
        break;
    case '1month':
        $date_condition = "AND created_at >= NOW() - INTERVAL 1 MONTH";
        break;
    default:
        $date_condition = "AND created_at >= NOW() - INTERVAL 1 DAY";
}

// Interogăm baza de date
$sql = "SELECT mesaj, created_at FROM logs WHERE categorie = ? $date_condition ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $categorie);
$stmt->execute();
$result = $stmt->get_result();

// Creăm fișierul Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Antet coloane
$sheet->setCellValue('A1', 'Mesaj');
$sheet->setCellValue('B1', 'Data');

$row = 2; // Începem de la a doua linie
while ($log = $result->fetch_assoc()) {
    $sheet->setCellValue("A$row", $log['mesaj']);
    $sheet->setCellValue("B$row", $log['created_at']);
    $row++;
}

$stmt->close();

// Generăm fișierul
$filename = "logs_{$categorie}_{$duration}.xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
