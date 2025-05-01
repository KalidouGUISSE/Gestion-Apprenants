<?php
namespace App\Controllers;
require_once "../app/enums/enum.link.php";
use App\Enums\Includes;

require_once Includes::CONTROLLER->value;
require_once Includes::ENUM_VIEW->value;
require_once Includes::ENUM_KEYS->value;
require_once Includes::ENUM_MESSAGE->value;

use App\Enums\Keys;
use App\Enums\View;
use App\Enums\Error;
function show($message = null) : void {
    $errorMessage = $message ?? Error::ERROR_PRODUIT->value;
    render(Keys::ERROR_ERROR->value, [Keys::ERROR_MESSAGE->value => $errorMessage]);
}