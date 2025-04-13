<?php
require '../vendor/autoload.php';
require_once __DIR__ . '/vendor/tecnickcom/tcpdf/tcpdf.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['items'])) {
    $items = $_POST['items'];
    $exportType = $_POST['export'] ?? 'excel';

    $header = ['Nr.', 'Tip', 'Model', 'Descriere', 'Imagine', 'Cantitate', 'Preț', 'Total'];
    $rows = [];
    $grandTotal = 0;

    foreach ($items as $index => $item) {
        $tip = $item['tip'] ?? '';
        $model = $item['model'] ?? ''; // asigură-te că aici vine denumirea, nu ID-ul
        $descriere = $item['descriere'] ?? '';
        $imagine = $item['imagine'] ?? '';
        $cantitate = floatval($item['cantitate'] ?? 0);
        $pret = floatval($item['pret'] ?? 0);
        $total = $cantitate * $pret;
        $grandTotal += $total;

        $rows[] = [
            $index + 1,
            $tip,
            $model,
            $descriere,
            $imagine,
            $cantitate,
            number_format($pret, 2),
            number_format($total, 2)
        ];
    }

    if ($exportType === 'excel') {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($header, null, 'A1');

        // Dimensiuni coloane pentru aspect
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(12);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(12);

        $rowIndex = 2;
        foreach ($rows as $row) {
            $sheet->setCellValue("A$rowIndex", $row[0]);
            $sheet->setCellValue("B$rowIndex", $row[1]);
            $sheet->setCellValue("C$rowIndex", $row[2]);
            $sheet->setCellValue("D$rowIndex", $row[3]);
            $sheet->getStyle("D$rowIndex")->getAlignment()->setWrapText(true);

            // Imagine
            $imgPath = __DIR__ . '/uploads/' . basename($row[4]);
            if (!empty($row[4]) && file_exists($imgPath)) {
                $drawing = new Drawing();
                $drawing->setName('Imagine');
                $drawing->setPath($imgPath);
                $drawing->setHeight(40);
                $drawing->setCoordinates("E$rowIndex");
                $drawing->setOffsetX(5);
                $drawing->setOffsetY(5);
                $drawing->setWorksheet($sheet);
            }

            $sheet->setCellValue("F$rowIndex", $row[5]);
            $sheet->setCellValue("G$rowIndex", $row[6]);
            $sheet->setCellValue("H$rowIndex", $row[7]);
            $rowIndex++;
        }

        $sheet->setCellValue("G$rowIndex", 'TOTAL GENERAL');
        $sheet->setCellValue("H$rowIndex", number_format($grandTotal, 2) . ' LEU');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="oferta.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;

    } elseif ($exportType === 'pdf') {
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('dejavusans', '', 9);

        $html = '<h2 style="text-align:center;">Ofertă</h2>';
        $html .= '<style>
                    table { border-collapse: collapse; width: 100%; }
                    th, td { border: 1px solid #000; padding: 5px; text-align: center; font-size: 9px; }
                    td.descriere { width: 120px; word-wrap: break-word; text-align: left; }
                 </style>';

        $html .= '<table><thead><tr>';
        foreach ($header as $col) {
            $html .= "<th>$col</th>";
        }
        $html .= '</tr></thead><tbody>';

        foreach ($rows as $row) {
            $html .= '<tr>';
            foreach ($row as $i => $cell) {
                if ($i === 4 && $cell) { // Imagine
                    $imgPath = __DIR__ . '/uploads/' . basename($cell);
                    if (file_exists($imgPath)) {
                        $imgData = base64_encode(file_get_contents($imgPath));
                        $imgExt = pathinfo($imgPath, PATHINFO_EXTENSION);
                        $imgTag = '<img src="data:image/' . $imgExt . ';base64,' . $imgData . '" height="40">';
                        $html .= "<td>$imgTag</td>";
                    } else {
                        $html .= '<td></td>';
                    }
                } elseif ($i === 3) {
                    $html .= '<td class="descriere">' . htmlspecialchars($cell) . '</td>';
                } else {
                    $html .= '<td>' . htmlspecialchars($cell) . '</td>';
                }
            }
            $html .= '</tr>';
        }

        $html .= '<tr><td colspan="6"></td><td><strong>TOTAL GENERAL</strong></td><td><strong>' . number_format($grandTotal, 2) . ' LEU</strong></td></tr>';
        $html .= '</tbody></table>';

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('oferta.pdf', 'D');
        exit;
    }
} else {
    echo "Nu s-au primit date valide pentru export.";
}
