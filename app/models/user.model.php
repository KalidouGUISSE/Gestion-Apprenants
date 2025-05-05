<?php
namespace App\Models;

require_once "../app/enums/enum.link.php";
use App\Enums\Includes;

require_once Includes::ENUM_KEYS->value;
require_once Includes::ENUM_VIEW->value;

use App\Enums\Keys;
use App\Enums\View;

require_once "model.php";
$findUserByCredentials = function($username, $password) : array|null {
    $data = readData();
    
    $checkUser = function ($users, $role) use ($username, $password) {
        $matched = array_values(array_filter($users, function ($user) use ($username, $password) {
            return isset($user[Keys::LOGIN->value], $user[Keys::PASSWORD->value]) &&
                $user[Keys::LOGIN->value] === $username &&
                password_verify($password, $user[Keys::PASSWORD->value]);
        }));
    
        if (!empty($matched)) {
            $matched[0][Keys::ROLE->value] = $role;
            return $matched[0];
        }
    
        return null;
    };
    
    // Vérifie chaque type d'utilisateur en une ligne chacun
    if (isset($data[Keys::ADMINS->value]) && $user = $checkUser($data[Keys::ADMINS->value], Keys::ADMIN->value)) return $user;
    if (isset($data[Keys::VIGILES->value]) && $user = $checkUser($data[Keys::VIGILES->value], Keys::VIGILE->value)) return $user;
    if (isset($data[Keys::APPRENANTS->value]) && $user = $checkUser($data[Keys::APPRENANTS->value], Keys::APPRENANT->value)) return $user;

    return null;
};

// Injecte dans le contexte global
$GLOBALS[Keys::USER_MODEL_FUNCTION->value] = [
    Keys::FIND_USER_BY_CREDENTIALS->value => $findUserByCredentials
];

function findUserByCredentials($username, $password) : array|null {
    return $GLOBALS[Keys::USER_MODEL_FUNCTION->value][Keys::FIND_USER_BY_CREDENTIALS->value]($username, $password);
}
