<?php
namespace App\Controllers;
require_once "../app/enums/enum.link.php";

use App\Enums\Includes;

require_once __DIR__ . '/../services/validator.service.php';
require_once Includes::CONTROLLER->value;
require_once includes::SESSION_SERVICE->value;
require_once Includes::MODEL->value;
require_once Includes::ENUM_KEYS->value;
require_once Includes::ENUM_VIEW->value;

    use function App\Models\readData;
    use function App\Models\writeData;
    use App\Enums\Keys;
    use App\Enums\View;
    use function App\Services\validatePromotion;
    use function App\Services\gererErreurs;
    use function App\Services\gererreferentielValidationFunctionsErreurs;


//affiche le ref en cours
function getPromotionEnCours(array $promotions): ?array {
    return array_values(array_filter($promotions, function ($promo) {
        return isset($promo['etat']) && strtolower($promo['etat']) === 'encours';
    }))[0] ?? null;
}
//affiche le ref actif
function getPromotionActive(array $promotions): ?array {
    $actives = array_filter($promotions, function ($promo) {
        return isset($promo['statut']) && strtolower($promo['statut']) === 'actif';
    });

    return !empty($actives) ? array_shift($actives) : null;
}
function getNombreApprenants(array $promotion): int {
    return isset($promotion['apprenants']) ? count($promotion['apprenants']) : 0;
}
function getNombreReferentiels(array $promotion): int {
    return isset($promotion['referentiels']) ? count($promotion['referentiels']) : 0;
}
// Récupérer tous les référentiels
function getAllReferentiels(): array {
    $data = readData();
    $promotions = $data['promotions'] ?? [];

    return array_values(array_reduce($promotions, function ($carry, $promotion) {
        $refs = $promotion['referentiels'] ?? [];

        $refs = array_map(function ($ref) use ($promotion) {
            $ref['apprenants'] = $promotion['apprenants'] ?? [];
            $ref['statut'] = $promotion['statut'] ?? 'inactif';
            $ref['promotion'] = $promotion['idnom'] ?? '';
            return $ref;
        }, $refs);

        return array_merge($carry, $refs);
    }, []));
}


function filtrerPromotions(array $promotions): array {
    $referentiel = $_GET['referentiel'] ?? '';
    $statut = $_GET['statut'] ?? '';
    $search = $_GET['search'] ?? '';

    // Filtre par nom
    if (!empty($search)) {
        $promotions = array_filter($promotions, function ($promo) use ($search) {
            return isset($promo['idnom']) && stripos($promo['idnom'], $search) !== false;
        });
    }

    // Filtre par référentiel
    if (!empty($referentiel)) {
        $promotions = array_filter($promotions, function ($promo) use ($referentiel) {
            return !empty($promo['referentiels']) &&
                count(array_filter($promo['referentiels'], function ($ref) use ($referentiel) {
                    return isset($ref['nom']) && stripos($ref['nom'], $referentiel) !== false;
                })) > 0;
        });
    }

    // Filtre par statut
    if (!empty($statut)) {
        $promotions = array_filter($promotions, function ($promo) use ($statut) {
            return isset($promo['statut']) && strtolower($promo['statut']) === strtolower($statut);
        });     
    }

    return $promotions;
}
function paginer(array $items, int $limit = 5): array {
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $total = count($items);
    $pages = ceil($total / $limit);
    $offset = ($page - 1) * $limit;
    $pageItems = array_slice($items, $offset, $limit);

    return [$pageItems, $total, $pages, $page];
}
function sauvegarderPromotion(array &$data, array $promo): void {
    $data['promotions'][] = $promo;
    writeData($data);
}
function listePromotions(): void {
    $data = readData();
    $promotions = $data[Keys::PROMOTIONS->value] ?? [];

    // Appliquer les filtres
    $promotions = filtrerPromotions($promotions);

    // Réindexer après filtrage
    $promotions = array_values($promotions);

    // Pagination
    [$promosPagines, $total, $pages, $page] = paginer($promotions, 5);

    // Statistiques
    $promotionActive = getPromotionActive($data[Keys::PROMOTIONS->value] ?? []);
    $nbApprenants = $promotionActive ? getNombreApprenants($promotionActive) : 0;
    $nbReferentiels = $promotionActive ? getNombreReferentiels($promotionActive) : 0;

    // Vue
    $view = View::ADMIN_LISTE_PROMOTION->value;
    require Includes::BASE_LAYOUT->value;
}




function ajouterPromotion(): void {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        afficherFormulaireAjoutPromotion();
        return;
    }

    $data = readData();
    $newPromo = construireNouvellePromotion($_POST);
    $errors = validatePromotion($newPromo);

    if (empty($errors)) {
        $imagePath = handleImageUpload();

        if ($imagePath) {
            $newPromo['image'] = $imagePath;
            sauvegarderPromotion($data, $newPromo);
            redirect('promotions');
        } else {
            $errors['image'] = "Image invalide ou erreur de téléchargement.";
        }
    }
    
    gererErreurs($errors, $_POST);
}
function formulaireAjouterPromotion(){
    // Facultatif : stocke les anciennes données si besoin
    if (!isset($_SESSION['old'])) {
        $_SESSION['old'] = [];
    }

    // Affiche la page du formulaire
    require_once __DIR__ . '/../views/formulaire/nouvelle_promotion.php';
}
function construireNouvellePromotion(array $post): array {
    $promo = [
        'idnom' => $post['idnom'] ?? '',
        'debutAnnee' => $post['debutAnnee'] ?? '',
        'finAnnnee' => $post['finAnnnee'] ?? '',
        'statut' => 'inactif',
        'nombreApprenant' => 0,
        'image' => '',
        'referentiels' => [],
        'apprenants' => []
    ];

    addReferentielToPromotion($post['referentiel_nom'] ?? '', $promo);
    return $promo;
}
function changerStatutPromotion(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['promo'])) {
        $action = $_POST['action']; // 'activer' ou 'desactiver'
        $promoNom = $_POST['promo']; // Nom de la promo

        $data = readData(); // Lecture des données

        foreach ($data['promotions'] as &$promotion) {
            if ($action === 'activer') {
                // On désactive tout d'abord
                $promotion['statut'] = 'inactif';
            }

            if ($promotion['idnom'] === $promoNom) {
                $promotion['statut'] = ($action === 'activer') ? 'actif' : 'inactif';
            }
        }

        writeData($data); // Sauvegarde
        redirect('admin_dashboard');
        exit;
    }
}

function dashboard() : void {   
    $user = \App\Services\get(Keys::USER->value);

    if (!$user || $user[Keys::ROLE->value] !== Keys::ADMIN->value) {
        redirect(View::LOGIN->value);
        return;
    }

    $data = \App\Models\readData(); 
    $promotions = $data[View::PROMOTIONS->value] ?? [];

    render(View::ADMIN_DASHBOARD->value,[
        Keys::USER->value => $user,
        View::PROMOTIONS->value => $promotions
    ]);
}





function filtrerReferentielsParNom(string $nomRecherche): array {
    $referentiels = getAllReferentiels();

    $resultat = array_filter($referentiels, function ($ref) use ($nomRecherche) {
        return strcasecmp($ref['nom'], $nomRecherche) === 0;
    });

    return array_values($resultat); // pour réindexer proprement
}



function pageReferentiels(): void {

    $data = readData();
    $promotions = $data['promotions'] ?? [];
    $allRef = $_REQUEST['allref'] ?? null;

    $search = $_POST['search'] ?? '';

    if ($allRef !== null) {
        $referentiels = getAllReferentiels();
    } else {
        $promotionEnCours = getPromotionActive($promotions);
        $referentiels = $promotionEnCours['referentiels'] ?? [];
    }

    if(!empty ($search)){
        $referentiels = filtrerReferentielsParNom($search);
    }

    $view = View::REFERENTIELS_DASHBOARD->value;
    require Includes::BASE_LAYOUT->value;
    // $nombreApprenants = count($promotionEnCours['apprenants'] ?? []);
    
}



function ajouterReferentiels(): void {
    static $id = 150; 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = readData();

        // Construction du nouveau référentiel
        $nouveauReferentiel = [
            'id' => $id++,
            'nom' => $_POST['nom'] ?? '',
            'description' => $_POST['description'] ?? '',
            'capacite' => (int) ($_POST['capacite'] ?? 0),
            'sessions' => ($_POST['sessions'] ?? 0),
            'image' =>$_POST['image'] ?? "uploads\/promotions\/68085c6b9aea3_img-promotion-list.png",
            'modules' => []
        ];

        $referentielValidationFunctions = gererreferentielValidationFunctionsErreurs();
        $errors = $referentielValidationFunctions['validateReferentiel']($nouveauReferentiel);
        // var_dump($errors);
        // die();

        if (empty($errors)) {
             // Ajout à la base (fichier JSON)
            $data['referentielsNonAffecte'][] = $nouveauReferentiel;
            writeData($data);
        } else{
            var_dump($errors);
            die();
        }

        // Gestion de l'image
        // $imagePath = handleImageUpload(); // à adapter si déjà utilisée pour les promotions
        // if ($imagePath) {
        //     $nouveauReferentiel['photo'] = $imagePath;
        // }

        // var_dump($data);
        // die();
        // redirect('promotions');
    }

    // Si ce n'est pas un POST : on affiche le formulaire
    redirect('referentiels');
}



function assignerReferentiels(): void {
    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //     $data = readData();
    //     $referentiels = $data['referentielsNonAffecte'] ?? [];
    //     $promoNom = $_POST['promo'] ?? '';
    //     $referentielNom = $_POST['referentiel'] ?? '';

    //     // Vérification de l'existence de la promo
    //     $promotion = array_filter($data['promotions'], function ($promo) use ($promoNom) {
    //         return isset($promo['idnom']) && $promo['idnom'] === $promoNom;
    //     });

    //     if (empty($promotion)) {
    //         // Gérer l'erreur : promotion non trouvée
    //         return;
    //     }

    //     // Ajout du référentiel à la promotion
    //     addReferentielToPromotion($referentielNom, $promotion[0]);

    //     // Sauvegarde des données
    //     writeData($data);
    // }
    // redirect('promotions');


}



function addReferentielToPromotion($referentielNom, array &$newPromo): void {
    if (!empty($referentielNom)) {
        $newPromo['referentiels'][] = [
            'id' => uniqid(),
            'nom' => strtolower(trim($referentielNom)),
            'modules' => [] // vide au départ
        ];
    }
}

function afficherFormulaireAjoutPromotion(): void {
    require 'views/admin/ajouter_promotion.php';
}



function assignerRef(){
    $data = readData();
    $referentielsNonAffecte = $data['referentielsNonAffecte'] ?? [];
    $promotions = $data['promotions'] ?? [];
    $promotion = getPromotionEnCours($promotions);
    $referentielsEncour = $promotion['referentiels'] ?? [];

    $data['promotions'][] = $promotion;
    $view = "referentiels/assignerref";
    require Includes::BASE_LAYOUT->value;
}

// function affecterreftopromo(): void {
//     $data = readData();
//     $promotions = $data['promotions'] ?? [];
//     $promotionEnCours = getPromotionEnCours($promotions);
//     $referentielsEncour = $promotionEnCours['referentiels'] ?? [];
//     $referentielsNonAffecte = $data['referentielsNonAffecte'] ?? [];

//     foreach ($referentielsNonAffecte as $key => $monreferentiel) {
//         if (isset($_POST['a_affecter']) && $_POST['a_affecter'] === $monreferentiel['nom']) {
//             $referentielsEncour[] = $referentielsNonAffecte[$key];
//             unset($referentielsNonAffecte[$key]);
//         }
//     }

//     $data['referentielsNonAffecte'] = $referentielsNonAffecte;
//     $promotionEnCours['referentiels'] = $referentielsEncour;

//     foreach ($promotions as $key => $promotion) {
//         if ($promotion['etat'] === 'encours') {
//             $data['promotions'][$key] = $promotionEnCours;
//             break;
//         }
//     }
//     writeData($data);
//     redirect('assigner_ref');
// }

function de_affecterreftopromo(): void {
    $montab = $_POST;
    $data = readData();
    $promotions = $data['promotions'] ?? [];
    $promotionEnCours = getPromotionEnCours($promotions);
    $referentielsEncour = $promotionEnCours['referentiels'] ?? [];
    $referentielsNonAffecte = $data['referentielsNonAffecte'] ?? [];

        //pour desacfecter
        foreach ($referentielsEncour as $key => $ref) {
            if (in_array($ref['nom'], $montab['a_desaffecter'])) {
                echo 'La banane est présente.';
            } else {
                echo 'La banane n\'est pas présente.';
                $referentielsNonAffecte[] = $ref;
                unset($referentielsEncour[$key]);
                $referentielsEncour = array_values($referentielsEncour); 
            }
        }


        //pour affecter
    if ($montab['a_affecter'] !== '') {
        foreach ($referentielsNonAffecte as $key => $monreferentiel) {
            if (isset($_POST['a_affecter']) && $_POST['a_affecter'] === $monreferentiel['nom']) {
                $referentielsEncour[] = $referentielsNonAffecte[$key];
                unset($referentielsNonAffecte[$key]);
            }
        }
    }



    $data['referentielsNonAffecte'] = $referentielsNonAffecte;
    $promotionEnCours['referentiels'] = $referentielsEncour;

    foreach ($promotions as $key => $promotion) {
        if ($promotion['etat'] === 'encours') {
            $data['promotions'][$key] = $promotionEnCours;
            break;
        }
    }

    writeData($data);
    redirect('assigner_ref');
}