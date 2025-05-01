<?php
namespace App\Enums;

enum Message : String {
    case AUCUN_USER_TROUVE_AVEC_LOGIN = "Aucun utilisateur trouvé avec ce login.";
}

enum Error : string{
    case ERROR_PRODUIT = "Une erreur s'est produite";
}