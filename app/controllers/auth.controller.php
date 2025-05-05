<?php
namespace App\Controllers;

require_once "../app/enums/enum.link.php";
use App\Enums\Includes;

require_once Includes::ENUM_KEYS->value;
require_once Includes::ENUM_MESSAGE->value;
require_once Includes::ENUM_VIEW->value;
require_once Includes::CONTROLLER->value;
require_once includes::SESSION_SERVICE->value;
require_once Includes::USER_MODEL->value;
require_once Includes::VALIDATORE_SERVICE->value;
require_once Includes::ERROR_FUNCTION->value;
require_once Includes::MODEL->value;


use App\Enums\Keys;
use App\Enums\View;
use App\Enums\Message;
use function App\Translate\Fr\getErrors;
use function App\Models\readData;
use function App\Models\writeData;
use function App\Models\getAllApprenants;
use function App\Models\getApprenantKeyByLogin;


function loginForm() : void {
    $errorMessage = \App\Services\getFlash(Keys::ERROR->value);
    render(View::AUTH_LOGIN->value, [Keys::ERROR_MESSAGE->value => $errorMessage]);
}

function authenticate() : void {
    $smsErrors = getErrors();
    $username = getPostData(Keys::USERNAME->value);
    $password = getPostData(Keys::PASSWORD->value);
    
    if (!\App\Services\validateLogin($username, $password)) {
        \App\Services\setFlash(Keys::ERROR->value, $smsErrors[Keys::LOGIN_REQUIRED->value]);
        redirect(View::LOGIN->value);
        return;
    }
    

    $user = \App\Models\findUserByCredentials($username, $password);
    
    if ($user) {
        \App\Services\set(Keys::USER->value, $user);

        $redirectRoute = match ($user[Keys::ROLE->value]) {
            Keys::ADMIN->value  => View::ADMIN_DASHBOARD_2->value,
            Keys::VIGILE->value    => View::VIGILE_DASHBOARD->value,
            Keys::APPRENANT->value  => View::APPRENAMT_DASHBOARD->value,
            default   => View::LOGIN->value,
        };
        if ($user[Keys::ROLE->value] === Keys::APPRENANT->value) {
            $apprenants = getAllApprenants();
            $key = getApprenantKeyByLogin($username);

            if ($key !== null && isset($apprenants[$key]) && isset($apprenants[$key]['ok']) && $apprenants[$key]['ok'] === true) {
                unset($apprenants[$key]['ok']);
                $data = readData();
                $data['apprenants'] = $apprenants;
                // writeData($data);
            }else{
                redirect(View::LOGIN->value);
                return;
            }
        }
        redirect($redirectRoute);
    } else {
        \App\Services\setFlash(Keys::ERROR->value, $smsErrors[Keys::INVALID_CREDENTIALS->value]);
        redirect(View::LOGIN->value);
        
    }
}

function logout(): void {
    \App\Services\destroy();
    redirect(View::LOGIN->value);
}


function forgotPassword() : void {
    $view = View::AUTCH_FORGOT_PASSWORD->value;
    require_once Includes::BASE_LAYOUT->value;
}

function handlePasswordReset() : void{
    $login = $_POST[View::LOGIN->value] ?? '';
    $data = readData();

    // Regrouper tous les utilisateurs
    $allUsers = array_merge(
        $data['admins'] ?? [],
        $data['vigiles'] ?? [],
        $data['apprenants'] ?? []
    );

    // Chercher le user correspondant
    $matched = array_values(array_filter($allUsers, fn($user) => $user[View::LOGIN->value] === $login));

    if (!empty($matched)) {
        $foundUser = $matched[0];
        $message = "Votre mot de passe est : <strong>{$foundUser[Keys::PASSWORD->value]}</strong>";
    } else {
        $message = Message::AUCUN_USER_TROUVE_AVEC_LOGIN->value;
    }

    $view = View::AUTCH_FORGOT_PASSWORD->value;
    require_once Includes::BASE_LAYOUT->value;
}

function creerLogin(){
    $view = 'apprenant/creerlogion';
    require_once Includes::BASE_LAYOUT->value;
}

function changerPassword(){
    $errorMessage = \App\Services\getFlash(Keys::ERROR->value);
    $newpassword = getPostData('newpassword');
    $confirmernewpassword = getPostData('confirmernewpassword');

    if ($newpassword !== $confirmernewpassword) {
        $_SESSION['errorMessage'] = "Les mots de passe ne correspondent pas.";
        creerLogin();
        return;
    }

    if ($newpassword !== null && $confirmernewpassword !== null) {
        $apprenants = getAllApprenants();
        $key = getApprenantKeyByLogin($login);
    }

    if ($key !== null && isset($apprenants[$key]) && isset($apprenants[$key]['ok']) && $apprenants[$key]['ok'] === true) {
        unset($apprenants[$key]['ok']);
        redirect(View::LOGIN->value);
    }else{
        redirect(View::LOGIN->value);
        return;
    }

    $data = readData();
    $data['apprenants'] = $apprenants;
    writeData($data);
}