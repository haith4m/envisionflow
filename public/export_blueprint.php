<?php
session_start();
//export_blueprint.php

require_once 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$blueprintData = json_decode($_SESSION['blueprintData'] ?? '{}', true);

if (empty($blueprintData)) {
    header('Location: blueprint.php');
    exit;
}

// Generate the HTML content dynamically
$html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><style>
    body { font-family: sans-serif; margin: 40px; color: #333; }
    h1 { color: #B16CEA; text-align: center; }
    h2 { border-bottom: 2px solid #ddd; padding-bottom: 5px; margin-top: 25px; }
    p, li { font-size: 14px; line-height: 1.6; }
    ul { list-style-type: none; padding-left: 0; }
    li { margin-bottom: 10px; padding-left: 20px; position: relative; }
    li::before { content: "•"; color: #6CEAC7; position: absolute; left: 0; font-size: 20px; line-height: 1; }
</style></head><body>';

// Add the title
$html .= "<h1>" . htmlspecialchars($blueprintData['project_name'] ?? 'AI Generated Blueprint') . "</h1>";

// Loop through the blueprint data to generate the content for each section
foreach ($blueprintData as $key => $value) {
    if ($key === 'project_name') {
        continue;
    }
    // This will now correctly pull 'problem_statement', 'revenue_model', etc.
    $title = ucwords(str_replace('_', ' ', $key));
    $html .= "<h2>" . htmlspecialchars($title) . "</h2>";

    if (is_array($value)) {
        $html .= "<ul>";
        foreach ($value as $item) {
            $html .= "<li>" . htmlspecialchars($item) . "</li>";
        }
        $html .= "</ul>";
    } else {
        $html .= "<p>" . htmlspecialchars($value) . "</p>";
    }
}

$html .= '</body></html>';

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$filename = str_replace(' ', '_', $blueprintData['project_name'] ?? 'blueprint') . '.pdf';
$dompdf->stream($filename, ["Attachment" => true]);

unset($_SESSION['blueprintData']);
?>