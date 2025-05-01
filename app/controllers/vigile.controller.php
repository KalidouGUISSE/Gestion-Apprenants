<?php
namespace App\Controllers;
require_once "../app/enums/enum.link.php";
use App\Enums\Includes;

require_once Includes::CONTROLLER->value;
require_once includes::SESSION_SERVICE->value;
require_once Includes::ENUM_VIEW->value;
require_once Includes::ENUM_KEYS->value;

use App\Enums\Keys;
use App\Enums\View;

function dashboard() : void {
    $user = \App\Services\get(Keys::USER->value);
    
    if (!$user || $user[Keys::ROLE->value] !== Keys::VIGILE->value) {
        redirect(View::LOGIN->value);
        return;
    }
    
    render('vigile/dashboard', [Keys::USER->value => $user]);
}