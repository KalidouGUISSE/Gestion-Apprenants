<?php
namespace App\Services;
use DateTime;
require_once __DIR__ . '/../models/model.php';
use function App\Models\readData;


function validateLogin($username, $password) {
    return !empty($username) && !empty($password);
}

function validateRequired($value) {
    return !empty(trim($value));
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function isNotEmpty(?string $value): bool {
    return trim((string)$value) !== '';
}

function isPositiveInt($value): bool {
    return filter_var($value, FILTER_VALIDATE_INT) !== false && (int)$value > 0;
}

function validatePromotion(array $promotion): array {
    $errors = [];

    $errors += validatePromotionName($promotion['idnom']);
    $errors += validateStartDate($promotion['debutAnnee']);
    $errors += validateEndDate($promotion['finAnnnee']);
    $errors += validateDateRange($promotion['debutAnnee'], $promotion['finAnnnee']);
    $errors += validatePromotionImage();

    return $errors;
}
function validateDate(string $date, string $format = 'd-m-Y'): bool {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}
function validatePromotionName(?string $name): array {
    $errors = [];

    // Vérifie si le champ est vide
    if (!isNotEmpty($name)) {
        $errors['idnom'] = "Le nom de la promotion est requis.";
        return $errors;
    }

    // Vérifie que le nom est au format "Promotion 2024"
    if (!preg_match('/^Promotion\s+\d{4}$/i', $name)) {
        $errors['idnom'] = "Le nom doit être au format Ex : Promotion 2024.";
        return $errors;
    }

    // Vérifie l'unicité du nom sans foreach
    $data = readData();
    $noms = array_map('strtolower', array_column($data['promotions'] ?? [], 'idnom'));

    if (in_array(strtolower($name), $noms)) {
        $errors['idnom'] = "Ce nom de promotion existe déjà.";
    }

    return $errors;
}


function validateStartDate(?string $date): array {
    if (!isNotEmpty($date)) {
        return ['debutAnnee' => "La date de début est requise."];
    }

    if (!validateDate($date)) {
        return ['debutAnnee' => "La date de début n'est pas valide (format attendu : DD-MM-YYYY)."];
    }

    return [];
}
function validateEndDate(?string $date): array {
    if (!isNotEmpty($date)) {
        return ['finAnnnee' => "La date de fin est requise."];
    }

    if (!validateDate($date)) {
        return ['finAnnnee' => "La date de fin n'est pas valide (format attendu : DD-MM-YYYY)."];
    }

    return [];
}
function validateDateRange(string $startDate, string $endDate): array {
    if (validateDate($startDate) && validateDate($endDate)) {
        if (strtotime($startDate) > strtotime($endDate)) {
            return ['date_range' => "La date de début ne peut pas être postérieure à la date de fin."];
        }
    }
    return [];
}
function validatePromotionImage(): array {
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        return ['image' => "L'image de la promotion est requise."];
    }

    $allowedTypes = ['image/jpeg', 'image/png'];
    $maxFileSize = 2 * 1024 * 1024; // 2MB

    $fileType = mime_content_type($_FILES['image']['tmp_name']);
    $fileSize = $_FILES['image']['size'];

    if (!in_array($fileType, $allowedTypes)) {
        return ['image' => "Format d'image invalide. Seuls les formats JPG et PNG sont acceptés."];
    }

    if ($fileSize > $maxFileSize) {
        return ['image' => "La taille de l'image ne doit pas dépasser 2MB."];
    }

    return [];
}

// validator.service.php


function gererreferentielValidationFunctionsErreurs(): array{
    $referentielValidationFunctions = [
        'validateNomReferentiel' => function(?string $nom): array {
            if (!isNotEmpty($nom)) {
                return ['nom' => "Le nom du référentiel est requis."];
            }

            $data = readData();
            $noms = array_map('strtolower', array_column($data['referentiels'] ?? [], 'nom'));

            if (in_array(strtolower($nom), $noms)) {
                return ['nom' => "Ce nom de référentiel existe déjà."];
            }

            return [];
        },
        'validateDescriptionReferentiel' => function(?string $description): array {
            return !isNotEmpty($description)
                ? ['description' => "La description du référentiel est requise."]
                : [];
        },
        'validateCapaciteReferentiel' => function($capacite): array {
            return (!isset($capacite) || !isPositiveInt($capacite))
                ? ['capacite' => "La capacité doit être un entier positif."]
                : [];
        },
        // 'validateSessionsParAnnee' => function($sessions): array {
        //     return (!isset($sessions) || !isPositiveInt($sessions))
        //         ? ['sessions_par_annee' => "Le nombre de sessions par année doit être un entier positif."]
        //         : [];
        // },
        // 'validateImageReferentiel' => function(): array {
        //     if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        //         return ['image' => "La photo du référentiel est requise."];
        //     }

        //     $allowedTypes = ['image/jpeg', 'image/png'];
        //     $maxFileSize = 2 * 1024 * 1024; // 2MB

        //     $fileType = mime_content_type($_FILES['image']['tmp_name']);
        //     $fileSize = $_FILES['image']['size'];

        //     if (!in_array($fileType, $allowedTypes)) {
        //         return ['image' => "Format d'image invalide. Seuls les formats JPG et PNG sont acceptés."];
        //     }

        //     if ($fileSize > $maxFileSize) {
        //         return ['image' => "La taille de l'image ne doit pas dépasser 2MB."];
        //     }

        //     return [];
        // }
    ];

    // Maintenant que $referentielValidationFunctions existe, on peut ajouter validateReferentiel
    $referentielValidationFunctions['validateReferentiel'] = function(array $ref) use (&$referentielValidationFunctions): array {
        return array_merge(
            $referentielValidationFunctions['validateNomReferentiel']($ref['nom'] ?? null),
            $referentielValidationFunctions['validateDescriptionReferentiel']($ref['description'] ?? null),
            $referentielValidationFunctions['validateCapaciteReferentiel']($ref['capacite'] ?? null),
            // $referentielValidationFunctions['validateSessionsParAnnee']($ref['sessions'] ?? null),
            // $referentielValidationFunctions['validateImageReferentiel']()
        );
    };

    return $referentielValidationFunctions;
}


function validerApprenant(array $apprenant): array
{
    $champsObligatoires = [
        'nom', 'prenom', 'adresse', 'telephone', 'email',
        'nom_tuteur', 'lien_parente',
    ];

    $erreurs = [];

    foreach ($champsObligatoires as $champ) {
        if (empty($apprenant[$champ])) {
            $erreurs[$champ] = "Le champ $champ est obligatoire.";
        }
    }

    if (!empty($erreurs)) {
        return ['success' => false, 'errors' => $erreurs];
    }

    return ['success' => true, 'apprenant' => $apprenant];
}






// $promotionValidationFunctions = [
//     'validatePromotion' => function(array $promotion): array {
//         return array_merge(
//             validatePromotionName($promotion['idnom']),
//             validateStartDate($promotion['debutAnnee']),
//             validateEndDate($promotion['finAnnnee']),
//             validateDateRange($promotion['debutAnnee'], $promotion['finAnnnee']),
//             validatePromotionImage()
//         );
//     },

//     'validateDate' => function(string $date, string $format = 'd-m-Y'): bool {
//         $d = DateTime::createFromFormat($format, $date);
//         return $d && $d->format($format) === $date;
//     },

//     'validatePromotionName' => function(?string $name): array {
//         return !isNotEmpty($name)
//             ? ['idnom' => "Le nom de la promotion est requis."]
//             : [];
//     },

//     'validateStartDate' => function(?string $date): array {
//         return !isNotEmpty($date)
//             ? ['debutAnnee' => "La date de début est requise."]
//             : (!validateDate($date)
//                 ? ['debutAnnee' => "La date de début n'est pas valide (format attendu : DD-MM-YYYY)."]
//                 : []);
//     },

//     'validateEndDate' => function(?string $date): array {
//         return !isNotEmpty($date)
//             ? ['finAnnnee' => "La date de fin est requise."]
//             : (!validateDate($date)
//                 ? ['finAnnnee' => "La date de fin n'est pas valide (format attendu : DD-MM-YYYY)."]
//                 : []);
//     },

//     'validateDateRange' => function(string $startDate, string $endDate): array {
//         return (validateDate($startDate) && validateDate($endDate) && strtotime($startDate) > strtotime($endDate))
//             ? ['date_range' => "La date de début ne peut pas être postérieure à la date de fin."]
//             : [];
//     },

//     'validatePromotionImage' => function(): array {
//         $file = $_FILES['image'] ?? null;

//         return !$file || $file['error'] !== UPLOAD_ERR_OK
//             ? ['image' => "L'image de la promotion est requise."]
//             : (!in_array($type = mime_content_type($file['tmp_name']), ['image/jpeg', 'image/png'])
//                 ? ['image' => "Format d'image invalide. Seuls les formats JPG et PNG sont acceptés."]
//                 : ($file['size'] > 2 * 1024 * 1024
//                     ? ['image' => "La taille de l'image ne doit pas dépasser 2MB."]
//                     : []));
//     }
// ];
