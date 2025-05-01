<?php
namespace App\Controllers;

require_once "../app/enums/enum.link.php";
use App\Enums\Includes;

require_once Includes::CONTROLLER->value;
require_once includes::SESSION_SERVICE->value;
require_once Includes::ENUM_KEYS->value;
require_once Includes::ENUM_VIEW->value;
require_once Includes::MODEL->value;


use App\Enums\Keys;
use App\Enums\View;    
use function App\Models\readData;
use function App\Models\writeData;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\IOFactory;



function dashboard() : void {
    $user = \App\Services\get(Keys::USER->value);
    
    if (!$user || $user[Keys::ROLE->value] !== Keys::APPRENANT->value) {
        redirect(View::LOGIN->value);
        return;
    }
    
    render(View::APPRENANT_DASHBOARD->value, [Keys::USER->value => $user]);
}

function paginer(array $items, int $limit = 5): array {
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $total = count($items);
    $pages = ceil($total / $limit);
    $offset = ($page - 1) * $limit;
    $pageItems = array_slice($items, $offset, $limit);

    return [$pageItems, $total, $pages, $page];
}

function page_apprenants() : void {
    $data = readData();
    $promotions = $data["apprenants"] ?? [];
    // var_dump($promotions);
    // die();
    $promotions = array_values($promotions);
    [$promosPagines, $total, $pages, $page] = paginer($promotions, 8);

    // $promotionActive = getPromotionActive($data[Keys::PROMOTIONS->value] ?? []);
    // $nbApprenants = $promotionActive ? getNombreApprenants($promotionActive) : 0;
    // $nbReferentiels = $promotionActive ? getNombreReferentiels($promotionActive) : 0;

    $view = "apprenant/pageApprenant";
    require Includes::BASE_LAYOUT->value;

}


function telechargerExcel(): void {
    require_once __DIR__ . '/../../vendor/autoload.php';

    $data = readData();
    $apprenants = $data["apprenants"] ?? [];

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    if (empty($apprenants)) {
        $sheet->setCellValue('A1', 'Aucun apprenant trouvé.');
    } else {
        $headers = array_keys($apprenants[0]);
        
        // Entêtes
        foreach ($headers as $colIndex => $header) {
            $cell = Coordinate::stringFromColumnIndex($colIndex + 1) . '1';
            $sheet->setCellValue($cell, ucfirst($header));
        }

        // Données
        foreach ($apprenants as $rowIndex => $apprenant) {
            foreach (array_values($apprenant) as $colIndex => $value) {
                $cell = Coordinate::stringFromColumnIndex($colIndex + 1) . ($rowIndex + 2);
                $sheet->setCellValue($cell, $value);
            }
        }
    }

    // Télécharger
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="apprenants.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}



function telechargerPDF(): void {
    require_once __DIR__ . '/../../vendor/autoload.php';

    $data = readData();
    $apprenants = $data["apprenants"] ?? [];

    // Construction HTML
    $html = '<h2 style="text-align:center;">Liste des Apprenants</h2>';
    $html .= '<table border="1" cellspacing="0" cellpadding="5" style="width:100%; border-collapse:collapse;">';
    $html .= '<thead><tr>';

    if (!empty($apprenants)) {
        foreach (array_keys($apprenants[0]) as $key) {
            $html .= '<th>' . htmlspecialchars(ucfirst($key)) . '</th>';
        }
        $html .= '</tr></thead><tbody>';

        foreach ($apprenants as $apprenant) {
            $html .= '<tr>';
            foreach ($apprenant as $val) {
                $html .= '<td>' . htmlspecialchars($val) . '</td>';
            }
            $html .= '</tr>';
        }

        $html .= '</tbody>';
    } else {
        $html .= '<td colspan="100%">Aucun apprenant trouvé</td>';
    }

    $html .= '</table>';

    // Options PDF
    $options = new Options();
    $options->set('defaultFont', 'DejaVu Sans');
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    // Envoi au navigateur
    $dompdf->stream('apprenants.pdf', ["Attachment" => true]);
    exit;
}


function importerExcel() {
    if (!isset($_FILES['excel_file']) || $_FILES['excel_file']['error'] !== UPLOAD_ERR_OK) {
        echo "Erreur de téléchargement du fichier.";
        return;
    }

    require_once __DIR__ . '/../../vendor/autoload.php';

    $filePath = $_FILES['excel_file']['tmp_name'];

    try {
        // Lire le fichier Excel
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        if (empty($rows)) {
            echo "Fichier vide.";
            return;
        }

        // Lire les entêtes (1ère ligne)
        $headers = array_map('strtolower', $rows[0]); // standardiser les clés
        $apprenants = [];

        for ($i = 1; $i < count($rows); $i++) {
            $rowData = array_combine($headers, $rows[$i]);
            if ($rowData) {
                $apprenants[] = $rowData;
            }
        }

        // Charger les données existantes
        $data = readData();
        $data["apprenants"] = $data["apprenants"] ?? [];

        // Récupérer les matricules déjà existants
        $matriculesExistants = array_column($data["apprenants"], 'matricule');
        $emailsExistants = array_column($data["apprenants"], 'email');

        // Ajouter seulement les nouveaux apprenants
        foreach ($apprenants as $nouveau) {
            if (!in_array($nouveau['matricule'], $matriculesExistants) && !in_array($nouveau['email'], $emailsExistants)) {
                $data["apprenants"][] = $nouveau;
            }else {
                $listeattente[] = $nouveau;
                var_dump($listeattente);
                echo "L'apprenant avec le matricule {$nouveau['matricule']} ou l'email {$nouveau['email']} existe déjà.";
                echo "<br>";  
                die();
            }

        }

        writeData($data);
        echo "Fichier importé et apprenants enregistrés avec succès !";

    } catch (Exception $e) {
        echo "Erreur lors de la lecture du fichier Excel : " . $e->getMessage();
    }

    exit;
}
