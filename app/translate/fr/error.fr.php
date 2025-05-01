<?php
namespace App\translate\fr;
require_once "../app/enums/enum.link.php";
use App\Enums\Includes;

require_once Includes::ENUM_KEYS->value;
use App\Enums\Keys;

return [
    Keys::LOGIN_REQUIRED->value => 'Nom d\'utilisateur et mot de passe requis',
    Keys::INVALID_CREDENTIALS->value => 'Identifiants incorrects',
    Keys::NOT_FOUND->value => 'Page non trouvée',
    Keys::INTERNAL_ERROR->value => 'Une erreur interne est survenue',
    'required' => 'ce champ est obligatoire'
];

