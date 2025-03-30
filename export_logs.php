<?php
require 'db.php'; // Conectarea la baza de date
require 'vendor/autoload.php'; // Biblioteca PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Obținem perioada selectată
$duration = isset($_GET['duration']) ? $_GET['duration'] : 'day';
$date_condition = '';

switch ($duration) {
    case 'week':
        $date_condition = "log_time >= NOW() - INTERVAL 1 WEEK";
        break;
    case 'month':
        $date_condition = "log_time >= NOW() - INTERVAL 1 MONTH";
        break;
    default:
        $date_condition = "DATE(log_time) = CURDATE()";
}

$query = "SELECT id, user, action, log_time FROM logs WHERE $date_condition ORDER BY log_time DESC";
$result = $conn->query($query);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'User');
$sheet->setCellValue('C1', 'Action');
$sheet->setCellValue('D1', 'Timestamp');

$row = 2;
while ($log = $result->fetch_assoc()) {
    $sheet->setCellValue("A$row", $log['id']);
    $sheet->setCellValue("B$row", $log['user']);
    $sheet->setCellValue("C$row", $log['action']);
    $sheet->setCellValue("D$row", $log['log_time']);
    $row++;
}

$filename = "logs_" . date('Y-m-d') . ".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=$filename");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
