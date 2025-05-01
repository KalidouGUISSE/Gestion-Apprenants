<?php
namespace App\Models;

require_once "../app/enums/enum.link.php";
use App\Enums\Includes;

require_once Includes::ENUM_KEYS->value;
require_once Includes::ENUM_VIEW->value;

use App\Enums\Keys;
use App\Enums\View;


$readData = function() : array{
    $jsonFile = Includes::DATA_JSON->value;;
    if (!file_exists($jsonFile)) {
        return [];
    }
    $jsonContent = file_get_contents($jsonFile);
    return json_decode($jsonContent, true) ?? [];
};

$writeData = function($data) : int|false {
    $jsonFile = Includes::DATA_JSON->value;;
    $jsonContent = json_encode($data, JSON_PRETTY_PRINT);
    return file_put_contents($jsonFile, $jsonContent);
};

// Exporter ces fonctions pour qu'elles soient accessibles
$GLOBALS[Keys::MODEL_FUNCTION->value] = [
    Keys::READ_DATA->value => $readData,
    Keys::WRITE_DATA->value => $writeData 
];

// Wrappers pour accéder aux fonctions anonymes
function readData() : array {
    return $GLOBALS[Keys::MODEL_FUNCTION->value][Keys::READ_DATA->value]();
}

function writeData($data) : int|false {
    return $GLOBALS[Keys::MODEL_FUNCTION->value][Keys::WRITE_DATA->value]($data);
}

function getStatistiques($jsonFilePath)
{
    if (!file_exists($jsonFilePath)) {
        return [
            'totalPromotions' => 0,
            'promotionsActives' => 0,
            'totalReferentiels' => 0,
            'totalApprenants' => 0
        ];
    }

    $data = json_decode(file_get_contents($jsonFilePath), true);

    if (!$data) {
        return [
            'totalPromotions' => 0,
            'promotionsActives' => 0,
            'totalReferentiels' => 0,
            'totalApprenants' => 0
        ];
    }

    $promotions = $data['promotions'] ?? [];
    $referentiels = $data['referentiels'] ?? [];

    $totalPromotions = count($promotions);
    $promotionsActives = count(array_filter($promotions, fn($promo) => $promo['statut'] === 'actif'));
    $totalReferentiels = count($referentiels);

    // Utiliser array_reduce pour compter tous les apprenants
    $totalApprenants = array_reduce($promotions, function ($carry, $promotion) {
        if (isset($promotion['apprenants']) && is_array($promotion['apprenants'])) {
            return $carry + count($promotion['apprenants']);
        }
        return $carry;
    }, 0);

    return [
        'totalPromotions' => $totalPromotions,
        'promotionsActives' => $promotionsActives,
        'totalReferentiels' => $totalReferentiels,
        'totalApprenants' => $totalApprenants
    ];
}

function getPromotionActive(array $promotions): ?array {
    $actives = array_filter($promotions, fn($p) => strtolower($p['statut']) === 'actif');
    return !empty($actives) ? array_values($actives)[0] : null;
}

function getAllPromotions(): array {
    $json = file_get_contents(__DIR__ . '/../../data/data.json'); // ajuste le chemin si nécessaire
    $data = json_decode($json, true);
    return $data['promotions'] ?? [];
}

function getNombreApprenants(array $promotion): int {
    return isset($promotion['apprenants']) ? count($promotion['apprenants']) : 0;
}

function getNombreReferentiels(array $promotion): int {
    return isset($promotion['referentiels']) ? count($promotion['referentiels']) : 0;
}
