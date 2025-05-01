<?php
namespace App\Enums;

enum Includes: string {
    case BASE_LAYOUT = __DIR__ . '/../views/layout/base.layout.php';
    case REFERENTIELS = __DIR__ . '/../views/referentiels/dashboard.php';
    case CONTROLLER = "../app/controllers/controller.php";
    case SESSION_SERVICE = "../app/services/session.service.php";
    case MODEL = __DIR__ . '/../models/model.php';
    case USER_MODEL = "../app/models/user.model.php";
    case VALIDATORE_SERVICE = "../app/services/validator.service.php";
    case ERROR_FUNCTION = __DIR__ . '/../translate/fr/functions.php';
    case ENUM_KEYS = "../app/enums/enum.keys.php";
    case ENUM_VIEW = "../app/enums/enum.view.php";
    case ENUM_MESSAGE = "../app/enums/enum.message.php";
    case DATA_JSON = __DIR__ . '/../../data/data.json';
    case ASIDE = __DIR__ . '/../daguite/aside.php';
    case HEADER =  __DIR__ . '/../daguite/header.php';
    case NOUVEAU_PROMO = __DIR__ . '/../daguite/nouveaupromo.php';
}
