<?php
require_once('../vendor/tecnickcom/tcpdf/tcpdf.php');

if (!isset($_POST['items']) || !is_array($_POST['items'])) {
    die('Date invalide.');
}

$items = $_POST['items'];

// Inițializare PDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('AdrexM');
$pdf->SetTitle('Ofertă client');
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();
$pdf->SetFont('dejavusans', '', 10);

// Stil
$style = <<<EOD
<style>
    table { border-collapse: collapse; width: 100%; }
    th { background-color: #000; color: #fff; padding: 5px; border: 1px solid #000; text-align: center; }
    td { border: 1px solid #000; padding: 5px; text-align: center; vertical-align: middle; }
    .nume { text-align: left; font-weight: bold; }
    img { height: 50px; }
</style>
EOD;

$html = $style;
$html .= '<h2 style="text-align:center;">Ofertă Client</h2>';
$html .= '<table>
            <thead>
                <tr>
                    <th>Nr.</th>
                    <th>Model</th>
                    <th>Imagine</th>
                    <th>Preț</th>
                    <th>Preț Final</th>
                    <th>Descriere</th>
                </tr>
            </thead>
            <tbody>';

$total_general = 0;
$nr = 1;

foreach ($items as $item) {
    $model = htmlspecialchars(trim($item['model'] ?? '')) ?: '—';
    $pret = floatval($item['pret'] ?? 0);
    $cantitate = floatval($item['cantitate'] ?? 1);
    $pret_final = $pret * $cantitate;
    $total_general += $pret_final;
    $descriere = htmlspecialchars(trim($item['descriere'] ?? '')) ?: '—';

    // Imagine
    $imagineHtml = '—';
    if (!empty($item['imagine'])) {
        $imgPath = __DIR__ . '/uploads/' . basename($item['imagine']);
        if (file_exists($imgPath)) {
            $imgExt = strtolower(pathinfo($imgPath, PATHINFO_EXTENSION));
            if (in_array($imgExt, ['png', 'jpg', 'jpeg'])) {
                $imgData = base64_encode(file_get_contents($imgPath));
                $imagineHtml = '<img src="data:image/' . $imgExt . ';base64,' . $imgData . '" />';
            }
        }
    }

    // Dacă toate câmpurile sunt goale, trecem peste rând
    if ($model === '—' && $imagineHtml === '—' && $pret === 0 && $pret_final === 0 && $descriere === '—') {
        continue;
    }

    $html .= "<tr>
                <td>$nr</td>
                <td class='nume'>$model</td>
                <td>$imagineHtml</td>
                <td>" . number_format($pret, 2) . " LEU x {$cantitate}</td>
                <td>" . number_format($pret_final, 2) . " LEU</td>
                <td>$descriere</td>
              </tr>";
    $nr++;
}

$html .= '</tbody></table>';
$html .= '<br><h3 style="text-align:right;">Total General: ' . number_format($total_general, 2) . ' LEU</h3>';

// Generare PDF
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('oferta_client.pdf', 'I');
