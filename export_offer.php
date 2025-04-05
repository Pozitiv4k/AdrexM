<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (!isset($_POST['items'])) {
    die("Nu s-au primit date.");
}

$items = $_POST['items'];

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Headere
$sheet->fromArray(['Model Cameră', 'Material Cablu', 'Preț Punct', 'Cantitate', 'Total'], NULL, 'A1');

// Rânduri
$row = 2;
foreach ($items as $item) {
    $sheet->fromArray([
        $item['model_camera'],
        $item['material_cablu'],
        $item['pret_punct'],
        $item['cantitate'],
        $item['total'],
    ], NULL, "A$row");
    $row++;
}

// Download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="oferta.xlsx"');

$writer = new Xlsx($spreadsheet);
$writer->save("php://output");
exit;
