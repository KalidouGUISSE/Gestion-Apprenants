<?php
namespace App\Controllers;

require_once "../app/enums/enum.link.php";
use App\Enums\Includes;

require_once Includes::CONTROLLER->value;
require_once includes::SESSION_SERVICE->value;
require_once Includes::ENUM_KEYS->value;
require_once Includes::ENUM_VIEW->value;
require_once Includes::MODEL->value;
require_once Includes::VALIDATORE_SERVICE->value;



use App\Enums\Keys;
use App\Enums\View;    
use function App\Models\readData;
use function App\Models\writeData;
use function App\Services\validerApprenant;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


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
    
    
    $promotions = array_values($promotions);
    if (($_REQUEST['route']) === 'apprenants_attente') {
        $promotions = $data["listeattente"] ?? [];
    }
    [$promosPagines, $total, $pages, $page] = paginer($promotions, 8);


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

function importerExcel() : void {
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

        $matriculesExistantslisteattente = array_column($data["apprenants"], 'matricule');
        $emailsExistantslisteattente = array_column($data["apprenants"], 'email');


        // Ajouter seulement les nouveaux apprenants
        foreach ($apprenants as $nouveau) {
            if (!in_array($nouveau['matricule'], $matriculesExistants) && !in_array($nouveau['email'], $emailsExistants)) {
                $data["apprenants"][] = $nouveau;
            }elseif (!in_array($nouveau['matricule'], $matriculesExistantslisteattente) && !in_array($nouveau['email'], $emailsExistantslisteattente)) {
                $data["listeattente"][] = $nouveau;
                echo "L'apprenant avec le matricule {$nouveau['matricule']} ou l'email {$nouveau['email']} existe déjà.";
                echo "<br>";  
            }
        }

        // writeData($data);
        $importreuie = "Fichier importé et apprenants enregistrés avec succès !";
        $_SESSION['importreuie'] = $importreuie;
        echo "Fichier importé et apprenants enregistrés avec succès !";

    } catch (Exception $e) {
        echo "Erreur lors de la lecture du fichier Excel : " . $e->getMessage();
    }
    redirect('apprenants');

}

function pageAjoutApprenant() {

    $view = "apprenant/ajoutApprenant";
    require Includes::BASE_LAYOUT->value;
}



function ajouterApprenant(): void {
    require_once __DIR__ . '/../../vendor/autoload.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirect('apprenants');
        return;
    }
    $data = readData();
    $newApprenant = collectApprenantData($_POST, $_FILES);

    $resultat = validerApprenant($newApprenant);
    if ($resultat['success']) {
        $newApprenant = enrichApprenantData($newApprenant);
        $data["apprenants"][] = $newApprenant;
        writeData($data);
        if (envoyerEmailConfirmation($newApprenant)) {
            $_SESSION['success'] = "Apprenant ajouté avec succès et email envoyé.";
        } else {
            $_SESSION['errors'] = ["L'envoi de l'e-mail a échoué."];
        }
    } else {
        session_start();
        $_SESSION['errors'] = $resultat['errors'] ?? ['Une erreur inconnue s\'est produite.'];
        var_dump($_SESSION['errors']['prenom']);
    }

    $_SESSION['old'] = $_POST;
    redirect('page_ajout_apprenant');
}
function collectApprenantData(array $post, array $files): array {
    return [
        'nom' => $post['nom'] ?? '',
        'prenom' => $post['prenom'] ?? '',
        'email' => $post['email'] ?? '',
        'telephone' => $post['telephone'] ?? '',
        'adresse' => $post['adresse'] ?? '',
        'nom_tuteur' => $post['nom_tuteur'] ?? '',
        'lien_parente' => $post['lien_parente'] ?? '',
        'adresse_tuteur' => $post['adresse_tuteur'] ?? '',
        'telephone_tuteur' => $post['telephone_tuteur'] ?? '',
        'image' => $files['image']['name'] ?? '',
    ];
}
function enrichApprenantData(array $apprenant): array {
    $matricule = rand(1000, 9999);
    $apprenant['matricule'] = "ECSA" . $matricule;
    $apprenant['statut'] = "Actif";
    $apprenant['Nombre_absences'] = 0;
    $apprenant['Nombre_retards'] = 0;
    $apprenant['Nombre_presence'] = 0;
    $apprenant['Nombre_justifie'] = 0;

    $apprenant['login'] = $apprenant['email'];
    $motDePasse = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 8);
    $apprenant['mot_de_passe'] = password_hash($motDePasse, PASSWORD_DEFAULT);
    $apprenant['plain_mot_de_passe'] = $motDePasse; // utile temporairement pour l'email

    return $apprenant;
}
function envoyerEmailConfirmation(array $apprenant): bool {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'kalidouguisse16@gmail.com';
        $mail->Password = 'aoam kgod thzp boxc';// ⚠️ À externaliser dans un fichier de config sécurisé
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('kalidouguisse16@gmail.com', 'L\'équipe ODC');
        $mail->addAddress("{$apprenant['email']}", "{$apprenant['prenom']} {$apprenant['nom']}");
        $mail->isHTML(true);
        $mail->Subject = 'Bienvenue sur la plateforme de formation';

        $mail->Body = "Bonjour <strong>{$apprenant['prenom']} {$apprenant['nom']}</strong>,<br><br>" .
                    "Votre compte a été créé avec succès.<br>" .
                    "Voici vos identifiants de connexion :<br><br>" .
                    "Login : <strong>{$apprenant['login']}</strong><br>" .
                    "Mot de passe : <strong>{$apprenant['plain_mot_de_passe']}</strong><br><br>" .
                    "Merci de vous connecter rapidement pour finaliser votre profil : http://guisse.kalidou.sa.edu.sn:8125/index.php?route=login .<br><br>" .
                    "Cordialement,<br>L'équipe ODC";

        $mail->send();
        return true;
    } catch (Exception $e) {
        var_dump($e);
        die();
        error_log("Erreur envoi email : " . $mail->ErrorInfo);
        return false;
    }
}


// function ajouterApprenant() : void {
//     $data = readData();
//     $apprenants = $data["apprenants"] ?? [];
//     $listeattente = $data["listeattente"] ?? [];

//     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//         $newApprenant = [
//             'nom' => $_POST['nom'],
//             'prenom' => $_POST['prenom'],
//             'email' => $_POST['email'],
//             'telephone' => $_POST['telephone'],
//             'adresse' => $_POST['adresse'],
//             'nom_tuteur' => $_POST['nom_tuteur'],
//             'lien_parente' => $_POST['lien_parente'],
//             'adresse_tuteur' => $_POST['adresse_tuteur'],
//             'telephone_tuteur' => $_POST['telephone_tuteur']
//         ];
//     }

//     $resultat = validerApprenant($newApprenant);

//     if ($resultat['success']) {
//         $nouvelApprenant = $resultat['apprenant'];
//         // L'enregistrer dans le fichier JSON ici
//         // Générer un matricule unique : AAAA-MM-XXXXX
//         $apprenant['matricule'] = strtoupper(substr($apprenant['nom'], 0, 2)) .
//         strtoupper(substr($apprenant['prenom'], 0, 2)) .
//         '-' . date('ym') . '-' . rand(10000, 99999);

//         // Initialiser les champs d’assiduité
//         $apprenant['Nombre_absences'] = 0;
//         $apprenant['Nombre_retards'] = 0;
//         $apprenant['Nombre_presence'] = 0;
//         $apprenant['Nombre_justifie'] = 0;

//         $data["apprenants"][] = $newApprenant;
//         writeData($data);
//     } else {
//         session_start(); // au début du fichier s'il n'y est pas déjà
//         $_SESSION['errors'] = $resultat['errors'] ?? ['Une erreur inconnue s\'est produite.'];
//         var_dump($_SESSION['errors']['prenom']);
//         // $ok = $_SESSION['errors'];
//         // var_dump('ko');

//         // die();
//         // exit;
//     }
//     // require_once __DIR__ . '/../views/apprenant/ajoutApprenant.php';
    
//     header('Location: index.php?route=page_ajout_apprenant');
//     // header("Location: index.php?route=page_ajout_apprenant");
//     exit;
    
// }