<?php
namespace App\Route;


require_once "../app/enums/enum.link.php";
use App\Enums\Includes;
require_once Includes::ENUM_KEYS->value;
require_once Includes::ENUM_VIEW->value;

use App\Enums\Keys;
use App\Enums\View;

function loadController($route) : void {
    $controllerMapping = [
        Keys::LOGIN->value => [Keys::CONTROLLER->value => Keys::AUTH->value, Keys::ACTION->value => Keys::LOGIN_FORM->value],
        Keys::AUTH->value => [Keys::CONTROLLER->value => Keys::AUTH->value, Keys::ACTION->value => Keys::AUTHENTICATE->value],
        Keys::LOUGOUT->value => [Keys::CONTROLLER->value => Keys::AUTH->value, Keys::ACTION->value => Keys::LOUGOUT->value],
        View::ADMIN_DASHBOARD_2->value => [Keys::CONTROLLER->value => Keys::ADMIN->value, Keys::ACTION->value => Keys::DASHBOARD->value],
        View::VIGILE_DASHBOARD->value => [Keys::CONTROLLER->value => Keys::VIGILE->value, Keys::ACTION->value => Keys::DASHBOARD->value],
        View::APPRENAMT_DASHBOARD->value => [Keys::CONTROLLER->value => Keys::APPRENANT->value, Keys::ACTION->value => Keys::DASHBOARD->value],
        // 'liste-promotions' => [Keys::CONTROLLER->value => Keys::ADMIN->value, Keys::ACTION->value => 'listePromotions'],
        Keys::ERROR->value => [Keys::CONTROLLER->value => Keys::ERROR->value, Keys::ACTION->value => 'show'],
        Keys::FORGORT_PASSWORD->value => [Keys::CONTROLLER->value => Keys::AUTH->value, Keys::ACTION->value => 'forgotPassword'],
        Keys::RESET_PASSWORD->value => [Keys::CONTROLLER->value => Keys::AUTH->value, Keys::ACTION->value => 'handlePasswordReset'],
        Keys::PROMOTIONS->value => [Keys::CONTROLLER->value => Keys::ADMIN->value, Keys::ACTION->value => 'listePromotions'],
        Keys::AJOUTER_PROMOTION->value => [Keys::CONTROLLER->value => Keys::ADMIN->value, Keys::ACTION->value => 'ajouterPromotion'],
        Keys::REFERENTIELS->value => [Keys::CONTROLLER->value => Keys::ADMIN->value, Keys::ACTION->value => 'pageReferentiels'],
        // 'ajouter_promotion' => ['controller' => 'admin', 'action' => 'ajouterPromotion'],
        'changer_statut' => ['controller' => 'admin', 'action' => 'changerStatutPromotion'],
        'ajouter_referentiels' => ['controller' => 'admin' , 'action' => 'ajouterReferentiels'],
        'assigner_referentiels' => ['controller' => 'admin', 'action' => 'assignerReferentiels'],
        'modifier_promo' => ['controller' => 'admin', 'action' => 'de_affecterreftopromo'],
        'assigner_ref' => ['controller' => 'admin', 'action' => 'assignerRef'],
        'apprenants' => ['controller' => 'apprenant','action' => 'page_apprenants'],
        'telechargerExcel' => ['controller' => 'apprenant', 'action' => 'telechargerExcel'],
        'telechargerPDF'=> ['controller' => 'apprenant', 'action' => 'telechargerPDF'],
        'importerExcel' => ['controller' => 'apprenant', 'action' => 'importerExcel'],
        'apprenants_attente' => ['controller' => 'apprenant', 'action' => 'page_apprenants'],
        'page_ajout_apprenant' => ['controller' => 'apprenant', 'action' => 'pageAjoutApprenant'],
        'ajout_apprenant' => ['controller' => 'apprenant', 'action' => 'ajouterApprenant'],
    ];
    
    if (!array_key_exists($route, $controllerMapping)){
        $route = Keys::ERROR->value;
    }
    
    $controllerName = $controllerMapping[$route][Keys::CONTROLLER->value];
    $actionName = $controllerMapping[$route][Keys::ACTION->value];
    
    $controllerFile = "../app/controllers/{$controllerName}.controller.php";
    
    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        $controller = "\\App\\Controllers\\{$actionName}";
        $controller();
    } else {
        require_once "../app/controllers/error.controller.php";
        \App\Controllers\show("Contrôleur non trouvé");
    }
}